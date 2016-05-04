<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Define validation rules here.
 */

// --------------------------------------------------------------------
// --------------------------------------------------------------------

/**
 * Add a callout form.
 */
 $config['validation_membership'] = array (
        array(
            'field' => 'fname',
            'label' => 'First Name',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'lname',
            'label' => 'Last Name',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'credentials',
            'label' => 'Last Name',
            'rules' => 'trim|xss_clean'
            ),
		array(
            'field' => 'street',
            'label' => 'Street',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|xss_clean'
            ),
		array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|required'
            ),
		array(
            'field' => 'zip',
            'label' => 'Zip',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required|xss_clean'
            ),
		array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean'
            ),
		array(
            'field' => 'specialty',
            'label' => 'Specialty',
            'rules' => 'trim'
            )
);
 
/**
 * Testimonials/add.
 */
$config['validation_testimonial_add'] = array (
        array(
            'field' => 'body',
            'label' => 'Message',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean'
            ),
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'weight_lost',
            'label' => 'Lost weight',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'field_before_picture',
            'label' => 'Before picture',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
            ),
        array(
            'field' => 'field_after_picture',
            'label' => 'After picture',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
            ),
    );

// --------------------------------------------------------------------

/**
 * Testimonial category add form.
 */
    
$config['validation_testimonial_category_form'] = array (
        array(
            'field' => 'category_name',
            'label' => 'Category name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'sort_order',
            'label' => 'Sort Order',
            'rules' => 'trim|numeric|xss_clean'
            ),        
        array(
            'field' => 'field_list_image',
            'label' => 'Image',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
	    ),
        array(
            'field' => 'field_image',
            'label' => 'Image',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
	    ),	    
	);	

// --------------------------------------------------------------------

/**
 * Seminars/Register.
 */
$config['validation_seminar_registration'] = array (
        array(
            'field' => 'seminar_id',
            'label' => 'Seminar',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'feet',
            'label' => 'Feet',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'inches',
            'label' => 'Inches',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'weight',
            'label' => 'Weight',
            'rules' => 'trim|numeric|xss_clean'
            ),
        array(
            'field' => 'first_name',
            'label' => 'First name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'last_name',
            'label' => 'Last name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'address1',
            'label' => 'Address',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'address2',
            'label' => 'Address2',
            'rules' => 'trim'
            ),
        array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'zip',
            'label' => 'Zip code',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'country_id',
            'label' => 'Country',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'phone1[]',
            'label' => 'Primary phone',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'phone2[]',
            'label' => 'Alternate phone',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean'
            ),
        array(
            'field' => 'insurance',
            'label' => 'Insurance',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'number_of_guests',
            'label' => 'Number of guests',
            'rules' => 'trim|numeric|xss_clean'
            )
        
        );

// --------------------------------------------------------------------
/**
 * Online Seminar Register.
 */
$config['validation_online_seminar_registration'] = array (
        array(
            'field' => 'seminar_id',
            'label' => 'Seminar',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'feet',
            'label' => 'Height',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'inches',
            'label' => 'Height',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'weight',
            'label' => 'Weight',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'first_name',
            'label' => 'First name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'last_name',
            'label' => 'Last name',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'address1',
            'label' => 'Address',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'address2',
            'label' => 'Address2',
            'rules' => 'trim'
            ),
        array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'zip',
            'label' => 'Zip code',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'country_id',
            'label' => 'Country',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'phone1[]',
            'label' => 'Primary phone',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'phone2[]',
            'label' => 'Alternate phone',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean'
            ),
        array(
            'field' => 'insurance',
            'label' => 'Insurance',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'how_heard',
            'label' => 'How did you hear about us',
            'rules' => 'trim|required|xss_clean'
            ),
        );

// --------------------------------------------------------------------



/**
 * Seminars, add/edit. 
 */

$config['validation_seminar_form'] = array (
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'location',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'time',
            'label' => 'Start time',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'end_time',
            'label' => 'End time',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'seminar_date',
            'label' => 'Seminar date',
            'rules' => 'trim|required|alpha_dash|xss_clean'
            ),
        array(
            'field' => 'max_num_attendees',
            'label' => 'Maximum number of attendees',
            'rules' => 'trim|required|numeric|xss_clean'
            ),
        array(
            'field' => 'is_full',
            'label' => 'Seminar is FULL',
            'rules' => 'trim|xss_clean'
            ),
    
        );

// --------------------------------------------------------------------


/**
 * Online Seminars, add/edit. 
 */

$config['validation_online_seminar_form'] = array (
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'link',
            'label' => 'Link',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|xss_clean',
            )
        );

// --------------------------------------------------------------------

/**
 * Seminar email settings form.
 */

$config['seminars_email_settings'] = array (
        array(
            'field' => 'seminars_email_recipient',
            'label' => 'Email recipient',
            'rules' => 'trim|required|valid_emails|xss_clean'
        ),
        array(
            'field' => 'seminars_email_patient_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'seminars_email_patient',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'seminars_email_admin_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'seminars_email_admin',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
    );

// --------------------------------------------------------------------

/**
 * Online Seminar email settings form.
 */

$config['online_seminars_email_settings'] = array (
        array(
            'field' => 'online_seminars_email_recipient',
            'label' => 'Email recipient',
            'rules' => 'trim|required|valid_emails|xss_clean'
        ),
        array(
            'field' => 'online_seminars_email_patient_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'online_seminars_email_patient',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'online_seminars_email_admin_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'online_seminars_email_admin',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
    );

// --------------------------------------------------------------------

/**
 * Add recurring event form.
 */

$config['calendar_edit_recurring_event'] = array (
        array(
            'field' => 'event_title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean'
            ),
        array(
            'field' => 'details',
            'label' => 'Details',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'recurrence',
            'label' => 'Recurrence',
            'rules' => 'trim|required|numeric|xss_clean',
            ),
        array(
            'field' => 'recurrence_rate',
            'label' => 'recurrence rate',
            'rules' => 'trim|required|is_natural_no_zero|xss_clean',
            ),
        array(
            'field' => 'recurrence_days',
            'label' => 'recurrence days',
            'rules' => 'required|xss_clean',
            ),
        array(
            'field' => 'start_date',
            'label' => 'start date',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'end_date',
            'label' => 'end date',
            'rules' => 'trim|required|xss_clean',
            ),
    );

// --------------------------------------------------------------------

/**
 * Add calendar event form.
 */

$config['calendar_edit_note'] = array (
        array(
            'field' => 'eventDate',
            'label' => 'Date',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'eventTitle',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'category_id',
            'label' => 'Category',
            'rules' => 'trim|required|numeric|xss_clean',
            ),
        array(
            'field' => 'eventContent',
            'label' => 'Details',
            'rules' => 'trim|required|xss_clean',
            ),
    );

// --------------------------------------------------------------------

/**
 * Add news form.
 */

$config['news_edit_form'] = array (
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'body',
            'label' => 'Body',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'introduction',
            'label' => 'Introduction',
            'rules' => 'trim|required|xss_clean',
            ),
    );

// --------------------------------------------------------------------

/**
 * Referral form.
 */

$config['referrals_new_form'] = array (
        array(
            'field' => 'patient_name',
            'label' => 'Your name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'patient_email',
            'label' => 'Your email',
            'rules' => 'trim|required|valid_email|xss_clean',
            ),
        array(
            'field' => 'patient_address',
            'label' => 'Your address',
            'rules' => 'trim|xss_clean',
            ),
        array(
            'field' => 'patient_phone[]',
            'label' => 'Your phone number',
            'rules' => 'trim|xss_clean'
        ),
        array(
            'field' => 'referral_name',
            'label' => 'Referral name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'referral_email',
            'label' => 'Referral email',
            'rules' => 'trim|required|valid_email|xss_clean',
            ),
        array(
            'field' => 'referral_relationship',
            'label' => 'Your relationship',
            'rules' => 'trim|xss_clean',
            ),
        array(
            'field' => 'referral_address',
            'label' => 'Referral address',
            'rules' => 'trim|xss_clean',
            ),
        array(
            'field' => 'referral_phone[]',
            'label' => 'Referral phone number',
            'rules' => 'trim|xss_clean',
            ),
    );

/**
 * reCAPTCHA
 */
$config['validation_recaptcha'] = array(
    array(
      'field' => 'recaptcha_response_field',
      'label' => 'lang:recaptcha_field_name',
      'rules' => 'required|callback_check_captcha'
    )
  );

// --------------------------------------------------------------------

/**
 * Survey
 */
$config['validation_survey_edit'] = array (
    array(
        'field' => 'survey_name',
        'label' => 'Survey name',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'survey_description',
        'label' => 'Survey description',
        'rules' => 'trim|required|xss_clean'
    ),
);

$config['validation_survey_question_edit'] = array (
    array(
        'field' => 'survey_id[]',
        'label' => 'Survey',
        'rules' => 'trim|xss_clean'
    ),
    array(
        'field' => 'question_details',
        'label' => 'Question',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'type_of_question_id',
        'label' => 'Type of question',
        'rules' => 'trim|required|numeric|xss_clean'
    ),
    array(
        'field' => 'choices[]',
        'label' => 'Choices',
        'rules' => 'trim|xss_clean'
    ),
    array(
        'field' => 'range',
        'label' => 'Range',
        'rules' => 'trim|numeric|xss_clean'
    ),
);

$config['validation_survey_take'] = array (
    array(
        'field' => 'name',
        'label' => 'Your name',
        'rules' => 'trim|xss_clean'
    ),
    array(
        'field' => 'user_email',
        'label' => 'email',
        'rules' => 'trim|required|valid_email|xss_clean'
    ),
    array(
        'field' => 'survey_id',
        'label' => 'survey_id',
        'rules' => 'trim|required|numeric|xss_clean'
    ),
);

// --------------------------------------------------------------------

/**
 * Survey email settings form.
 */

$config['surveys_email_settings'] = array (
        array(
            'field' => 'surveys_email_recipient',
            'label' => 'Email recipient',
            'rules' => 'trim|required|valid_emails|xss_clean'
        ),
        array(
            'field' => 'surveys_email_patient_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'surveys_email_patient',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'surveys_email_admin_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'surveys_email_admin',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
    );
    
// --------------------------------------------------------------------

/**
 * Ask an appointment form.
 */
    
$config['validation_appointment_form'] = array (
        array(
            'field' => 'name',
            'label' => 'name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|xss_clean',
            ),
        array(
            'field' => 'address',
            'label' => 'address',
            'rules' => 'trim|xss_clean',
            ),
        array(
            'field' => 'date_selected',
            'label' => 'date',
            'rules' => 'trim|xss_clean',
            ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'trim|xss_clean'
            ),
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|xss_clean'
            ),  
        array(
            'field' => 'other',
            'label' => 'other',
            'rules' => 'trim|xss_clean'
            ),                                 
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'xss_clean'
            ),                
);    

// --------------------------------------------------------------------

// --------------------------------------------------------------------

/**
 * Ask an appointment form.
 */
    
$config['validation_main_appointment_form'] = array (
        array(
            'field' => 'name',
            'label' => 'name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|xss_clean',
            ),
        array(
            'field' => 'comments',
            'label' => 'Comments',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'other',
            'label' => 'other',
            'rules' => 'trim|required|xss_clean'
        ),                 
);    

// --------------------------------------------------------------------

/**
 * Add a video form.
 */
    
$config['validation_videocast_form'] = array (
        array(
            'field' => 'field_video',
            'label' => 'Video',
            'rules' => 'trim|required|callback_handle_file_upload|xss_clean'
        ),        
        array(
            'field' => 'infoTitle',
            'label' => 'info title',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'infoDesc',
            'label' => 'info description',
            'rules' => 'trim|required|xss_clean'
        ),                                
);    

// --------------------------------------------------------------------

/**
 * Add a callout form.
 */
    
$config['validation_callouts_form'] = array (
        array(
            'field' => 'field_image_url',
            'label' => 'Image',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
        ),        
        array(
            'field' => 'image_link',
            'label' => 'Image Link',
            'rules' => 'trim|xss_clean'
        ),
        array(
            'field' => 'alt_text',
            'label' => 'ALT text',
            'rules' => 'trim|xss_clean'
        ),                                
        array(
            'field' => 'anchor_text',
            'label' => 'Anchor text',
            'rules' => 'trim|xss_clean'
        ),         
        array(
            'field' => 'anchor_link',
            'label' => 'Anchor link',
            'rules' => 'trim|xss_clean'
        ),         
        array(
            'field' => 'target',
            'label' => 'Target',
            'rules' => 'trim|xss_clean'
        ),          
        array(
            'field' => 'opening_tag',
            'label' => 'Opening tag',
            'rules' => 'trim|xss_clean'
        ),  
        array(
            'field' => 'closing_tag',
            'label' => 'Closing tag',
            'rules' => 'trim|xss_clean'
        ),      
        array(
            'field' => 'display_order',
            'label' => 'display_order',
            'rules' => 'trim|numeric|xss_clean'
        ),                             
);     

// --------------------------------------------------------------------

/**
 * Insurance verification form.
 */
    
$config['validation_insurance_verification_form'] = array (
        array(
            'field' => 'patient_name',
            'label' => 'Patient name',
            'rules' => 'trim|required|xss_clean'
        ),   
        array(
            'field' => 'home_phone',
            'label' => 'Home phone',
            'rules' => 'trim|required|xss_clean'
        ),           
        array(
            'field' => 'cell_phone',
            'label' => 'Cell phone',
            'rules' => 'trim|xss_clean'
        ),
        array(
            'field' => 'feet',
            'label' => 'feet',
            'rules' => 'trim|required|xss_clean'
        ),           
        array(
            'field' => 'inches',
            'label' => 'Inches',
            'rules' => 'trim|required|xss_clean'
        ),           
        array(
            'field' => 'have_insurance',
            'label' => 'Patient name',
            'rules' => 'trim|required|xss_clean'
        ),           
        array(
            'field' => 'subscriber_id',
            'label' => 'Subscriber ID',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'subscriber_name',
            'label' => 'Subscriber name',
            'rules' => 'trim|required|xss_clean'
        ),                    
        array(
            'field' => 'mService_number',
            'label' => 'Member service number',
            'rules' => 'trim|xss_clean'
        ),           
        array(
            'field' => 'weight',
            'label' => 'Weight',
            'rules' => 'trim|required|xss_clean'
        ),   
        array(
            'field' => 'date_of_birth',
            'label' => 'Patient date of birth',
            'rules' => 'trim|required|xss_clean'
        ),                   
        array(
            'field' => 'work_phone',
            'label' => 'Work phone',
            'rules' => 'trim|required|xss_clean'
        ),           
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|xss_clean'
        ),           
        array(
            'field' => 'insurance',
            'label' => 'Insurance',
            'rules' => 'trim|xss_clean'
        ),           
        array(
            'field' => 'group_number',
            'label' => 'Group number',
            'rules' => 'trim|xss_clean'
        ),           
        array(
            'field' => 'subscriber_date_of_birth',
            'label' => 'Subscriber date of birth',
            'rules' => 'trim|required|xss_clean'
        ),           
);  
// --------------------------------------------------------------------

/**
 * Self-Assessment
 */
$config['validation_self_assessment_edit'] = array (
    array(
        'field' => 'self_assessment_name',
        'label' => 'Self-Assessment name',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'self_assessment_description',
        'label' => 'Self-Assessment description',
        'rules' => 'trim|required|xss_clean'
    ),
);

$config['validation_self_assessment_question_edit'] = array (
    array(
        'field' => 'self_assessment_id[]',
        'label' => 'Self-Assessment',
        'rules' => 'trim|xss_clean'
    ),
    array(
        'field' => 'question_details',
        'label' => 'Question',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'type_of_question_id',
        'label' => 'Type of question',
        'rules' => 'trim|required|numeric|xss_clean'
    ),
    array(
        'field' => 'choices[]',
        'label' => 'Choices',
        'rules' => 'trim|xss_clean'
    ),
    array(
        'field' => 'range',
        'label' => 'Range',
        'rules' => 'trim|numeric|xss_clean'
    ),
);

$config['validation_self_assessment_take'] = array (
    array(
        'field' => 'firstname',
        'label' => 'First Name',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'lastname',
        'label' => 'Last Name',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'address',
        'label' => 'Address',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'city',
        'label' => 'City',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'state',
        'label' => 'State',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'zip',
        'label' => 'Zipcode',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'country_id',
        'label' => 'Country',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'phone',
        'label' => 'Phone',
        'rules' => 'trim|required|xss_clean'
    ),
    array(
        'field' => 'user_email',
        'label' => 'email',
        'rules' => 'trim|required|valid_email|xss_clean'
    ),
    array(
        'field' => 'self_assessment_id',
        'label' => 'self_assessment_id',
        'rules' => 'trim|required|numeric|xss_clean'
    ),
);

// --------------------------------------------------------------------

/**
 * Self-Assessment email settings form.
 */

$config['self_assessments_email_settings'] = array (
        array(
            'field' => 'self_assessments_email_recipient',
            'label' => 'Email recipient',
            'rules' => 'trim|required|valid_email|xss_clean'
        ),
        array(
            'field' => 'self_assessments_email_patient_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'self_assessments_email_patient',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'self_assessments_email_admin_subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean',
            ),
        array(
            'field' => 'self_assessments_email_admin',
            'label' => 'Email body',
            'rules' => 'trim|required|xss_clean',
            ),
    );
    
// -------------------------------------------------------------------- 


