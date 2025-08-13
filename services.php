<?php
include 'data.php'; // Ensure categories array is loaded
$page_title = 'Our Salon Services in Adyar | Hair, Skin, Waxing & More';
$meta_description = 'Explore the complete service menu at YLG Adyar. We offer a full range of hair services, facials, painless waxing, manicures, pedicures, and men\'s grooming.';
include 'header.php';
?>
<div class="container mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Discover Your Perfect Treatment</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
            From a transformative haircut to a relaxing pedicure, our menu is designed to cater to your every beauty need. Each treatment is performed by a trained expert using industry-leading products.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($service_categories as $slug => $category): ?>
            <a href="service_category.php?category=<?php echo urlencode($slug); ?>" class="group block rounded-lg shadow-lg overflow-hidden relative">
                <img src="<?php echo $images['categories'][$slug]; ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="w-full h-96 object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300 flex items-end p-6">
                    <div>
                        <h2 class="text-3xl font-playfair font-bold text-white mb-2"><?php echo $category['name']; ?></h2>
                        <div class="bg-ylg-pink h-1 w-16"></div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
