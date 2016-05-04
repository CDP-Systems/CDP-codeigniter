<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "default/page";
$route['404_override'] = 'page_not_found';

/*
|----------------------
| ADMIN ROUTE
|----------------------
*/

$route['admin'] = 'admin/dashboard';
$route['admin/forgot-password'] = 'admin/forgot_password';
$route['admin/forgot-password/retrieve'] = 'admin/forgot_password/retrieve';
$route['admin/login/index/(.*)/(.*)/(.*)'] = 'admin/login/index/$1/$2/$3';

/*
|----------------------
| PAGE ROUTES
|----------------------
*/

include_once('page_routes.php');

/*
|----------------------
| DOWNLOAD ROUTES
|----------------------
*/
$route['download/index/([0-9]+)'] = 'default/download/index/$1';

/*
|----------------------
| NEWSLETTER ROUTES
|----------------------
*/

$route['newsletter'] = 'default/newsletter';
$route['newsletter/subscribe'] = 'default/newsletter/subscribe';
$route['newsletter/subscribe/([a-z0-9]+)'] = 'default/newsletter/subscribe/$1';
$route['newsletter/unsubscribe/([a-z0-9]+)'] = 'default/newsletter/unsubscribe/$1';
$route['newsletter/view/([a-z0-9]+)'] = 'default/newsletter/view/$1';
$route['newsletter/subscriber_exists'] = 'default/newsletter/subscriber_exists';

/*
|----------------------
| ASK THE EXPERT
|----------------------
*/
$route['admin/ask-the-expert'] = 'admin/ask_the_expert';
$route['admin/ask-the-expert/index'] = 'admin/ask_the_expert/index';
$route['admin/ask-the-expert/settings'] = 'admin/ask_the_expert/settings';
$route['admin/ask-the-expert/view/(:num)'] = 'admin/ask_the_expert/view/$1';
$route['admin/ask-the-expert/action'] = 'admin/ask_the_expert/action';
$route['admin/ask-the-expert/delete/(:num)'] = 'admin/ask_the_expert/delete/$1';
$route['admin/ask-the-expert/export'] = 'admin/ask_the_expert/export';
$route['admin/ask-the-expert/settings_save'] = 'admin/ask_the_expert/settings_save';

/*
|----------------------
| CONTACT US ROUTES
|----------------------
*/

$route['contact-us'] = 'default/contact_us';
$route['contact-us/send'] = 'default/contact_us/send';

/*
|----------------------
| APPOINTMENT ROUTES
|----------------------
*/
$route['consult'] = 'default/page/ajax_consult';

/*
|----------------------
| SEARCH ROUTES
|----------------------
*/

$route['search'] = 'default/search';
$route['search/index/(:any)'] = 'default/search/index/$1';
$route['search/index/(:any)/(:num)'] = 'default/search/index/$1/$2';
$route["search/result"] = "default/search/result";
$route["search/construct"] = "default/search/construct/";  
$route["search/construct/(:any)"] = "default/search/construct/$1";  
$route['search/result/index/([a-z0-9]+)'] = 'default/search/result/index/$1';
$route['search/result/index/([a-z0-9]+)/([0-9]+)'] = 'default/search/result/index/$1/$2';

require_once(MODPATH . 'statistics/config/routes.php');

/* End of file routes.php */
/* Location: ./application/config/routes.php */