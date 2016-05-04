<script>
	$(document).ready(function () {
		window.location = window.location + "#event";
	});
</script>

<?php 
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
if (isset($page_content))
{
    //echo $page_content;
}
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$link = $ci->tree->get_link();

// Display color coding based on config.
if ($calendar_enable_color_coding):
?>
     <h1>Events are color-coded by topic:</h1>
     <?php foreach($categories as $category):?>
        <div>
            <label><?php echo $category->category_name;?></label>
            <span style="height:20px;width:60px;background-color: #<?php echo $category->category_color;?>">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
        </div>
     <?php endforeach;?>
<?php endif;?>
<div id="event"></div>
 <div id="calmain">
   	<h2 style="text-align: center;"><?php echo $current_month_text?></h2>
	<table cellspacing="0">
    	<thead>	
			<th>
				<?php echo anchor($link .'/index/'. $previous_year,'&laquo;&laquo;', array('title'=>$previous_year_text));?>
			</th>
			<th>
				<?php echo anchor($link. '/index/'. $previous_month,'&laquo;', array('title'=>$previous_month_text));?>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
			<?php echo anchor($link.'/index/'. $next_month,'&raquo;', array('title'=>$next_month_text));?>
			</th>
			<th>
			<?php echo anchor($link.'/index/'. $next_year,'&raquo;&raquo;', array('title'=>$next_year_text));?>

			</th>		
		</thead>
		<thead>
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
		</tr>
		</thead>
		<tr>
			<?php
			for($i=0; $i< $total_rows; $i++)
			{
				for($j=0; $j<7;$j++)
				{
					$day++;					
					
					if($day>0 && $day<=$total_days_of_current_month)
					{
						//YYYY-MM-DD date format
						$date_form = "$current_year/$current_month/$day";
						
						echo '<td';
						
						//check if the date is today
						if($date_form == $today)
						{
							echo ' id="today"';
						}
						
						//check if any event stored for the date
						if(array_key_exists($day,$events))
						{
							//adding the date_has_event class to the <td> and close it
							echo ' class="date_has_event"> ';
							echo anchor($link . "dayevents/".$current_year."-".$current_month."-".$day,"<b style='padding: 10px;'>" . $day . "</b>");
							
                                                        $first_event = reset($events[$day]);
                                                        
                                                        echo "<div style='font-size: 11px; text-align: center; padding: 0 10px; line-height: normal;'>" . substr($first_event->eventTitle, 0, 20) . "</div>";
                                                        if (count($events[$day]) > 1)
                                                        {
                                                            echo '&raquo;';
                                                        }

                                                        //adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
							echo '<div class="events"><ul style="height: 100px; overflow-y: scroll;">';
							
							foreach ($events as $key=>$event)
                                                        {
                                                            if ($key == $day)
                                                            {
							  	foreach ($event as $single)
                                                                {	
                                                                    $style = '';
                                                                    if ($calendar_enable_color_coding)
                                                                    {
                                                                        $style = 'style="background-color: #' . $single->category_color ;
                                                                    }

                                                                    echo '<li style="list-style:none;">';
                                                                    echo '<span class="title" '. $style . '>'.
                                                                            anchor($link . '/view/' . $single->id, $single->eventTitle) .'</span><span class="desc">'. html_entity_decode($single->eventContent) .'</span>';
                                                                    echo '</li>';
                                                            
  								} // end of for each $event
                                                            }
  								
							} // end of foreach $events
							
							
							echo '</ul></div>';
						} // end of if(array_key_exists...)
					
						else 
						{
							//if there is not event on that date then just close the <td> tag
							echo '><b style="padding: 10px;">'.$day.'</b>';
						}
						echo "</td>";
					}
					else 
					{
						//showing empty cells in the first and last row
						echo '<td class="padding">&nbsp;</td>';
					}
				}
				echo "</tr><tr>";
			}
			
			?>
		</tr>
		
	</table>
    <p>&nbsp;</p>
</div>

	