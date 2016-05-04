<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Videocast controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-06-06
 */
class Videocast extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('default/m_videocast', 'videos');
        $this->load->helper('form');
        $this->load->config('upload_config');
        $this->view_data['upload_config'] = $this->config->item('videocast/add');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Default action.
     */
    function index($page = 0, $category_id = null)
    {
        $this->view_data['content'] = 'admin/videocast/list';

        $videos = $this->videos->fetch_all();

        if ($videos->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $videos->num_rows();            

            $this->paginate($pagination);

            $results = $this->videos->fetch_all(10, $page);

            $this->view_data['videos'] = $videos->result();
        }

        $this->parser->parse('admin/template', $this->view_data);        
    }    
    
    // --------------------------------------------------------------------

    /**
     * Add a video.
     */
    function add()
    {
        $this->view_data['content'] = 'admin/videocast/edit';

        $this->_prep_form_values('validation_videocast_form');

        if ($this->input->post('submit') || $this->isAjax())
        {
            $id = $this->_save('validation_videocast_form', $this->videos);

            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Video added.');
        
                redirect (current_url());
            }
        }
        
        $this->parser->parse('admin/template', $this->view_data);
    }
    
    // --------------------------------------------------------------------

    /**
     * Edit a video.
     */
    function edit($id = null)
    {
        if (is_null($id) || !$video = $this->videos->get($id))
        {
            show_error('Invalid or no id specified');
        }
        
        $this->view_data['content'] = 'admin/videocast/edit';    

        $this->_prep_form_values('validation_videocast_form', $video);
        
        $this->_form_data['old_url']       = $video->url;
        $this->_form_data['videocast_id']  = $id;
        $this->view_data['videocast_id']   = $id;
        $this->view_data['orig_file_name'] = $video->orig_file_name;

        if ($this->input->post('submit') || $this->isAjax())
        {
            $id = $this->_save('validation_videocast_form', $this->videos);
    
            if ($id)
            {
                // Delete the old video.
                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Video updated.');
        
                redirect (current_url());
            }
        }
        
        $this->parser->parse('admin/template', $this->view_data);
    }    
    
    // --------------------------------------------------------------------

    /**
     * Deletes a video.
     *
     * @param mixed $id ID.
     */
    function delete($id)
    {
    	if($id != ''){
	        if ($this->videos->delete($id))
	        {
	            $message = 'Video/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the video. Please contact the administrator.';
	        }
	}else{
        	$message = '<span style="color:red;">No Videos(s) selected.</span>';
        }
        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/videocast/index');
        }
    }    
          
    // --------------------------------------------------------------------
    
    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $data = $this->input->post('data');

        $action = $this->input->post('selectAction');

	if (trim($action) == '')
	{
		$action = 'index';
	}

        $this->$action($data);
    }     
              
    // --------------------------------------------------------------------
}
/* End of file videocast.php */
/* Location: ./application/controllers/admin/videocast.php */