<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Calendar Manager</h1>
            <?php $this->load->view('admin/calendar/tabs', array('list' => 'active'));?>
			<div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>			
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="calleft"></div>
        <div id="calmain">
        <?php
        if ($this->session->flashdata('message')){
                echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
        }
        ?>
                <h2 style="text-align: center; font-size: 20px;"><?php echo $current_month_text; ?></h2>
                <table cellspacing="0" class="table-calendar">
                        <thead>
                        	<tr>
                                <th><?php echo anchor('admin/calendar/index/'.$previous_year,'&laquo;&laquo;', array('title'=>$previous_year_text));?></th>
                                <th><?php echo anchor('admin/calendar/index/'.$previous_month,'&laquo;', array('title'=>$previous_month_text));?></th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th><?php echo anchor('admin/calendar/index/'.$next_month,'&raquo;', array('title'=>$next_month_text));?></th>
                                <th><?php echo anchor('admin/calendar/index/'.$next_year,'&raquo;&raquo;', array('title'=>$next_year_text));?></th>
                            </tr>
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
                                                                echo '<b style="padding: 10px;">'.$day.'</b>';

                                                                $first_event = reset($events[$day]);

                                                                echo "<div style='font-size: 11px; text-align: center; padding: 0 10px; line-height: normal;'>" . $first_event->eventTitle . "</div>";
                                                               
															   if (count($events[$day]) > 1)
                                                                {
                                                                    echo '&raquo;';
                                                                }

                                                                //adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
                                                                echo '<div class="events"><ul style="height: 140px; overflow-y: scroll;">';

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
                                                                            echo '<li>';
																			
                                                                            echo anchor("admin/calendar/edit/$single->id",'<span class="title" '. $style .'>'.$single->eventTitle.'</span><span class="desc">'.html_entity_decode($single->eventContent).'</span>');
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
    </div>
</div>
