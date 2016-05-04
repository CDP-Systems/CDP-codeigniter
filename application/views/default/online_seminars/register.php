<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Show messages here (succes/failure/whatever).
if ($this->session->flashdata('message'))
{
    echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";
}

echo "<p>&nbsp;</p>";
?>
<script type="text/javascript" src="<?php echo site_url('js/seminars.js');?>"></script>
<script>
 $(document).ready(function () {

 	$('.inputClass input:text').bind("keydown", function(e) {
	   if (e.which == 9)
	   {
	     e.preventDefault(); //to skip default behavior of the tab key
	     var nextIndex = $('input:text').index(this) + 1;
	     $('input:text')[nextIndex].focus();
	   }
	});
	
	
	
	$("#countryId").change(function () {
		  if($(this).val() != 1){
		  	$("#stateId").val("");
			$("#stateId").removeAttr("class");
			$("#stateId").attr("disabled", "disabled");
		  }else{
		  	$("#stateId").removeAttr("disabled");
		  }
	})
	

 });

</script>
<style>
.border { border: 1px solid #c3decb; padding: 4px; }
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; width: 100%; background: #b3bb92; }
.form td { padding: 8px 0 8px 8px; }
.form td.title { width: 120px; }
.form td.captcha-section label.error { margin-left: -165px; }
label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }
</style>

<p><i>Fields with an asterisk (<span style="color: red">*</span>) are required.</i></p>

<!-- .border -->
<div class="border">
<form id="register-form" action="" method="POST" class='require-validation' style="background: #fff; margin-bottom: 20px;">
<table cellpadding="8" cellspacing="1" border="0" class="form">
  <tr>
    <td colspan="2"><h5>Seminar Details</h5></td>
  </tr>
  <tr>
    <td class="title">Title:</td>
    <td><span><?php echo $seminar_title;?></span></td>
	<input type='hidden' name='seminar_id' value='<?php echo $seminar_id ?>' /></tr>
  </tr>
  
  <!-- PATIENT INFORMATION BOX -->
  <tr>
    <td colspan="2"><h5>Patient Information</h5></td>
  </tr>
  <tr>
    <td class="title">Date of Birth:<span class="red">*</span></td>
    <td><?php echo form_dropdown('month', month_dropdown()) . form_dropdown('date', date_dropdown()) . form_dropdown('year', year_dropdown(), set_value('year'),'class="required"');?>
	<?php echo form_error('year');?></td>
  </tr>
  <tr>
    <td class="title">Height<span class="red">*</span></td>
    <td><input type="text" name="feet" class="numeric textfield" size="5" value="<?php echo $feet;?>"/><span style="margin: 0 20px 0 10px;">Feet</span>
    <input type="text" name="inches" class="require_numeric textfield required" size="5" value="<?php echo $inches;?>"/><span style="margin: 0 10px 0 10px;">Inches</span>
    <?php echo (form_error('feet')) ? form_error('feet') : form_error('inches');?></td>
  </tr>
  <tr>
    <td class="title">Weight<span class="red">*</span></td>
    <td><input type="text" name="weight" class="require_numeric required textfield" size="5" value="<?php echo $weight;?>"/><span style="margin: 0 20px 0 10px;">Pounds
    <?php echo form_error('weight');?></td>
  </tr>
  <tr>
    <td class="title">First Name:<span class="red">*</span></td>
    <td><input type="text" class='required textfield' name="first_name" value="<?php echo $first_name;?>"/><?php echo form_error('first_name');?></td>
  </tr>
  <tr>
    <td class="title">Last Name:<span class="red">*</span></td>
    <td><input type="text" class='required textfield' name="last_name" value="<?php echo $last_name;?>"/><?php echo form_error('last_name');?></td>
  </tr>
  <tr>
    <td class="title">Gender<span class="red">*</span></td>
    <td>
    <?php echo form_dropdown('gender', gender_dropdown(), set_value('gender'), 'class="required"');?>
	<?php echo form_error('gender');?>
    </td>
  </tr>
  
  <!-- CONTACT INFORMATION BOX -->
  <tr>
    <td colspan="2"><h5>Contact Information</h5></td>
  </tr>
  <tr>
    <td class="title">Address 1:<span class="red">*</span></td>
    <td>
    <input type="text" name="address1" value="<?php echo $address1;?>" class='required textfield' />
	<?php echo form_error('address1');?>
    </td>
  </tr>
  <tr>
    <td class="title">Address 2:</td>
    <td><input type="text" name="address2" value="<?php echo $address2;?>" class='textfield'/><?php echo form_error('address2');?></td>
  </tr>
  <tr>
    <td class="title">City:<span class="red">*</span></td>
    <td><input class='required textfield' type="text" name="city" value="<?php echo $city;?>" /><?php echo form_error('city');?></td>
  </tr>
  <tr>
    <td class="title">State:<span class="red">*</span></td>
    <td><?php echo form_dropdown('state', state_dropdown(), set_value('state'), 'class="required" id="stateId"');?><?php echo form_error('state');?></td>
  </tr>
  <tr>
    <td class="title">Zip:<span class="red">*</span></td>
    <td><input class='required textfield' type="text" name="zip" value="<?php echo $zip;?>"/><?php echo form_error('zip');?></td>
  </tr>
  <tr>
    <td class="title">Country:</td>
    <td><?php echo form_dropdown('country_id', country_dropdown(), 1, 'id="countryId"');?><?php echo form_error('country');?></td>
  </tr>
  <tr>
    <td class="title">Primary Phone:<span class="red">*</span></td>
    <td>
    <input maxlength='3' type="text" class="phone1 require_numeric textfield" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="3"/>-
    <input maxlength='3'type="text" class="phone1 require_numeric textfield" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="3"/>-
    <input maxlength='4' type="text" class="phone2 require_numeric textfield required" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="4"/>
    <?php echo form_error('phone1[]');?>
    </td>
  </tr>
  <tr>
    <td class="title">Alternate Phone:</td>
    <td>
    <input maxlength='3' type="text" class="phone1 require_numeric textfield" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="3"/>-
    <input maxlength='3' type="text" class="phone1 require_numeric textfield" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="3"/>-
    <input maxlength='4' type="text" class="phone2 require_numeric textfield" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="4"/>
    <?php echo form_error('phone2[]');?>
    </td>
  </tr>
  <tr>
    <td class="title">E-mail Address:<span class="red">*</span></td>
    <td><input class='required textfield' type="text" name="email" value="<?php echo $email;?>"/><?php echo form_error('email');?></td>
  </tr>
  
  <!-- OTHERS BOX -->
  <tr>
    <td colspan="2"><h5>Others</h5></td>
  </tr>
  <tr>
    <td class="title">How did you hear about us?<span class="red">*</span></td>
    <td>
    <?php echo form_dropdown('how_heard', how_heard_dropdown(0, 4), set_value('how_heard') , 'class="required"');?>
    <?php echo form_error('how_heard');?>
    </td>
  </tr>
  <tr>
    <td class="title">Insurance</td>
    <td><input type="text" name="insurance" value="<?php echo $insurance;?>" class="textfield"/><?php echo form_error('insurance');?></td>
  </tr>
  
  <!-- reCAPTCHA -->
  <?php if (isset($recaptcha) && $recaptcha != ''):?>
  <tr>
    <td class="title"></td>
    <td>    
    <?php echo $recaptcha;?>
	<?php echo form_error('recaptcha_response_field');?>
    </td>
  </tr>
  <?php endif;?>
  
  <tr>
    <td class="title"></td>
    <td>
    <input type="submit" name="submit" value="View Online Seminar" onmouseover='this.style.cursor="pointer"' />
    <input type="reset" value="Clear" onmouseover='this.style.cursor="pointer"' />
    </td>
  </tr>
</table>
</form>
</div>
<!-- .border ends -->

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#dfe5d7" );</script>