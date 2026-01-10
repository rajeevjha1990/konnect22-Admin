<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin_auth::login');
$routes->post('/auth/dologin', 'Admin_auth::dologin');
$routes->get('/auth/logout', 'Admin_auth::logout');
$routes->get('/auth/group_edit_requests', 'Admin_auth::group_edit_requests');
$routes->get('/adminauth/permission_granted/(:num)/(:num)', 'Admin_auth::permission_granted/$1/$2');
$routes->get('/adminauth/volunteer_groups/(:num)', 'Admin_auth::volunteer_groups/$1');
$routes->get('/adminauth/saintri_distribution/(:num)', 'Admin_auth::saintri_distribution/$1');
$routes->get('/adminauth/group_members/(:num)/(:num)', 'Admin_auth::group_members/$1/$2');
$routes->get('/adminauth/volunteers', 'Admin_auth::volunteers');
$routes->get('/adminauth/programs', 'Admin_auth::programs');
$routes->get('/adminauth/new_program', 'Admin_auth::new_program');
$routes->get('/adminauth/edit_program/(:num)', 'Admin_auth::edit_program/$1');
$routes->get('/adminauth/new_associate', 'Admin_auth::new_associate');
$routes->get('/adminauth/edit_associate/(:num)', 'Admin_auth::edit_associate/$1');
$routes->get('/adminauth/delete_associate/(:num)', 'Admin_auth::delete_associate/$1');
$routes->get('/adminauth/delete_program/(:num)', 'Admin_auth::delete_program/$1');
$routes->post('/adminauth/save_volunteer', 'Admin_auth::save_volunteer');
$routes->post('/adminauth/save_program', 'Admin_auth::save_program');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('/common/states', 'Common::states');
$routes->get('/common/districts/(:num)', 'Common::districts/$1');
$routes->get('/common/new_district/(:num)', 'Common::new_district/$1');
$routes->get('/common/edit_district/(:num)/(:num)', 'Common::edit_district/$1/$2');
$routes->get('/common/delete_district/(:num)', 'Common::delete_district/$1');
$routes->post('/common/save_district', 'Common::save_district');
$routes->get('/common/blocks/(:num)', 'Common::blocks/$1');
$routes->get('/common/new_block/(:num)', 'Common::new_block/$1');
$routes->get('/common/edit_block/(:num)/(:num)', 'Common::edit_block/$1/$2');
$routes->post('/common/save_block', 'Common::save_block');
$routes->get('/common/delete_block/(:num)', 'Common::delete_block/$1');
$routes->get('/common/villages/(:num)', 'Common::villages/$1');
$routes->get('/common/new_village/(:num)', 'Common::new_village/$1');
$routes->get('/common/edit_village/(:num)/(:num)', 'Common::edit_village/$1/$2');
$routes->post('/common/save_village', 'Common::save_village');
$routes->get('/common/delete_village/(:num)', 'Common::delete_village/$1');
$routes->get('/common/associate_details/(:num)', 'Common::associate_details/$1');
$routes->post('/common/filter_associate_data', 'Common::filter_associate_data');


$routes->group('api/auth', function($routes) {
    $routes->match(['post','options'], 'login', 'Api\Auth::login');
    $routes->match(['post','options'], 'volunteer_register', 'Api\Auth::volunteer_register');
    $routes->match(['post','options'], 'check_mobile_registered', 'Api\Auth::check_mobile_registered');
    $routes->match(['post','options'], 'verify_forgot_otp', 'Api\Auth::verify_forgot_otp');
    $routes->match(['post','options'], 'reset_password', 'Api\Auth::reset_password');
    $routes->match(['post','options'], 'get_volunteer', 'Api\Auth::get_volunteer');
    $routes->match(['post','options'], 'get_volunteer', 'Api\Auth::get_volunteer');
    $routes->match(['post','options'], 'logout', 'Api\Auth::logout');
    $routes->match(['post','options'], 'update_profile', 'Api\Auth::update_profile');
    $routes->match(['post','options'], 'get_profile', 'Api\Auth::get_profile');
    $routes->match(['post','options'], 'check_mobile_registered', 'Api\Auth::check_mobile_registered');
});
$routes->group('api/common', function($routes) {
    $routes->match(['post','options'], 'qualifications', 'Api\Common::qualifications');
    $routes->match(['post','options'], 'getPrograms', 'Api\Common::getPrograms');
    $routes->match(['post','options'], 'new_group', 'Api\Common::new_group');
    $routes->match(['post','options'], 'epGropus', 'Api\Common::epGropus');
    $routes->match(['post','options'], 'getMembers', 'Api\Common::getMembers');
    $routes->match(['post','options'], 'update_role', 'Api\Common::update_role');
    $routes->match(['post','options'], 'request_edit_group', 'Api\Common::request_edit_group');
    $routes->match(['post','options'], 'getAllEditRequests', 'Api\Common::getAllEditRequests');
    $routes->match(['post','options'], 'get_groupdata', 'Api\Common::get_groupdata');
    $routes->match(['post','options'], 'get_states', 'Api\Common::get_states');
    $routes->match(['post','options'], 'state_districts', 'Api\Common::state_districts');
    $routes->match(['post','options'], 'saintri_distribution', 'Api\Common::saintri_distribution');
    $routes->match(['post','options'], 'distributed_saintries', 'Api\Common::distributed_saintries');
    $routes->match(['post','options'], 'district_blocks', 'Api\Common::district_blocks');
    $routes->match(['post','options'], 'block_villages', 'Api\Common::block_villages');
    $routes->match(['post','options'], 'get_allsainetriCount', 'Api\Common::get_allsainetriCount');
    $routes->match(['post','options'], 'get_allGroupCount', 'Api\Common::get_allGroupCount');
    $routes->match(['post','options'], 'getProgramsAndGroups', 'Api\Common::getProgramsAndGroups');

});
$routes->group('api/upload', function($routes) {
    $routes->match(['post','options'], 'upload', 'Api\Upload::upload');
});
$routes->group('api/publicApi', function($routes) {
    $routes->match(['post','options'], 'apply_program', 'Api\PublicApi::apply_program');
});

