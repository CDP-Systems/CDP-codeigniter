<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				SEO Manager
			</h1>
			<?php $this->load->view('admin/seo/tabs', array('advanced' => 'active')); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
	<iframe src="<?php echo $url;?>" width="900" height="1000"/>
    </div><!--end of content-text-->
</div><!--end of content-container-->