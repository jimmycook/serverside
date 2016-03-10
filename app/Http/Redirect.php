<?php

namespace App\Http;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class Redirect
{

    private $requestMethod;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function home()
    {

    }

    public function dispatch($uri)
    {
        // Get the routecollector
		$router = new RouteCollector();

        // Require any route filters
        require(__DIR__ . '/../filters.php');

		// Require the routes
		require(__DIR__ . '/../routes.php');

        $url = parse_url($uri, PHP_URL_PATH);

		// Run the dispatcher
        $dispatcher = new Dispatcher($router->getData());
		$response = $dispatcher->dispatch($this->requestMethod, $url);
        echo $response;
        die();
    }

}
