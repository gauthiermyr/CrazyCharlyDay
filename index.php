<?php

use Slim\Views\PhpRenderer;
use Slim\Http\Response;
use Slim\Http\Request;
use crazycharlyday\controllers\AccountController;
use crazycharlyday\controllers\PlanningController;


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
    $controller = new AccountController($this);
    return $controller->getLogin($request, $response, $args);
})->setName('login');

$app->post('/', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->postLogin($request, $response, $args);
});

$app->get('/planning/{semaine:[ABCD]}[/]', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->displayPlanning($request, $response, $args);
})->setName('planning');

$app->get('/planning/{semaine:[ABCD]}/creneau/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->getCreneau($request, $response, $args);
})->setName('getCreneau');

$app->get('/planning/creneau/{id:[0-9]+}[/]', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->getCreneau($request, $response, $args);
})->setName('getCreneau');

$app->get('/inscription[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->getInscription($request, $response, $args);
})->setName('inscription');

$app->post('/inscription[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->postInscription($request, $response, $args);
});

$app->get('/deconnexion[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->getLogout($request, $response, $args);
})->setName('logout');

$app->get('/membres[/]', function (Request $request, Response $response, array $args) {
     $controller = new AccountController($this);
    return $controller->displayUsers($request, $response, $args);
})->setName('members');

$app->get('/compte[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->getCompte($request, $response, $args);
})->setName('account');

$app->post('/editAccount/{id:[0-9]+}[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->postEditAccount($request, $response, $args);
})->setName('editAccount');

$app->post('/changePassword[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->postChangePassword($request, $response, $args);
})->setName('changePassword');

$app->post('/deleteAccount/{id:[0-9]+}[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->postDeleteAccount($request, $response, $args);
})->setName('deleteAccount');

$app->get('/nouveauCreneau[/]', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->getNewCreneau($request, $response, $args);
})->setName('newCreneau');

$app->post('/nouveauCreneau[/]', function (Request $request, Response $response, array $args) {
    $controller = new PlanningController($this);
    return $controller->postNewCreneau($request, $response, $args);
});
$app->get('/gestion[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->displayUsersUpdate($request, $response, $args);
})->setName('gestion');

$app->get('/compte/{id:[0-9]+}[/]', function (Request $request, Response $response, array $args) {
    $controller = new AccountController($this);
    return $controller->getCompteById($request, $response, $args);
})->setName('accountupdate');

/**
 * Run of Slim
 */
$app->run();
