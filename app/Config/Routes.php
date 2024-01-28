<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/barang', 'BarangController::index');
$routes->get('/barang/datatable', 'BarangController::datatable');
$routes->post('/barang/store', 'BarangController::store');
$routes->get('/barang/show/(:num)', 'BarangController::show/$1');
$routes->post('/barang/update/(:num)', 'BarangController::update/$1');
$routes->delete('/barang/delete/(:num)', 'BarangController::delete/$1');

$routes->get('/penjualan', 'PenjualanController::index');
$routes->get('/penjualan/datatable', 'PenjualanController::datatable');
$routes->get('/penjualan/show/(:segment)', 'PenjualanController::show/$1');
$routes->post('/penjualan/store', 'PenjualanController::store');
$routes->delete('/penjualan/delete/(:num)', 'PenjualanController::delete/$1');
