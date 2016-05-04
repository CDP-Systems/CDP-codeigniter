<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_country extends MY_Model {

        function __construct()
        {
            parent::__construct();

            $this->set_table_name('country');
            $this->set_primary_key('country_id');
        }
}

/* End of file m_country.php */
/* Location: ./application/models/default/m_country.php */