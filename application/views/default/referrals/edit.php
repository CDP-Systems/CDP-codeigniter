<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Display CMS content here. -->
<?php echo $page_content;?>
<style>
.border { border: 1px solid #cedbc7; padding: 4px; margin-bottom: 20px; }
.form { margin: 0; width: 100%; background: white; }
.form td { padding: 8px; }
.form tr.shade td { background: #f3f6f1; }
</style>

Fields with an asterisk (<span class="red">*</span>) are required.
<form action="" method="POST" class="require-validation">

<div class="border">
    <div class="green bold"><?php echo $this->session->flashdata('message');?></div>    
    <table cellpadding="0" cellspacing="1" border="0" class="form">
      <tr class="shade">
        <td width="140"><label for="patient_name">Your name<span class="red">*</span></label></td>
        <td>
            <input type="text" name="patient_name" class="required" value="<?php echo set_value('patient_name');?>" style="width: 240px;" />
            <?php echo form_error('patient_name');?>
        </td>
      </tr>    
      <tr>
        <td><label for="patient_email">Your email<span class="red">*</span></label></td>
        <td>
            <input type="text" name="patient_email" class="required email" value="<?php echo set_value('patient_email');?>" />
            <?php echo form_error('patient_email');?>
        </td>
      </tr>
      <tr class="shade">
        <td valign="top"><label for="patient_address">Your address</label></td>
        <td>
            <textarea name="patient_address" style="width: 240px;"><?php echo set_value('patient_address');?></textarea>
            <?php echo form_error('patient_address');?>
        </td>
      </tr>
      <tr>
        <td><label for="patient_phone">Your phone number</label></td>
        <td>
            <input type="text" name="patient_phone[]" class="require_numeric" value="<?php echo set_value('patient_phone[]');?>" class="phone1 require_numeric" size="3" maxlength="3"/>-
            <input type="text" name="patient_phone[]" class="require_numeric" value="<?php echo set_value('patient_phone[]');?>" class="phone1 require_numeric" size="3" maxlength="3"/>-
            <input type="text" name="patient_phone[]" class="require_numeric" value="<?php echo set_value('patient_phone[]');?>" class="phone2 require_numeric" size="4" maxlength="4"/>
            <?php echo form_error('patient_phone[]');?>
        </td>
      </tr>
    </table>
</div>

<h3 style="margin-bottom: 10px;">Your Friend:</h3>
<div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="form">
      <tr class="shade">
        <td width="140"><label for="referral_name">Name<span class="red">*</span></label></td>
        <td>
            <input type="text" name="referral_name" class="required" value="<?php echo set_value('referral_name');?>" style="width: 240px;" />
            <?php echo form_error('referral_name');?>
        </td>
      </tr>    
      <tr>
        <td><label for="referral_relationship">Relationship</label></td>
        <td>
            <input type="text" name="referral_relationship" value="<?php echo set_value('referral_relationship');?>" style="width: 240px;" />
            <?php echo form_error('referral_relationship');?>
        </td>
      </tr>
      <tr class="shade">
        <td valign="top"><label for="referral_email">Email<span class="red">*</span></label></td>
        <td>
            <input type="text" name="referral_email" class="required email" value="<?php echo set_value('referral_email');?>" />
            <?php echo form_error('referral_email');?>
        </td>
      </tr>    
      <tr>
        <td valign="top"><label for="referral_address">Address</label></td>
        <td>
            <textarea name="referral_address" style="width: 240px;"><?php echo set_value('referral_address');?></textarea>
            <?php echo form_error('referral_address');?>
        </td>
      </tr>
      <tr class="shade">
        <td valign="top"><label for="referral_phone">Phone number</label></td>
        <td>
            <input type="text" name="referral_phone[]" class="require_numeric" value="<?php echo set_value('referral_phone[]');?>" class="phone1 require_numeric" size="3" maxlength="3"/>-
            <input type="text" name="referral_phone[]" class="require_numeric" value="<?php echo set_value('referral_phone[]');?>" class="phone1 require_numeric" size="3" maxlength="3"/>-
            <input type="text" name="referral_phone[]" class="require_numeric" value="<?php echo set_value('referral_phone[]');?>" class="phone2 require_numeric" size="4" maxlength="4"/>
            <?php echo form_error('referral_phone[]');?>
        </td>
      </tr>    
      <tr>
        <td></td>
        <td><input type="submit" name="submit" value="Submit" /></td>
      </tr>
    </table>
</div>

</form>
<a href="" id="referral-message-preview">Click here to preview your message</a>
<?php 
$ci =& get_instance();
echo "<div id='referral-message'>" . html_entity_decode($ci->get_setting('referrals_patient_email')) . "</div>";
