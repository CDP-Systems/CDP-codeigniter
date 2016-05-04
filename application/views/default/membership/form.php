<?php
// Get complete page URI
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$page_uri = $ci->tree->get_link();
?>

<div class="border">
<script type='text/javascript'>
function cancelResgistration(){
	var ans = confirm("Are you sure?");
	if(ans){
		window.location="<?php echo base_url(); ?>";
	}
}
</script>
<style>
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; width: 100%; }
.form td { padding: 8px; }
label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }
</style>
<?php echo $this->session->flashdata('message'); ?>

<form action="<?php echo base_url().index_page(). $page_uri; ?>" method="post"  class="require-validation" style="border: 1px solid #EEEEEE;">

	<table cellpadding="8" cellspacing="1" border="0" width='100%'  class="form">
	<tr bgcolor="#F1F1F1">
		<td width="120">First Name:</td>
		<td>
			<?php echo form_error('fname','<div class="red">','</div>'); ?>
			<input type="text" name="fname" class="long-text" value="<?php echo set_value('fname'); ?>" style="width: 320px;" />
		</td>
	</tr>
    <tr>
		<td width="120">Last Name:</td>
		<td>
			<?php echo form_error('lname','<div class="red">','</div>'); ?>
			<input type="text" name="lname" class="long-text" value="<?php echo set_value('lname'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr bgcolor="#F1F1F1">
		<td width="120">Credentials/Title:</td>
		<td>
			<?php echo form_error('credentials','<div class="red">','</div>'); ?>
			<input type="text" name="credentials" class="long-text" value="<?php echo set_value('credentials'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr>
		<td width="120">Street Address:</td>
		<td>
			<?php echo form_error('street','<div class="red">','</div>'); ?>
			<input type="text" name="street" class="long-text" value="<?php echo set_value('street'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr bgcolor="#F1F1F1" >
		<td width="120">Address Line 2:</td>
		<td>
			<?php echo form_error('address','<div class="red">','</div>'); ?>
			<input type="text" name="address" class="long-text" value="<?php echo set_value('address'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr>
		<td width="120">City:</td>
		<td>
			<?php echo form_error('city','<div class="red">','</div>'); ?>
			<input type="text" name="city" class="long-text" value="<?php echo set_value('city'); ?>" style="width: 320px;" />
		</td>
	</tr>
		<tr bgcolor="#F1F1F1">
			<td width="120">State:</td>
			<td>
				<?php echo form_error('state','<div class="red">','</div>'); ?>
				<?php echo form_dropdown('state', $states, set_value('state')); ?>
			</td>
		</tr>
	<tr>
		<td width="120">Zip:</td>
		<td>
			<?php echo form_error('zip','<div class="red">','</div>'); ?>
			<input type="text" name="zip" class="long-text" value="<?php echo set_value('zip'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr bgcolor="#F1F1F1">
		<td width="120">Phone:</td>
		<td>
			<?php echo form_error('phone','<div class="red">','</div>'); ?>
			<input type="text" name="phone" class="long-text" value="<?php echo set_value('phone'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr>
		<td width="120">Email:</td>
		<td>
			<?php echo form_error('email','<div class="red">','</div>'); ?>
			<input type="text" name="email" class="long-text" value="<?php echo set_value('email'); ?>" style="width: 320px;" />
		</td>
	</tr>
	<tr bgcolor="#F1F1F1">
		<td width="120">Specialty:</td>
		<td valign="top" style="width: 300px">
			<?php echo form_error('specialty','<div class="red">','</div>'); ?>
			<table>
			<tr>
				<td>
				<input class='specialty' type="radio" name="specialty" value="Anesthesia" <?php echo (set_value('specialty') == 'Anesthesia') ? 'checked="checked"' : ''; ?> id="aff1" />Anesthesia<br />
				<input class='specialty' type="radio" name="specialty" value="Bariatric Physician" <?php echo (set_value('specialty') == 'Bariatric Physician') ? 'checked="checked"' : '';  ?> id="aff2" />Bariatric Physician<br />
				<input class='specialty' type="radio" name="specialty" value="Fellow" <?php echo (set_value('specialty') == 'Fellow') ? 'checked="checked"' : '';  ?> id="aff3" />Fellow<br />
				<input class='specialty' type="radio" name="specialty" value="Hospital Executive" <?php echo (set_value('specialty') == 'Hospital Executive') ? 'checked="checked"' : '';  ?> id="aff4" />Hospital Executive<br />
				<input class='specialty' type="radio" name="specialty" value="Nursing" <?php echo (set_value('specialty') == 'Nursing')? 'checked="checked"' : '';  ?> id="aff5" />Nursing<br />
				<input class='specialty' type="radio" name="specialty" value="Nutrition" <?php echo (set_value('specialty') == 'Nutrition') ? 'checked="checked"' : ''; ?> id="aff6" />Nutrition<br />
				<input class='specialty' type="radio" name="specialty" value="Physician Assistant – Family Nurse Practitioner" <?php echo (set_value('specialty') == 'Physician Assistant – Family Nurse Practitioner') ? 'checked="checked"' : '';  ?> id="aff7" />Physician Assistant &ndash; Family Nurse Practitioner<br />
				</td>
				<td style="width: 200px;">
				<input class='specialty' type="radio" name="specialty" value="Program Coordinator" <?php echo (set_value('specialty') == 'Program Coordinator')? 'checked="checked"' : '';  ?> id="aff8" />Program Coordinator<br />
				<input class='specialty' type="radio" name="specialty" value="Program Director" <?php echo (set_value('specialty') == 'Program Director') ? 'checked="checked"' : '';  ?> id="aff9" />Program Director<br />
				<input class='specialty' type="radio" name="specialty" value="Student" <?php echo (set_value('specialty') == 'Student') ? 'checked="checked"' : '';  ?> id="aff14" />Student<br />
				<input class='specialty' type="radio" name="specialty" value="Psychology" <?php echo (set_value('specialty') == 'Psychology') ? 'checked="checked"' : ''; ?> id="aff10" />Psychology<br />
				<input class='specialty' type="radio" name="specialty" value="Radiology" <?php echo (set_value('specialty') == 'Radiology') ? 'checked="checked"' : '';  ?> id="aff11" />Radiology<br />
				<input class='specialty' type="radio" name="specialty" value="Resident" <?php echo (set_value('specialty') == 'Resident') ? 'checked="checked"' : ''; ?> id="aff12" />Resident<br />
				<input class='specialty' type="radio" name="specialty" value="Surgery" <?php echo (set_value('specialty') == 'Surgery') ? 'checked="checked"' : '';  ?> id="aff13" />Surgery<br />
				</td>
				</tr>
				<tr>
					<td>
						Other: Please specify <input type="text" name="specialty_other" value="<?php echo set_value('specialty_other'); ?>" id="specialty_other" />
					</td>
				</tr>
				</table>
					<script type='text/javascript'>
					/*Remove Other specialty field if the user has selected from radio options*/
							 $(document).ready(function(){
							   $('.specialty').click(function(event){
								 $('#specialty_other').val('');
							   });
							   
							   $('#specialty_other').click(function(event){
								 $('.specialty').attr('checked', false);
							   });
							 });
					</script>
				</td>
			</tr>
			<!-- reCAPTCHA -->
			 <?php if (isset($recaptcha) && $recaptcha != ''):?>
			 
			<tr>
				<td></td>
				<td>
					<?php echo $recaptcha;?>
					<?php echo form_error('recaptcha_response_field');?>
				</td>
			</tr>
			
			<?php endif;?>
	</table>
	<p>&nbsp;</p>             
	<table cellpadding="8" cellspacing="1" width="50px" style="margin-bottom: 20px; margin-left: 20px;">
		<tr>
			<td><input type="submit" name="membershipFormBtn" class="btn-bg button" value="Join Now!" style="margin-right: 10px;" /></td>
			<td><input type="button" name="membershipFormCancel" class="btn-bg button" value="Cancel" onclick='cancelResgistration();' /></td>
		</tr>
	</table> 

</form>
</div>