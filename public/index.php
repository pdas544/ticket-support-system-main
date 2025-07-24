<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ErrorController;
use App\Core\Session;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;


Session::start();

require '../helpers.php';

// Middleware mapping configuration
$middlewareMap = [
    'auth'  => AuthMiddleware::class,
    'admin' => AdminMiddleware::class
];

//load the routes and initialize the router
$router = require __DIR__ . '../../config/routes.php';


// Match current request
$match = $router->match();


if ($match) {
    $session = new Session();

    $target = $match['target'];
    $params = $match['params'];

    if (!empty($target['middleware'])) {
        foreach ($target['middleware'] as $middlewareName) {
            if (isset($middlewareMap[$middlewareName])) {
                $middlewareClass = $middlewareMap[$middlewareName];
                $middleware = new $middlewareClass($session);
                $middleware->handle();
            }
        }
    }

    $controller = new $target['controller']();
    $action = $target['action'];



    // Execute controller action
    try {
        call_user_func_array([$controller, $action], $params);
    } catch (Exception $e) {
        // ErrorController::notFound();
    }
} else {
    ErrorController::notFound();
}
