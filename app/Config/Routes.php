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

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'authenticated']);

// Category Management
$routes->group('categories', ['filter' => ['authenticated']], function ($routes) {
    $routes->get('/', 'ProductCategory::index');
    $routes->get('new', 'ProductCategory::new');
    $routes->post('/', 'ProductCategory::create');
    $routes->get('(:num)/edit', 'ProductCategory::edit/$1');
    $routes->put('(:num)', 'ProductCategory::update/$1');
    $routes->delete('(:num)/delete', 'ProductCategory::delete/$1');
});

// Admin User Management
$routes->group('users', ['filter' => ['authenticated', 'role:admin']], function ($routes) {
    $routes->get('/', 'UserManagement::index');
    $routes->get('(:num)/edit', 'UserManagement::edit/$1');
    $routes->post('(:num)', 'UserManagement::update/$1');
    $routes->post('(:num)/delete', 'UserManagement::delete/$1');
});
