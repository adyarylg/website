<?php // FILE: blog.php ?>
<?php
$page_title = 'YLG Salon Adyar Blog | Beauty Tips & Expert Advice';
$meta_description = 'Explore the YLG Salon blog for expert tips on hair care, skin treatments, painless waxing, and the latest beauty trends in Chennai.';
include 'header.php';
include_once 'Parsedown.php'; // Use include_once to be safe

// Function to read metadata from a markdown file
function get_post_metadata($file) {
    $handle = fopen($file, 'r');
    if (!$handle) {
        return [];
    }
    $content = fread($handle, 4096); // Read first 4kb, enough for metadata
    fclose($handle);

    $metadata = [];
    $matches = [];
    // Regex to find the content between the '---' separators
    if (preg_match('/---\s*(.*?)\s*---/s', $content, $matches)) {
        $front_matter = trim($matches[1]);
        $lines = explode("\n", $front_matter);
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $metadata[trim($key)] = trim($value);
            }
        }
    }
    return $metadata;
}

$posts_dir = __DIR__ . '/posts/';
$post_files = glob($posts_dir . '*.md');
$blog_posts = [];

foreach ($post_files as $file) {
    $slug = basename($file, '.md');
    $blog_posts[$slug] = get_post_metadata($file);
}

// Sort posts by date, newest first
uasort($blog_posts, function($a, $b) {
    $timeA = isset($a['date']) ? strtotime($a['date']) : 0;
    $timeB = isset($b['date']) ? strtotime($b['date']) : 0;
    return $timeB - $timeA;
});

?>

<div class="container mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">The YLG Beauty Blog</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Your expert source for beauty insights, tips, and trends from the heart of Adyar.</p>
    </div>

    <?php if (!empty($blog_posts)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($blog_posts as $slug => $post): ?>
                <a href="single-post.php?slug=<?php echo $slug; ?>" class="group block bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($post['image'] ?? 'images/placeholder.png'); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? 'Blog Post'); ?>" class="w-full h-56 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-300"></div>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-500 mb-2"><?php echo htmlspecialchars($post['date'] ?? ''); ?> &bull; By <?php echo htmlspecialchars($post['author'] ?? 'YLG'); ?></p>
                        <h2 class="text-2xl font-playfair font-bold text-gray-800 mb-3 group-hover:text-ylg-pink transition-colors duration-300"><?php echo htmlspecialchars($post['title'] ?? 'Untitled Post'); ?></h2>
                        <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-gray-500 p-8 border-2 border-dashed rounded-lg">
            <p class="font-bold text-xl">Our blog is coming soon!</p>
            <p class="mt-2">Check back later for expert articles and beauty tips.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
