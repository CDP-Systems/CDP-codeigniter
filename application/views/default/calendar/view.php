<?php



/*Get the tree url key*/

$ci =& get_instance();

$ci->load->library('CS_Url_Tree', null, 'tree');

$ci->tree->clear();

$ci->tree->id_page = $ci->view_data['id_page'];

$link = $ci->tree->get_link();





if (isset($empty) && $empty == TRUE)

{

    echo "<h2>Sorry could not find the event specified.</h2>";

}

else

{

    echo anchor($link, '&laquo; Back to events');

} 

?>



<div>

<table cellpadding="1" cellspacing="1" border="0" class="form" style="margin-top: 20px">

  <tr>

    <td width="50"><strong>Date:</strong></td>

    <td><?php echo $event_date;?></td>

  </tr>

  <tr>

    <td><strong>Title:</strong></td>

    <td><?php echo $event_title;?></td>

  </tr>

  <tr>

    <td></td>

    <td><?php echo html_entity_decode($event_content);?></td>

  </tr>

</table>

</div>





