<?php

use App\ApiFetcher;
use App\Controllers\ArticleController;
use GuzzleHttp\Client;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';


$apiFetcher = new ApiFetcher(new Client());
$articleController = new ArticleController($apiFetcher);

$loader = new FilesystemLoader('/Users/raivis/PhpstormProjects/web/app/Views');
$twig = new Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/articles', [ArticleController::class, 'index']);
    $r->addRoute('GET', '/article/{id:\d+}', [ArticleController::class, 'show']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $vars = $routeInfo[2];
        [$controller, $method] = $routeInfo[1];

        if ($method === 'show' && isset($vars['id'])) {
            $response = $articleController->$method($vars['id']);
        } else {
            $response = $articleController->$method();
        }

        echo $twig->render($response->getViewName() . '.twig', $response->getData());
        break;
}
