<?php

namespace App\Services;

use App\Views\View;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class App
{

    private $requestMethod;
    private $url;
    private $router;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Run the application;
     */
    public function boot($router)
    {
        session_start();

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
     * Draw the 404 error page
     * @return void
     */
    public function notFound()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo View::render('errors/404');
    }
}
