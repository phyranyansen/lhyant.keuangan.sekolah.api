<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('login', 'Login::index');
$routes->post('token/refresh', 'Token::refreshToken');

$routes->get('/', 'Home::index');
// $routes->get('me', 'Me::index', ['filter' => 'auth']);

// Student
$routes->post('/student', 'Service\Master\StudentController::getStudent', ['filter' => 'auth']);
$routes->post('/student/add','Service\Master\StudentController::addStudent', ['filter' => 'auth']);
$routes->post('/student/delete','Service\Master\StudentController::deleteStudent', ['filter' => 'auth']);

// Periode
$routes->post('/period/periodActive', 'Service\Master\PeriodController::activePeriod', ['filter' => 'auth']);
$routes->post('/period/periodGet', 'Service\Master\PeriodController::getAllPeriod', ['filter' => 'auth']);
$routes->post('/period/periodAddOrUpdate', 'Service\Master\PeriodController::addOrUpdatePeriod', ['filter' => 'auth']);

// User
$routes->get('/users', 'Service\Master\User::index', ['filter' => 'auth']);
$routes->get('/users/show', 'Service\Master\User::show', ['filter' => 'auth']);
$routes->post('/users/create', 'Service\Master\User::create', ['filter' => 'auth']);

// Pay
$routes->post('/pay/payCheck', 'Service\PayController::checkPayMonth', ['filter' => 'auth']);