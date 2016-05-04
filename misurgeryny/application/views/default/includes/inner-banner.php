<div id="inner-banner">
	<?php if($this->uri->segment(1) == 'patient-support'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-patient-support.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'patient-resources'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-patient-resources.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'meet-dr-teixeira'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-meet-dr-texeira.jpg" border="0" />
	<?php } else if($this->uri->segment(1) == 'contact-us'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-contact-us.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'diabetes-surgery'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-diabetes-surgery.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'getting-started'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-getting-started.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'bariatric-surgery'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-bariatric-surgery.jpg" border="0" />
	<?php }else if($this->uri->segment(1) == 'general-surgery'){ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-meet-dr-texeira.jpg" border="0" />
	<?php }else{ ?>
		<img src="<?php echo $image_dir;?>/default/banners/banner-meet-dr-texeira.jpg" border="0" />
	<?php } ?>
</div>