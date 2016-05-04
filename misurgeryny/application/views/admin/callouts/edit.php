<!-- jQuery validation -->
<script type="text/javascript" src="<?php echo $js_dir;?>/jquery.validate.min.js"></script>
<!-- jQuery validation ends -->
<script type='text/javascript'>
    var $j = jQuery.noConflict(); 
    $j(document).ready(function () {
	    $j('form.require-validation').validate({
	    		errorPlacement: function(error, element) {
				error.appendTo( element.parent() );
			}	
	    });    
    });
</script>
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Callout Manager</h1>
            <?php $this->load->view('admin/callouts/tabs', array('edit' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                                    
        <div class="clear"></div>
    </div>
    <div class="content-text">
    
    <?php if(isset($image_error)){ echo $image_error; } ?>
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post" class="require-validation" enctype="multipart/form-data">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="200">Image:</td>
                <td>
                    <input type="file" name="image_url" <?php if (!isset($old_image)) echo 'class="required"';?>/>
                    <input type="hidden" name="field_image_url" value="image_url"/>
                    <?php if (isset($old_image)):?>
                    <div><img src="<?php echo site_url('uploads/callouts/' . $old_image);?>" /></div>
                    <?php endif;?>
                    <?php echo form_error('field_image_url');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Image Link:</td>
                <td>
                    <input type="text" class="required" name="image_link" value="<?php echo (isset($image_link)) ? $image_link : ''?>"/>
                    <?php 
                    	echo form_dropdown(
                    		'image_link_url', 
                    		page_url_dropdown(), 
                    		(isset($image_link) ? $image_link : ''),
                    		'class="cs_select_to_input" rel="image_link"'
                    		);
                    ?>
                    <?php echo form_error('image_link');?>
                </td>
              </tr>              
              <tr bgcolor="#F1F1F1">
                <td valign="top">Alt Text:</td>
                <td>
                    <input type="text" name="alt_text" class="required" value="<?php echo (isset($alt_text)) ? $alt_text : ''?>"/>
                    <?php echo form_error('alt_text');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Anchor Text:</td>
                <td>
                    <input type="text" name="anchor_text" class="required" value="<?php echo (isset($anchor_text)) ? $anchor_text : ''?>"/>
                    <?php echo form_error('anchor_text');?>                    
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Anchor Link:</td>
                <td>
                    <input type="text" name="anchor_link" class="required" value="<?php echo (isset($anchor_link)) ? $anchor_link : ''?>"/>
                    <?php echo form_dropdown(
                    			'anchor_link_url', 
                    			page_url_dropdown(),
                    			(isset($anchor_link) ? $anchor_link : ''),
                    			'class="cs_select_to_input" rel="anchor_link"'                    			
                    			);
                    ?>
                    <?php echo form_error('anchor_link');?>                    
                </td>
              </tr>     
              <tr bgcolor="#F1F1F1">
                <td valign="top">Open in:</td>
                <td>
                    <?php echo form_dropdown('target', target_dropdown());?>
                    <?php echo form_error('target');?>                    
                </td>
              </tr>     
              <tr bgcolor="#F1F1F1">
                <td valign="top">Opening tag:</td>
                <td>
                    <input type="text" name="opening_tag" class="required" value="<?php echo (isset($opening_tag)) ? $opening_tag : ''?>"/>
                    <?php echo form_error('closing_tag');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Closing tag:</td>
                <td>
                    <input type="text" name="closing_tag" class="required" value="<?php echo (isset($closing_tag)) ? $closing_tag: ''?>"/>
                    <?php echo form_error('closing_tag');?>
                </td>
              </tr>                                                
              <tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Display order:</td>
                <td>
                    <input type="text" name="display_order" class="required number" value="<?php echo (isset($display_order)) ? $display_order: ''?>"/>
                    <?php echo form_error('display_order');?>
                </td>
              </tr>                                                
              
			  
			  <tr bgcolor="#F1F1F1">
                <td valign="top">Disable from page(s):</td>
                <td>
                    <?php echo form_error('disabled_from_pages','<div class="red">', '</div>'); ?>
					<?php if(count($pages)): ?>
						
						<select name='disabled_from_pages[]' multiple size='10' class="required">
							<?php foreach($pages as $row): ?>
								<?php
									$selected = '';
									foreach($not_in_page as $id){
										if($row['id_page'] == $id){ 
											$selected = "selected='selected'";
										}
									}
								?>
								<option value='<?php echo $row['id_page']; ?>'  <?php echo $selected; ?> >
									<?php echo $row['page_title']; ?>
								</option>
							<?php endforeach; ?>
						</select>
						
					<?php else: ?>
						No page found.<a href='<?php echo base_url().index_page(); ?>admin/page/add'>Add page</a>
					<?php endif; ?>
                </td>
              </tr>  

			  
              <tr>              
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
              
            </table>
            
            </fieldset>
            <?php
                if (isset($videocast_id))
                {
                    echo form_hidden('videocast_id', $videocast_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->