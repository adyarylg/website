<?php
// FILE: reviews.php
// This file reads the locally stored reviews.json and displays them in a professional UI with tabs.

$page_title = 'Customer Reviews | YLG Salon Adyar';
$meta_description = 'Read real, verified reviews from our satisfied customers. See why YLG is considered one of the best beauty salons in Adyar, Chennai.';
include 'header.php';

// --- Data Fetching from local JSON file ---
$reviews_file = 'reviews.json';
$reviews_data = null;
$recent_reviews = [];
$popular_reviews = [];

if (file_exists($reviews_file)) {
    $json_content = file_get_contents($reviews_file);
    $reviews_data = json_decode($json_content, true);

    // Get both recent and popular reviews from the new structure
    if (!empty($reviews_data['recent_reviews'])) {
        $recent_reviews = array_slice($reviews_data['recent_reviews'], 0, 9);
    }
    if (!empty($reviews_data['popular_reviews'])) {
        $popular_reviews = array_slice($reviews_data['popular_reviews'], 0, 9);
    }
}

// Function to generate star icons from a rating
function generate_stars($rating) {
    $stars_html = '';
    $full_stars = floor($rating);
    $half_star = ceil($rating - $full_stars);
    for ($i = 0; $i < $full_stars; $i++) { $stars_html .= '<i class="fas fa-star"></i>'; }
    if ($half_star) { $stars_html .= '<i class="fas fa-star-half-alt"></i>'; }
    $empty_stars = 5 - $full_stars - $half_star;
    for ($i = 0; $i < $empty_stars; $i++) { $stars_html .= '<i class="far fa-star"></i>'; }
    return $stars_html;
}

// Function to render a single review card. This avoids code duplication.
function render_review_card($review) {
    ob_start(); // Start output buffering to capture HTML
    ?>
    <div itemprop="review" itemscope itemtype="http://schema.org/Review" class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-ylg-pink flex flex-col h-full">
        <div class="flex items-center mb-4">
            <img src="<?php echo htmlspecialchars($review['user_photo']); ?>" 
                 alt="<?php echo htmlspecialchars($review['user_name']); ?>" 
                 class="w-12 h-12 rounded-full mr-4 object-cover bg-gray-200"
                 onerror="this.onerror=null; this.src='images/default-avatar.png';">
            <div>
                <h3 itemprop="author" class="font-bold text-lg text-gray-800"><?php echo htmlspecialchars($review['user_name']); ?></h3>
                <?php if (!empty($review['date'])): ?>
                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($review['date']); ?></p>
                    <meta itemprop="datePublished" content="<?php echo date('Y-m-d', strtotime(str_replace('Edited ','', $review['date']))); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="text-yellow-400 text-lg mb-4">
            <?php echo generate_stars($review['rating']); ?>
            <meta itemprop="ratingValue" content="<?php echo $review['rating']; ?>">
            <meta itemprop="bestRating" content="5">
        </div>
        <p itemprop="reviewBody" class="text-gray-600 italic flex-grow">"<?php echo htmlspecialchars($review['snippet']); ?>"</p>
    </div>
    <?php
    return ob_get_clean(); // Return the captured HTML
}

?>

<div itemscope itemtype="http://schema.org/BeautySalon">
    <meta itemprop="name" content="<?php echo $business_details['name']; ?>">
    <meta itemprop="address" content="<?php echo $business_details['address']; ?>">
    <meta itemprop="telephone" content="<?php echo $business_details['phone']; ?>">
    
    <div class="container mx-auto px-6 py-20">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Trusted by Our Clients</h1>
            <?php if ($reviews_data && isset($reviews_data['place_info'])): ?>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    We're proud of our live <strong itemprop="ratingValue"><?php echo $reviews_data['place_info']['rating']; ?></strong>-star rating from over <strong itemprop="reviewCount"><?php echo $reviews_data['place_info']['reviews_count']; ?></strong> reviews on Google.
                </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($recent_reviews)): ?>
            <!-- Tab Navigation -->
            <div class="mb-8 flex justify-center border-b">
                <button id="tab-recent" class="px-6 py-3 font-bold text-lg border-b-4 border-ylg-pink text-ylg-pink">Recent Reviews</button>
                <button id="tab-popular" class="px-6 py-3 font-bold text-lg border-b-4 border-transparent text-gray-500 hover:text-ylg-pink">Popular 5-Star</button>
            </div>

            <!-- Tab Content -->
            <div id="content-recent" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($recent_reviews as $review) { echo render_review_card($review); } ?>
            </div>

            <div id="content-popular" class="hidden grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($popular_reviews as $review) { echo render_review_card($review); } ?>
            </div>
            
            <div class="text-center mt-12">
                 <a href="<?php echo $google_reviews['link']; ?>" target="_blank" class="bg-blue-500 text-white px-8 py-4 rounded-full hover:bg-blue-600 transition-transform duration-300 hover:scale-105 font-bold text-lg inline-flex items-center">
                    <i class="fab fa-google mr-3"></i> View All on Google
                </a>
            </div>

        <?php else: ?>
            <!-- Fallback Message -->
            <div class="text-center text-gray-500 p-8 border-2 border-dashed rounded-lg">
                <p class="font-bold text-xl">Could Not Load Live Reviews</p>
                <p class="mt-2">The `reviews.json` file could not be found or is empty. Please ensure the daily cron job is running correctly.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    // JavaScript for tab functionality
    const tabRecent = document.getElementById('tab-recent');
    const tabPopular = document.getElementById('tab-popular');
    const contentRecent = document.getElementById('content-recent');
    const contentPopular = document.getElementById('content-popular');

    tabRecent.addEventListener('click', () => {
        // Show recent content, hide popular
        contentRecent.classList.remove('hidden');
        contentPopular.classList.add('hidden');
        // Style active tab
        tabRecent.classList.add('border-ylg-pink', 'text-ylg-pink');
        tabRecent.classList.remove('border-transparent', 'text-gray-500');
        // Style inactive tab
        tabPopular.classList.add('border-transparent', 'text-gray-500');
        tabPopular.classList.remove('border-ylg-pink', 'text-ylg-pink');
    });

    tabPopular.addEventListener('click', () => {
        // Show popular content, hide recent
        contentPopular.classList.remove('hidden');
        contentRecent.classList.add('hidden');
        // Style active tab
        tabPopular.classList.add('border-ylg-pink', 'text-ylg-pink');
        tabPopular.classList.remove('border-transparent', 'text-gray-500');
        // Style inactive tab
        tabRecent.classList.add('border-transparent', 'text-gray-500');
        tabRecent.classList.remove('border-ylg-pink', 'text-ylg-pink');
    });
</script>

<?php include 'footer.php'; ?>
