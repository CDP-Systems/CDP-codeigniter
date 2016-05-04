<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_callouts extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('callouts');
        $this->set_primary_key('callout_id');
    }
    
    function fetch_all($limit = null, $offset = null)
    {
    	$this->db->order_by('display_order');
    	return parent::fetch_all($limit, $offset);
    }

    function do_save($params)
    { 

        $params['image_url'] = $this->session->userdata('file_image_url');
			
			$params['disabled_from_pages'] = @json_encode($this->input->post('disabled_from_pages'));
			

        unset($params['field_image_url']);
        return parent::do_save($params);
    }
    
    function do_update($params)
    {
        if (trim($params['image_url']) == '')
        {
            unset($params['image_url']);
        }
        else
        {
            // Delete the old video.
            if (file_exists(getcwd() . '/uploads/callouts/' . $params['old_image']) 
            	&& !is_dir(getcwd() . '/uploads/callouts/' . $params['old_image']))
            {
            	unlink(getcwd() . '/uploads/callouts/' . $params['old_image']);
            }
        }

        unset($params['old_image']);
        return parent::do_update($params);
    }    
}

/* End of file m_videocast.php */
/* Location: ./application/models/default/m_videocast.php */