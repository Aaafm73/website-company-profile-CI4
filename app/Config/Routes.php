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
$routes->setAutoRoute(false);

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');

// Products Routes
$routes->get('/products', 'Products::index');
$routes->get('/products/detail/(:num)', 'Products::detail/$1');

// Checkout Routes
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/add-to-cart', 'Checkout::addToCart', ['filter' => 'throttle:cart']);
$routes->post('/checkout/remove-from-cart', 'Checkout::removeFromCart', ['filter' => 'throttle:cart']);
$routes->post('/checkout/update-cart', 'Checkout::updateCart', ['filter' => 'throttle:cart']);
$routes->post('/checkout/process', 'Checkout::process', ['filter' => 'throttle:checkout']);

// Dashboard Routes
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/contact', 'Dashboard::contact');
$routes->post('/dashboard/send-contact', 'Dashboard::sendContact', ['filter' => 'throttle:contact']);
$routes->post('/dashboard/track-order', 'Dashboard::trackOrder', ['filter' => 'throttle:tracking']);

// Admin Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Auth
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::processLogin', ['filter' => 'throttle:admin-login']);
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function($routes) {
    $routes->post('logout', 'Auth::logout');

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

