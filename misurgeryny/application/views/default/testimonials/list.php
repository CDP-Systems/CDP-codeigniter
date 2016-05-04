<script type="text/javascript">
	var $j = jQuery.noConflict(); 
	$j(document).ready(function(){
                $j("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
        });
</script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (isset($page_content))
{
   // echo $page_content;
}

if (!isset($testimonials))
{
    echo "No testimonials were found.";
}
else
{   echo "<!--h2>Patient Stories</h2-->";
    echo "<!--hr /-->";

    foreach ($testimonials as $testimonial):
?>
    <div style="margin-bottom:30px">
        <p><h3><?php echo $testimonial->first_name . ' ' . $testimonial->last_name;?></h3></p>
        
        <p><?php  echo $testimonial->body;?></p>

        <table>
            <tr>
                <!--<?php if (isset($testimonial->before_picture) && trim($testimonial->before_picture) != '' && $testimonial->before_picture != '0'): ?>
                <td>Before<br /><br /><img alt="before" src="<?php echo base_url().'uploads/testimonials/' . $testimonial->before_picture; ?>" /></td>
                <?php endif;?>

                <?php if (isset($testimonial->after_picture) && trim($testimonial->after_picture) != '' && $testimonial->after_picture != '0'): ?>
                <td>After<br /><br /><img alt="after" src="<?php echo base_url().'uploads/testimonials/' . $testimonial->after_picture; ?>" /></td>
                <?php endif;?> -->
                
                <?php if (isset($testimonial->before_picture) && trim($testimonial->before_picture) != '' && $testimonial->before_picture != '0'): ?>
                <td width="120">Before<br /><br /><a href="<?php echo base_url().'uploads/testimonials/' . $testimonial->before_picture; ?>" rel="prettyPhoto" title=""><img alt="" width="100" height="100" src="<?php echo base_url().'uploads/testimonials/' . $testimonial->before_picture; ?>" /></a></td>
                <?php endif;?>

                <?php if (isset($testimonial->after_picture) && trim($testimonial->after_picture) != '' && $testimonial->after_picture != '0'): ?>
                <td>After<br /><br /><a href="<?php echo base_url().'uploads/testimonials/' . $testimonial->after_picture; ?>" rel="prettyPhoto" title=""><img alt="" width="100" height="100" src="<?php echo base_url().'uploads/testimonials/' . $testimonial->after_picture; ?>" /></a></td>
                <?php endif;?>
            </tr>
        </table>
    </div>
    <hr />
<?php
    endforeach;

    echo $this->pagination->create_links();
}

