<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
            <h1>Insurance Manager</h1>
            <?php $this->load->view('admin/insurance/tabs', array('email_settings' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <p>            
            Feel free to make your edits but make sure you DO NOT edit words prefixed/suffixed with symbols (i.e. fields on the table or words with symbols) as these refer to programming details that will help remind your patients identify your practice.
        </p>
        <br />
        <p class="green bold"><?php echo $this->session->flashdata('message');?></p>
        <form action="" method="post" class="require-validation">
            <fieldset>
                <legend><b>Email Recipient</b></legend>
                <p>&nbsp;</p>
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140">Destination E-mail</td>
                    <td>
                    <input type="text" size="25" name="insurance_email_recipient" value="<?php echo $insurance_email_recipient;?>" class="required"/>
                    <?php echo form_error('insurance_email_recipient');?>
                    </td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </fieldset>
            
            <!-- Confirmation Email -->
            <fieldset>
            <table cellpadding="8" cellspacing="1">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Patient Confirmation Message</b><?php echo form_error('insurance_patient_confirmation_subject');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="insurance_patient_confirmation_subject" style="width: 200px;" value="<?php echo $insurance_patient_confirmation_subject;?>" class="required"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label><?php echo form_error('insurance_patient_confirmation');?></td>
                <td>
                <textarea name="insurance_patient_confirmation" id="insurance_patient_confirmation" class="required"><?php echo $insurance_patient_confirmation?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'insurance_patient_confirmation' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
                </td>
              </tr>
            </table>
            </fieldset>
            <!-- End confirmation email -->            
            <br />
            
            <!-- Admin email -->
            <br />
            <fieldset>
            <table cellpadding="8" cellspacing="1">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Admin Notification Message</b><?php echo form_error('insurance_admin_notification_subject');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="insurance_admin_notification_subject" style="width: 240px;" value="<?php echo $insurance_admin_notification_subject;?>" class="required"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label><?php echo form_error('insurance_admin_notification');?></td>
                <td>
                <textarea name="insurance_admin_notification" id="insurance_admin_notification" class="required"><?php echo $insurance_admin_notification?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'insurance_admin_notification' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
                </td>
              </tr>
            </table>
            </fieldset>
            
            <input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" />
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->