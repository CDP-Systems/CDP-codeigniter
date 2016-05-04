<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Display content from CMS.
$ci =& get_instance();

if (isset($page_content))
{
    echo $page_content;
}
//echo "<hr />";
echo "<p>&nbsp;</p>";
if (!isset($surveys))
{
    echo "No surveys available at the moment.";
}
else
{
?>

<style>
.chart { border-color: #CCC; border-style: solid solid solid none; border-width: 1px 1px 1px 0; margin: 10px 0 20px; width: 100%; }
.chart th { border-left: 1px solid #CCCCCC; padding: 10px; background: #DDD; }
.chart td { border-color: #CCCCCC -moz-use-text-color -moz-use-text-color #CCCCCC; border-style: solid none none solid; border-width: 1px 0 0 1px; padding: 10px; }
.chart .first { background: #EEE; }
</style>

<table width="0"  cellspacing="0" cellpadding="0" class="chart">
  <tr class="title">
    <th><strong>Title</strong></th>
    <th><strong>Description</strong></th>
  </tr>
  <?php foreach ($surveys as $survey):?>
  <tr>
    <td><?php echo anchor($ci->get_current_module() . '/take_survey/' . $survey->survey_id , $survey->survey_name);?></td>
    <td><?php echo $survey->survey_description;?></td>
  </tr>
  <?php
    endforeach;
    echo "</tbody></table>" . $this->pagination->create_links();
	echo "<p>&nbsp;</p>";
}

