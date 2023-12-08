<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('token/login', 'Login::index');
$routes->post('token/refresh', 'Login::refreshToken');
$routes->get('me', 'Me::index', ['filter' => 'auth']);
$routes->get('users', 'User::index', ['filter' => 'auth']);