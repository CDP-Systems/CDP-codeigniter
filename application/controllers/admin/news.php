<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

    // Holds values of form fields.
    protected $_form_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_news', 'news');       
    }

    // --------------------------------------------------------------------

    /**
    * Default action, lists all news created.
    */
    function index()
    {
        $this->view_data['content'] = 'admin/news/list';

        $news = $this->news->fetch_all();

        if ($news->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $news->num_rows();

            $this->paginate($pagination);

            $results = $this->news->fetch_all(10, $page);

            $this->view_data['news'] = $results->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
    * View single news item.
    */
    function view($news_id = NULL)
    {
        $news = $this->news->get($news_id);

        if (is_null($news_id) || $news == FALSE)
        {
            redirect ('admin/news/');
        }       

        $this->view_data['content'] = 'admin/news/view';

        $this->view_data['news_title'] = $news->title;
        $this->view_data['news_body'] = $news->body;

        $this->parser->parse('admin/template', $this->view_data);
    }
    
    // --------------------------------------------------------------------

    /**
    * Add a single news item.
    */
    function add()
    {
        $this->view_data['content'] = 'admin/news/edit';

        $this->_prep_form_values('news_edit_form');

        if ($this->input->post('submit'))
        {
            if ($this->_save('news_edit_form', $this->news))
            {
                $this->session->set_flashdata('message', 'News item added!');

                redirect (current_url());
            }
        }
        
        $this->parser->parse('admin/template', $this->view_data);
    }    

    // --------------------------------------------------------------------

    /**
    * Edit single news item.
    */
    function edit($news_id = NULL)
    {
        $news = $this->news->get($news_id);

        if (is_null($news_id) || $news == FALSE)
        {
            redirect ('admin/news/');
        }

        $this->view_data['content'] = 'admin/news/edit';

        $this->_prep_form_values('news_edit_form', $news);

        $this->_form_data['news_id'] = $news_id;

        if ($this->input->post('submit'))
        {
            if ($this->_save('news_edit_form', $this->news))
            {
                $this->session->set_flashdata('message', 'News item updated!');

                redirect (current_url());
            }
        }
        
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a row/rows from the news table.
     *
     * @param mixed $id ID.
     */
    function delete($id)
    {
   	 if($id != ''){
	        if ($this->news->delete($id))
	        {
	            $this->session->set_flashdata('message', 'News successfully deleted.');
	        }
	        else
	        {
	            $this->session->set_flashdata('message', 'Could not delete the news item. Please contact the administrator.');
	        }
	}else{
		$this->session->set_flashdata('message', '<p class="red bold">No news selected.</p>');
	}
        redirect('admin/news/');
        
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
}

/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */
