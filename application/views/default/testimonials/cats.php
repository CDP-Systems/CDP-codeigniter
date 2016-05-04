<?php
  /**   
   * This is the file where we can control the layout of the testimonial categories page.
   * The $categories array can be used here to loop through all available categories.
   * As much as possible, hopefully, this should be the only page we edit when setting up different sites
   * and NOT the CONTROLLER.
   */
   $ci =& get_instance();
   
   if ($ci->get_current_action() != 'list_testimonials')
   {
   	$big_image = 'success-main.jpg';
   }
?>

<div class="testimonials-category-top-container">        
	<ul class="testi-top-nav">
		<?php foreach ($categories as $category):?>
			<li><?php echo anchor(current_url() . '/list_testimonials/' . $category->cat_id , $category->category_name);?></li>
		<?php endforeach;?>
	</ul>
</div>	

<div>
	<?php
	 $x = 1;
	 foreach ($categories as $category):
	   $style = '';
	   if ($x % 2 == 0):
	   	$style = 'style = "float: right;';
	   	$x = 1;
	   ;else:
	   	$style = 'style = "float: left;';
	  	$x = 2;	   	
	   endif;
	   $style .= 'margin-bottom: 20px;"';
	?>	
		<div width="220" <?php echo $style;?>>
			<img src="<?php echo site_url('uploads/testimonials/' . $category->list_image);?>" width="220" height="140" />
			<div class="testimonials-category-name"><?php echo anchor(current_url() . '/list_testimonials/' . $category->cat_id , $category->category_name);?></div>
		</div>
	<?php
	 endforeach;
	?>
</div>

<script type="text/javascript">
$(document).ready(function () {
	$('.testimonials-category-name').click(function() {
		window.location = $('a', this).attr('href');
	});
	
	$('.testi-top-nav li').click(function() {
		window.location = $('a', this).attr('href');
	});	
});	
</script>
