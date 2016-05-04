<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Testimonials Manager</h1>
            <?php $this->load->view('admin/testimonials/tabs', array('add' => 'active'));?>
		    <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>        
        </div>		    
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <?php echo $this->session->flashdata('message');?>
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <table cellpadding="8" cellspacing="1" width="100%">
                  <tr bgcolor="#F1F1F1">
                    <td colspan="2"><b>Testimonial Informations</b></td>                   
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td width="160">First Name:</td>
                    <td><input type='text' name='first_name' value="<?php echo $first_name;?>" /><?php echo form_error('first_name');?></td>                    
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td>Last Name:</td>
                    <td><input type='text' name='last_name' value="<?php echo $last_name;?>" /><?php echo form_error('last_name');?></td>                    
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td>Email:</td>
                    <td><input type='text' name='email' value="<?php echo $email;?>" /><?php echo form_error('email');?></td>
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td>Status:</td>
                    <td>
                    <select name='status'>
                        <option value='1' <?php echo $status['pending'];?>>Pending</option>
                        <option value='2' <?php echo $status['approved'];?>>Approved</option>
                    </select>
                    </td>
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td>Published:</td>
                    <td>
                    <select name='publish'>
                        <option value='0' <?php echo $publish[1];?>>False</option>
                        <option value='1' <?php echo $publish[0];?>>True</option>
                    </select>
                    </td>
                  </tr>
                  <tr bgcolor="#F1F1F1">
                    <td valign="top">Testimonial message:<?php echo form_error('body');?></td>
                    <td>
                    <textarea name="body" id="page_content" ><?php echo $body; ?></textarea>
					<script type='text/javascript'>
                        var editor = CKEDITOR.replace( 'page_content' );
                        //CKEDITOR.config.skin = 'v2';
                        CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                    </script>
                    </td>
                  </tr>
                </table>
            </fieldset>
            <P>&nbsp;</p>
            
            <!-- Before and after -->
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="text-transform: uppercase;">Before and after Photos</b></td>                    
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="140"><label for="before_picture">Before Photo</label>:</td>
                <td><input type="file" name="before_picture" /><?php echo form_error('field_before_picture');?></td>                    
              </tr>
              <tr bgcolor="#F1F1F1">
                <td><label for="after_picture">After Photo</label>:</td>
                <td><input type="file" name="after_picture" /><?php echo form_error('field_after_picture');?></td>                    
              </tr>
            </table>
           
                <input type="hidden" name="field_before_picture" value="before_picture" />
                <input type="hidden" name="field_after_picture" value="after_picture" />
            
            <?php
                if (isset($testi_id))
                {
                    echo form_hidden('testi_id', $testi_id);
                }
            ?>
            <input type='submit' name="submit" value='Save' class="green-btn" style="margin-top:20px;" />
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
