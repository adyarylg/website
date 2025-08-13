<?php // FILE: header.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'YLG Salon Adyar'; ?></title>
    <meta name="description" content="<?php echo $meta_description ?? 'Welcome to YLG Salon Adyar, your one-stop destination for premium beauty and wellness services.'; ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'ylg-pink': '#D91A5D',
            'ylg-orange': '#F26C24',
            'ylg-green': '#8BC53F'
          },
          typography: (theme) => ({
            DEFAULT: {
              css: {
                color: theme('colors.gray.700'),
                a: { color: theme('colors.ylg-pink'), '&:hover': { color: theme('colors.ylg-orange'), }, },
                h2: { fontFamily: "'Playfair Display', serif", },
                h3: { fontFamily: "'Playfair Display', serif", },
                h4: { fontFamily: "'Playfair Display', serif", },
                strong: { color: theme('colors.gray.800'), fontWeight: '700', },
              },
            },
          }),
        }
      }
    }
  </script>
  
  <?php include_once 'data.php'; ?>
  
  <!-- UPDATED: Google Analytics & Facebook Pixel Integration -->
  <?php if (isset($api_keys['google_analytics_id']) && !empty($api_keys['google_analytics_id']) && $api_keys['google_analytics_id'] !== 'G-XXXXXXXXXX'): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($api_keys['google_analytics_id']); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo htmlspecialchars($api_keys['google_analytics_id']); ?>');
    </script>
  <?php endif; ?>

  <?php if (isset($api_keys['facebook_pixel_id']) && !empty($api_keys['facebook_pixel_id']) && $api_keys['facebook_pixel_id'] !== '0000000000000'): ?>
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo htmlspecialchars($api_keys['facebook_pixel_id']); ?>');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo htmlspecialchars($api_keys['facebook_pixel_id']); ?>&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
  <?php endif; ?>
  
</head>
<body class="bg-stone-50 font-lato">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="index.php" class="flex items-center">
                <img src="<?php echo $images['logo']; ?>" alt="YLG Salon Adyar Logo" class="w-40 h-auto">
            </a>
            <div class="hidden md:flex items-center space-x-8 text-lg">
                <a href="index.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Home</a>
                <a href="services.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Services</a>
                <a href="blog.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Blog</a>
                <a href="gallery.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Gallery</a>
                <a href="reviews.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Reviews</a>
                <a href="contact.php" class="text-gray-700 hover:text-ylg-pink transition duration-300">Contact</a>
            </div>
            <a href="<?php echo $booking_urls['main']; ?>" target="_blank" class="hidden md:inline-block bg-ylg-pink text-white px-6 py-3 rounded-full hover:bg-opacity-90 transition-transform duration-300 hover:scale-105 font-bold">Book Now</a>
            <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pt-2 pb-4 space-y-2 border-t">
            <a href="index.php" class="block text-gray-700 hover:text-ylg-pink py-2">Home</a>
            <a href="services.php" class="block text-gray-700 hover:text-ylg-pink py-2">Services</a>
            <a href="blog.php" class="block text-gray-700 hover:text-ylg-pink py-2">Blog</a>
            <a href="gallery.php" class="block text-gray-700 hover:text-ylg-pink py-2">Gallery</a>
            <a href="reviews.php" class="block text-gray-700 hover:text-ylg-pink py-2">Reviews</a>
            <a href="contact.php" class="block text-gray-700 hover:text-ylg-pink py-2">Contact</a>
            <a href="<?php echo $booking_urls['main']; ?>" target="_blank" class="block bg-ylg-pink text-white text-center px-6 py-2 rounded-full hover:bg-opacity-90 transition mt-2 font-bold">Book Now</a>
        </div>
    </header>
    <main>