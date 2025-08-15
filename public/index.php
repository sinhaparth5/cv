<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

if ($_SERVER['REQUEST_URI'] === '/api/data') {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from PHP!', 'time' => date('H:i:s')]);
    exit;
}

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    
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
    
    $data = [
        'seo' => $seo,
        'profile' => [
            'name' => 'Parth Sinha',
            'description' => 'Detail-oriented Full Stack Engineer dedicated to building high-quality products.',
            'location' => 'Oxford, United Kingdom',
            'about' => 'Frontend-focused Full Stack Engineer specializing in high-performance React applications, scalable Node.js services, and real-time collaboration systems. Experienced in technical architecture design and remote team leadership.'
        ]
    ];
    
    return $view->render($response, 'index.twig', $data);
});

$app->get('/{path:.*}', function ($request, $response, $args) {
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->run();