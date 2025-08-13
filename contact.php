<?php // FILE: contact.php ?>
<?php
$page_title = 'Contact YLG Salon Adyar | Book Your Appointment';
$meta_description = 'Contact YLG Salon in Adyar, Chennai. Find our address, phone number, and book your appointment online. We are located in Gandhi Nagar.';
include 'header.php';
?>

<div class="container mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Get In Touch</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">We'd love to hear from you! Reach out with any questions or book your next appointment.</p>
    </div>

    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="grid md:grid-cols-2">
            <div class="p-8 md:p-12">
                <h2 class="text-3xl font-playfair font-bold text-gray-800 mb-6">Send Us a Message</h2>
                
                <form action="https://formsubmit.co/adyar.ylg@gmail.com" method="POST" class="space-y-6">
    
                    <input type="hidden" name="_next" value="https://ylgsalonadyar.lsentreprises.in/thank-you.php">

                    <div>
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ylg-pink" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ylg-pink" required>
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700 font-bold mb-2">Mobile Number</label>
                        <input type="tel" id="phone" name="phone" value="+91 " class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ylg-pink">
                    </div>
                    <div>
                        <label for="message" class="block text-gray-700 font-bold mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ylg-pink" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-ylg-pink text-white px-6 py-4 rounded-full hover:bg-opacity-90 transition font-bold text-lg">Send Message</button>
                </form>

            </div>

            <div class="bg-stone-100 p-8 md:p-12">
                <div class="space-y-6 text-gray-700">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-2xl text-ylg-pink w-8 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-lg">Address</h3>
                            <p><?php echo $business_details['address']; ?></p>
                            <a href="<?php echo $business_details['google_maps_link']; ?>" target="_blank" class="text-ylg-pink hover:underline font-bold mt-1 inline-block">Get Directions</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-phone-alt text-2xl text-ylg-pink w-8 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-lg">Phone</h3>
                            <a href="tel:<?php echo $business_details['phone']; ?>" class="hover:text-ylg-pink"><?php echo $business_details['phone']; ?></a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-2xl text-ylg-pink w-8 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-lg">Email</h3>
                            <a href="mailto:<?php echo $business_details['email']; ?>" class="hover:text-ylg-pink"><?php echo $business_details['email']; ?></a>
                        </div>
                    </div>
                     <div class="flex items-start">
                        <i class="fab fa-whatsapp text-2xl text-ylg-pink w-8 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-lg">WhatsApp</h3>
                            <a href="<?php echo $whatsapp_links['general']; ?>" target="_blank" class="hover:text-ylg-pink">Chat with us</a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 rounded-lg overflow-hidden shadow-md">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15549.119037423676!2d80.250964!3d13.017894!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267d2b45e0e7b%3A0xe333455197415175!2sYLG%20Salon%2C%20Adyar!5e0!3m2!1sen!2sin!4v1678886400000!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
