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
$routes->setDefaultController('Home');
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
$routes->get('/', 'User::index');
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->get('/admin/edit(:any)', 'Admin::edit/$1');
$routes->get('/admin/jadwal/(:num)', 'Admin::editjad/$1');
$routes->get('/user/history(:num)', 'User::history/$1');
$routes->get('/admin/pesanan', 'Admin::pesanan');
$routes->get('/user/history', 'User::history');
//$routes->get('/user/ts', 'User::rctransaksi');


$routes->get('/admin/pesanan/(:num)', 'Admin::editpsn/$1');
$routes->get('/admin/pesanan/(:num)', 'Admin::editpsn/$1');
$routes->get('/admin/transaksi/(:num)', 'Admin::invoiceadmin/$1');
$routes->get('/user/ts/(:num)', 'User::invoice/$1');
$routes->get('/user/transaksi/(:num)', 'User::editaksi/$1');
$routes->get('/user/transaksi(:num)', 'User::editrci/$1');
$routes->put('/user/transaksi/(:num)', 'User::editrci/$1');
//$routes->get('/user/transaksi(:num)', 'User::editrci/$1');
//$routes->get('/user/transaksi/(:num)', 'User::tboking/$1');
// $routes->get('/user/transaksi/(:num)', 'User::editaksi/$1');
//$routes->get('/admin/pesanan/(:num)', 'Admin::editpsn/$1');
//$routes->get('/admin/editjdwl/(:num)', 'Admin::editjad/$1');
$routes->get('/admin/edit(:any)', 'Admin::edit/$1');
$routes->put('/admin/lapangan(:any)', 'Admin::update/$1');
$routes->put('/admin/jadwal(:any)', 'Admin::updatejad/$1');
//$routes->put('/admin/pesanan(:any)', 'Admin::updatepsn/$1');
//$routes->post('/admin/lapangan(:any)', 'Admin::update/$1');
$routes->put('/admin/lapangan(:num)', 'Admin::edit/$1');
$routes->put('/admin/pesanan(:num)', 'Admin::updatepsn/$1');
//$routes->put('/admin/pesanan(:num)', 'Admin::editjad/$1');
//$routes->put('/admin/jadwal(:num)', 'Admin::editjad/$1');
//$routes->get('/admin/lapang(:num)', 'Admin::edit/$1');
//$routes->get('/admin/lapangan', 'Admin::lapangan');
// $routes->get('/admin/tlapangan', 'Admin::savelap');
$routes->delete('/admin/lapangan(:num)', 'Admin::delete/$1');
$routes->delete('/admin/jadwal(:num)', 'Admin::deletejad/$1');
$routes->delete('/admin/pesanan(:num)', 'Admin::deletepsn/$1');
//$routes->delete('/admin/jadwal(:any)', 'Admin::jadwal');
$routes->get('/admin/jadwal(:num)', 'Admin::tjadwal');
//$routes->get('/user/transaksi(:num)', 'User::tboking');
$routes->put('/admin/jadwal(:any)', 'Admin::savejad/$1');
$routes->put('/user/transaksi/(:any)', 'User::tamboking/$1');
$routes->put('/user/transaksirci/(:any)', 'Transaksi::view/$1');
$routes->put('/transaksi/view/(:num)', 'Transaksi::view/$1');
$routes->put('/user/transaksi/(:num)', 'User::rctransaksi/$1');
//$routes->put('/user/transaksi(:num)', 'User::editrci/$1');
//$routes->put('/user/transaksi', 'User::tamboking');
//$routes->put('/user/transaksi', 'User::editrci$1');



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
