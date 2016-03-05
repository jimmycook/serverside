<?php

namespace App\Views;

use App\Response;

class Renderer
{

    protected $templatePath;

    /**
     * Constructor
     *
     * @param string $templatePath
     */
    public function __construct($templatePath = "templates/")
    {
        $this->templatePath = $templatePath;
    }

    /**
     * Render the template
     * @param  \App\Response $reponse
     * @param  string $templateName
     * @param  array $args
     *
     * @return  \App\Response $response
     */
    public function render(Response $response, $templateName, $args = [])
    {

        ob_start();
        extract($args);
        include($this->$templatePath . $templateName . '.php');
        $response->writeBody(ob_get_clean());
        return $response;
    }

}
