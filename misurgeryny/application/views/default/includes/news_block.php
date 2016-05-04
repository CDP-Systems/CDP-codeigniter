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

                	<!-- general surgery callout -->

                    <div id="home-gensurgery"><a href="<?php echo base_url();?>general-surgery"></a></div>

                    <!-- general surgery callout ends -->

                    

	<!-- new events -->

	<div id="news-and-events">

	<div id="top">News and Events</div>

		<div id="context">

		      <?php if(count($latest_news->result())): ?>
                    <div id="scrolling">
                    	<!-- #marqueecontainer -->
                        <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                          <ul id="vmarquee">
						  <?php foreach($latest_news->result() as $latest):?>
                            <li>
                            <h5><?php echo anchor( $news_url_key . '/view/' . create_news_url(str_replace('!','',$latest->title)) . '/' . $latest->news_id, $latest->title, array("style"=>"color:#003470"));?></h5>
                            <p><?php echo $latest->introduction; ?></p>
                            <h5><a href="<?php echo $news_url_key . '/view/' . create_news_url(str_replace('!','',$latest->title)) . '/' . $latest->news_id ?>" class="read-more">Read more Fresno Bariatric news</a></h5>
                            </li>
						  <?php endforeach;?>
                          </ul> 
                        </div>
                        <!-- #marqueecontainer ends --> 
                    </div>       
			<?php else: ?>
			<p style="margin: auto; lwidth: 150px;">There are no news at the moment</p>
			<?php endif; ?>	


		</div>

	<div id="bottom"></div>

	</div>                    

	<!-- new events -->

                    

</div>