<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app = AppFactory::create();

$isDev = ($_ENV['APP_ENV'] ?? 'production') !== 'production';
$app->addErrorMiddleware($isDev, true, true);

$twig = Twig::create(__DIR__ . '/../templates', [
    'cache' => $isDev ? false : __DIR__ . '/../var/twig_cache',
    'debug' => $isDev
]);
$app->add(TwigMiddleware::create($app, $twig));

$trustedHosts = ['cv.parthsinha.com', 'localhost', 'localhost:8000'];

$app->get('/', function (Request $request, Response $response) use ($trustedHosts): Response {
    $view = Twig::fromRequest($request);

    $data = require __DIR__ . '/../data/cv.php';

    $host = $_SERVER['HTTP_HOST'] ?? $trustedHosts[0];
    if (!in_array($host, $trustedHosts, true)) {
        $host = $trustedHosts[0];
    }
    $data['seo']['image'] = 'https://' . $host . '/assets/images/profile.webp';

    return $view->render($response, 'index.twig', $data);
});

$app->get('/{path:.*}', function (Request $request, Response $response): Response {
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->run();
