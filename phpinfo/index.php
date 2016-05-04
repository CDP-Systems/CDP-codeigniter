<?php 
/*
 *---------------------------------------------------------------
 * APACHE GET MODULES
 *---------------------------------------------------------------
 * uncomment this function to Get the PHP info
 *
 */
 
 //phpinfo();
 
/*
 *---------------------------------------------------------------
 * APACHE GET MODULES
 *---------------------------------------------------------------
 *
 * uncomment this function to Get a list of loaded Apache modules
 * (PHP 4 >= 4.3.2, PHP 5)
 *
 */
 
 //print_r(apache_get_modules());

 
 
 /*
 *---------------------------------------------------------------
 * TEST MOD REWRITE
 *---------------------------------------------------------------
 * (PHP 4 >= 4.3.2, PHP 5)
 *
 */
/*
echo '<pre>';
if (in_array("mod_rewrite", apache_get_modules())) { 
    echo "mod_rewrite loaded"; 
} else { 
    echo "mod_rewrite not loaded"; 
}
; echo '</pre>';die();
*/

?>