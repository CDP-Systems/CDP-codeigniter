<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_videocast extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('videocast');
        $this->set_primary_key('videocast_id');
    }
    
    function do_save($params)
    {
        $params['orig_file_name'] = $this->session->userdata('orig_file_video');
        $params['url'] = $this->session->userdata('file_video');
        unset($params['field_video']);
        return parent::do_save($params);
    }
    
    function do_update($params)
    {
        if (trim($params['url']) == '')
        {
            unset($params['url']);
        }
        else
        {
            // Delete the old video.
            unlink(getcwd() . '/uploads/videocast/' . $params['old_url']);
        }

        unset($params['old_url']);
        return parent::do_update($params);
    }
}

/* End of file m_videocast.php */
/* Location: ./application/models/default/m_videocast.php */
