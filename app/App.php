<?php

namespace App;

use App\Views\Rednerer;
use App\Response;
class App
{
    public function start()
    {
    	die('test');
		$renderer = new Renderer();
		$response = new Response();

		$response = $renderer->render($response, 'basetemplate');
    }
}
