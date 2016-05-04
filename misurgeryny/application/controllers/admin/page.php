<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends MY_Controller {

    // Defines wether scratchpad is enabled.
    private $_scratchpad = FALSE;

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in'))
            redirect('admin/login');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('admin/M_website');
	$this->load->model('default/M_page');
        $this->load->model('admin/M_class');
        $this->load->helper('file');

        if ($this->get_setting('page_enable_scratchpad') === 1) {
            $this->_scratchpad = TRUE;
        } else {
            $scratchpad_features = array('edit_draft', 'delete_draft');
            if (in_array($this->get_current_action(), $scratchpad_features)) {
                redirect('admin/page');
            }
        }

        session_start();
    }

    function index($offset = 0) {
        //set pagination
        $perpage = 20;
        $this->pagination($perpage);
        //set page data
        $data['title'] = 'Pages';
        $data['content'] = 'admin/page/page';
        $data['sitename'] = $this->M_website->getName();
        $data['pages'] = $this->m_page->get_all($perpage, $offset);
        $data['scratchpad'] = $this->_scratchpad;

        if ($this->_scratchpad) {
            $this->load->model('default/m_page_draft', 'draft');
            foreach ($data['pages'] as &$page) {
                $page['draft'] = $this->draft->fetch_page_drafts($page['id_page']);
            }
        }

        if (isset($_SESSION['saved'])) {
            $data['saved'] = $_SESSION['saved'];
            unset($_SESSION['saved']);
        }
        if (isset($_SESSION['updated'])) {
            $data['updated'] = $_SESSION['updated'];
            unset($_SESSION['updated']);
        }
        if (isset($_SESSION['deleted'])) {
            $data['deleted'] = $_SESSION['deleted'];
            unset($_SESSION['deleted']);
        }
        //actions settled
        if (isset($_SESSION['noSelected'])) {
            $data['noSelected'] = $_SESSION['noSelected'];
            unset($_SESSION['noSelected']);
        }
        if (isset($_SESSION['action'])) {
            $data['action'] = $_SESSION['action'];
            unset($_SESSION['action']);
            if (isset($_SESSION['actionsSuccess'])) {
                $data['actionsSuccess'] = $_SESSION['actionsSuccess'];
                unset($_SESSION['actionsSuccess']);
            }
            if (isset($_SESSION['actionsFailed'])) {
                $data['actionsFailed'] = $_SESSION['actionsFailed'];
                unset($_SESSION['actionsFailed']);
            }
        }
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    function view_all() {
       
        //set page data
        $data['title'] = 'Pages';
        $data['content'] = 'admin/page/page';
        $data['sitename'] = $this->M_website->getName();
        $data['pages'] = $this->m_page->get_all();
        $data['scratchpad'] = $this->_scratchpad;

        if ($this->_scratchpad) {
            $this->load->model('default/m_page_draft', 'draft');
            foreach ($data['pages'] as &$page) {
                $page['draft'] = $this->draft->fetch_page_drafts($page['id_page']);
            }
        }

        if (isset($_SESSION['saved'])) {
            $data['saved'] = $_SESSION['saved'];
            unset($_SESSION['saved']);
        }
        if (isset($_SESSION['updated'])) {
            $data['updated'] = $_SESSION['updated'];
            unset($_SESSION['updated']);
        }
        if (isset($_SESSION['deleted'])) {
            $data['deleted'] = $_SESSION['deleted'];
            unset($_SESSION['deleted']);
        }
        //actions settled
        if (isset($_SESSION['noSelected'])) {
            $data['noSelected'] = $_SESSION['noSelected'];
            unset($_SESSION['noSelected']);
        }
        if (isset($_SESSION['action'])) {
            $data['action'] = $_SESSION['action'];
            unset($_SESSION['action']);
            if (isset($_SESSION['actionsSuccess'])) {
                $data['actionsSuccess'] = $_SESSION['actionsSuccess'];
                unset($_SESSION['actionsSuccess']);
            }
            if (isset($_SESSION['actionsFailed'])) {
                $data['actionsFailed'] = $_SESSION['actionsFailed'];
                unset($_SESSION['actionsFailed']);
            }
        }
        //parse template
        $this->parser->parse('admin/template', $data);
    }



    function add() {
        //set page data
        $data['title'] = 'Add Page';
        $data['content'] = 'admin/page/page_add';
        $data['sitename'] = $this->M_website->getName();
        $data['classes'] = $this->M_class->get_all();
        $data['parents'] = $this->m_page->get_parent_dropdown();
        $data['pages'] = $this->m_page->get_all();
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    function save() {
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');
        $this->form_validation->set_rules('url_key', 'URL Key', 'required|callback_checkURLKey');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            //set page data
            $this->add();
        } else {
            if ($this->m_page->insert($_POST)) {
                //page route
                $this->define_routing();
                //redirect page
                $_SESSION['saved'] = TRUE;
                redirect('admin/page');
            }
        }
    }

    function edit($id) {
        //set page data
        $data['scratchpad'] = $this->_scratchpad;

        $data['title'] = 'Edit Page';
        $data['content'] = 'admin/page/page_edit';
        $data['sitename'] = $this->M_website->getName();
        $data['page'] = $this->m_page->get_id($id);
        $data['pages'] = $this->m_page->get_all();
        $data['parents'] = $this->m_page->get_parent_dropdown();

        if ($this->_scratchpad) {
            $this->load->model('default/m_page_draft', 'draft');

            $drafts = $this->draft->fetch_page_drafts($id);

            if ($drafts->num_rows() > 0) {
                $data['drafts'] = $drafts->result();
            }
        }

        $data['classes'] = $this->M_class->get_all();
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    function edit_draft($id) {
        //set page data
        $this->load->model('default/m_page_draft', 'draft');
        $data['scratchpad'] = $this->_scratchpad;
        $draft = $this->draft->get($id);

        $data['title'] = 'Edit Draft';
        $data['content'] = 'admin/page/page_edit';
        $data['sitename'] = $this->M_website->getName();
        $data['page'] = (array) $draft;
        $data['pages'] = $this->m_page->get_all();
        $data['parents'] = $this->m_page->get_parent_dropdown();

        $drafts = $this->draft->fetch_page_drafts($draft->id_page);

        if ($drafts->num_rows() > 0) {
            $data['drafts'] = $drafts->result();
        }

        $data['classes'] = $this->M_class->get_all();
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    function delete_draft($id) {
        $this->load->model('default/m_page_draft', 'draft');

        if ($this->draft->delete($id)) {
            $this->session->set_flashdata('message', 'Draft deleted');
        }
        redirect('admin/page');
    }

    function update() {
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');
        $this->form_validation->set_rules('url_key', 'URL Key', 'required|callback_checkURLKey');
        $this->form_validation->set_rules('status', 'Status', 'required');

        $data['page'] = $this->m_page->get_by_id($this->input->post('id_page'));
        if ($this->form_validation->run() == FALSE) {
            //set page data
            $data['title'] = 'Edit Page';
            $data['content'] = 'admin/page/page_edit';
            $data['sitename'] = $this->M_website->getName();

            //parse template
            $this->parser->parse('admin/template', $data);
        } else {
            // Check if draft is called.
            if ($this->_scratchpad && $this->uri->segment(4) == 'draft') {
                $this->load->model('default/m_page_draft', 'draft');

                if ($draft_id = $this->draft->do_save($_POST)) {
                    $this->session->set_flashdata('message', 'Draft on ' . date('Y-m-d, h:i:s') . ' saved.');
                    redirect('admin/page/edit_draft/' . $draft_id);
                } else {
                    die('fail');
                }
            } else if ($this->_scratchpad && $this->uri->segment(4) == 'publish_draft') {
                $this->load->model('default/m_page_draft', 'draft');

                if ($draft_id = $this->draft->do_save($_POST)) {
                    $this->session->set_flashdata('message', 'Draft published and saved');
                }
            }

            if ($this->m_page->update($_POST)) {
                //page route
                if (!isset($_POST['class'])) {
                    $class = $data['page']->class;
                } else {
                    $class = $_POST['class'];
                }

//				$this->setPageRoute($_POST['url_key'], $class, $this->input->post('parent_id'));
                $this->define_routing();
                //redirect page
                $_SESSION['updated'] = TRUE;
                redirect('admin/page');
            }
        }
    }

    function delete($id) {
        if ($this->m_page->delete($id)) {
            $_SESSION['deleted'] = TRUE;
            redirect('admin/page');
        }
    }

    /**
     *
     * Clears the page_routes.php file and defines the routes all over again for each page that we have.
     */
    private function define_routing() {
        $routeFilePath = str_replace('system/', '', BASEPATH) . 'application/config/page_routes.php';
        // Open and clear the file.
        $fp = fopen($routeFilePath, 'w');
        // Append the php open tag.	    
        fwrite($fp, "<?php\n\r");

        $pages = $this->m_page->fetch_all();

        foreach ($pages->result() as $page) {
            // Comment to identify the page.
            fwrite($fp, '// ' . $page->page_title . "\n");
            // Append the routes.
            $routes = str_replace(';', ";\n", $this->setPageRoute($page->url_key, $page->class, $page->parent_id));
            fwrite($fp, $routes . "\n");
        }

        // Close the file.
        fclose($fp);
    }

    private function _build_route($url_key, $parent_id) {
        $parent = $this->m_page->get_by_id($parent_id);

        $this->url_key[] = $parent->url_key;

        if ($parent->parent_id > 0) {
            $this->_build_route($parent->url_key, $parent->parent_id);
        }

        return implode('/', array_reverse($this->url_key)) . '/' . $url_key;
    }

    function setPageRoute($url_key, $class, $parent_id = null) {


        $regex_key = $url_key;

        if (!is_null($parent_id) && $parent_id > 0) {
            $this->url_key = '';
            $url_key = $this->_build_route($url_key, $parent_id);

            $regex_key = str_replace('/', '\/', $url_key);
        }

        $data = '';

        //overwrite the file if the route did not exists
        switch ($class) {
            case 'home':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/page"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/page"; ';
                }
                break;
            case 'contact_us':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/contact_us"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/contact_us"; ';
                    $data .= '$route["' . $url_key . '/send"] = "default/contact_us/send";';
                }
                break;
            case 'newsletter':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/newsletter"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/newsletter"; ';
                    $data .= '$route["' . $url_key . '/subscribe"] = "default/newsletter/subscribe"; ';
                    $data .= '$route["' . $url_key . '/subscribe/([a-z0-9]+)"] = "default/newsletter/subscribe/$1"; ';
                    $data .= '$route["' . $url_key . '/unsubscribe"] = "default/newsletter/unsubscribe"; ';
                    $data .= '$route["' . $url_key . '/unsubscribe-form"] = "default/newsletter/unsubscribe_form"; ';
                    $data .= '$route["' . $url_key . '/unsubscribe/([a-z0-9]+)"] = "default/newsletter/unsubscribe/$1"; ';
                    $data .= '$route["' . $url_key . '/view/([a-z0-9]+)"] = "default/newsletter/view/$1"; ';
                    $data .= '$route["' . $url_key . '/success"] = "default/newsletter/success"; ';
                    $data .= '$route["' . $url_key . '/subscriber_exists"] = "default/newsletter/subscriber_exists"; ';
                }
                break;
            case 'search':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/search"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/search"; ';
                    $data .= '$route["' . $url_key . '/result"] = "default/search/result"; ';
                    $data .= '$route["' . $url_key . '/construct"] = "default/search/construct"; ';
                    $data .= '$route["' . $url_key . '/construct/(:any)"] = "default/search/construct/$1"; ';
                    $data .= '$route["' . $url_key . '/result/index/([a-z0-9]+)"] = "default/search/result/$1"; ';
                    $data .= '$route["' . $url_key . '/result/index/([a-z0-9]+)/([0-9]+)"] = "default/search/result/$1/$2"; ';
                    $data .= '$route["' . $url_key . '/index"] = "default/search/index/"; ';
                    $data .= '$route["' . $url_key . '/index/(:any)"] = "default/search/index/$1"; ';
                    $data .= '$route["' . $url_key . '/index/(:any)/([0-9]+)"] = "default/search/index/$1/$2"; ';
                }
                break;
            case 'faq':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/faq"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/faq";';
                    $data .= '$route["' . $url_key . '/category/([0-9]+)"] = "default/faq/category/$1";';
                }
                break;
            case 'referrals':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/referrals"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/referrals";';
                }
                break;
            case 'calendar':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/calendar"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/calendar";';
                    $data .= '$route["' . $url_key . '/(:num)"] = "default/calendar/dayevents/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)"] = "default/calendar/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/calendar/$1/$2";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:any)"] = "default/calendar/$1/$2";';
                }
                break;
            case 'bmi_calc':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/bmi_calc"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/bmi_calc";';
                    $data .= '$route["' . $url_key . '/compute"] = "default/bmi_calc/compute";';
                }
                break;
            case 'affordability_calc':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/affordability_calc"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/affordability_calc";';
                    $data .= '$route["' . $url_key . '/compute"] = "default/affordability_calc/compute";';
                }
                break;
            case 'podcast':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/podcast"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/podcast";';
                }
                break;
            case 'testimonial_add':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/testimonials\/add"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/testimonials/add"; ';
                }
                break;
            case 'testimonial':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/testimonials"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/testimonials"; ';
                }
                break;
            case 'testimonials':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/testimonials\/index"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/testimonials/index"; ';
                    $data .= '$route["' . $url_key . '/view/([a-z0-9]+)"] = "default/testimonials/view/$1"; ';
                    $data .= '$route["' . $url_key . '/index/([0-9]+)"] = "default/testimonials/index/$1";';
                    $data .= '$route["' . $url_key . '/index"] = "default/testimonials/index"; ';
                    $data .= '$route["' . $url_key . '/list_testimonials"] = "default/testimonials/list_testimonials"; ';
                    $data .= '$route["' . $url_key . '/list_testimonials/([a-z0-9]+)"] = "default/testimonials/list_testimonials/$1"; ';
                    $data .= '$route["' . $url_key . '/list_testimonials/([a-z0-9]+)/([a-z0-9]+)"] = "default/testimonials/list_testimonials/$1/$2"; ';
                }
                break;
            case 'testimonial_add':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/testimonials\/add"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["tell-us-your-story"] = "default/testimonials/add"; ';
                }
                break;
            case 'seminars':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/seminars"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/seminars/index"; ';
                    $data .= '$route["' . $url_key . '/(:num)"] = "default/seminars/$1"; ';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)"] = "default/seminars/$1"; ';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/seminars/$1/$2"; ';
                }
                break;
            case 'online_seminars':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/online_seminars"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/online_seminars";';
                }
                break;
            case 'news':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/news"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/news";';
                    $data .= '$route["' . $url_key . '/view/(:any)"] = "default/news/view/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)"] = "default/news/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/news/$1/$2"; ';
                }
                break;
            case 'surveys':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/surveys"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/surveys";';
                    $data .= '$route["' . $url_key . '/(:any)"] = "default/surveys/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/surveys/$1/$2"; ';
                }
                break;
            case 'self_assessment':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/self_assessment"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/self_assessment";';
                    $data .= '$route["' . $url_key . '/(:any)"] = "default/self_assessment/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/self_assessment/$1/$2"; ';
                }
                break;
            case 'videocast':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/videocast"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/videocast";';
                    $data .= '$route["' . $url_key . '/(:any)"] = "default/videocast/$1";';
                    $data .= '$route["' . $url_key . '/([a-z0-9]+)/(:num)"] = "default/videocast/$1/$2"; ';
                }
                break;
            case 'appointment':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/appointment"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/appointment"; ';
                }
                break;
            case 'insurance':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/insurance"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/insurance"; ';
                }
                break;
            case 'membership':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/membership"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/membership"; ';
                    $data .= '$route["' . $url_key . '/payment"] = "default/membership/payment"; ';
                    $data .= '$route["' . $url_key . '/paypal"] = "default/membership/paypal"; ';
                }
                break;
            case 'ask_the_expert':
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/ask_the_expert"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/ask_the_expert"; ';
                    $data .= '$route["' . $url_key . '/send"] = "default/ask_the_expert/send";';
                }
                break;
            default:
                $routeExists = (preg_match('~/\$route\["' . $regex_key . '"\] = "default\/page\/view"/~', $data)) ? TRUE : FALSE;
                if (!$routeExists) {
                    $data .= '$route["' . $url_key . '"] = "default/page/view"; ';
                }
        }

        return $data;
    }

    function checkURLKey($url_key) {
        $result = $this->m_page->checkUrlKey($url_key, $this->input->post('id_page'));
        if (count($result)) {
            $this->form_validation->set_message('checkURLKey', 'URL key not available.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function hide($id){
         if($this->m_page->hide($id)){
			$_SESSION['saved'] = TRUE;	
			redirect('admin/page');
		}else{
			$_SESSION['saved'] = FALSE;
		}
    }
   
    function show($id){
	if($this->m_page->show($id)){
			$_SESSION['saved'] = TRUE;	
			redirect('admin/page');
		}else{
			$_SESSION['saved'] = FALSE;
	         }
    }

    function post_to_uri($value = null)
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('search', 'Search', 'trim|xss_clean|urlencode');

        if ($this->form_validation->run())
        {
            $query_string = set_value('search');
            redirect (site_url('admin/page/search/' . $query_string));
        }
        else
        {
            show_error('Nice try! Your IP has been logged and we are notifying proper authorities');
        }
    }

     // --------------------------------------------------------------------
    
    function search($value = '', $offset = 0)
    {
        // Decode uri encoded string.
        $value = urldecode($value);

        //set page data
        $pages = $this->M_page->search_all(array('page_title', 'class'), $value);
        //set pagination
        $perpage = 10;
        //set pagination
        $pagination_config = array(
            'perpage' => 10,
            'base_url' =>  site_url('admin/page/search/' . $value . '/'),
            'count' => $pages->num_rows(),
            'uri_segment' => 5
        );
        //$this->pagination($pagination_config);
        $pages = $this->M_page->search_all(array('page_title', 'class'), $value, $perpage, $offset)->result();

        $pageList = array();
        foreach ($pages as $page)
        {
            $pageList[] = (array) $page;
        }

        $data['pages'] = $pageList;
        $data['title'] = 'Page';
        $data['content'] = 'admin/page/page';
        $data['sitename'] = $this->M_website->getName();
         //parse template
        $this->parser->parse('admin/template', $data);
    }

    function pagination($perpage) {
        /* PAGINATION SETTING */
        $config['base_url'] = base_url() . index_page() . 'admin/page/index/';
        $config['total_rows'] = $this->m_page->get_count();
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        //first and last links
        $config['first_link'] = '&laquo; First';
        $config['last_link'] = 'Last &raquo;';
        //first link tags
        $config['first_tag_open'] = '<li style="margin-right:20px;">';
        $config['first_tag_close'] = '</li>';
        //last link tags
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '<li>';
        //next link tags
        $config['next_link'] = 'Next &raquo;';
        $config['next_tag_open'] = '<li style="margin-right:20px;margin-left:10px;"">';
        $config['next_tag_close'] = '</li>';
        //previous link tags
        $config['prev_link'] = '&laquo; Previous';
        $config['prev_tag_open'] = '<li style="margin-right:10px;">';
        $config['prev_tag_close'] = '</li>';
        //current link tags
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        //links tags
        $config['num_tag_open'] = '<li class="pages">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }

    function action() {
        $uri_4 = $this->input->post('uri_4');
        $failCtr = 0;
        $successCtr = 0;
        if (!$this->input->post('pages')) {
            $_SESSION['noSelected'] = TRUE;
        } else {
            switch ($this->input->post('selectAction')) {
                case 1:
                    //DELETE
                    $_SESSION['action'] = TRUE;
                    foreach ($this->input->post('pages') as $row) {
                        if (!$this->m_page->delete($row)) {
                            $failCtr++;
                            $_SESSION['actionsFailed'] = $failCtr;
                        } else {
                            $successCtr++;
                            $_SESSION['actionsSuccess'] = $successCtr;
                        }
                    }
                    break;
            }
        }
        redirect('admin/page/index/' . $uri_4);
    }

}

/* End of file page.php */
/* Location: ./application/controllers/admin/page.php */