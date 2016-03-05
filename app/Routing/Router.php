<?php

namespace App\Routing;

use App\Routing\Route;

class Router
{

    public $uri;

    protected $routes;


    function __construct($routes)
    {

        $this->routes = [];

        $router = $this;

        require(__DIR__ . '/../routes.php');

        print_r($router);
        die();

        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * Checks the current route against
     * all of the routes in the system
     * @return App\Routing\Route
     */
    public function currentRoute()
    {
        foreach($routes as $route)
        {
            if($this->uri == $route->uri)
            {
                return $route;
            }
        }
        return null;
    }

    /**
     * Add a route to be caught by any HTTP request method
     * @param  String $uri      the uri for this route
     * @param  Closure $response the response anonymous function
     * @return boolean
     */
    public function any($uri, $response)
    {
        $this->checkRoute($uri);

        $route = new Route($uri, $reponse);
        $this->routes[] = $route;
        print_r($route);
        die();

    }

    /**
     * Check the route is available
     * @param $uri String the uri to check
     * @param $method String the HTTP method being used
     */
    private function checkRoute($uri, $method = 'any')
    {
        foreach($this->routes as $route)
        {
            if($route->uri == $uri)
            {
                if($method == 'any')
                {
                    throw new Exception("Route already exists", 1);

                }
                elseif ($route->method == $method) {
                    throw new Exception("Route already exists", 1);
                }
            }
        }
    }

}
