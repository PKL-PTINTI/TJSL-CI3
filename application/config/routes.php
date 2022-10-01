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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// TASK: Mitra Management System

// $route['admin/mitra/kolektibilitas/(:any)'] = 'admin/mitra/mitrakolektibilitas/$1';
// $route['admin/mitra/masalah/(:any)'] = 'admin/mitra/mitramasalah/$1';

// $route['admin/mitra/status/(:any)/(:any)'] = 'admin/mitra/statussektor/$1/$2';

// $route['admin/mitra/kolektibilitas/lancar/(:any)'] = 'admin/mitra/sektorlancar/$1';
// $route['admin/mitra/kolektibilitas/kuranglancar/(:any)'] = 'admin/mitra/sektorkuranglancar/$1';
// $route['admin/mitra/kolektibilitas/diragukan/(:any)'] = 'admin/mitra/sektordiragukan/$1';
// $route['admin/mitra/kolektibilitas/macet/(:any)'] = 'admin/mitra/sektormacet/$1';

$route['admin/mitra/get_data_mitra/kolektibilitas/(:any)'] = 'admin/mitra/get_data_mitra/$1';
$route['admin/mitra/get_data_mitra/masalah/(:any)'] = 'admin/mitra/get_data_mitra/$1';
$route['admin/mitra/get_data_mitra/koleksektor/(:any)/(:any)'] = 'admin/mitra/get_data_mitra/$1/$2';
$route['admin/mitra/get_data_mitra/masalahsektor/(:any)/(:any)'] = 'admin/mitra/get_data_mitra/$1/$2';

$route['admin/mitra/update/(:any)'] = 'admin/mitra/update/$1';
$route['admin/mitra/destroy/(:any)'] = 'admin/mitra/destroy/$1';

$route['admin/mitra/cicilan/(:any)'] = 'admin/mitra/rinciancicilan/$1';
$route['admin/mitra/cicilan/create/(:any)'] = 'admin/mitra/cretaecicilan/$1';

// ENDTASK: Mitra Management System


// TASK: Jurnal Management System

$route['admin/jurnal/transaksi/(:any)'] = 'admin/jurnal/jurnalbank/$1';

// ENDTASK: Jurnal Management System
