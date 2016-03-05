<?php

namespace App\Kernel;

use App\Views\Renderer;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class App
{

    public function boot()
    {
		$router = new RouteCollector();

		// Require the routes defined in routes.php
		require(__DIR__ . '/../routes.php');

		// Run the dispatcher
		$dispatcher = new Dispatcher($router->getData());

		$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		echo $response;
    }
}
