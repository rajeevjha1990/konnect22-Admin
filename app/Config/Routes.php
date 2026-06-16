<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin_auth::login');
$routes->post('/auth/dologin', 'Admin_auth::dologin');
$routes->get('/auth/logout', 'Admin_auth::logout');
$routes->get('vendor','Vendor::index');
$routes->get('vendor/add', 'Vendor::add');
$routes->get('vendor/edit/(:num)', 'Vendor::edit/$1');
$routes->get('vendor/delete/(:num)', 'Vendor::delete/$1');
$routes->post('vendor/save', 'Vendor::save');

$routes->get('category','Category::index');
$routes->get('category/add', 'Category::add');
$routes->get('category/edit/(:num)', 'Category::edit/$1');
$routes->get('category/delete/(:num)', 'Category::delete/$1');
$routes->post('category/save', 'Category::save');

$routes->get('product','Product::index');
$routes->get('product/add', 'Product::add');
$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->get('product/delete/(:num)', 'Product::delete/$1');
$routes->post('product/save', 'Product::save');
$routes->get('product/toggle_featured/(:num)/(:num)', 'Product::toggle_featured/$1/$2');

$routes->get('banner','Banner::index');
$routes->get('banner/add','Banner::add');
$routes->get('banner/edit/(:num)','Banner::edit/$1');
$routes->get('banner/delete/(:num)','Banner::delete/$1');
$routes->post('banner/save','Banner::save');

$routes->get('order', 'Order::index');
$routes->post('order/status/(:num)', 'Order::status/$1');
$routes->get('order/details/(:num)', 'Order::details/$1');

$routes->get('dashboard', 'Dashboard::index');

$routes->group('api/auth', function($routes) {
    $routes->match(['post','options'], 'login', 'Api\Auth::login');
    $routes->match(['post','options'], 'user_register', 'Api\Auth::user_register');
    $routes->match(['post','options'], 'check_mobile_registered', 'Api\Auth::check_mobile_registered');
    $routes->match(['post','options'], 'verify_otp', 'Api\Auth::verify_otp');
    $routes->match(['post','options'], 'create_password', 'Api\Auth::create_password');
    $routes->match(['post','options'], 'logout', 'Api\Auth::logout');
    $routes->match(['post','options'], 'update_profile', 'Api\Auth::update_profile');
    $routes->match(['post','options'], 'get_profile', 'Api\Auth::get_profile');
    $routes->match(['post','options'], 'check_mobile_registered', 'Api\Auth::check_mobile_registered');
    $routes->post('create-password', 'Api\Auth::create_password');
    $routes->match(['post','options'],'create-password','Api\Auth::create-password');
});

$routes->group('api/order', function($routes) {
    $routes->match(['post','options'],'place_order','Api\Order::place_order');
    $routes->match(['post','options'],'my_orders','Api\Order::my_orders');
    $routes->match(['post','options'],'cancel_order','Api\Order::cancel_order');
});
$routes->group('api/cart', function($routes) {
    $routes->match(['post','options'],'add_to_cart','Api\Cart::add_to_cart');
    $routes->match(['post','options'],'get_cart','Api\Cart::get_cart');
    $routes->match(['post','options'],'update_cart_qty','Api\Cart::update_cart_qty');
    $routes->match(['post','options'],'remove_cart_item','Api\Cart::remove_cart_item');
});
$routes->group('api/wishlist', function($routes) {
    $routes->match(['post','options'],'add_to_wishlist','Api\Wishlist::add_to_wishlist');
    $routes->match(['post','options'],'get_wishlist','Api\Wishlist::get_wishlist');
    $routes->match(['post','options'],'remove_wishlist','Api\Wishlist::remove_wishlist');
});
$routes->group('api/product', function($routes) {
    $routes->match(['post','options'],'get_products','Api\Product::get_products');
    $routes->match(['post','options'],'get_categories','Api\Product::get_categories');
    $routes->match(['post','options'],'search_products','Api\Product::search_products');
    $routes->match(['post','options'],'get_featured_products','Api\Product::get_featured_products');
        $routes->match(['post','options'],'get_banners','Api\Product::get_banners');

});

