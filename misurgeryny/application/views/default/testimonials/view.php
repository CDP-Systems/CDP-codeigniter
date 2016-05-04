<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div style="background: url('<?php echo site_url('uploads/testimonials/' . $cat_image);?>'); height: 240px; width: 470px; margin-bottom: 20px;">        
	<ul class="testi-top-nav">
		<?php foreach ($categories as $category):
		      // Active state.
		      $active = '';
		      if ($category->cat_id == $cat_id)
		      {
		        $active = 'class="active"';
		      }
		?>
			<li><?php echo anchor('meet-our-patients/list_testimonials/' . $category->cat_id , $category->category_name, $active);?></li>
		<?php endforeach;?>
	</ul>
</div>

<h1><?php echo $first_name;?> Story</h1>
<p>&nbsp;</p>
        
<table cellpadding="1" cellspacing="0" border="0" align="center" class="person-table">
	<tr>
	<?php if (isset($after_picture)):?>
            <td>
            	    <div>
            	    	<img src="<?php echo site_url('uploads/testimonials/' . $after_picture);?>" width="170" height="280" />
            	    </div>
	            <div class="testi-photo">After</div>
            </td>
       <?php endif;?>
       <?php if (isset($before_picture)):?>
            <td>
            	<div>
            	  	<img src="<?php echo site_url('uploads/testimonials/' . $before_picture);?>" width="170" height="280" />
		</div>			           	
        	    <div class="testi-photo">Before</div>
            </td>
       <?php endif;?>
          </tr>
</table>

<p><?php echo $testimonial_body;?></p>

<div class="be-a-success-story">
	<?php echo anchor('meet-our-patients/submit-your-story', '<noscript>Be a success story!</noscript>');?>
</div>
    
<br class="clear" />
<div class="testi-back-bg">
	<?php if (isset($previous_id)):?>
	<a href="<?php echo site_url('meet-our-patients/view/' . $previous_id);?>">Previous Story</a> | 
	<?php endif;?>
	<a href="<?php echo site_url('meet-our-patients');?>">Back to Index</a> | 
	<a href="<?php echo site_url('meet-our-patients/list_testimonials/' . $cat_id);?>">Back to <?php echo $cat_name;?></a>
	<?php if (isset($next_id)):?>
	| <a href="<?php echo site_url('meet-our-patients/view/' . $next_id);?>">Next Story</a>
	<?php endif;?>	
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$('.be-a-success-story ').click(function (){
		window.location = $('a', this).attr('href');
	});
	
	$('.testi-top-nav li').click(function() {
		window.location = $('a', this).attr('href');
	});		
});
</script>
