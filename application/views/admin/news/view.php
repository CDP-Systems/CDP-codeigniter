<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
        <h1>
        	News Manager
        </h1>
            <?php $this->load->view('admin/news/tabs', array('list' => 'active'));?>
            <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
    	<ul>
		  <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/news' >Back</a></li>
		</ul>
        
		<div class="clear" style="padding-bottom: 20px;"></div>
        
        <h1><?php echo $news_title;?></h1>

        <div>
            <?php echo $news_body;?>
        </div>
    </div>
</div>