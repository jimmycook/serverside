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
    public function __construct($templatePath = "/templates/")
    {
        $this->templatePath = $templatePath;
    }

    /**
     * Render the template
     * @param  string $templateName
     * @param  array $args
     *
     * @return  \App\Response $response
     */
    public function render($templateName, $args = [])
    {

        $templateFullPath = __DIR__ . $this->templatePath . $templateName . '.php';

        ob_start();

        extract($args);

        require($templateFullPath);
        $response = ob_get_clean();
        return $response;
    }

}
