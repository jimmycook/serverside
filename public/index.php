<?php
// Require the autoloader
require __DIR__ . '/../vendor/autoload.php';

// Set the envirionment variables
require __DIR__ . '/../app/helpers.php';

// Start the app
$app = new App\Services\App();

try {
    $router = new Phroute\Phroute\RouteCollector;

    $app->boot($router);
} catch (Exception $e) {
    // Route wasn't found so call the not found
    $app->notFound();
}
