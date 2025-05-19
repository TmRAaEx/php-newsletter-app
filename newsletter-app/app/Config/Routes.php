<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




$routes->setAutoRoute(false);


//public pages
$routes->get('/', 'Pages::home');
$routes->get('/newsletters', 'Newsletters::index');
$routes->get('/message', 'Pages::message');





// Auth pages, only accesible if not logged in
$routes->group('', ['filter' => 'noauth'], function ( $routes) {
    $routes->get('/register', 'Auth::register');
    $routes->get('/login', 'Auth::login');
    //post requests
    $routes->post('/register', 'Auth::register');
    $routes->post('/login', 'Auth::login');
});


//pages that require an account
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/profile', 'Profile::index'); 
    $routes->post('/logout', 'Auth::logout');   
    $routes->post('/logout-all', 'Auth::logoutAll');   
});

// pages that require a subscriber account
$routes->group('', ['filter' => 'subscriber'], function ($routes) {
    $routes->get('/newsletters/(:num)', 'Newsletters::single/$1');
    $routes->post('/newsletters/subscribe', 'Newsletters::subscribe');
});

//pages that require an customer account