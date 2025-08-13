<?php // FILE: thank-you.php ?>
<?php
$page_title = 'Thank You for Contacting Us | YLG Salon Adyar';
$meta_description = 'Thank you for your message. We have received your inquiry and will get back to you shortly.';
include 'header.php';
?>

<div class="container mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Get In Touch</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">We'd love to hear from you! Reach out with any questions or book your next appointment.</p>
    </div>

    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="grid md:grid-cols-2">
            
            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="text-center">
                    <i class="fas fa-check-circle text-6xl text-green-500 mb-6"></i>
                    <h2 class="text-3xl font-playfair font-bold text-gray-800 mb-4">Message Sent Successfully!</h2>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Thank you for reaching out. Our team will review your message and get back to you within 24 business hours.
                    </p>
                </div>
                <div class="border-t pt-6 text-center">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">What's Next?</h3>
                    <div class="space-y-3">
                        <a href="services.php" class="text-ylg-pink hover:underline font-semibold">→ Explore Our Services</a><br>
                        <a href="<?php echo $booking_urls['main']; ?>" target="_blank" class="text-ylg-pink hover:underline font-semibold">→ Book an Appointment Online</a><br>
                        <a href="index.php" class="text-ylg-pink hover:underline font-semibold">→ Return to the Homepage</a>
                    </div>
                </div>
            </div>

            <div class="bg-stone-100 p-8 md:p-12">
                <div class="space-y-6 text-gray-700">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-2xl text-ylg-pink w-8 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-lg">Address</h3>
                            <p><?php echo $business_details['address']; ?></p>
                            <a href="<?php echo $business_details['Maps_link']; ?>" target="_blank" class="text-ylg-pink hover:underline font-bold mt-1 inline-block">Get Directions</a>
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