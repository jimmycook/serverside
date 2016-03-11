<?php

use App\Views\View;
use App\Services\Database;


$router->controller('/', 'App\\Controllers\\PagesController');

$router->get('test', function() {

	$database = Database::getInstance();

	$users = $database->query('SELECT * FROM users WHERE id = 123');

	dd($users);
});

$router->any('create', function() {
	return View::render('createListing');
}, ['before' => 'check']);

$router->any('prototype', function () {
	return View::render('prototype');
});
