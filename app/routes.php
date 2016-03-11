<?php

use App\Views\View;
use App\Services\Database;


$router->controller('/', 'App\\Controllers\\PagesController');

$router->get('test', function() {

	$database = Database::getInstance();
	$database->query('INSERT INTO users VALUES (1)');
	$users = $database->query('SELECT * FROM users');

	dd($users);
});

$router->any('create', function() {
	return View::render('createListing');
}, ['before' => 'check']);

$router->any('prototype', function () {
	return View::render('prototype');
});
