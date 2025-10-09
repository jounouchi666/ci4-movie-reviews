<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('movies', function($routes) {
    $routes->get('', 'Movies::index', ['as' => 'index']);
    $routes->get('show/(:num)', 'Movies::show/$1', ['as' => 'show']);
    $routes->get('edit/', 'Movies::edit', ['as' => 'create']);
    $routes->get('edit/(:num)', 'Movies::edit/$1', ['as' => 'edit']);
    $routes->post('save', 'Movies::save', ['as' => 'save']);
    $routes->post('delete/(:num)', 'Movies::delete/$1', ['as' => 'delete']);
});

service('auth')->routes($routes);