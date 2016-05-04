<?php
$production = ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='192.168.1.92') ? FALSE : TRUE;

if ($production){
	define('_BASE_URL_','http://www.misurgeryny.com');
	define('_URI_PROTOCOL_','AUTO');
	define('_DB_USERNAME_','misurger_user');
	define('_DB_PASSWORD_','Araw_Ng_Kagitingan_2011');
	define('_DB_DATABASE_','misurger_texeira');
}else{
	define('_BASE_URL_','http://localhost/ci_template');
	define('_URI_PROTOCOL_','REQUEST_URI');
	define('_DB_USERNAME_','root');
	define('_DB_PASSWORD_','pwd');
	define('_DB_DATABASE_','ci_template');
}