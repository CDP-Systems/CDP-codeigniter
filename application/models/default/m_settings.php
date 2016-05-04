<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "testimonials" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */
class M_settings extends MY_Model {

    private $_table_name = 'settings';
    private $_primary_key = 'setting_name';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    /**
      *
      * Save the settings to the database.
      *
      * @param mixed $settings
      *
      * @return bool
      */
    function save_settings($settings)
    {
        if (!is_array($settings))
        {
            $settings = array ($settings);
        }

        foreach ($settings as $setting_name => $value)
        {
            $this->db->where('setting_name', $setting_name);
            if (!$this->db->update($this->_table_name, array('setting_value' => $value)))
            {
                return FALSE;
            }
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
      *
      * Fetch all settings and assign them to key-value pairs.
      *
      * @return array
      */
    function get_settings()
    {
        $result = $this->fetch_all();
    
        if ($result->num_rows() == 0)
        {
            show_error('You have no settings specified on the database.');
        }

        foreach ($result->result() as $setting)
        {
            $settings[$setting->setting_name] = $setting->setting_value;
        }

        return $settings;
    }
	
	
	function createSettingsIfNotExists($settings){
		if(count($settings)){
			foreach($settings as $_setting){
				
				$this->db->where('setting_name', $_setting);
				$q = $this->db->get($this->_table_name);
				if($q->num_rows() <= 0){
					$data = array(
						'setting_name' => $_setting,
						'setting_value' => ''
					);
					
					$this->do_create($data);
				}
			}
		}
	}
}

/* End of file m_settings.php */
/* Location: ./application/models/default/m_settings.php */
