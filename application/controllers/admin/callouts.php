<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Videocast controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-06-06
 */
class Callouts extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('default/m_callouts', 'callouts');
        $this->load->helper('form');
        $this->load->helper('cs_dropdown');
		$this->load->model('admin/M_website');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Default action.
     */
    function index($page = 0, $category_id = null)
    {
        $this->view_data['content'] = 'admin/callouts/list';

        $callouts = $this->callouts->fetch_all();

        if ($callouts->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $callouts->num_rows();            

            $this->paginate($pagination);

            $results = $this->callouts->fetch_all(10, $page);

            $this->view_data['callouts'] = $callouts->result();
        }

        $this->parser->parse('admin/template', $this->view_data);        
    }    
    
    // --------------------------------------------------------------------

    /**
     * Add a callout.
     */
    function add()
    {	
        $this->view_data['content'] = 'admin/callouts/edit';

        $this->_prep_form_values('validation_callouts_form');

        if ($this->input->post('submit') || $this->isAjax())
        {
            $id = $this->_save('validation_callouts_form', $this->callouts);
			
            if ($id)
            { 
                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Callout added.');
        
                redirect (current_url());
            }
        }
		
	$this->view_data['pages']  = $this->m_page->get_all();
        
        $this->parser->parse('admin/template', $this->view_data);
    }
    
    // --------------------------------------------------------------------

    /**
     * Edit a callout.
     */
    function edit($id = null)
    {
        if (is_null($id) || !$callout= $this->callouts->get($id))
        {
            show_error('Invalid or no id specified');
        }
        
        $this->view_data['content'] = 'admin/callouts/edit';    

        $this->_prep_form_values('validation_callouts_form', $callout);
        
        $this->_form_data['old_image']   = $callout->image_url;
        $this->_form_data['callout_id']  = $id;
        $this->view_data['callout_id']   = $id;
        $this->view_data['old_image']    = $this->_form_data['old_image'];


        if ($this->input->post('submit') || $this->isAjax())
        { 
            $id = $this->_save('validation_callouts_form', $this->callouts);
    
            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Callout updated.');
        
                redirect (current_url());
            }
        }
		
			$this->view_data['pages']  = $this->m_page->get_all();
			$this->view_data['not_in_page']  = @json_decode($callout->disabled_from_pages);
			
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
	        if ($this->callouts->delete($id))
	        {
	            $message = 'Callout/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the callout. Please contact the administrator.';
	        }
        }else{
        	$message = '<span style="color:red;">No Callout(s) selected.</span>';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/callouts/index');
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