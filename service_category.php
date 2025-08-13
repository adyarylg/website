<?php // FILE: service_category.php ?>
<?php
include_once 'data.php';
include_once 'Parsedown.php';

$category_slug = $_GET['category'] ?? '';

if (!isset($service_categories[$category_slug])) {
    header("Location: services.php");
    exit();
}

$category = $service_categories[$category_slug];
$page_title = $category['title'];
$meta_description = $category['meta_description'] ?? '';
$booking_link = $booking_urls[$category_slug] ?? '#';
$whatsapp_link = $whatsapp_links[$category_slug] ?? '#';

$Parsedown = new Parsedown();
$content_path = __DIR__ . '/services-content/' . $category_slug . '/';

// Function to safely load and parse a markdown file
function render_markdown($path, $parser) {
    if (file_exists($path)) {
        $markdown = file_get_contents($path);
        return $parser->text($markdown);
    }
    return '';
}

// Load content from the markdown files
$introduction_html = render_markdown($content_path . 'introduction.md', $Parsedown);
$guide_html        = render_markdown($content_path . 'guide.md', $Parsedown);
$faq_html          = render_markdown($content_path . 'faq.md', $Parsedown);
$care_html         = render_markdown($content_path . 'care.md', $Parsedown);

// Load prices from JSON if available
$prices_data = null;
if (file_exists($content_path . 'prices.json')) {
    $prices_data = json_decode(file_get_contents($content_path . 'prices.json'), true);
}

include 'header.php';
?>

<!-- Category Hero Section -->
<section class="relative h-[40vh] bg-cover bg-center" style="background-image: url('<?php echo $images['categories'][$category_slug] ?? ''; ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center text-white p-4">
            <h1 class="text-5xl md:text-6xl font-playfair font-bold"><?php echo htmlspecialchars($category['title']); ?></h1>
        </div>
    </div>
</section>

<div class="container mx-auto px-6 py-20">
    <div class="grid lg:grid-cols-3 gap-12">
        
        <!-- Service Details Column -->
        <div class="lg:col-span-2">
            <!-- Introduction -->
            <?php if ($introduction_html): ?>
                <div class="prose lg:prose-xl max-w-none mb-12">
                    <?php echo $introduction_html; ?>
                </div>
            <?php endif; ?>

            <!-- Service Sections from JSON -->
            <?php if (!empty($prices_data['sections'])): ?>
                <?php foreach ($prices_data['sections'] as $section): ?>
                    <div class="mb-12">
                        <h2 class="text-3xl font-playfair font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($section['title']); ?></h2>
                        <div class="bg-ylg-pink h-1 w-20 mb-4"></div>
                        <?php if (!empty($section['description'])): ?>
                            <p class="text-gray-600 leading-relaxed mb-6"><?php echo htmlspecialchars($section['description']); ?></p>
                        <?php endif; ?>
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="space-y-4">
                                <?php foreach ($section['services'] as $service): ?>
                                    <div class="flex justify-between items-center border-b border-gray-200 py-4">
                                        <p class="text-lg text-gray-800"><?php echo htmlspecialchars($service['name']); ?></p>
                                        <p class="text-lg font-bold text-ylg-pink whitespace-nowrap pl-4">
                                            ₹<?php echo htmlspecialchars($service['price']); ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Detailed Guide Section -->
            <?php if ($guide_html): ?>
                <div class="prose lg:prose-xl max-w-none mb-12">
                    <?php echo $guide_html; ?>
                </div>
            <?php endif; ?>

            <!-- FAQ Section -->
            <?php if ($faq_html): ?>
                <div class="prose lg:prose-xl max-w-none mb-12">
                    <?php echo $faq_html; ?>
                </div>
            <?php endif; ?>

            <!-- Care Instructions Section -->
            <?php if ($care_html): ?>
                <div class="prose lg:prose-xl max-w-none mb-12">
                    <?php echo $care_html; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sticky Booking Column -->
        <div class="lg:col-span-1">
            <div class="sticky top-28">
                <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                    <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-4">Ready to Book?</h3>
                    <p class="text-gray-600 mb-6">
                        Book your <?php echo strtolower($category['title']); ?> appointment online now. It's fast, easy, and secure.
                    </p>
                    <a href="<?php echo $booking_link; ?>" target="_blank" class="w-full block bg-ylg-pink text-white px-8 py-4 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold text-lg mb-4">
                        Book Online
                    </a>
                    <a href="<?php echo $whatsapp_link; ?>" target="_blank" class="w-full block bg-green-500 text-white px-8 py-4 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold text-lg flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-2"></i> Inquire on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
