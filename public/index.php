<?php

// Require the autoloader
require __DIR__.'/../vendor/autoload.php';

// Set the envirionment variables 
require __DIR__.'/../environment.php';

// Start the app
$app = new Framework\App;
$app->start();
