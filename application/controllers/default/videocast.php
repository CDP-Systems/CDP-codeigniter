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

        $this->load->helper('form');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Default action.
     */
    function index()
    {
        $this->view_data['page'] = 'default/videocast/play';
        $this->view_data['title']   = 'Videocasts';
        
        $this->load->model('default/M_page');
        $url_key = $this->get_current_module(); 
	$page = $this->M_page->get($url_key);
	$this->load->model('admin/M_website');
	$website = $this->M_website->getWebsite();
	
	$this->view_data['robots'] = $website['meta_robots'];			
	$this->view_data['keywords'] = $page['keywords'];
	$this->view_data['desc'] = $page['desc'];
	
	//set global meta data if page meta data is blank
	if($page['keywords'] == ''){
		$this->view_data['keywords'] = $website['default_metakeywords'];
	}
	if($page['desc'] == ''){
		$this->view_data['desc'] = $website['default_metadesc'];
	}
	
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);	 
    }    

    /**
     * Create an xml page that feeds data to the swf player.
     */ 
    function drawXml()
    {
        $this->load->library('xml_writer');
        
        $this->load->model('default/m_videocast', 'videos');
        
        $id = $this->session->userdata('videocast_id');

        $videos = $this->videos->fetch_all();
        
        if ($videos->num_rows() > 0)
        {
            $this->xml_writer->setRootName('media');
            $this->xml_writer->initiate();
            
            foreach ($videos->result() as $video)
            {
                $this->xml_writer->startBranch('item');
                $this->xml_writer->addNode('watermark', '', array('value' => 'assets/watermark/oscar.png'));
                $this->xml_writer->addNode('startImage', '', array('value' => 'assets/startimage/film.gif'));
                $this->xml_writer->addNode('url','', array('value' => '../uploads/videocast/' . $video->url));
                $this->xml_writer->addNode('infoThumb', '', array('value' => 'assets/infothumb/default_video.gif'));                
                $this->xml_writer->addNode('subtitleURL', '', array('value' => 'assets/subtitles/dummy.xml'));
                $this->xml_writer->addNode('infoTitle', '<infoTitle>' . $video->infoTitle . '</infoTitle>', array(), TRUE);
                $this->xml_writer->addNode('infoDesc', '<infoDesc>' . $video->infoDesc . '</infoDesc>', array(), TRUE);                
                $this->xml_writer->endBranch();
            }
            $this->xml_writer->getXml(true);
        }         
    }

    // --------------------------------------------------------------------
}
/* End of file videocast.php */
/* Location: ./application/controllers/default/videocast.php */
