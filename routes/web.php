<?php

$router->get('/', 'HomeController@home')->only('guest');

$router->get('/submit-a-ticket', 'Guest/GuestController@show')->only('guest');
$router->post('/submit', 'Guest/GuestController@submit')->only('guest');
$router->get('/thank-you', 'Guest/GuestController@ty')->only('guest');
$router->get('/check-tickets', 'Guest/GuestController@check')->only('guest');

$router->get('/admin/login', 'Admin/AuthController@loginForm')->only('guest');
$router->post('/admin/login', 'Admin/AuthController@login')->only('guest');

$router->post('/admin/logout', 'Admin/AuthController@logout')->only('auth');

$router->get('/admin/dashboard', 'Admin/DashboardController@index')->only('auth');
$router->get('/admin/dashboard/ticket', 'Admin/DashboardController@show')->only('auth');
$router->patch('/admin/dashboard/ticket', 'Admin/DashboardController@update')->only('auth');

//$router->get('/admin/download/ticket-document');