<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('login', 'Login::index');
$routes->post('token/refresh', 'Token::refreshToken');

$routes->get('/', 'Home::index');
// $routes->get('me', 'Me::index', ['filter' => 'auth']);

$routes->post('/student', 'Service\Master\StudentController::getStudent', ['filter' => 'auth']);
$routes->post('/student/add','Service\Master\StudentController::addStudent', ['filter' => 'auth']);
$routes->post('/student/delete','Service\Master\StudentController::deleteStudent', ['filter' => 'auth']);
$routes->get('/users', 'Service\Master\User::index', ['filter' => 'auth']);
$routes->get('/users/show', 'Service\Master\User::show', ['filter' => 'auth']);