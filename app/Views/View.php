<?php

namespace App\Views;

/**
* View Templating Engine
*/
class View
{

    protected $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer(getenv('TEMPLATE_PATH'));
    }

    public function render($template, $args)
    {
        $this->renderer->render($template, $args);
    }

}