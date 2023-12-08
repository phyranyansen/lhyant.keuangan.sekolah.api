<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/student', 'Service\Master\StudentController::getStudent');
$routes->post('/student/add','Service\Master\StudentController::addStudent');
$routes->post('/student/delete','Service\Master\StudentController::deleteStudent');
