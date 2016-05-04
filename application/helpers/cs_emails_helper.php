<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package		CS
 * @author		CS
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 */

if (!function_exists('send_email_template'))
{
    /**
     * Sends an email using the specified template from the SETTINGS table.
     * 
     * @param string $template
     * @param string $recipient email recipient
     * @param string $subject Set a value for $subject to override the default,
     *                          or subject retrieved from the database with suffix "_subject".
     * @param mixed $vars
     */
    function send_email_template($template, $recipient, $subject=null, $vars=null)
    {
        $ci =& get_instance();
        $ci->load->model('default/m_settings');
        
        //get site data
        $website = $ci->M_website->getWebsite();
        
        // Get email settings.
//        $ci->load->config('email_settings');
//        $config = $ci->config->item('email_settings');
//        $config['mailtype'] = 'html';
        
        $ci->load->library('email');
        $ci->email->clear();
        $config['mailtype'] = 'html';
        $ci->email->initialize($config);
        
       
        // Set default subject.
        if ($subject == null)
        {
            // Try to find a "_subject" setting for the template specified.
            $subject = $ci->m_settings->get($template . '_subject');            

            if ($subject)
            {
                $subject = $subject->setting_value;
            }
            else
            {
                $subject = '';
            }
        }

        $template = $ci->m_settings->get($template);
        
        $body = htmlspecialchars_decode(cs_parse_vars($template->setting_value, $vars));

        $body .= $ci->m_settings->get('global_email_footer')->setting_value;

        $ci->email->set_newline("\r\n");

        /**
         * @TODO: Change email settings!!
         */
        //$ci->email->from('no-reply@mdnetsolutions.com', $ci->config->item('CLOSING'));
       
        //get admin email
        $ci->load->model('admin/M_administrator');
        $admin_email = $ci->m_settings->get('admin_outgoing_email')->setting_value;
        $email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$website['name']));
        $ci->email->from($email_sender_from, $website['name']);
        
        // _APPLICATION_ENV_ is set in /index.php
        if (_APPLICATION_ENV_ != 'PRODUCTION')
        {
            $recipient = _EMAIL_RECEPIENT_;
            $ci->email->bcc('jose@creatingskies.com');
        }

        if ($recipient == '')
        {
            $recipient = 'cherry@mdnetsolutions.com';
        }

        $ci->email->to($recipient);      
        $ci->email->bcc('seminars@mdnetsolutions.com');  
        $ci->email->subject('['.$website["name"].'] ' .$subject);
        $ci->email->message($body);

        if ($ci->email->send())
        {
            return TRUE;
        }
        else
        {
            show_error('mailer error:' . $ci->email->print_debugger());
        } 
        return TRUE;
    }
}



/**
 * Replace constants on the email body.
 *
 * @param string $template_string
 * @param <type> $data
 */
function cs_parse_vars($template_string, $data=null)
{
    $ci =& get_instance();

    $site_name = $ci->config->item('SITE_NAME');

    $template_string = str_replace('%%SITE_NAME%%', $site_name, $template_string);

    //$closing = $ci->config->item('CLOSING');
    $closing = '';

    $template_string = str_replace('%%CLOSING%%', $closing, $template_string);

    if (is_array($data))
    {
        $data = array_change_key_case($data, CASE_UPPER);
        
        foreach ($data as $key=>$value)
        {
            $template_string = str_replace("%%$key%%", $value, $template_string);
        }        
    }
    return $template_string;
}