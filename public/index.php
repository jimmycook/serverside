<?php

use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

// Require the autoloader
require __DIR__ . '/../vendor/autoload.php';

// Set the envirionment variables
require __DIR__ . '/../app/helpers.php';


// Start the app
$app = new App\Services\App();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $router = new RouteCollector;
    $app->boot($router);
} catch (HttpRouteNotFoundException $e) {
    // Route wasn't found so call the not found
    $app->notFound();
} catch (Exception $e) {
    print_r($e->getMessage());
}
