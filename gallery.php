<?php // FILE: gallery.php ?>
<?php
$page_title = 'Gallery | YLG Salon Adyar';
$meta_description = 'View photos of our salon, our work, and our happy clients. See the results of our hair, skin, and beauty treatments.';
include 'header.php';
?>

<div class="container mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">A Glimpse of Our World</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Explore the atmosphere of our salon and see the quality of our work. This is where beauty happens.</p>
    </div>

    <!-- Masonry-style gallery -->
    <div class="columns-2 md:columns-3 gap-4 space-y-4">
        <?php
        $gallery_images = [
            'images/salon-interior.jpg',
            'images/service-hair.png',
            'images/service-skin.png',
            'images/service-nails.png',
            'images/service-waxing.png',
            'images/service-men.png',
            'images/Hair-offer.jpg',
            'images/wednesday-offer.jpg'
        ];
        
        foreach ($gallery_images as $index => $image_url) {
            echo '
            <div class="overflow-hidden rounded-lg shadow-lg break-inside-avoid">
                <img src="' . $image_url . '" alt="YLG Salon Gallery Image ' . ($index + 1) . '" class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-300">
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>