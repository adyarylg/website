<?php // FILE: about.php ?>
<?php
$page_title = 'About YLG Salon Adyar | Our Story, Values & Reviews';
$meta_description = 'Learn why YLG is considered the best beauty salon in Adyar, Chennai. Discover our commitment to quality, our expert team, and our passion for making you look great.';
include 'header.php';

// --- NEW: Logic to fetch live review data ---
$reviews_data = null;
$reviews_file = 'reviews.json';
if (file_exists($reviews_file)) {
    $json_content = file_get_contents($reviews_file);
    $reviews_data = json_decode($json_content, true);
}

// Use live data if available, otherwise use fallback from data.php
$rating = $reviews_data['place_info']['rating'] ?? $google_reviews['rating'];
$count = $reviews_data['place_info']['reviews_count'] ?? $google_reviews['count'];

// Function to generate star icons from a rating
function generate_stars_about($rating) {
    $stars_html = '';
    $full_stars = floor($rating);
    $half_star = ceil($rating - $full_stars);
    $empty_stars = 5 - $full_stars - $half_star;
    for ($i = 0; $i < $full_stars; $i++) { $stars_html .= '<i class="fas fa-star"></i>'; }
    if ($half_star) { $stars_html .= '<i class="fas fa-star-half-alt"></i>'; }
    for ($i = 0; $i < $empty_stars; $i++) { $stars_html .= '<i class="far fa-star"></i>'; }
    return $stars_html;
}
?>

<!-- About Us Hero Section -->
<section class="relative h-[40vh] bg-cover bg-center" style="background-image: url('<?php echo $images['about_banner']; ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center text-white p-4">
            <h1 class="text-5xl md:text-6xl font-playfair font-bold">About YLG Adyar</h1>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-12">

            <!-- REWRITTEN: Detailed Content Column -->
            <div class="lg:col-span-2">
                <h2 class="text-4xl font-playfair font-bold text-gray-800 mb-4">The Science of Beauty, The Art of You</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    YLG Salon Adyar is proud to be part of a brand built on a foundation of care, respect, and a relentless passion for excellence. The YLG story began with a simple mission: to create a safe, hygienic, and welcoming space where every client could feel celebrated. We believe that beauty is not just a service, but a science. That's why we are committed to providing scientifically-backed, world-class treatments that deliver real, visible results.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    As the premier <strong>beauty salon in Adyar</strong>, we bring this brand promise to our local community. Our team of certified stylists and therapists are not just experts in their craft; they are consultants dedicated to understanding your unique needs. From our revolutionary, virtually painless <strong>Waxing 2.0</strong> system to our exclusive <strong>European Light Therapy Facials</strong>, every service we offer is designed with your comfort and satisfaction as our top priority.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    We partner with globally recognized brands like <strong>L'Oréal Professionnel</strong> and <strong>Schwarzkopf Professional</strong> to ensure that every treatment uses only the highest quality products. At YLG Adyar, you're not just a customer; you are the center of our universe. Our goal is simple: to make sure that every time you leave our salon, you feel confident, radiant, and ready to affirm, "You Look Great!"
                </p>
            </div>

            <!-- Trust & Quality Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-stone-100 rounded-lg shadow-lg p-8 sticky top-28">
                    <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-4">Trusted by Our Clients</h3>
                    <!-- UPDATED: Live Review Data Section -->
                    <div class="bg-white p-4 rounded-lg text-center">
                        <p class="text-lg text-gray-600">Live Rating on Google</p>
                        <div class="flex items-center justify-center my-2">
                            <span class="text-5xl font-bold text-ylg-orange mr-2"><?php echo $rating; ?></span>
                            <div class="text-yellow-400 text-2xl">
                                <?php echo generate_stars_about($rating); ?>
                            </div>
                        </div>
                        <a href="<?php echo $google_reviews['link']; ?>" target="_blank" class="text-gray-600 hover:text-ylg-pink transition">
                           Based on <strong><?php echo $count; ?></strong> happy reviews
                        </a>
                    </div>

                    <div class="mt-8">
                         <h3 class="text-2xl font-playfair font-bold text-gray-800 mb-4">Our Core Values</h3>
                         <ul class="space-y-3 text-gray-700">
                             <li class="flex items-center"><i class="fas fa-heart text-ylg-pink w-6 mr-2"></i> Care for Customers</li>
                             <li class="flex items-center"><i class="fas fa-eye text-ylg-orange w-6 mr-2"></i> Openness & Transparency</li>
                             <li class="flex items-center"><i class="fas fa-user-check text-ylg-green w-6 mr-2"></i> Respect for the Individual</li>
                             <li class="flex items-center"><i class="fas fa-hands-helping text-ylg-pink w-6 mr-2"></i> Ownership in our Craft</li>
                             <li class="flex items-center"><i class="fas fa-award text-ylg-orange w-6 mr-2"></i> Passion for Excellence</li>
                         </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
