<?php
// Get absolute link
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$link = $ci->tree->get_link();
?>

<style>
.border { border: 1px solid #dfe5d7; padding: 4px; }
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; width: 100%; background: #b3bb92; }
.form td { padding: 8px 0 8px 8px; }
.form td select { width: 205px; }
.form td.title { width: 120px; }
.form td.captcha-section label.error { margin-left: -165px; }
label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }
</style>

<?php if(isset($contact_msg_sent)): ?>
	<p class="green bold">Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.</p>
<?php endif; ?>

<br />

<div class="border">
<form action="<?php echo base_url(). index_page() . $link; ?>/send" method="POST" class="require-validation">
<table cellpadding="8" cellspacing="1" border="0" class="form">
  <tr>
    <td class="title">Name:</td>
    <td><input type='text' name='name' class="required" value='<?php echo set_value("name"); ?>' style="width: 200px;" />
    <?php echo form_error('name');?></td>
  </tr> 
  <tr>
    <td class="title">Phone Number:</td>
    <td><input type='text' name='number' class="required" value='<?php echo set_value("number"); ?>' style="width: 200px;" />
    <?php echo form_error('number');?></td>
  </tr>
  <tr>
    <td class="title">Email:</td>
    <td><input type='text' name='email' class="required" value='<?php echo set_value("email"); ?>' style="width: 200px;" />
    <?php echo form_error('email');?></td>
  </tr>
  <tr>
    <td class="title">What time of the day is best to contact you?</td>
    <td>
    <?php 
		$options = array(
			'' => '-Select-',
			 'Morning' => 'Morning',
			 'Afternoon' => 'Afternoon',
			 'Evening' => 'Evening'
		);
		echo form_dropdown('time_to_contact', $options ,set_value('time_to_contact')); 	
	?>
	<?php echo form_error('time_to_contact'); ?>
    </td>
  </tr>
  <tr>
    <td class="title">Message:</td>
    <td><textarea name='message' class="required" style="width: 200px;" rows="4"><?php echo set_value('message'); ?></textarea>
    <?php echo form_error('message');?></td>
  </tr>
  
  <!-- reCAPTCHA -->
  <?php if (isset($recaptcha) && $recaptcha != ''):?>
  <tr>
    <td colspan="2" align="center" class="captcha-section">
        <?php echo $recaptcha;?>
        <?php echo form_error('recaptcha_response_field');?>
        <br />
    </td>
  </tr>
  <?php endif;?>
  <tr>
    <td></td>
    <td><input type='submit' value='Send' onmouseover='this.style.cursor="pointer"'>&nbsp;<input type='reset' value='Reset' onmouseover='this.style.cursor="pointer"'></td>
  </tr>
</table>
</form>
</div>

<p>&nbsp;</p>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#dfe5d7" );</script>