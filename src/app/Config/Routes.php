<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('movies', function($routes) {
    $routes->get('', 'Movies::index', ['as' => 'index']);
    $routes->get('show/(:num)', 'Movies::show/$1', ['as' => 'show']);
    $routes->get('edit/', 'Movies::edit', ['as' => 'create', 'filter' => 'session']);
    $routes->get('edit/(:num)', 'Movies::edit/$1', ['as' => 'edit', 'filter' => 'session']);
    $routes->post('save', 'Movies::save', ['as' => 'save', 'filter' => 'session']);
    $routes->post('delete/(:num)', 'Movies::delete/$1', ['as' => 'delete', 'filter' => 'session']);
});

service('auth')->routes($routes);