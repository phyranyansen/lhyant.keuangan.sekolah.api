<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/student', 'Service\Master\StudentController::getStudent');
$routes->post('/student/add','Service\Master\StudentController::addStudent');
$routes->post('/student/delete','Service\Master\StudentController::deleteStudent');
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->post('token/login', 'Login::index');
$routes->post('token/refresh', 'Login::refreshToken');
$routes->get('me', 'Me::index', ['filter' => 'auth']);
$routes->get('users', 'User::index', ['filter' => 'auth']);
