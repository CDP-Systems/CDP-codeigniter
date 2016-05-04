<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Get the tree url key*/
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$link = $ci->tree->get_link();

echo "<br />";
// Display news title.
echo "<h2>" . $news_title . "</h2>";
echo "<br />";
// Display content.
echo html_entity_decode($news_body);
echo anchor ($link, '<p><b>Back to news</b></p>');
