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
    "google_analytics_id" => "G-13WY2003GT",
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
    ]
];

// --- SEO Category Info ---
$service_category_info = [
    "waxing" => ["name" => "Waxing Services", "title" => "Painless Brazilian & Bikini Waxing in Adyar | YLG Salon", "meta_description" => "Discover the art of painless waxing at YLG Adyar. We specialize in hygienic, stripless Brazilian and bikini waxing for sensitive skin."],
    "hair-care" => ["name" => "Hair Care", "title" => "Expert Haircut, Colour & Treatments in Adyar | YLG Salon", "meta_description" => "From precision haircuts to advanced L'Oréal hair colour and Botoplexx treatments, discover the best hair care in Adyar at YLG."],
    "skin-care" => ["name" => "Skin Care", "title" => "Advanced Facials & European Light Therapy in Adyar | YLG", "meta_description" => "Experience revolutionary European Light Therapy (ELT) facials, Bridal Facials, and premium skin treatments at YLG Adyar for a radiant glow."],
    "mani-pedi" => ["name" => "Mani & Pedi", "title" => "Luxury Manicure & Pedicure in Adyar | YLG Salon", "meta_description" => "Indulge in luxury manicures and pedicures from Bombini, Mintree, and more at YLG Salon Adyar for beautiful, pampered hands and feet."],
    "mens-grooming" => ["name" => "Men's Grooming", "title" => "Men's Grooming in Adyar | Haircut, Shave & Spa | YLG Salon", "meta_description" => "Discover expert men's haircuts, styling, premium shaves, and relaxing hair spa treatments designed for the modern man at YLG Salon Adyar."]
];

// --- Category Links for services.php ---
$service_categories = [
    "waxing" => [
        "name" => "Waxing Services",
        "image" => $images['categories']['waxing'],
        "link" => "service_category.php?category=waxing"
    ],
    "hair-care" => [
        "name" => "Hair Care",
        "image" => $images['categories']['hair-care'],
        "link" => "service_category.php?category=hair-care"
    ],
    "skin-care" => [
        "name" => "Skin Care",
        "image" => $images['categories']['skin-care'],
        "link" => "service_category.php?category=skin-care"
    ],
    "mani-pedi" => [
        "name" => "Mani & Pedi",
        "image" => $images['categories']['mani-pedi'],
        "link" => "service_category.php?category=mani-pedi"
    ],
    "mens-grooming" => [
        "name" => "Men's Grooming",
        "image" => $images['categories']['mens-grooming'],
        "link" => "service_category.php?category=mens-grooming"
    ]
];

?>
