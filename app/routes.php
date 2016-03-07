<?php

use App\Views\View;

$router->controller('/', 'App\\Controllers\\PagesController');

$router->any('create', function() {
	return View::render('createListing');
});

$router->any('prototype', function () {
	return View::render('prototype');
});
