<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login', ['filter' => 'guest']);
$routes->post('/login', 'Auth::authenticate', ['filter' => 'guest']);

$routes->get('/register', 'Auth::register', ['filter' => 'guest']);
$routes->post('/register', 'Auth::createUser', ['filter' => 'guest']);

$routes->delete('/logout', 'Auth::logout', ['filter' => 'authenticated']);

$routes->get('/dashboard', function () {
    return view('dashboard');
}, ['filter' => 'authenticated']);