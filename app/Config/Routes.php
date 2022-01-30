<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'GeneralUserController::index');
$routes->match(['get','post'],'register', 'GeneralUserController::register');
$routes->match(['get','post'],'login', 'GeneralUserController::login');
$routes->match(['get','post'],'logout', 'GeneralUserController::logout');
$routes->get('/browseproducts/(:any)', 'GeneralUserController::browseproducts/$1');
$routes->match(['get','post'],'/browseproducts', 'GeneralUserController::browseproducts');

$routes->get('/Customer', 'CustomerController::index');
$routes->match(['get','post'],'/addToCart/(:any)', 'CustomerController::addToCart/$1');
$routes->get('/addToCart/(:any)', 'CustomerController::addToCart/$1');
$routes->get('/removeFromCart/(:any)', 'CustomerController::removeFromCart/$1');
$routes->get('/viewCart','CustomerController::viewCart');
$routes->get('/wishlist','CustomerController::viewWishlist');
$routes->match(['get','post'],'/addToWishlist/(:any)','CustomerController::addToWishlist/$1');
$routes->get('/removeFromWishlist/(:any)', 'CustomerController::removeFromWishlist/$1');
$routes->get('/orders','CustomerController::orders');
$routes->get('/orderdetails/(:any)', 'CustomerController::orderDetails/$1');
$routes->match(['get','post'],'/amendorderdetails/(:any)','CustomerController::amendorderdetails/$1');
$routes->match(['get','post'],'/addProductToOrder/(:any)/(:any)','CustomerController::addProductToOrder/$1/$2');
$routes->get('/removeProductFromOrder/(:any)/(:any)','CustomerController::removeProductFromOrder/$1/$2');
$routes->match(['get','post'],'/checkout','CustomerController::checkout');

$routes->get('/Administrator', 'AdministratorController::index');
$routes->get('/viewproducts', 'AdministratorController::viewproducts');
$routes->match(['get','post'],'/addproduct', 'AdministratorController::addproduct');
$routes->match(['get','post'],'/editproduct/(:any)', 'AdministratorController::editproduct/$1');
$routes->match(['get','post'],'/editproduct/', 'AdministratorController::editproduct/');
$routes->get('/allorders', 'AdministratorController::allorders');
$routes->get('/customerorders/(:any)', 'AdministratorController::customerorders/$1');
$routes->get('/removeproduct/(:any)', 'AdministratorController::removeproduct/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
