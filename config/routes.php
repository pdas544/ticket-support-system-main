<?php

/***
 * 
 *   
 * NOTE: Do not create separate routes /tickets and /admin/tickets instead implement RBAC in the controller 
 * Single source of truth: /tickets calls the index() method of TicketController
 * 
 *
 * Role based access Control: Implement the functionality inside the Controller based on Session
 * Session::user['role']
 * if user['role'] === 'admin' then get all the tickets and redirect to appropriate view
 * if user['role'] === 'agent' then get all the tickets based on agent id and redirect to appropriate view

 *
 */


$router = new AltoRouter();


$router->map('GET', '/', [
    'controller' => 'App\Controllers\HomeController',
    'action'     => 'index',
], 'home');


$router->map('GET', '/tickets/create',  [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'create',
], 'create_ticket');



$router->map('GET', '/tickets', [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'index',
    'middleware' => ['auth']
], 'ticket_index');

$router->map('GET', '/tickets/check-status',  [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'showStatusForm',

], 'check_status');

$router->map('POST', '/tickets/search',  [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'processSearch',

], 'process_search');

$router->map('GET', '/tickets/[*:id]',  [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'show',

], 'show_ticket');


$router->map('POST', '/tickets', [
    'controller' => 'App\Controllers\TicketController',
    'action'     => 'store',

], 'store_ticket');



$router->map('GET', '/register', [
    'controller' => 'App\Controllers\UserController',
    'action'     => 'create',
    'middleware' => ['guest']
], 'create_user');

$router->map('POST', '/register', [
    'controller' => 'App\Controllers\UserController',
    'action'     => 'store',

], 'store_user');


$router->map('GET', '/auth/login', [
    'controller' => '\App\Controllers\UserController',
    'action'     => 'login',
    'middleware' => ['guest']
], 'login');


$router->map('POST', '/auth/login', [
    'controller' => 'App\Controllers\UserController',
    'action'     => 'authenticate'
], 'login_user_post');

$router->map('GET', '/auth/logout', [
    'controller' => 'App\Controllers\UserController',
    'action'     => 'logout',
    'middleware' => ['auth']
], 'logout_user');

$router->map('GET', '/dashboard', [
    'controller' => 'App\Controllers\UserController',
    'action'     => 'showDashboard',
    'middleware' => ['auth']
], 'dashboard');


return $router;
