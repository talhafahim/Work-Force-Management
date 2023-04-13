<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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
$routes->get('/503', 'Settings::page_503');
//
$routes->group('/',['filter' => 'MaintenanceFilter'], static function ($routes) { 
    
    $routes->get('', 'Login::error');
    
    $routes->get('/login', 'Login::index');
    $routes->get('/login/verify-otp', 'Login::otp_verification');

});
//
$routes->group('/',['filter' => 'AuthFilter'], static function ($routes) {

    $routes->get('/', 'Dashboard::index');
    $routes->get('/cpanel', 'Dashboard::index');
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/welcome', 'Dashboard::welcome');
    //
    $routes->get('/403', 'Settings::page_403');
    //
    $routes->get('/dashboard-menu-management', 'Dashboard_menu::index');
    $routes->get('/settings', 'Settings::index');
    // user
    $routes->get('/user/user-list', 'User::index');
    $routes->get('/user/user-access-control', 'User::user_access');
    $routes->get('/user/user-profile', 'User::user_profile');
    //
    $routes->get('/task/my-tasks', 'Task::my_task');
    $routes->get('/task/detail/(:segment)', 'Task::task_detail/$1');
    $routes->get('/task/task-list', 'Customer::customer_list');
    $routes->get('/task/bulk-assign', 'Customer::bulk_assign');
    $routes->get('/task/upload', 'Customer::upload');
    $routes->get('/task/view-detail/(:segment)', 'Customer::view_detail/$1');
    //
    $routes->get('/gateway', 'General::gateway');
    $routes->get('/miscellaneous_equipment', 'General::miscellaneous_equipment');
    $routes->get('/devices-n-tools', 'General::devices_n_tools');
    $routes->get('/return-reason', 'General::return_reason');
    //
    $routes->get('/message', 'Tools::all_reminders');
    $routes->get('/message/create', 'Tools::notification');
    //
    $routes->get('/team', 'Team::index');
    $routes->get('/team/detail', 'Team::detial_sheet');
    //
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
