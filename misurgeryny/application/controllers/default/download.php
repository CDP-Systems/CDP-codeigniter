<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('download');
	}

	function index($id){ 
		$download = $this->M_download->get($id); 
		if(count($download)){
			$filePath = str_replace('system/','',BASEPATH).'uploads/downloads/'.$download['file_name'];
			$name = $download['file_name'];
			force_download($name, file_get_contents($filePath));
			return TRUE;
		}
		return FALSE;
	}
	

}


/* End of file download.php */
/* Location: ./application/controllers/default/download.php */