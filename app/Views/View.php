<?php

namespace App\Views;

/**
* View Templating Engine
*/
class View
{


    public static function render($templateName, $args = [])
    {
        // Get the renderer
        $renderer = new Renderer();

        return $renderer->render($templateName, $args);
    }

}
