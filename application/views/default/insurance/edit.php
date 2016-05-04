<style>
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; }
.required { clear: both; float: none; }
label.error { font-weight: normal; font-style: italic; font-size: 11px; padding: 4px 0 0 0; display: block; position: static; }
</style>

<?php if($this->session->flashdata('message')): ?>
	<div class="green bold"><?php echo $this->session->flashdata('message');?></div>
<?php endif; ?>

<div class="border">
    <form action="" method="POST" class="require-validation">
        <table cellpadding="1" cellspacing="1" border="0" class="form">
          <tr>
            <td width="160">Patient Name<span class="red">*</span></td>
            <td>
                <input type='text' name='patient_name' class="required" value='<?php echo set_value("patient_name"); ?>' style="width: 200px;" />
                <?php echo form_error('patient_name');?>
            </td>
          </tr>
          <tr>
            <td>Home Phone<span class="red">*</span></td>
            <td>
                <input type='text' name='home_phone' class="phoneUS required" value='<?php echo set_value("home_phone"); ?>' style="width: 200px;" />
                <?php echo form_error('home_phone');?>
            </td>
          </tr>
          <tr>
            <td>Work Phone<span class="red">*</span></td>
            <td>
                <input type='text' name='work_phone' class="phoneUS required" value='<?php echo set_value("work_phone"); ?>' style="width: 200px;" />
                <?php echo form_error('work_phone');?>
            </td>
          </tr>          
          <tr>
            <td>Cell Phone</td>
            <td>
                <input type='text' name='cell_phone' value='<?php echo set_value("cell_phone"); ?>' style="width: 200px;" />
                <?php echo form_error('cell_phone');?>
            </td>
          </tr>
	  <tr>
	  	<td>Email Address<span class="red">*</span></td>
	  	<td>
	  		<input type="text" name="email" class="required email" value="<?php echo (isset($email) ? $email: '' );?>"/>
	  		<?php echo form_error('email');?>
	  	</td>
	  </tr>          
          <tr>
            <td valign="top">Height<span class="red">*</span></td>
            <td>
			Feet <input type="text" name="feet" class="number" size="3" value="<?php echo (isset($feet) ? $feet: '' );?>" maxlength="2"/>
			Inches <input type="text" class="required number" name="inches" size="3" value="<?php echo (isset($inches) ? $inches : '' );?>" maxlength="2"/>
            </td>
          </tr>
          <tr>
          	<td>Weight<span class="red">*</span></td>
          	<td>
          	Pounds <input type="text" name="weight" class="required number" value="<?php echo (isset($weight) ? $weight: '' );?>" />
          		<?php echo form_error('weight');?>
          	</td>
          </tr>
          <tr>
          	<td>Date of birth<span class="red">*</span></td>
          	<td>
          		<input type="text" name="date_of_birth" class="required datepick" value="<?php echo (isset($date_of_birth) ? $date_of_birth : '' );?>" />
          		<?php echo form_error('date_of_birth');?>
          	</td>
          </tr>
	  <tr>
	    <td>Insurance: Please state if you have a PPO/POS/HMO</td>
	    <td><?php echo form_dropdown('have_insurance', yes_no_dropdown(), (isset($have_insurance) ? $have_insurance : '' ));?></td>
	  </tr>
	  <tr>
	  	<td>If yes, please state your insurance</td>
	  	<td>
			<input type="text" name="insurance" value="<?php echo (isset($insurance) ? $insurance: '' );?>" />
			<?php echo form_error('insurance');?>		  	
	  	</td>
	  </tr>
	  <tr>
	    	<td>Subscriber ID number<span class="red">*</span></td>
	    	<td>
	    		<input type="text" name="subscriber_id" value="<?php echo (isset($subscriber_id) ? $subscriber_id: '' );?>" class="required"/>
	    		<?php echo form_error('subscriber_id');?>
	    	</td>	    
	  </tr>
	  <tr>
	  	<td>Subscriber Name<span class="red">*</span></td>
	  	<td>
	  		<input type="text" name="subscriber_name" class="required" value="<?php echo (isset($subscriber_name) ? $subscriber_name: '' );?>" />
	  		<?php echo form_error('subscriber_name');?>
	  	</td>
	  </tr>
          <tr>
          	<td>Subsciber Date of birth<span class="red">*</span></td>
          	<td>
          		<input type="text" name="subscriber_date_of_birth" class="required datepick" value="<?php echo (isset($subscriber_date_of_birth) ? $subscriber_date_of_birth: '' );?>" />
          		<?php echo form_error('subscriber_date_of_birth');?>
          	</td>
          </tr>	  
	  <tr>
	  	<td>Member Services Number</td>
	  	<td>
	  		<input type="text" name="mService_number" value="<?php echo (isset($mService_number) ? $mService_number: '' );?>" />
	  		<?php echo form_error('mService_number');?>
	  	</td>
	  </tr>
	  <tr>
	  	<td>Group number</td>
	  	<td>
	  		<input type="text" name="group_number" value="<?php echo (isset($group_number) ? $group_number: '' );?>"/>
	  		<?php echo form_error('group_number');?>
	  	</td>
	  </tr>
	   <!-- <tr>
	  	<td colspan="2" align="center">
	  	<?php echo $this->session->flashdata('ayah_message');?>
	  	<input type="hidden" name="Submit" value="Yes">
	  		<?php echo $ayah_captcha;?>
	  	</td>
	  </tr> -->
	  
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
          
          <tr>
            <td></td>
            <td><input type='submit' value='Send' name='submit' /><input type='reset' value='Reset' /></td>
          </tr>
        </table>
    </form>
</div>
<p>&nbsp;</p>
<script type="text/javascript">
$(document).ready(function () {
    $('input[name="insurance"]').rules(
    	'add',
    	{
    		required: function() {
    			return ($('select[name="have_insurance"]').val() == 1);
    		}
    	}
    ); 

});
</script>