<?php 

namespace JimmyCook\Routing;

class Router
{

    public $uri;

    protected $routes;

    protected $currentRoute;

    function __construct() 
    {
        $this->routes = array();     
        $this->currentRoute = $this->currentRoute();
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function get($uri, $closure)
    {

    }

    public function currentRoute()
    {

    }
}