<?php

$config['testimonials/add']['allowed_types'] = 'jpg|png';
$config['testimonials/add']['max_size']	= '100';
$config['testimonials/add']['max_width']  = '1024';
$config['testimonials/add']['max_height']  = '768';
$config['testimonials/add']['encrypt_name'] = TRUE;

$config['testimonials/edit'] = $config['testimonials/add'];
$config['testimonials/edit_category'] = $config['testimonials/add'];

$config['videocast/add']['allowed_types'] = 'flv';
$config['videocast/add']['max_size']	= '5000';
$config['videocast/add']['encrypt_name'] = TRUE;

$config['videocast/edit'] = $config['videocast/add'];

$config['callouts/add'] = $config['callouts/edit'] = $config['testimonials/add'];