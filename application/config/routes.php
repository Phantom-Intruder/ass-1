<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/**
 * Custom routes Admin
 */
$route['Admin/Book/Add'] = 'Admin/addBook';
$route['Admin/Book/Delete/(:num)'] = 'Admin/deleteBook/$1';
$route['Admin/Category/Add'] = 'Admin/addCategory';
$route['Admin/Book/Show/(:num)'] = 'Admin/showBook/$1';
$route['Admin/Book/Search'] = 'Admin/searchBook';

/**
 * Custom routes Home
 */
$route['Home/Category/List/(:num)'] = 'Home/listByCategory/$1';
$route['Home/Category/List/(:num)/(:num)/(:num)'] = 'Home/listByCategory/$1/$2/$3';
$route['Home/Book/Show/(:num)'] = 'Home/showBook/$1';
$route['Home/Cart/Add/(:num)'] = 'Home/addToCart/$1';
$route['Home/Cart/Show'] = 'Home/showCart';
$route['Home/Cart/Delete/(:num)'] = 'Home/deleteFromCart/$1';