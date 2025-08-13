<?php
// FILE: single-post.php

// --- STEP 1: ENABLE ERROR REPORTING (FOR DEBUGGING) ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- STEP 2: GET THE REQUESTED POST ---
$post_slug = $_GET['slug'] ?? '';
$post_file = __DIR__ . '/posts/' . $post_slug . '.md';

// Immediately stop if the file doesn't exist or no slug is provided.
if (!file_exists($post_file) || empty($post_slug)) {
    header("Location: blog.php");
    exit();
}

// --- NEW: ROBUSTLY INCLUDE THE PARSER LIBRARY ---
$parsedown_path = __DIR__ . '/Parsedown.php';
if (file_exists($parsedown_path)) {
    include_once $parsedown_path;
} else {
    // Provide a clear, user-friendly error if the file is missing.
    die("CRITICAL ERROR: The required library file 'Parsedown.php' could not be found. Please ensure it has been uploaded to the main project directory.");
}

// Check if the class was loaded successfully after including the file.
if (!class_exists('Parsedown')) {
    die("CRITICAL ERROR: The 'Parsedown.php' file was found, but the 'Parsedown' class is not defined within it. The file may be corrupted or incorrect.");
}


// --- STEP 3: PARSE THE MARKDOWN FILE ---
function parse_post_file($file) {
    $content = file_get_contents($file);
    $post = [];
    $matches = [];
    
    if (preg_match('/---\s*(.*?)\s*---\s*(.*)/s', $content, $matches)) {
        $front_matter = trim($matches[1]);
        $post['content'] = trim($matches[2]);
        
        $lines = explode("\n", $front_matter);
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $post[trim($key)] = trim(trim($value), '"');
            }
        }
    }
    return $post;
}

$post = parse_post_file($post_file);

// --- STEP 4: VALIDATE THE PARSED DATA ---
if (empty($post) || empty($post['content'])) {
    die("Error: Could not parse the markdown file. Please check the format of '{$post_slug}.md', especially the '---' separators.");
}

// --- STEP 5: SET PAGE-SPECIFIC METADATA ---
$page_title = htmlspecialchars($post['title'] ?? 'Blog Post') . ' | YLG Blog';
$meta_description = htmlspecialchars($post['excerpt'] ?? 'Read our latest article from the YLG Adyar blog.');

// --- STEP 6: INCLUDE THE HEADER ---
include 'header.php';

// --- STEP 7: RENDER THE HTML CONTENT ---
$Parsedown = new Parsedown();
$html_content = $Parsedown->text($post['content']);
?>

<!-- Post Hero Section -->
<section class="relative h-[50vh] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($post['image'] ?? ''); ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center text-white p-6 max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-playfair font-bold leading-tight"><?php echo htmlspecialchars($post['title'] ?? 'Post Title'); ?></h1>
            <p class="mt-4 text-lg">By <?php echo htmlspecialchars($post['author'] ?? 'YLG'); ?> on <?php echo htmlspecialchars($post['date'] ?? ''); ?></p>
        </div>
    </div>
</section>

<div class="container mx-auto px-6 py-20">
    <div class="max-w-3xl mx-auto">
        <!-- The 'prose' classes from Tailwind handle the article styling beautifully -->
        <article class="prose lg:prose-xl max-w-none text-gray-700 leading-relaxed">
            <?php echo $html_content; // This is where the formatted article content is displayed ?>
        </article>

        <div class="mt-12 border-t pt-8 text-center">
            <a href="blog.php" class="text-ylg-pink hover:underline font-bold text-lg">&larr; Back to All Articles</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
