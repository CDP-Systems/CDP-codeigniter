<?php

$config['validate_recaptcha'] = array(
              'field' => 'recaptcha_response_field',
              'label' => 'lang:recaptcha_field_name',
              'rules' => 'required|callback_check_captcha'
            );
