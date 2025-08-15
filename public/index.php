<?php

require_once '../vendor/autoload.php';

use Flight;
use Latte\Engine;
use App\AssetManager;

// Initialize Latte
$latte = new Engine();
$latte->setTempDirectory('../cache/latte');

// Initialize Asset Manager  
$assetManager = new AssetManager();

// Routes
Flight::route('/', function() use ($latte, $assetManager) {
    // Compile assets
    $cssFile = $assetManager->compileSCSS(['main.scss']);
    $jsFile = $assetManager->minifyJS(['main.js']);

    // Portfolio data
    $data = [
        'personal' => [
            'name' => 'Parth Sinha',
            'title' => 'Full Stack Engineer', 
            'description' => 'Detail-oriented Full Stack Engineer dedicated to building high-quality products.',
            'location' => [
                'city' => 'Oxford',
                'country' => 'United Kingdom'
            ],
            'email' => 'sinhaparth555@gmail.com',
            'phone' => '+447306179724',
            'github' => 'https://github.com/sinhaparth5',
            'linkedin' => 'https://www.linkedin.com/in/parth-sinha18/',
            'twitter' => 'https://x.com/sinhaparth555'
        ],
        'about' => 'Frontend-focused Full Stack Engineer specializing in high-performance React applications, scalable Node.js services, and real-time collaboration systems.',
        'skills' => [
            'Frontend' => ['React', 'Vue.js', 'TypeScript', 'HTML5', 'CSS3'],
            'Backend' => ['Node.js', 'PHP', 'Python', 'Express.js', 'REST APIs'],
            'Database' => ['MongoDB', 'PostgreSQL', 'MySQL', 'Redis'],
            'DevOps' => ['Docker', 'AWS', 'Nginx', 'CI/CD']
        ],
        'currentYear' => date('Y'),
        'initials' => strtoupper(substr('Parth Sinha', 0, 1) . substr('Sinha', 0, 1)),
        'assets' => [
            'css' => $cssFile,
            'js' => $jsFile
        ]
    ];
    
    echo $latte->renderToString('../templates/portfolio.latte', $data);
});

// Serve cached assets
Flight::route('/cache/@file', function($file) {
    $filePath = 'cache/' . $file;
    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header('Content-Type: ' . $mimeType);
        header('Cache-Control: public, max-age=31536000');
        readfile($filePath);
        exit;
    }
    Flight::notFound();
});

Flight::start();