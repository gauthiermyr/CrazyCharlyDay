<?php

use Slim\Views\PhpRenderer;
use Slim\Http\Response;
use Slim\Http\Request;

require_once 'vendor/autoload.php';

session_start();

\crazycharlyday\config\Database::connect();


/**
 * Dev. mode to show errors in details
 */
$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];


/**
 * Instanciation of Slim
 */
$app = new Slim\App($config);
$container = $app->getContainer();


$container['view'] = function($container) {
    $vars = [
        "rootUri" => $container->request->getUri()->getBasePath(),
        "router" => $container->router,
        "title" => "Grande Épicerie Générale"
    ];
    $renderer = new PhpRenderer(__DIR__.'/src/views', $vars);
    $renderer->setLayout('layout.phtml');
    return $renderer;
};


/**
 * Middleware HTTPS
 */
$app->add(function (Request $request, Response $response, $next) {
    // redirect with https if not on localhost
    if ($request->getUri()->getScheme() !== 'https' && $request->getUri()->getHost() !== 'localhost') {
        $uri = $request->getUri()->withScheme("https");
        return $response->withRedirect((string)$uri);
    } else {
        return $next($request, $response);
    }
});

$container['notFoundHandler'] = function ($container) {
    return function ($request, Response $response) use ($container) {
        $container->view->render($response, 'errors/404.phtml', ["title" => "404 Not Found"]);
        return $response->withStatus(404);
    };
};


/**
 * Main pages
 */
$app->get('/', function (Request $request, Response $response, array $args) {
    $this->view->render($response, 'home.phtml', ['title' => 'Grande Épicerie Générale - Accueil']);
})->setName('home');


$app->get('/planning[/]', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->displayPlanning($request, $response, $args);
})->setName('register');



/**
 * Run of Slim
 */
$app->run();
