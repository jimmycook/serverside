<?php
// Require the autoloader
require __DIR__.'/../vendor/autoload.php';

// Set the envirionment variables
require __DIR__.'/../app/Helpers/helpers.php';

// Start the app
$app = new App\Kernel\App();

try {
    $app->boot();
} catch (Exception $e) {
    $app->notFound();
}
