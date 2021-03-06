<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

// Shop routes
Route::get('/', array('as' => 'home', 'uses' => 'shop@index'));
Route::get('shop', array('as' => 'shop', 'uses' => 'shop@index'));
Route::get('category/(:num)', array('as' => 'category', 'uses' => 'shop@category'));

// Image routes
Route::get('product/(:num)/image.png', array('after' => 'image', 'as' => 'product_image', 'uses' => 'image@product'));

// Search routes
Route::get('search/(.*)', array('as' => 'search', 'uses' => 'shop@search'));
Route::post('search', array('as' => 'searchaction', function()
	{
		$query = Input::get('query');
		$query = str_replace(' ', '/', $query);
		return Redirect::to_route('search', $query);
	}));

// Product routes
Route::get('product/(:num)', array('as' => 'product', 'uses' => 'shop@product'));
Route::post('product/(:num)', array('as' => 'addproduct', 'uses' => 'shop@addtocart'));

// Cart routes
Route::get('cart', array('as' => 'cart', 'uses' => 'cart@index'));
Route::group(array('before' => 'csrf'), function()
{
	Route::post('cart/add/(:num)', array('as' => 'cartadd', 'uses' => 'cart@addproduct'));
	Route::post('cart/sub/(:num)', array('as' => 'cartsub', 'uses' => 'cart@subtractproduct'));
	Route::post('cart/del/(:num)', array('as' => 'cartdel', 'uses' => 'cart@deleteproduct'));
});
Route::group(array('before' => 'auth'), function()
{
	Route::get('cart/checkout', array('as' => 'checkout', 'uses' => 'cart@checkout'));
	Route::post('cart/checkout', array('as' => 'processcheckout', 'uses' => 'cart@processcheckout'));
});

// Account routes
Route::group(array('before' => 'auth'), function()
{
	Route::get('account', array('as' => 'account', 'uses' => 'account@index'));
	Route::get('account/profile', array('as' => 'profile', 'uses' => 'account@index'));
	Route::get('account/profile/edit', array('as' => 'editprofile', 'uses' => 'account@editprofile'));
	Route::post('account/profile/edit', array('before' => 'csrf', 'as' => 'saveprofile', 'uses' => 'account@saveprofile'));

	Route::get('account/profile/delete', array('before' => 'noadmin', 'as' => 'deleteprofile', 'uses' => 'account@deleteprofile'));
	Route::post('account/profile/delete', array('before' => 'csrf|noadmin', 'as' => 'confirmdeleteprofile', 'uses' => 'account@confirmdeleteprofile'));

	Route::get('account/address', array('as' => 'address', 'uses' => 'account@address'));
	Route::get('account/address/edit', array('as' => 'editaddress', 'uses' => 'account@editaddress'));
	Route::post('account/address/edit', array('before' => 'csrf', 'as' => 'saveaddress', 'uses' => 'account@saveaddress'));
	
	Route::get('account/orders', array('as' => 'orders', 'uses' => 'account@orders'));
	Route::get('account/orderhistory', array('as' => 'orderhistory', 'uses' => 'account@orderhistory'));
	Route::get('account/order/(:num).pdf', array('as' => 'orderpdf', 'uses' => 'account@pdf'));
});

// Admin
Route::group(array('before' => 'auth|admin'), function()
{
	Route::get('admin/users', array('as' => 'manage_users', 'uses' => 'admin@users'));
	Route::post('admin/user/(:num)/delete', array('before' => 'csrf', 'as' => 'deleteuser', 'uses' => 'admin@deleteuser'));

	Route::get('admin/orders', array('as' => 'manage_orders', 'uses' => 'admin@orders'));
	Route::post('admin/order/(:num)/pay', array('before' => 'csrf', 'as' => 'payorder', 'uses' => 'admin@payorder'));
	Route::post('admin/order/(:num)/ship', array('before' => 'csrf', 'as' => 'shiporder', 'uses' => 'admin@shiporder'));
	Route::post('admin/order/(:num)/delete', array('before' => 'csrf', 'as' => 'deleteorder', 'uses' => 'admin@deleteorder'));

	Route::get('admin/categories', array('as' => 'manage_categories', 'uses' => 'admin@categories'));
	Route::post('admin/category/(:num)/delete', array('before' => 'csrf', 'as' => 'deletecategory', 'uses' => 'admin@deletecategory'));
	Route::post('admin/category/add', array('before' => 'csrf', 'as' => 'addcategory', 'uses' => 'admin@addcategory'));

	Route::get('admin/products', array('as' => 'manage_products', 'uses' => 'admin@products'));
	Route::post('admin/product/(:num)/delete', array('before' => 'csrf', 'as' => 'deleteproduct', 'uses' => 'admin@deleteproduct'));
	Route::post('admin/product/add', array('before' => 'csrf', 'as' => 'addproduct', 'uses' => 'admin@addproduct'));
	Route::post('admin/product/(:num)/addstock', array('before' => 'csrf', 'as' => 'stockadd', 'uses' => 'admin@addstock'));
	Route::post('admin/product/(:num)/substock', array('before' => 'csrf', 'as' => 'stocksub', 'uses' => 'admin@substock'));
});

// Login
Route::get('account/login', array('as' => 'login', 'uses' => 'account@login'));
Route::post('account/login', array('as' => 'loginaction', 'before' => 'csrf', function()
	{
		$username = Input::get('username');
		$password = Input::get('password');
		$credentials = array('username' => $username, 'password' => $password);
		if (Auth::attempt($credentials)) {
			return Redirect::to_route('account');
		}
		return Redirect::to_route('login')->with('status', 'login_error');;
	}));

// Logout
Route::get('account/logout', array('as' => 'logout', function()
	{
		Auth::logout();
		return Redirect::to_route('login')
		->with('success', 'logout_ok');
	}));

// Register
Route::get('account/register', array('as' => 'register', 'uses' => 'account@register'));
Route::post('account/register', array('as' => 'registeraction', 'before' => 'csrf', 'uses' => 'account@doregister'));

// Information routes
Route::get('information/about', array('as' => 'information_about', 'uses' => 'information@about'));
Route::get('information/contact', array('as' => 'information_contact', 'uses' => 'information@contact'));
Route::get('information/tob', array('as' => 'information_tob', 'uses' => 'information@tob'));
Route::get('information', array('as' => 'information', 'uses' => 'information@about'));


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('image', function($response)
{
	$response->header('Content-Type', 'image/png');
});

Route::filter('before', function()
{
	IoC::resolve('assetManager')->init();
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) {
		return Redirect::to_route('login');
	}
});

Route::filter('admin', function()
{
	$user = Auth::user();
	if ($user == null or !$user->isAdmin()) {
		return Response::error('401');
	}
});

Route::filter('noadmin', function()
{
	$user = Auth::user();
	if ($user->isAdmin()) {
		return Response::error('401');
	}
});
