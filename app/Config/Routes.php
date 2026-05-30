<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

// Default Router Setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');

// Products Routes
$routes->get('/products', 'Products::index');
$routes->get('/products/detail/(:num)', 'Products::detail/$1');

// Checkout Routes
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/add-to-cart', 'Checkout::addToCart');
$routes->post('/checkout/remove-from-cart', 'Checkout::removeFromCart');
$routes->post('/checkout/update-cart', 'Checkout::updateCart');
$routes->post('/checkout/process', 'Checkout::process');

// Dashboard Routes
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/contact', 'Dashboard::contact');
$routes->post('/dashboard/send-contact', 'Dashboard::sendContact');
$routes->post('/dashboard/track-order', 'Dashboard::trackOrder');

// Admin Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Auth
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::processLogin');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Orders Management
    $routes->get('orders', 'Orders::index');
    $routes->get('orders/detail/(:num)', 'Orders::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Orders::updateStatus/$1');
    $routes->post('orders/update-notes/(:num)', 'Orders::updateNotes/$1');
    $routes->post('orders/delete/(:num)', 'Orders::delete/$1');

    // Contacts Management
    $routes->get('contacts', 'Contacts::index');
    $routes->get('contacts/detail/(:num)', 'Contacts::detail/$1');
    $routes->post('contacts/update-status/(:num)', 'Contacts::updateStatus/$1');
    $routes->post('contacts/delete/(:num)', 'Contacts::delete/$1');

    // Products Management
    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->post('products/delete/(:num)', 'Products::delete/$1');

    // Settings Management
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
});

// Additional Routing
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

