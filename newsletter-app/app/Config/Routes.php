<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/profile', 'Profile::index');

});

$routes->get('/newsletters', 'Newsletters::index');
$routes->get('/newsletters/(:num)', 'Newsletters::Single/$1');