<?php
// Simple API endpoint
if ($_SERVER['REQUEST_URI'] === '/api/data') {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from PHP!', 'time' => date('H:i:s')]);
    exit;
}

// SEO Configuration
$seo = [
    'title' => 'Parth Sinha - Full Stack Engineer',
    'description' => 'Detail-oriented Full Stack Engineer dedicated to building high-quality products. Specializing in modern web technologies and scalable solutions.',
    'keywords' => 'Full Stack Engineer, Web Developer, PHP, JavaScript, React, Node.js, Software Engineer',
    'author' => 'Parth Sinha',
    'url' => 'https://parthsinha.com',
    'image' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/assets/images/profile.png',
    'type' => 'profile',
    'locale' => 'en_US',
    'site_name' => 'Parth Sinha Portfolio'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parth Sinha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Basic SEO -->
    <title><?= $seo['title'] ?></title>
    <meta name="description" content="<?= $seo['description'] ?>">
    <meta name="keywords" content="<?= $seo['keywords'] ?>">
    <meta name="author" content="<?= $seo['author'] ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $seo['url'] ?>">
    
    <!-- Open Graph (Facebook, LinkedIn) -->
    <meta property="og:title" content="<?= $seo['title'] ?>">
    <meta property="og:description" content="<?= $seo['description'] ?>">
    <meta property="og:image" content="<?= $seo['image'] ?>">
    <meta property="og:url" content="<?= $seo['url'] ?>">
    <meta property="og:type" content="<?= $seo['type'] ?>">
    <meta property="og:locale" content="<?= $seo['locale'] ?>">
    <meta property="og:site_name" content="<?= $seo['site_name'] ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $seo['title'] ?>">
    <meta name="twitter:description" content="<?= $seo['description'] ?>">
    <meta name="twitter:image" content="<?= $seo['image'] ?>">
    <meta name="twitter:creator" content="@bartoszjarocki">
    <meta name="twitter:site" content="@bartoszjarocki">
    
    <!-- WhatsApp -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Bartosz Jarocki - Full Stack Engineer Profile">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#ffffff">
    <meta name="application-name" content="<?= $seo['site_name'] ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="assets/css/style.css" as="style">
    <link rel="preload" href="assets/js/app.js" as="script">

    <link rel="stylesheet" href="assets/css/style.css">
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Bartosz Jarocki",
        "jobTitle": "Full Stack Engineer",
        "description": "<?= $seo['description'] ?>",
        "url": "<?= $seo['url'] ?>",
        "image": "<?= $seo['image'] ?>",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Oxford",
            "addressCountry": "United Kingdom"
        },
        "sameAs": [
            "https://github.com/sinhaparth5",
            "https://www.linkedin.com/in/parth-sinha18",
            "https://x.com/sinhaparth555"
        ]
    }
    </script>
</head>
<body>
    <main class="container">
        <div class="content">
            <div class="header-section">
                <div class="profile-info">
                    <h1>Parth Sinha</h1>
                    <p class="description">Detail-oriented Full Stack Engineer dedicated to building high-quality products.</p>
                    <div class="location">
                        <a class="profile-location" href="https://www.google.com/maps/place/Oxford" target="_blank">
                            <div class="contact-link">
                                <img src="assets/icons/browser.png" />
                            </div>
                            <p>Oxford, United Kingdom</p> 
                        </a>
                    </div>
                    
                    <div class="contact-links">
                        <a href="https://parthsinha.com" class="contact-link" target="_blank"><img src="assets/icons/browser.png" /></a>
                        <a href="mailto:sinhaparth555@gmail.com" class="contact-link" target="_blank"><img src="assets/icons/mail.png" /></a>
                        <a href="tel:+447306179724" class="contact-link" target="_blank""><img src="assets/icons/phone.png" /></a>
                        <a href="https://github.com/sinhaparth5" class="contact-link" target="_blank"><img src="assets/icons/github.png" /></a>
                        <a href="https://www.linkedin.com/in/parth-sinha18/" class="contact-link" target="_blank"><img src="assets/icons/linkedin.png" /></a>
                        <a href="https://x.com/sinhaparth555" class="contact-link" target="_blank"><img src="assets/icons/x.svg" /></a>
                    </div>
                </div>
                
                <div class="profile-image">
                    <img src="assets/images/profile.png" alt="Parth Sinha" />
                </div>
            </div>
            <div id="about-section">
                <div class="about-info">
                    <h2>About</h2>
                    <div class="about-description">
                        Frontend-focused Full Stack Engineer specializing in high-performance React applications, scalable Node.js services, and real-time collaboration systems. Experienced in technical architecture design and remote team leadership.
                    </div>
                </div>
            </div>
            
            <button onclick="loadData()">Load API Data</button>
            <div id="result"></div>
        </div>
    </main>

    <script src="assets/js/app.js"></script>
</body>
</html>