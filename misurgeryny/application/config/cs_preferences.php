<?php
/**
 * Set config/preferences here for various models.
 *
 */

/**
 * Testimonials.
 */

$config['testimonial_auto_publish'] = TRUE;
$config['seminars_show_ended'] = FALSE;
$config['seminars_show_full'] = TRUE;

/** 
 * reCAPTCHA
 */
$config['recaptcha'] = array(
  'public'=>'6LezRMQSAAAAAIWTNBWCgrhVtEZx6ALo5Boqkqju',
  'private'=>'6LezRMQSAAAAAA5Dv90fr_WRhD0CUdzD8bVkyQFW',
  'RECAPTCHA_API_SERVER' =>'http://www.google.com/recaptcha/api',
  'RECAPTCHA_API_SECURE_SERVER'=>'https://www.google.com/recaptcha/api',
  'RECAPTCHA_VERIFY_SERVER' =>'www.google.com',
  'RECAPTCHA_SIGNUP_URL' => 'https://www.google.com/recaptcha/admin/create',
  'theme' => 'white'
);
?>
