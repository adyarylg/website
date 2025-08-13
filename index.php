<?php // FILE: index.php ?>
<?php
$page_title = 'YLG Salon Adyar: Premium Hair, Skin & Spa Services in Chennai';
$meta_description = 'Experience luxury beauty services at YLG Salon in Adyar, Chennai. We offer expert haircuts, painless waxing, advanced facials, and more. Book your appointment today!';
include 'header.php';

// --- Logic to fetch live review data for the static grid ---
$reviews_data = null;
$testimonial_reviews = [];
$reviews_file = 'reviews.json';
if (file_exists($reviews_file)) {
    $json_content = file_get_contents($reviews_file);
    $reviews_data = json_decode($json_content, true);
    if (!empty($reviews_data['recent_reviews'])) {
        // Take the first 3-6 reviews for the grid
        $testimonial_reviews = array_slice($reviews_data['recent_reviews'], 0, 3);
    }
}
// Function to generate star icons
function generate_stars_index($rating) {
    $stars_html = '';
    for ($i = 0; $i < 5; $i++) {
        $stars_html .= '<i class="fas fa-star ' . ($i < floor($rating) ? 'text-yellow-400' : 'text-gray-300') . '"></i>';
    }
    return $stars_html;
}
?>

<!-- Hero Section -->
<section class="relative h-[70vh] bg-cover bg-center" style="background-image: url('<?php echo $images['hero']; ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center text-white p-4">
            <h1 class="text-5xl md:text-7xl font-playfair font-bold mb-4 leading-tight">You Look Great.</h1>
            <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">Welcome to YLG, the premier <strong class="text-white">luxury salon in Adyar</strong>. Discover a new standard of beauty with our personalized hair, skin, and wellness services.</p>
            <a href="<?php echo $booking_urls['main']; ?>" target="_blank" class="bg-ylg-pink text-white px-10 py-4 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold text-lg">Book an Appointment</a>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-playfair font-bold mb-4 text-gray-800">Your Sanctuary of Style in Adyar</h2>
                <p class="text-gray-600 leading-relaxed">
                    Step into a world where your beauty and well-being are our passion. YLG Salon Adyar is more than just a salon; it's a destination built on care, respect, and a passion for excellence. As the <strong class="text-gray-900">best hair salon in Adyar</strong>, our expert stylists and therapists use only world-class products to craft a look that is uniquely you.
                </p>
            </div>
            <div class="rounded-lg overflow-hidden shadow-2xl">
                <img src="<?php echo $images['salon_interior']; ?>" alt="Interior of YLG Salon Adyar" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- ENHANCED Priority Service: Waxing -->
<section class="py-20 bg-pink-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-playfair font-bold mb-3 text-gray-800">The Society of Smooth</h2>
        <p class="text-xl text-ylg-pink font-semibold mb-6">Experience the Best <strong class="text-ylg-pink">Painless Waxing Adyar</strong> Has to Offer.</p>
        <p class="max-w-4xl mx-auto text-gray-600 leading-relaxed mb-8">
            Forget everything you know about painful waxing. At YLG, we've pioneered a revolutionary approach designed for your comfort and hygiene. Our signature Waxing 2.0 system uses hygienic, single-use cartridges that glide smoothly over your skin. The wax itself is a scientific breakthrough, formulated to grip hair, not skin. The result? A virtually painless experience, no burns, no rashes, and impeccably smooth, de-tanned skin.
        </p>
        <div class="flex justify-center items-center space-x-4">
             <a href="service_category.php?category=waxing" class="bg-ylg-orange text-white px-8 py-3 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold text-lg">Explore Waxing Services</a>
             <a href="<?php echo $whatsapp_links['waxing']; ?>" target="_blank" class="bg-green-500 text-white px-8 py-3 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold text-lg flex items-center">
                <i class="fab fa-whatsapp mr-2"></i> Inquire Now
            </a>
        </div>
    </div>
</section>

<!-- NEW: Static Testimonial Section -->
<?php if (!empty($testimonial_reviews)): ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-playfair font-bold text-gray-800">What Our Clients Say</h2>
            <p class="mt-4 text-lg text-gray-600">Real reviews from our happy Google-verified customers.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($testimonial_reviews as $review): ?>
            <div class="bg-stone-100 p-8 rounded-lg shadow-lg text-center h-full flex flex-col justify-between">
                <i class="fas fa-quote-left text-4xl text-ylg-pink opacity-20 mb-4"></i>
                <p class="text-gray-600 italic mb-6">"<?php echo htmlspecialchars(substr($review['snippet'], 0, 150)); ?>..."</p>
                <div>
                    <div class="text-yellow-400 text-2xl mb-2">
                        <?php echo generate_stars_index($review['rating']); ?>
                    </div>
                    <p class="font-bold text-lg text-gray-800"><?php echo htmlspecialchars($review['user_name']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ENHANCED Explore Our Services Section -->
<section class="py-20 bg-stone-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-playfair font-bold text-gray-800">Explore Our Full Range of Services</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="service_category.php?category=hair-care" class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-2">Hair Care</h3>
                <p class="text-gray-600">Expert haircuts, coloring, and advanced treatments.</p>
            </a>
            <a href="service_category.php?category=skin-care" class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-2">Skin Care</h3>
                <p class="text-gray-600">Rejuvenating facials for a radiant glow.</p>
            </a>
            <a href="service_category.php?category=mani-pedi" class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-2">Mani & Pedi</h3>
                <p class="text-gray-600">Luxury treatments for your hands and feet.</p>
            </a>
            <a href="service_category.php?category=mens-grooming" class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-2">Men's Grooming</h3>
                <p class="text-gray-600">Precision haircuts, shaves, and treatments.</p>
            </a>
        </div>
    </div>
</section>

<!-- Weekly Offers Section -->
<section class="py-20 bg-pink-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-playfair font-bold text-gray-800">Our Weekly Specials</h2>
            <p class="mt-4 text-lg text-gray-600">Exclusive offers to make your week even more beautiful.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <?php
            // Load specials.json (should be placed in your root or data folder)
            $specials_file = __DIR__ . '/specials.json';
            if (file_exists($specials_file)) {
                $weekly_offers = json_decode(file_get_contents($specials_file), true);
            } else {
                $weekly_offers = [];
            }

            // If you have booking URLs in a config file, load them here
            if (!isset($booking_urls['main'])) {
                $booking_urls['main'] = "#"; // fallback link
            }

            date_default_timezone_set('Asia/Kolkata');
            $today = date('l');

            foreach ($weekly_offers as $day => $offer) {
                $is_today = ($today === $day);
                $card_classes = $is_today ? 'border-4 border-ylg-pink scale-105 shadow-2xl z-10' : 'border-4 border-transparent';
                $button_classes = $is_today ? 'bg-ylg-pink text-white' : 'bg-gray-200 text-gray-700';
                echo '
                <div class="bg-white rounded-lg shadow-lg p-8 text-center transform transition-transform duration-300 relative flex flex-col ' . $card_classes . '">
                    ' . ($is_today ? '<span class="absolute top-0 right-0 bg-ylg-pink text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-md -mt-0.5 -mr-0.5">TODAY\'S OFFER</span>' : '') . '
                    <div class="w-full aspect-video mb-6"><img src="' . $offer['image'] . '" alt="' . $offer['title'] . '" class="w-full h-full object-cover rounded-md"></div>
                    <div class="flex-grow flex flex-col">
                        <h3 class="text-2xl font-playfair font-bold mb-3">' . $offer['title'] . '</h3>
                        <p class="text-gray-600 mb-6 flex-grow">' . $offer['description'] . '</p>
                        <a href="' . $booking_urls['main'] . '" target="_blank" class="inline-block mt-auto px-8 py-3 rounded-full font-bold transition ' . $button_classes . '">Book This Offer</a>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- ENHANCED Brand Partners Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-center text-3xl font-playfair font-bold text-gray-800 mb-4">Our Commitment to Quality</h2>
        <p class="text-center text-gray-600 max-w-2xl mx-auto mb-10">
            We partner with trusted brands like <strong class="text-gray-900">L'Oréal Professionnel</strong> and <strong class="text-gray-900">Schwarzkopf Professional</strong> to ensure your hair and skin receive the premium care they deserve.
        </p>
        <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-8">
            <?php foreach ($images['partner_logos'] as $brand => $logo_url): ?>
                <img src="<?php echo $logo_url; ?>" alt="<?php echo ucfirst($brand); ?> Logo" class="h-12 md:h-16 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition duration-300">
            <?php endforeach; ?>
            <div class="h-12 md:h-16 w-32 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 italic">More Brands</div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
