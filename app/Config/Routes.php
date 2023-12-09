<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('me', 'Me::index', ['filter' => 'auth']);
$routes->get('users', 'User::index', ['filter' => 'auth']);