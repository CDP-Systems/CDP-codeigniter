<?php
	$ci =& get_instance();
	$ci->load->model('default/m_news', 'news');
	$latest_news = $ci->news->fetch_latest_news();
	$this->load->helper('cs_news');
	
	//get news page url
	$ci->load->model('default/m_page');
	$news_page_data = $ci->m_page->get_by_class('news', 1)->row();
	$news_url_key = ($news_page_data) ? $news_page_data->url_key : 'news';
?>

<div id="home-sidebar" class="left">
    <!-- Request an Appointment callout -->
    <div id="home-request-appointment"><a href="https://drchrono.com/for_patients/public_schedule/32433" target="_blank"></a></div>
    <!-- Request an Appointment callout ends -->
    
    <!-- general surgery callout -->
    <div id="home-gensurgery"><a href="<?php echo base_url();?>general-surgery"></a></div>
    <!-- general surgery callout ends -->

	<!-- new events -->
	<div id="news-and-events">
		<div id="top">News and Events</div>
			<div id="context"> <!-- start of context -->
			<?php if(count($latest_news->result())): ?>            	  
		        <marquee direction="up" scrolldelay="100" scrollamount="3" onMouseOver="stop()" onMouseOut="start()" height = "90%">              
				  <ul>
		            <?php foreach($latest_news->result() as $latest):?>
		            <li>
		            <h5><?php echo anchor( $news_url_key  . '/view/' . create_news_url(str_replace('!','',$latest->title)) . '/' . $latest->news_id, $latest->title, array("style"=>"color:#003470"));?></h5>                            
		            <p><?php echo $latest->introduction; ?></p>
		            <h5><a href="<?php echo $news_url_key .'/view/' . create_news_url(str_replace('!','',$latest->title)) . '/' . $latest->news_id ?>" class="read-more">Read more Teixeira news</a></p></h5>
		            </li>
					<?php endforeach;?>
				  </ul>
				</marquee>
	            	 
			<?php else: ?>
	        	There are no news at the moment
	        <?php endif; ?>		
			</div> <!-- end of context -->

		<div id="bottom"></div>
	</div>
	<!-- new events -->
</div>