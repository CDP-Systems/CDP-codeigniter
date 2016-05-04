<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Display content from CMS.
$ci =& get_instance();

if (isset($page_content))
{	
    //echo $page_content;
}
//echo "<hr />";
//echo "<p>&nbsp;</p>";
if (!isset($seminars))
{
    echo "No seminars available at the moment.";
}
else
{
?>

<style>
.chart { padding: 1px; margin: 10px 0 20px; width: 100%; background: #fff; }
.chart th { /*border-left: 1px solid #CCCCCC;*/ padding: 10px; background: #b3bb92; }
.chart td {/* border-color: #CCCCCC -moz-use-text-color -moz-use-text-color #CCCCCC; border-style: solid none none solid; border-width: 1px 0 0 1px;*/ padding: 10px; }
.chart .first { background: #b3bb92; }
.chart tr.shade { background: #dfe5d7; }
</style>

<div class="border">

<table width="0"  cellspacing="0" cellpadding="0" class="chart">
  <tr class="title">
    <th width="180"><strong>Seminar Date and Time</strong></th>
    <th><strong>Title</strong></th>
    <th><strong>Location</strong></th>
  </tr>
  <?php foreach ($seminars as $seminar):?>
  <tr>
    <td>
        <div style="color: #336350; margin-bottom: 5px"><?php echo date('F d, Y', strtotime($seminar->seminar_date));?></div>
        <div><?php echo $seminar->time . ' - ' . $seminar->end_time;?></div>
    </td>
    <td>
        <?php 
        if ($seminar->total_attendees >= $seminar->max_num_attendees || $seminar->is_full)
        {
            echo $seminar->title . ' <div class="red">(Seminar is full)</div>';
        }
        else
        {
           // echo anchor($ci->get_current_module() . '/' . 'register/' . $seminar->seminar_id, $seminar->title);
		   echo "<a href='".$current_url."/register/".$seminar->seminar_id."'>".$seminar->title."</a>";
		}
        ?>
    </td>
    <td><?php echo $seminar->location;?></td>
  </tr>
  <?php
    endforeach;
    echo "</tbody></table></div>" . $this->pagination->create_links();
	echo "<p>&nbsp;</p>";
}
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table tr:nth-child(odd)").css( "backgroundColor", "#eeeab6" );</script>
