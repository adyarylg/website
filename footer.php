<?php // FILE: footer.php ?>
    </main>
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="col-span-1 md:col-span-2">
                    <a href="index.php">
                        <img src="<?php echo $images['logo']; ?>" alt="YLG Salon Adyar Logo" class="w-40 h-auto mb-4">
                    </a>
                    <p class="text-gray-400 max-w-md">
                        Your destination for premium beauty and wellness in Adyar, Chennai. Experience expert care and look great, always.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 tracking-wider uppercase">Explore</h3>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="services.php" class="text-gray-400 hover:text-white transition">Our Services</a></li>
                        <li><a href="blog.php" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="gallery.php" class="text-gray-400 hover:text-white transition">Gallery</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact & Social -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 tracking-wider uppercase">Connect</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt w-5 mt-1 mr-2 text-ylg-pink"></i>
                            <span><?php echo $business_details['address']; ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt w-5 mr-2 text-ylg-pink"></i>
                            <a href="tel:<?php echo $business_details['phone']; ?>" class="hover:text-white transition"><?php echo $business_details['phone']; ?></a>
                        </li>
                    </ul>
                    <div class="mt-6 flex space-x-5">
                        <a href="<?php echo $whatsapp_links['general']; ?>" target="_blank" class="text-gray-400 hover:text-white text-2xl transition" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <!-- Add links to your actual social media profiles here -->
                        <a href="#" class="text-gray-400 hover:text-white text-2xl transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-500">
                <p>&copy; <?php echo date("Y"); ?> YLG Salon Adyar (VS AND GS ASSOCIATES). All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
