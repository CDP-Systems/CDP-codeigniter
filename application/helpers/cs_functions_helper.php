<?php

if (!function_exists('get_age'))
{
    function get_age( $p_strDate, $separator = "-" ) 
    {
        list($m,$d,$Y)    = explode($separator,$p_strDate);

        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }
}

if(!function_exists('get_url_key')){
/**
      * Get the url key of current page
      * @param string $method - the method of the current class
      * @return string
      */
	function get_url_key($method = NULL){ 
		$ci =& get_instance(); 
		if($method){
			$url_key = ''; $methodFound = FALSE;
			$uri_segment = $ci->uri->segment_array();
			$view_key = '';
			foreach($uri_segment as $key => $value){
				if($value == $method){
					$view_key = $key;
					$methodFound = TRUE;
				}
			}
			$url_key = ($methodFound) ? $uri_segment[$view_key - 1] : end($uri_segment);
		}else{
			$url_key = $ci->get_current_module();
		}
		return $url_key;
	}
}

if(!function_exists('merge_data')){
	/**
      * Merge two data arrays with distinction
      * @param array $base_data - the base data array
	  * @param array $data_to_filter - the array to filter
      * @return null
      */
	function merge_data($base_data, $data_to_filter){
		
		$filtered_view_data = array();
			$page_data = array_keys($base_data);
			foreach($data_to_filter as $key => $val){
				if(!in_array($key, $page_data)){
					$filtered_view_data[$key] = $val;
				}
			}
		return 	$filtered_view_data;
	
	}
	
}

if (!function_exists('get_absolute_url_key'))
{
   // Get absolute link
   function get_absolute_url_key($id_page){
		$ci =& get_instance();
		$ci->load->library('CS_Url_Tree', null, 'tree');
		$ci->tree->clear();
		$ci->tree->id_page = $id_page;
		return $ci->tree->get_link();
		
	}
}

if (!function_exists('enable_recaptcha'))
{
    /**
      * Adds the captcha validation config to the validation rules specified in $config.
      *
      * @param string $config Name of the config index.
      *
      * @return null
      */
    function enable_recaptcha($config)
    {
    
        $ci =& get_instance();
        
        $ci->load->config('recaptcha');
        $ci->load->config('validations');

        $recaptcha_config = $ci->config->item('validate_recaptcha');
        $form_config      = $ci->config->item($config);
        $ci->config->set_item($config, array_merge($form_config, array ($recaptcha_config)));
    }
}

/**
 * Get domain
 *
 * Return the domain name only based on the "base_url" item from your config file.
 *
 * @access    public
 * @return    string
 */    
if (!function_exists('getDomain'))
{
	function getDomain()
	{
		$CI =& get_instance();
		return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/","$1", $CI->config->slash_item('base_url'));
	}  
}


if (!function_exists('html2text'))
{
	function html2text($html)
	{
		$search = ARRAY ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
		                 "'<[/!]*?[^<>]*?>'si",          // Strip out HTML tags
		                 "'([rn])[s]+'",                // Strip out white space
		                 "'&(quot|#34);'i",                // Replace HTML entities
		                 "'&(amp|#38);'i",
		                 "'&(lt|#60);'i",
		                 "'&(gt|#62);'i",
		                 "'&(nbsp|#160);'i",
		                 "'&(iexcl|#161);'i",
		                 "'&(cent|#162);'i",
		                 "'&(pound|#163);'i",
		                 "'&(copy|#169);'i",
		                 "'&#(d+);'e");                    // evaluate as php
		 
		$replace = ARRAY ("",
		                 "",
		                 "\1",
		                 "\"",
		                 "&",
		                 "<",
		                 ">",
		                 " ",
		                 CHR(161),
		                 CHR(162),
		                 CHR(163),
		                 CHR(169),
		                 "chr(\1)");
		 
		return PREG_REPLACE($search, $replace, $html);
	}
}
 