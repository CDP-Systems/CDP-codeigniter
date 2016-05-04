<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
            <h1>Testimonials Manager<!--[Email Settings]--></h1>
            <?php $this->load->view('admin/testimonials/tabs', array('set_email' => 'active'));?>
		    <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>        
        </div>		    
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <p>These are the confirmation emails related to the user testimonial submission process. The Approval Message is the email automatically sent when you approve a patient's testimonial. Feel free to make your edits but make sure you DO NOT edit words prefixed/suffixed with symbols (i.e. fields on the table or words with symbols) as these refer to programming details that will help remind your patients identify your practice.</p>
        <br />
        <p class="green bold"><?php echo $this->session->flashdata('message');?></p>
        <form action="" method="post" >
            <fieldset>
                <legend><b>Email Recipient</b></legend>
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140">Destination E-mail</td>
                    <td><input type="text" style="width: 200px;" name="testimonials_email_recipient" value="<?php echo $testimonials_email_recipient;?>"/></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </fieldset>
            
            <!-- Confirmation Email -->
            <fieldset>                
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Patient Confirmation Message</b><?php echo form_error('testimonials_patient_confirmation');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="testimonials_patient_confirmation_subject" style="width: 200px;" value="<?php echo $testimonials_patient_confirmation_subject;?>"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label></td>
                <td>
                <textarea name="testimonials_patient_confirmation" id="testimonials_patient_confirmation" ><?php echo $testimonials_patient_confirmation?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'testimonials_patient_confirmation' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
                </td>
              </tr>
            </table>
            </fieldset>
            <!-- End confirmation email -->
            
            <!-- Approval email -->
            <br />
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Patient Approval Message</b><?php echo form_error('testimonials_patient_confirmation');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="testimonials_patient_approval_subject" style="width: 200px;" value="<?php echo $testimonials_patient_approval_subject;?>"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label></td>
                <td>
                <textarea name="testimonials_patient_approval" id="testimonials_patient_approval" ><?php echo $testimonials_patient_approval?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'testimonials_patient_approval' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
                </td>
              </tr>
            </table>
            </fieldset>
            <!-- Admin email -->
            
            <br />
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Admin Notification Message</b><?php echo form_error('testimonials_admin_notification');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="testimonials_admin_notification_subject" style="width: 200px;" value="<?php echo $testimonials_admin_notification_subject;?>"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label></td>
                <td>
                <textarea name="testimonials_admin_notification" id="testimonials_admin_notification" ><?php echo $testimonials_admin_notification?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'testimonials_admin_notification' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
                </td>
              </tr>
            </table>                
            </fieldset>
            <input type='submit' name="submit" value='Save' style="margin-top:20px;" />
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
