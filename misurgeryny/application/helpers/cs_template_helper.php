<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package		CS
 * @author		CS
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 */

if (!function_exists('set_template'))
{
    /**
     * Set the page template
     */
    function set_template($url_key)
    {
		$data = array();
		$ci =& get_instance();

		$default_tpl = $ci->get_setting('inner_template');
		
		switch($url_key){
			case 'your-medical-weight-loss-options':
			case 'intensive-lifestyle-intervention':
			case 'low-and-very-low-calorie-diet-plans':
			case 'medication':
			case 'meal-replacement':
			case 'supervision-and-support':
			case 'medical-exercise':
			case 'tobacco-cessation':
				$template = '2columns_right.php';
				break;
			case 'general-surgery':
			case 'laparoscopic-surgery':
			case 'staff':
			case 'location':
			case 'heart-burn':
			case 'reflux-surgery':
			case 'endoscopic-reflux-surgery':
			case 'abdominal-procedures':
			case 'breast-health':
			case 'vascular-surgery':
			case 'hernia-repair':
				$template = '2columns_right.php';
				break;
			default:
				$template = $default_tpl;
		}
		
		return 'default/templates/' . $template;
	
    }
}

/* End of file cs_dropdown_helper.php */
/* Location: ./application/application/helpers/cs_template_helper.php */