<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
            <h1>Survey Manager [Email Settings]</h1>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <?php $this->load->view('admin/surveys/tabs', array('set_email' => 'active'));?>
            <div class="clear"></div>
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
                    <input type="text" size="25" name="surveys_email_recipient" value="<?php echo $surveys_email_recipient;?>" class="required"/>
                    <?php echo form_error('surveys_email_recipient');?>
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
                <td colspan="2"><b style="padding: 6px 0;">Patient Confirmation Message</b><?php echo form_error('surveys_email_patient_subject');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="surveys_email_patient_subject" style="width: 200px;" value="<?php echo $surveys_email_patient_subject;?>" class="required"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label><?php echo form_error('surveys_email_patient');?></td>
                <td>
                <textarea name="surveys_email_patient" id="surveys_email_patient" class="required"><?php echo $surveys_email_patient?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'surveys_email_patient' );
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
                <td colspan="2"><b style="padding: 6px 0;">Admin Notification Message</b><?php echo form_error('surveys_email_admin_subject');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="surveys_email_admin_subject" style="width: 240px;" value="<?php echo $surveys_email_admin_subject;?>" class="required"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label><?php echo form_error('surveys_email_admin');?></td>
                <td>
                <textarea name="surveys_email_admin" id="surveys_email_admin" class="required"><?php echo $surveys_email_admin?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'surveys_email_admin' );
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
