<?php
// FILE: update_reviews.php

// --- SECURE API KEY HANDLING ---
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') !== 0) {
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
$apiKey = $_ENV['SERPAPI_KEY'] ?? null;

if ($apiKey === null) {
    die("Error: API Key not found in environment file.");
}

// --- CONFIG ---
$placeId = "ChIJtToQYpRnUjoRbzfhTA1GcbQ";
$outputFile = 'reviews.json';

// --- FETCH FUNCTION using cURL ---
// Corrected the sortBy parameter to use valid API values.
function fetchReviews($placeId, $apiKey, $sortBy) {
    $url = "https://serpapi.com/search.json?engine=google_maps_reviews&place_id={$placeId}&sort_by={$sortBy}&api_key={$apiKey}";
    
    echo "--> Contacting SerpAPI to fetch reviews sorted by '{$sortBy}'...\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response_json = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($response_json === false || $curl_error) {
        echo "    [FAIL] cURL failed. Error: {$curl_error}\n";
        return null;
    }

    $data = json_decode($response_json, true);

    if (isset($data['error'])) {
        echo "    [FAIL] SerpAPI returned an error: " . $data['error'] . "\n";
        return null;
    }
    
    if ($data === null || !isset($data['reviews'])) {
        echo "    [FAIL] Data received from SerpAPI was not in the expected format.\n";
        return null;
    }
    
    echo "    [SUCCESS] Successfully fetched " . count($data['reviews']) . " reviews.\n";
    return $data;
}

// --- SCRIPT EXECUTION ---
echo "Starting review update process...\n";

// Using the correct sort_by values from the API documentation
$recentData = fetchReviews($placeId, $apiKey, 'newestFirst');
$popularData = fetchReviews($placeId, $apiKey, 'ratingHigh');

if ($recentData === null) {
    die("CRITICAL ERROR: Could not fetch recent reviews from SerpAPI. Halting script.\n");
}

// --- INTELLIGENT DE-DUPLICATION ---
$recentReviews = $recentData['reviews'];
$recentReviewSnippets = array_map(function($review) { return $review['snippet']; }, $recentReviews);

$popularReviews = [];
if ($popularData !== null) {
    foreach ($popularData['reviews'] as $review) {
        // Add to popular list ONLY if it's not already in the recent list
        if (!in_array($review['snippet'], $recentReviewSnippets)) {
            $popularReviews[] = $review;
        }
    }
}

// --- PREPARE FINAL JSON DATA ---
$reviews_data = [
    'place_info' => [
        'title' => $recentData['place_info']['title'] ?? 'YLG Salon Adyar',
        'address' => $recentData['place_info']['address'] ?? '',
        'rating' => $recentData['place_info']['rating'] ?? 0,
        'reviews_count' => $recentData['place_info']['reviews'] ?? 0
    ],
    'recent_reviews' => [],
    'popular_reviews' => []
];

// Populate the final arrays
foreach ($recentReviews as $review) {
    $reviews_data['recent_reviews'][] = [
        'user_name' => $review['user']['name'] ?? 'A Customer',
        'user_photo' => $review['user']['thumbnail'] ?? 'images/default-avatar.png',
        'rating' => $review['rating'] ?? 0,
        'snippet' => $review['snippet'] ?? '',
        'date' => $review['date'] ?? ''
    ];
}

foreach ($popularReviews as $review) {
    $reviews_data['popular_reviews'][] = [
        'user_name' => $review['user']['name'] ?? 'A Customer',
        'user_photo' => $review['user']['thumbnail'] ?? 'images/default-avatar.png',
        'rating' => $review['rating'] ?? 0,
        'snippet' => $review['snippet'] ?? '',
        'date' => $review['date'] ?? ''
    ];
}

// --- SAVE TO FILE ---
$json_output = json_encode($reviews_data, JSON_PRETTY_PRINT);
if (file_put_contents($outputFile, $json_output)) {
    echo "Successfully saved " . count($reviews_data['recent_reviews']) . " recent and " . count($reviews_data['popular_reviews']) . " unique popular reviews to {$outputFile}.\n";
} else {
    echo "Error: Could not write to {$outputFile}. Please check file permissions.\n";
}
