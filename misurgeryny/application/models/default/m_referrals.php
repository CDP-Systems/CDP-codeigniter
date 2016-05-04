<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "referrals" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-04
 */
class M_referrals extends MY_Model {

    private $_table_name = 'referrals';
    private $_primary_key = 'referral_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // Override. tsk
    function do_save($params)
    {
        $params['patient_phone'] = implode('-', $_POST['patient_phone']);
        $params['referral_phone'] = implode('-', $_POST['referral_phone']);

        unset($params['patient_phone[]']);
        unset($params['referral_phone[]']);

        return parent::do_save($params);
    }

    function do_create($params)
    {
        $params['date_filed'] = date('Y-m-d');
        
        return parent::do_create($params);
    }
}

/* End of file m_referrals.php */
/* Location: ./application/models/default/m_referrals.php */
