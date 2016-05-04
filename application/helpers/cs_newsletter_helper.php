<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if (!function_exists('subscribe_for_mailing_list'))

{

	function subscribe_for_mailing_list($data){

		$ci =& get_instance();
                
                $ci->load->library('email');
                $ci->load->helper('security');
                $ci->load->model('admin/M_website');
                $ci->load->model('admin/M_transactional_emails');
		$ci->load->model('admin/M_administrator');
		$ci->load->model('default/M_subscribers');
                $ci->load->model('default/m_settings');
                
                //get site data
		$website = $ci->M_website->getWebsite();

		//get transactional emails
                $subscription = $ci->M_transactional_emails->get('subscription');

                $closing = $ci->m_settings->get('global_email_footer')->setting_value;
                $subscription_msg = str_replace('%%CLOSING%%', $closing, $subscription['message']);
                
                //get admin outgoing email
		$admin_email = $ci->m_settings->get('admin_outgoing_email')->setting_value;
		$email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$website['name']));


                //get admin data
                $admin = $ci->M_administrator->getSuperAdmin();
                //save subscriber into database
                $subscriberExists = $ci->M_subscribers->getByEmail($data['email']);
                if(count($subscriberExists)){
                        if($subscriberExists['active'] == 1){
                                $ci->session->set_flashdata('mailing_msg', 'You are already signed up to our Newsletter.');
                        }else{
                                $ci->M_subscribers->subscribe($subscriberExists['subscription_key']);
                                $subscriber = $subscriberExists;
                                
                                //send subscription email
                                $config['mailtype'] = 'html';
                                $ci->email->initialize($config);
                                $ci->email->from($email_sender_from, $website['name']);
                                $ci->email->to($data['email']);
                                $ci->email->subject('['.$website['name'].'] Newsletter Confirmation');
                                $ci->email->message($subscription_msg);
                                $ci->email->send();

                                $ci->session->set_flashdata('mailing_msg', 'Subscription Successful.');
                        }	
                }else{
                        $data['subscription_key'] = do_hash($data['email']);
                        $ci->M_subscribers->save($data);
                        $subscriber_insert_id = $ci->db->insert_id();
                        $subscriber = $ci->M_subscribers->get($subscriber_insert_id);
                        
                        //send subscription email
                        $config['mailtype'] = 'html';
                        $ci->email->initialize($config);
                        $ci->email->from($email_sender_from, $website['name']);
                        $ci->email->to($data['email']);
                        $ci->email->subject('['.$website['name'].'] Newsletter Confirmation');
                        $ci->email->message($subscription_msg);
                        $ci->email->send();

                        $ci->session->set_flashdata('mailing_msg', 'Subscription Successful.');
                }

		return '';

	

	}



}

?>