<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawCharts);
      function drawCharts() {
        drawPastDay();
        drawThisWeek();
        drawPastMonth();
        drawPastYear();
        drawPerPage();
      }
     
      // --------------------------------------------------------------------    
      
      function drawPastDay()
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Time');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Unique Visitors');
        data.addRows(<?php echo count($times);?>);
        <?php 
            if (count($times) > 0):
                $index = 0;
                foreach ($times as $time):
        ?>
            data.setValue(<?php echo $index;?>, 0, "<?php echo $time['time'];?>");
            data.setValue(<?php echo $index;?>, 1, <?php echo $time['hits'];?>);            
            data.setValue(<?php echo $index;?>, 2, <?php echo $time['unique'];?>);            
        <?php 
                $index++;
                endforeach;
            endif;
        ?>

        var chart = new google.visualization.AreaChart(document.getElementById('today_chart'));
        chart.draw(data, {
                    width: 910, 
                    height: 300, 
                    title: 'Today',
                    hAxis: {title: 'Total Views: <?php echo $today_hits;?> | Unique Visitors: <?php echo $today_unique;?>'},
                    });
      }
      
      // --------------------------------------------------------------------          
      
      function drawThisWeek()
      {
        <?php $days = array ('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');?>
      
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Day');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Unique Visitors');
        data.addRows([
            ['Today', <?php echo $today_hits;?>, <?php echo $today_unique;?>],
            <?php 
                foreach ($days as $day):
                    if ($day != strtolower(date('l'))):
                        $last_day_hits = 'last_' . $day . '_hits';
                        $last_day_unique = 'last_' . $day . '_unique';                        
            ?>
            ['<?php echo ucwords($day);?>', <?php echo $$last_day_hits;?>, <?php echo $$last_day_unique;?>],
            <?php 
                    endif;
                endforeach;
            ?>
        ]);                                                      
                
        var chart = new google.visualization.BarChart(document.getElementById('this_week_chart'));
        chart.draw(data, {
                    width: 450, 
                    height: 240, 
                    legend: 'none',
                    title: 'This Week',
                    });
      }        
      
      // --------------------------------------------------------------------    
      
      function drawPastMonth()
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Day');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Unique Visitors');
        data.addRows([
            ['This Week', <?php echo $this_week_hits;?>, <?php echo $this_week_unique;?>],
            ['Last Week', <?php echo $last_week_hits;?>, <?php echo $last_week_unique;?>],
            ['2 Weeks Ago', <?php echo $two_week_hits;?>, <?php echo $two_week_unique;?>],
            ['3 Weeks Ago', <?php echo $three_week_hits;?>, <?php echo $three_week_unique;?>],
            ['4 Weeks Ago', <?php echo $four_week_hits;?>, <?php echo $four_week_unique;?>],
        ]);                                                      
                
        var chart = new google.visualization.BarChart(document.getElementById('past_month_chart'));
        chart.draw(data, {
                    width: 450,         
                    height: 240, 
                    legend: 'none',                    
                    title: 'Past Month',
                    });      
      }      
      
      // --------------------------------------------------------------------    
      
      function drawPastYear()
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Unique Visitors');        
        data.addRows([
            ['This Month', <?php echo $this_month_hits;?>, <?php echo $this_month_unique;?>],
            <?php 
                // Rearrange the month array from this month downwards.
                $month = date('n');
                                
                for ($i = 0 ; $i < 12; $i++):
                    $s_month = strtolower($month_array[$month]);
                    if ($s_month != strtolower(date('F'))):
                        $month_hits = $s_month . '_hits';
                        $month_unique = $s_month . '_unique';
                        $month_year = $s_month . '_year';                        
            ?>
            ['<?php echo ucwords($s_month) . " " . $$month_year;?>', <?php echo $$month_hits;?>, <?php echo $$month_unique;?>],
            <?php 
                    endif;
                    $month--;
                    if ($month < 1) {
                        $month += 12;
                    }                    
                endfor;
            ?>
        ]);                                                      
                
        var chart = new google.visualization.ColumnChart(document.getElementById('past_year_chart'));
        chart.draw(data, {
                    height: 300, 
                    legend: 'none',                    
                    title: 'Past Year',
                    });      
      }        
      
      // --------------------------------------------------------------------    
      
      function drawPerPage()
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Top Pages');
        data.addColumn('number', 'Page');
        data.addRows(<?php echo count($top_pages);?>);
            <?php 
                $ctr = 0;
                foreach ($top_pages as $page):
            ?>
            data.setValue(<?php echo $ctr;?>, 0, '<?php echo $page->page;?>');
            data.setValue(<?php echo $ctr;?>, 1, <?php echo $page->count;?>);
            <?php
                    $ctr++;
                endforeach;
            ?>                                                              
                
        var chart = new google.visualization.PieChart(document.getElementById('per_page_chart'));
        chart.draw(data, {
                    height: 300, 
                    title: 'Pages',
                    });      
      }      
</script>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Basic Site Statistics</h1>
            <?php //$this->load->view('tabs', array('edit' => 'active'));?>
                <?php $this->load->view('admin/seo/tabs', array('basic' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                                    
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <table width="100%">
            <thead>
                <tr>
                    <th colspan="2">Visits</th>
                </tr>
            </thead>        
            <tbody>
                <tr>
                    <!-- Left -->                
                    <td colspan="2">
                        <div id="today_chart"></div>
                    </td>                
                </tr>
                <tr>
                    <td>
                        <div id="this_week_chart"></div>                    
                    </td>
                    <td>
                        <div id="past_month_chart"></div>                    
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div id="past_year_chart"></div></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="per_page_chart" style="height: 400px;"></div></td>
                </tr>                
            </tbody>
        </table>
    </div><!--end of content-text-->
</div><!--end of content-container-->
