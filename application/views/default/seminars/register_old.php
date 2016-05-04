<script type="text/javascript">  
        function ShowHide(xElemName,xHow){  
         blockNone = (xHow)?"inline":"none";  
           document.getElementById(xElemName).style.display = blockNone;  
        }  
      	
</script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Display content from CMS.
$ci =& get_instance();

// Show messages here (succes/failure/whatever).
if ($this->session->flashdata('message'))
{
    echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";
}

if (isset($page_content))
{
    //echo $page_content;
}

if ($seminar_is_full)
{
    echo "<div class='red bold'>Sorry. This seminar is full.</div>";
    exit();
}   

echo "<p>&nbsp;</p>";
?>
<script type="text/javascript" src="<?php echo site_url('js/seminars.js');?>"></script>
<style>
.border { border: 1px solid #cedbc7; padding: 4px; }
table.form { margin: 0; width: 100%; background: white; font-size: 12px; }
table.form { width: 100%; }
table.form td { padding: 8px; }
table.form tr.shade td { background: #deead6; }
h3.subtitle { margin-bottom: 10px; }
table.form label.error { margin-left: 10px; font-weight: normal; font-style: italic; font-size: 11px; display: block; position: static; padding-top: 4px; margin: 0; }
</style>
<h2>Registration Form</h2>
<p class="subtext"><em>Fields with an asterisk (<span class="red">*</span>) are required.</em></p>
<form action="" method="POST" class="require-validation">
    <h3 class="subtitle">Meeting Details</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="form">
        <tr class="shade">
            <td width="200"><label for="">Date and Time of Seminar:</label></td>
            <td><?php echo form_dropdown('seminar_id', $seminars_dropdown, $ci->uri->segment(3));?></td>
        </tr>
        <tr>
            <td><label for="title">Title:</label></td>
            <td><span><?php echo $seminar_title;?></span></td>
        </tr>
        <tr class="shade">
            <td>Where</td>
            <td><?php echo $seminar_location;?></td>
        </tr>
    </table>
    </div>
    <p>&nbsp;</p>
    
    <!-- PATIENT INFORMATION BOX -->
    <!-- <h2>REGISTER NOW</h2> -->
    <h3 class="subtitle">Registrant Information</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="form">
      
      <tr>
        <td><label for="first_name">First Name:<span class="red">*</span></label></td>
        <td><input type="text" name="first_name" class="required" value="<?php echo $first_name;?>"/><?php echo form_error('first_name');?></td>
      </tr>
      <tr class="shade">
        <td><label for="last_name">Last Name:<span class="red">*</span></label></td>
        <td><input type="text" name="last_name" class="required" value="<?php echo $last_name;?>"/><?php echo form_error('last_name');?></td>
      </tr>
      <tr>
        <td><label for="gender">Gender<span class="red">*</span></label></td>
        <td><?php echo form_dropdown('gender', gender_dropdown(), '', 'class="required"');?><?php echo form_error('gender');?></td>
      </tr>
    </table>
    </div>
    <p>&nbsp;</p>
    
    <!-- CONTACT INFORMATION BOX -->
    <h3 class="subtitle">Contact Information</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="form">
      <tr class="shade">
        <td width="120"><label for="address1">Address 1:<span class="red">*</span></label></td>
        <td><input type="text" name="address1" value="<?php echo $address1;?>" class="required"/><?php echo form_error('address1');?></td>
      </tr>
      <tr>
        <td><label for="address2">Address 2:</label></td>
        <td><input type="text" name="address2" value="<?php echo $address2;?>"/><?php echo form_error('address2');?></td>
      </tr>
      <tr class="shade">
        <td><label for="city">City:<span class="red">*</span></label></td>
        <td><input type="text" name="city" value="<?php echo $city;?>" class="required"/><?php echo form_error('city');?></td>
      </tr>
      <tr>
        <td><label for="state">State:<span class="red">*</span></label></td>
        <td><?php echo form_dropdown('state', state_dropdown(), '', 'class="required"');?><?php echo form_error('state');?></td>
      </tr>
      <tr class="shade">
        <td><label for="zip">Zip:<span class="red">*</span></label></td>
        <td><input type="text" name="zip" value="<?php echo $zip;?>" class="required"/><?php echo form_error('zip');?></td>
      </tr>
      <tr>
        <td><label for="country_id">Country:</label></td>
        <td>
        	<select name='country_id'>
        		<option value="1" selected="selected">United States of America</option>
        	</select>
        </td>
      </tr>
      <tr class="shade">
        <td><label for="phone1">Primary Phone:<span class="red">*</span></label></td>
        <td>
    	    <input type="text" class="phoneUS" name="phone1" />
            <?php echo form_error('phone1');?>
        </td>
      </tr>
      <tr>
        <td><label for="phone2">Alternate Phone:</label></td>
        <td>
	    <input type="text" class="phoneUS" name="phone2" />
            <?php echo form_error('phone2');?>
        </td>
      </tr>
      <tr class="shade">
        <td><label for="email">E-mail Address:<span class="red">*</span></label></td>
        <td><input type="text" name="email" value="<?php echo $email;?>" class="required email" /><?php echo form_error('email');?></td>
      </tr>
    </table>
	</div>
    <p>&nbsp;</p>
    
    <!-- OTHERS BOX -->
    <h3 class="subtitle">Others</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="form">      
      <tr class="shade">
        <td width="120">
        	<label for="Specialty">Specialty</label>
        </td>
        	<td valign="top" width="70">
			<input type="checkbox" name="specialty[]" value="MD/DO" id="aff1" />MD/DO<br />
			<input type="checkbox" name="specialty[]" value="RN" id="aff2" />RN<br />
			<input type="checkbox" name="specialty[]" value="PT/EP" id="aff3" />PT/EP
		</td>
		<td valign="top">
			<input type="checkbox" name="specialty[]" value="Mental Health Professional" id="aff4" />Mental Health<br /> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Professional<br />
			<input type="checkbox" name="specialty[]" value="Office Manager" id="aff5" />Office Manager<br />
			<input type="checkbox" name="" value="Other" id="aff6" onclick="ShowHide(&#039;get&#039;,this.checked)" />Other
			<br style="margin-bottom: 10px;" />
            
			<div id="get" style="display:none;">
				<label>What is the TN ASMBS<br /> Member on the list?</label><br />
				<input type="text" id="other_member" name="specialty[]" size="30" maxlength="75" style="width:150px; margin-top: 7px;" value="" />
			</div>
		</td>
      </tr>    
      
    </table>
    </div>

    <!-- reCAPTCHA -->
    <?php if ($recaptcha != ''):?>
    <div class="border">
        <?php echo $recaptcha;?>
        <?php echo form_error('recaptcha_response_field');?>
    </div>
    <?php endif;?>

    <p style="padding-bottom: 0;">&nbsp;</p>

    <div style="margin-bottom: 30px;">
        <input type="submit" name="submit" value="Submit" class="btn-bg-small" style="float:left" /> 
           
            
        <input type="reset" value="Clear" class="btn-bg-small" style="cursor: pointer;float:left; margin-left: 10px;" /> 
        
        <a href="<?php echo base_url().index_page(); ?>"><input type="button" value="Cancel" class="btn-bg-small" style="cursor: pointer;float:left; margin-left: 10px;" /> </a>
              
        <!--div class="btn-bg-small" style="border:0; font-size: 12px; text-align:center;; padding-top: 5px; height: 19px; float:left; margin-left: 10px;"><a href="<?php// echo base_url().index_page(); ?>" style="text-decoration: none;">Cancel</a></div-->
        
        <div style="clear:both"></div><br />
        
        <a href="<?php echo base_url().index_page().'am-i-a-candidate/register-for-a-seminar'; ?>"><input type="button" class="btn-bg-large" style="cursor: pointer;"  value="View Other Seminar Dates" /></a>
        
    </div>
</form>
