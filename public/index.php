<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);

    $data = require __DIR__ . '/../data/cv.php';
    $data['seo']['image'] = 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/profile.webp';

    return $view->render($response, 'index.twig', $data);
});

$app->get('/{path:.*}', function ($request, $response, $args) {
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->run();
