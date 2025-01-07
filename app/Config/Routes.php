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
        $routes->get('(:num)', 'OrderController::showDetail/$1');
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






$routes->get('/logintes', 'Telemed_AuthController::login');
$routes->post('/auth/loginProcess', 'Telemed_AuthController::loginProcess');
$routes->get('/admin/dashboard', 'Telemed_AuthController::adminDashboard');
$routes->get('/admin/logout', 'Telemed_AuthController::logout');
$routes->match(['get', 'post'], '/register', 'Telemed_AuthController::register');
$routes->get('/admin/manage-users', 'Telemed_AuthController::manageUsers');
$routes->get('/signup', 'Telemed_SignupController::index');
$routes->post('/signup', 'Telemed_SignupController::register');
$routes->get('/admin/edit-user/(:num)', 'Telemed_AdminController::editUser/$1');
$routes->post('/admin/update-user/(:num)', 'Telemed_AdminController::updateUser/$1');
$routes->get('/admin/delete-user/(:num)', 'Telemed_AdminController::deleteUser/$1');
$routes->get('/patient/dashboard', 'Telemed_PatientController::dashboard');
$routes->get('/doctor/dashboard', 'Telemed_DoctorController::dashboard');
$routes->get('/doctor/add-schedule', 'Telemed_DoctorController::showAddScheduleForm');
$routes->post('/doctor/add-schedule', 'Telemed_DoctorController::addSchedule');


// Rute untuk dashboard pasien
$routes->get('/patient/dashboard', 'Telemed_PatientController::dashboard');

// Rute untuk form tambah pasien
$routes->get('/patient/add-patient', 'Telemed_PatientController::addPatientForm');

// Rute untuk menyimpan data pasien
$routes->post('/patient/save-patient', 'Telemed_PatientController::savePatient');

// Rute untuk profil pasien
$routes->get('/patient/profile', 'Telemed_PatientController::viewProfile');
$routes->get('/patient/history', 'Telemed_PatientController::viewHistory');
$routes->get('patient/booking', 'Telemed_BookingController::index');
$routes->post('patient/booking/create', 'Telemed_BookingController::create');
$routes->get('/doctor/add-profile', 'Telemed_DataDokterController::index');
$routes->post('/doctor/save', 'Telemed_DataDokterController::save');