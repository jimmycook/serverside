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
     *
     * @param  string $templateName
     * @param  array $args
     *
     * @return  string
     */
    public function render($templateName, $args = [], $baseTemplateName = 'app')
    {

        $templateFullPath = __DIR__ . $this->templatePath . $templateName . '.php';
        $baseTemplate = __DIR__ . $this->templatePath . $baseTemplateName . '.php';

        // Render the specific template
        ob_start();
        extract($args);
        require($templateFullPath);
        $template = ob_get_clean();

        // Render the framework template, which echoes out a template variable by default
        ob_start();
        require($baseTemplate);
        $response = ob_get_clean();

        // Return the rendered response
        return $response;
    }

}
