<?php

namespace App\Kernel;

use App\Views\View;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class App
{

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    }

    public function boot()
    {
        // Start the session
        session_start();

        // Get the routecollector
		$router = new RouteCollector();



		// Require the routes defined in routes.php
		require(__DIR__ . '/../routes.php');

		// Run the dispatcher
        $dispatcher = new Dispatcher($router->getData());
		$response = $dispatcher->dispatch($this->requestMethod, $this->url);
        echo $response;

    }

    /**
     * [notFound description]
     * @return [type] [description]
     */
    public function notFound()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo View::render('404');
    }
}
