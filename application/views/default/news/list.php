<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



// Display content from CMS.







/*Get the tree url key*/



$ci =& get_instance();



$ci->load->library('CS_Url_Tree', null, 'tree');



$ci->tree->clear();



$ci->tree->id_page = $ci->view_data['id_page'];



$link = $ci->tree->get_link();



$str_char  = array("!", "&", "amp;");



if (isset($page_content))



{



    //echo $page_content;



}







if (!isset($news))



{



    echo "No news available at the moment.";



}



else



{



?>



<?php foreach ($news as $balita):?>



	<br />



    <div><h3><?php echo anchor($link . '/view/' . create_news_url(str_replace($str_char,'',$balita->title)) . '/' . $balita->news_id, $balita->title);?></h3></div>



    <div><p style="padding-bottom: 10px;"><?php echo html_entity_decode($balita->introduction);?></p></div>



    <div><p style="padding-bottom:0"><b><?php echo anchor($link . '/' . 'view/' . create_news_url(str_replace($str_char,'',$balita->title)). '/' . $balita->news_id, 'more...');?></b></p></div>



    <hr />



<?php



    endforeach;



    echo $this->pagination->create_links();



}



