<?php

namespace App\Kernel;

use App\Views\View;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class App
{

    private $requestMethod;
    private $url;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function boot()
    {
        session_start();
        // Get the routecollector
		$router = new RouteCollector();

        // Require any route filters
        require(__DIR__ . '/../filters.php');

		// Require the routes
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
        echo View::render('errors/404');
    }
}
