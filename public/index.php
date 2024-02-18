<?php

declare(strict_types=1);

use App\App;
use App\Router;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Intl\IntlExtension;
use App\Controllers\CurlController;
use App\Controllers\HomeController;

use App\Controllers\InvoiceController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// use Illuminate\Container\Container;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');




$app = AppFactory::create();

// $app->get('/', function (Request $request, Response $response, $args) {
//     $view = Twig::fromRequest($request);

//     return $view->render($response, 'index.twig');
// });

$app->get('/', [HomeController::class, 'index'])

// Create Twig
$twig = Twig::create(VIEW_PATH, [
    'cache' => STORAGE_PATH . '/cache',
    'auto_reload' => true
]);
$twig->addExtension(new IntlExtension());

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

$app->run();
// $container = new Container();
// $router    = new Router($container);


// $router->registerRoutesFromControllerAttributes(
//     [
//         HomeController::class,
//         InvoiceController::class,
//         CurlController::class,
//     ]
// );

// (new App(
//     $container,
//     $router,
//     ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
// ))->boot()->run();
