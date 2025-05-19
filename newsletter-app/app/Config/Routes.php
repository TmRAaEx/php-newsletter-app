<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->setAutoRoute(false);
$routes->get('/', 'Pages::home');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/newsletters', 'Newsletters::index');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/profile', 'Profile::index'); 
    $routes->post('/logout', 'Auth::logout');   
    $routes->post('/logout-all', 'Auth::logoutAll');   
});

$routes->group('', ['filter' => 'subscriber'], function ($routes) {
    $routes->get('/newsletters/(:num)', 'Newsletters::single/$1');
    $routes->post('/newsletters/subscribe', 'Newsletters::subscribe');
});
