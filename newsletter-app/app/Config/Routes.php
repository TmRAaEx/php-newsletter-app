<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




$routes->setAutoRoute(false);


//public routes
$routes->get('/', 'Pages::home');
$routes->get('/newsletters', 'Newsletters::index');
$routes->get('/message', 'Pages::message');


//password reset routes
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/reset-password-email', 'Auth::resetPasswordEmail');

$routes->get('/reset-password', 'Auth::resetPassword');
$routes->post('/reset-password', 'Auth::resetPassword');
//-------------------



// Auth routes, only accesible if not logged in
$routes->group('', ['filter' => 'noauth'], function ($routes) {
    $routes->get('/register', 'Auth::register');
    $routes->get('/login', 'Auth::login');
    //post requests
    $routes->post('/register', 'Auth::register');
    $routes->post('/login', 'Auth::login');
});
//-------------------


//routes that require an account
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/profile', 'Profile::index');
    $routes->post('/logout', 'Auth::logout');
    $routes->post('/logout-all', 'Auth::logoutAll');
});
//-------------------


// routes that require a subscriber account
$routes->group('', ['filter' => 'subscriber'], function ($routes) {
    $routes->get('/newsletters/(:num)', 'Newsletters::single/$1');
    $routes->post('/newsletters/subscribe', 'Newsletters::subscribe');

    $routes->get('/newsletters/my-subscriptions', 'Subscriptions::subscriptions');
});
//-------------------


//routes that require an customer account
$routes->group('', ['filter' => 'customer'], function ($routes) {
    $routes->get('/newsletters/create', 'Newsletters::create');
    $routes->post('/newsletters/create', 'Newsletters::create');
    $routes->get('/newsletters/edit/(:num)', 'Newsletters::editNewsletter/$1');
    $routes->post('/newsletters/edit/(:num)', 'Newsletters::editNewsletter/$1');
    
    $routes->post('/newsletters/delete/(:num)', 'Newsletters::delete/$1');

    $routes->get('/newsletters/my-newsletters', 'Subscriptions::subscribers');
});