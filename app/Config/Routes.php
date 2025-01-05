<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// AUTH SECTION
// login and register
$routes->post('login', 'AuthController::login');
$routes->post('register', 'AuthController::register');

$routes->group('api', ['filter' => 'jwt'], function ($routes) {
    // Subgrup untuk produk
    $routes->group('products', function ($routes) {
        // show all of products data - admin can see all of the products
        $routes->get('', 'ProductController::index');
        // show catalog product that is_active is true - user can see all of the products that are active
        $routes->get('catalog', 'ProductController::showCatalog');
        // show detail product by id - user can see the details of the product
        $routes->get('(:num)', 'ProductController::show/$1');
        // create new product - admin can create new product
        $routes->post('', 'ProductController::create');
        // update product by id - admin can update the product
        $routes->put('(:num)', 'ProductController::update/$1');
        // delete product by id - admin can delete the product
        $routes->delete('(:num)', 'ProductController::delete/$1');
        // search product by name or category - user can search the product by name or category
        $routes->get('search', 'ProductController::search');
    });

    // Subgrup untuk pesanan
    $routes->group('orders', function ($routes) {
        // show all of orders data - admin can see all of the orders
        $routes->get('', 'OrderController::index');
        // create new order - user can create new order
        $routes->post('', 'OrderController::create');
        // show order detail by userID - user can see all of their order
        $routes->get('user/(:num)', 'OrderController::showByUser/$1');
        // show order detail by orderID - user can see the details of the order they made, like the name of product, quantity, and price, shipping address, and total price
        $routes->get('(:num)/user/(:num)', 'OrderController::showDetail/$2/$1');
        // update status order by admin - admin can update the status of the order
        $routes->put('(:num)', 'OrderController::update/$1');
        $routes->get('(:num)/track', 'OrderController::track/$1');
    });

    // Subgrup untuk pembayaran
    $routes->group('payments', function ($routes) {
        // show all of payments data - admin can see all of the payments
        $routes->get('', 'PaymentController::index');
        // create new payment - user can create new payment
        $routes->post('', 'PaymentController::create');
        // update status payment by id - admin can update the status of the payment
        $routes->put('', 'PaymentController::update');
        // show payment history by userID - user can see all of their payment history
        $routes->get('history/(:num)', 'PaymentController::history/$1');
        // check payment by status - admin can check the all of payment by status
        $routes->get('check/(:alpha)', 'PaymentController::check/$1');
    });
});

// hello
$routes->get('hello', 'Hello::index');
// test db
$routes->get('test', 'Test::index');

