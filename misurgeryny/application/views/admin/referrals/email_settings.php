<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        <h1>
        	Referrals Manager
        </h1>
        <?php $this->load->view('admin/referrals/tabs', array('email_settings' => 'active'));?>
	<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <p></p>
        <br />
        <p class="green bold"><?php echo $this->session->flashdata('message');?></p>
        <form action="" method="post" >
            <fieldset>
                <legend><b>Email Recipient</b></legend>
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140">Destination E-mail</td>
                    <td><input type="text" style="width: 200px;" name="referrals_email_recipient" value="<?php echo $referrals_email_recipient;?>"/>
                    <?php echo form_error('referrals_email_recipient', '<div class="red">','</div>'); ?></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </fieldset>
            
            <!-- Referral email -->
            <br />
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td colspan="2"><b style="padding: 6px 0;">Referral Message Subject</b><?php echo form_error('referrals_patient_email_subject');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td><input type="text" name="referrals_patient_email_subject" style="width: 200px;" value="<?php echo $referrals_patient_email_subject;?>"/></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label><?php echo form_error('referrals_patient_email');?></td>
                <td>
                <textarea name="referrals_patient_email" id="referrals_patient_email" ><?php echo $referrals_patient_email?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'referrals_patient_email' );
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
                <td colspan="2"><b style="padding: 6px 0;">Admin Notification Message</b></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Subject:</label></td>
                <td>
                    <input type="text" name="referrals_admin_email_subject" style="width: 200px;" value="<?php echo $referrals_admin_email_subject;?>"/>
                    <?php echo form_error('referrals_admin_email_subject');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top"><label>Message body:</label></td>
                <td>
                    <?php echo form_error('referrals_admin_email');?>
                    <textarea name="referrals_admin_email" id="referrals_admin_email" ><?php echo $referrals_admin_email?></textarea>
                    <script type='text/javascript'>
                        var editor = CKEDITOR.replace( 'referrals_admin_email' );
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
