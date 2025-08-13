<?php // FILE: data.php

// -- CORE BUSINESS DETAILS --
$business_details = [
    "name" => "YLG Salon Adyar",
    "address" => "1st Floor, Second Main Rd, above Kailash Parbat No: 62, Gandhi Nagar, Adyar, Chennai, Tamil Nadu 600020",
    "phone" => "+91 75501 96111",
    "whatsapp_number" => "919150455822",
    "google_maps_link" => "https://maps.app.goo.gl/LjGzrvAtv9Mme71J9",
    "email" => "contact.ylgadyar@example.com"
];

// -- GOOGLE REVIEW STATS (Fallback data) --
$google_reviews = [
    "rating" => "4.7",
    "count" => "1000+",
    "link" => "https://www.google.com/maps/search/?api=1&query=YLG+Salon+Adyar"
];

// -- Centralized WhatsApp Links --
$whatsapp_links = [
    "general" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, I'd like to inquire about your services at YLG Adyar.",
    "waxing" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, I'd like to know more about your painless waxing services.",
    "hair-care" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, I'd like to inquire about your hair services at YLG Adyar.",
    "skin-care" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, I'm interested in your facial treatments at YLG Adyar.",
    "mani-pedi" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, can I get more info on your mani-pedi services at YLG Adyar?",
    "mens-grooming" => "https://wa.me/" . $business_details['whatsapp_number'] . "?text=Hi, I'd like to know more about your men's grooming packages at YLG Adyar."
];

// -- ZYLU BOOKING URLS --
$booking_urls = [
    "main" => "https://app.zylu.co/salon/1280086/services",
    "waxing" => "https://app.zylu.co/business/1280086/services/services-categories/1011?genderSearch=true&name=Wax",
    "hair-care" => "https://app.zylu.co/business/1280086/services/services-categories/1396?genderSearch=true&name=Hair+Services",
    "skin-care" => "https://app.zylu.co/business/1280086/services/services-categories/1034?genderSearch=true&name=Facial",
    "mani-pedi" => "https://app.zylu.co/business/1280086/services/services-categories/1013?genderSearch=true&name=Pedi",
    "mens-grooming" => "https://app.zylu.co/business/1280086/services/services-categories/1026?genderSearch=true&name=Men+Value+Packages"
];

// -- API KEYS --
$api_keys = [
    "google_analytics_id" => "G-XXXXXXXXXX",
    "facebook_pixel_id" => "0000000000000"
];

// -- WEBSITE IMAGES --
$images = [
    "logo" => "images/logo.png",
    "hero" => "images/hero-background.png",
    "salon_interior" => "images/salon-interior.jpg",
    "about_banner" => "images/about-us-banner.png",
    "partner_logos" => [
        "loreal" => "images/loreal_professional.png",
        "schwarzkopf" => "images/schwarzkopf-professional.png"
    ],
    "categories" => [
        "waxing" => "images/service-waxing.png",
        "hair-care" => "images/service-hair.png",
        "skin-care" => "images/service-skin.png",
        "mani-pedi" => "images/service-nails.png",
        "mens-grooming" => "images/service-men.png"
    ],
    "blog" => [
        "hair-spa" => "images/blog/hair-spa.jpg",
        "waxing-guide" => "images/blog/waxing-guide.jpg",
        "bridal-prep" => "images/blog/bridal-prep.jpg"
    ]
];

// -- WEEKLY OFFERS --
$weekly_offers = [
    "Tuesday" => ["title" => "Terrific Tuesday Hair Offer", "description" => "Get 50% OFF on premium Haircuts & Hair Spas when you spend ₹1500 or more.", "image" => "images/Hair-offer.jpg"],
    "Wednesday" => ["title" => "Wonderful Wednesday Botox", "description" => "Experience our revolutionary Botoplexx hair treatment at an incredible 50% OFF.", "image" => "images/wednesday-offer.jpg"],
    "Thursday" => ["title" => "Flawless Skin Thursday", "description" => "Enjoy a flat 50% OFF on all our Premium & Luxury Facials.", "image" => "images/thursday-offer.jpg"]
];

// --- NEW: SIMPLIFIED SERVICE CATEGORY METADATA ---
// This simple array powers the main services.php grid. The detailed content is now in markdown files.
$service_category_info = [
    "waxing" => ["name" => "Waxing Services", "title" => "Painless Brazilian & Bikini Waxing in Adyar | YLG Salon", "meta_description" => "Discover the art of painless waxing at YLG Adyar. We specialize in hygienic, stripless Brazilian and bikini waxing for sensitive skin."],
    "hair-care" => ["name" => "Hair Care", "title" => "Expert Haircut, Colour & Treatments in Adyar | YLG Salon", "meta_description" => "From precision haircuts to advanced L'Oréal hair colour and Botoplexx treatments, discover the best hair care in Adyar at YLG."],
    "skin-care" => ["name" => "Skin Care", "title" => "Advanced Facials & European Light Therapy in Adyar | YLG", "meta_description" => "Experience revolutionary European Light Therapy (ELT) facials, Bridal Facials, and premium skin treatments at YLG Adyar for a radiant glow."],
    "mani-pedi" => ["name" => "Mani & Pedi", "title" => "Luxury Manicure & Pedicure in Adyar | YLG Salon", "meta_description" => "Indulge in luxury manicures and pedicures from Bombini, Mintree, and more at YLG Salon Adyar for beautiful, pampered hands and feet."],
    "mens-grooming" => ["name" => "Men's Grooming", "title" => "Men's Grooming in Adyar | Haircut, Shave & Spa | YLG Salon", "meta_description" => "Discover expert men's haircuts, styling, premium shaves, and relaxing hair spa treatments designed for the modern man at YLG Salon Adyar."]
];

?>
