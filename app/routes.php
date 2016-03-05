<?php

use App\Views\View;

$router->controller('/', 'App\\Controllers\\PagesController');

$router->any('prototype', function () {
	return View::render('prototype');
});
