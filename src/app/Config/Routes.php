<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('movies', function($routes) {
    $routes->get('', 'Movies::index', ['as' => 'index']);
    $routes->get('show/{id}', 'Movies::show', ['as' => 'show']);
    $routes->get('edit/{id?}', 'Movies::edit', ['as' => 'edit']);
    $routes->post('save', 'Movies::save', ['as' => 'save']);
    $routes->post('delete/{id}', 'Movies::delete', ['as' => 'delete']);
});
