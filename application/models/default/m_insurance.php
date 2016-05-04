<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_insurance extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('insurance');
        $this->set_primary_key('insurance_id');
    }
    
    function do_create($params)
    {
    	$params['date_submitted'] = date('Y-m-d');
    	
    	return parent::do_create($params);
    }
    
    function do_save($params)
    {
    	if (isset($params['date_of_birth']))
    	{
    		$params['date_of_birth'] = date('Y-m-d', strtotime($params['date_of_birth']));
    	}
    	
    	if (isset($params['subscriber_date_of_birth']))
    	{
    		$params['subscriber_date_of_birth'] = date('Y-m-d', strtotime($params['subscriber_date_of_birth']));
    	}    	
    	
    	return parent::do_save($params);
    }

}

/* End of file m_insurance.php */
/* Location: ./application/models/default/m_insurance.php */