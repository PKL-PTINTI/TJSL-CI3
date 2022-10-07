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

// $route['Admin/mitra/kolektibilitas/(:any)'] = 'Admin/mitra/mitrakolektibilitas/$1';
// $route['Admin/mitra/masalah/(:any)'] = 'Admin/mitra/mitramasalah/$1';

// $route['Admin/mitra/status/(:any)/(:any)'] = 'Admin/mitra/statussektor/$1/$2';

// $route['Admin/mitra/kolektibilitas/lancar/(:any)'] = 'Admin/mitra/sektorlancar/$1';
// $route['Admin/mitra/kolektibilitas/kuranglancar/(:any)'] = 'Admin/mitra/sektorkuranglancar/$1';
// $route['Admin/mitra/kolektibilitas/diragukan/(:any)'] = 'Admin/mitra/sektordiragukan/$1';
// $route['Admin/mitra/kolektibilitas/macet/(:any)'] = 'Admin/mitra/sektormacet/$1';

$route['Admin/mitra/get_data_mitra/kolektibilitas/(:any)'] = 'Admin/mitra/get_data_mitra/$1';
$route['Admin/mitra/get_data_mitra/bermasalah/(:any)'] = 'Admin/mitra/get_data_mitra/$1';
$route['Admin/mitra/get_data_mitra/koleksektor/(:any)/(:any)'] = 'Admin/mitra/get_data_mitra/$1/$2';
$route['Admin/mitra/get_data_mitra/masalahsektor/(:any)/(:any)'] = 'Admin/mitra/get_data_mitra/$1/$2';

$route['Admin/mitra/update/(:any)'] = 'Admin/mitra/update/$1';
$route['Admin/mitra/destroy/(:any)'] = 'Admin/mitra/destroy/$1';

$route['Admin/mitra/cicilan/(:any)'] = 'Admin/mitra/rinciancicilan/$1';
$route['Admin/mitra/cicilan/create/(:any)'] = 'Admin/mitra/cretaecicilan/$1';

// ENDTASK: Mitra Management System


// TASK: Jurnal Management System

$route['Admin/jurnal/transaksi/(:any)'] = 'Admin/jurnal/jurnalbank/$1';

// ENDTASK: Jurnal Management System
