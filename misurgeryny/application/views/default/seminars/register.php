<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Display content from CMS.
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$link = $ci->tree->get_link();


if (isset($page_content))
{
   // echo $page_content;
}

if ($seminar_is_full)
{
    // Show messages here (succes/failure/whatever)
    if ($this->session->flashdata('message'))
    {
        echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";
    }else{
        echo "<div class='red bold'>Sorry. This seminar is full.</div>";
    }

}   else{ 

    if ($this->session->flashdata('message'))
	{
        echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";
   	}
    echo "<p>&nbsp;</p>";
?>	

<script type="text/javascript">
function confirmAction(url){

	var ans = confirm("Are you sure you want to leave this page? All your typed entries will be lost.");

	if(ans){

		window.location = "<?php echo base_url();?>" + url;
	}
}
</script>

<style>
.chart { border-color: #CCC;  margin: 10px 0 20px; width: 100%; background: #dfe5d7; }
.chart th { border-left: 1px solid #CCCCCC; padding: 8px; background: #DDD; font-size: 14px; }
.chart td { border-color: #CCCCCC -moz-use-text-color -moz-use-text-color #CCCCCC; border-style: solid none none solid; border-width: 1px 0 0 1px; padding: 10px; }
.chart td { font-size: 12px; line-height: 18px; }.
table.chart tr.shade { background: #b3bb92; }
.chart .first { background: #EEE; }
label.error { font-weight: normal; font-style: italic; font-size: 11px; }
</style>

<script type="text/javascript" src="<?php echo site_url('js/seminars.js');?>"></script>

<p><i>Fields with an asterisk (*) are required.</i></p>

<form action="" method="POST" class="require-validation">
    <h3 class="subtitle">Seminar Details</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="chart">
        <tr class="shade" style="background:#b3bb92">
            <td width="200"><label for="">Date and Time of Seminar:</label></td>
            <td><?php echo form_dropdown('seminar_id', $seminars_dropdown, end($this->uri->segment_array()));?></td>
        </tr>
        <tr>
            <td><label for="title">Title:</label></td>
            <td><span><?php echo $seminar_title;?></span></td>
        </tr>
        <tr class="shade" style="background:#b3bb92">
            <td>Where</td>
            <td><?php echo $seminar_location;?></td>
        </tr>
    </table>
    </div>
    <p>&nbsp;</p>

   
    <!-- PATIENT INFORMATION BOX -->
    <h3 class="subtitle">Patient Information</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="chart">
      <tr class="shade-2" style="background:#b3bb92">
        <td width="120"><label for="date_of_birth">Date of Birth:<span class="red">*</span></label></td>
        <td>
        <?php echo form_dropdown('month', month_dropdown()) . form_dropdown('date', date_dropdown()) . form_dropdown('year', year_dropdown(), set_value('year'), 'class="required"');?>
        <?php echo form_error('year');?>
        </td>
      </tr>
      <tr>
        <td><label>Height<span class="red">*</span></label></td>
        <td>
        <input type="text"  name="feet" size="5" value="<?php echo $feet;?>" style="width:60px;"/><span style="margin: 0 20px 0 10px;">Feet</span><?php echo form_error('feet');?>
        <input type="text" class="required" name="inches" size="5" value="<?php echo $inches;?>" style="width:60px;"/><span style="margin: 0 8px 0 10px;">Inches</span><?php echo form_error('inches');?>
        </td>
      </tr>
      <tr class="shade" style="background:#b3bb92">
        <td><label>Weight<span class="red">*</span></label></td>
        <td><input type="text" class="required" name="weight"  size="5" value="<?php echo $weight;?>" style="width:60px;" /><span style="margin: 0 125px 0 10px;">Pounds<?php echo form_error('weight');?></td>
      </tr>
      <tr>
        <td><label for="first_name">First Name:<span class="red">*</span></label></td>
        <td><input class='required textfield' type="text" name="first_name" value="<?php echo $first_name;?>" /><?php echo form_error('first_name');?></td>
      </tr>
      <tr class="shade" style="background:#b3bb92">
        <td><label for="last_name">Last Name:<span class="red">*</span></label></td>
        <td><input class='required textfield' type="text" name="last_name" value="<?php echo $last_name;?>"/><?php echo form_error('last_name');?></td>
      </tr>
      <tr>
        <td><label for="gender">Gender<span class="red">*</span></label></td>
        <td><?php echo form_dropdown('gender', gender_dropdown(), set_value('gender'), 'class="required"');?><?php echo form_error('gender');?></td>
      </tr>
    </table>
    </div>
    <p>&nbsp;</p>


    <!-- CONTACT INFORMATION BOX -->

    <h3 class="subtitle">Contact Information</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="chart">
      <tr class="shade" style="background:#b3bb92">
        <td width="120"><label for="address1">Address 1:<span class="red">*</span></label></td>
        <td><input type="text" name="address1" class="required textfield" value="<?php echo $address1;?>"/><?php echo form_error('address1');?></td>
      </tr>
      <tr>
        <td><label for="address2">Address 2:</label></td>
        <td><input type="text" name="address2" value="<?php echo $address2;?>" class="textfield" /><?php echo form_error('address2');?></td>
      </tr>
      <tr class="shade" style="background:#b3bb92">
        <td><label for="city">City:<span class="red">*</span></label></td>
        <td><input type="text" name="city" class="required textfield" value="<?php echo $city;?>"/><?php echo form_error('city');?></td>
      </tr>
      <tr>
        <td><label for="state">State:<span class="red">*</span></label></td>
        <td><?php echo form_dropdown('state', state_dropdown(), set_value('state'), 'class="required"');?><?php echo form_error('state');?></td>
      </tr>
      <tr class="shade" style="background:#b3bb92">
        <td><label for="zip">Zip:<span class="red">*</span></label></td>
        <td><input class='required textfield' type="text" name="zip" value="<?php echo $zip;?>"/><?php echo form_error('zip');?></td>
      </tr>
      <tr>
        <td><label for="country_id">Country:</label></td>
        <td>
			<select name='country_id' >
				<option value="1" selected="selected">United States of America</option>
			</select>
			<?php //echo form_dropdown('country_id', country_dropdown(), 1);?><?php echo form_error('country');?>
		</td>
      </tr>
      <tr class="shade" style="background:#b3bb92">
        <td><label for="phone1">Primary Phone:<span class="red">*</span></label></td>
        <td>
            <input type="text" class="phone1 require_numeric" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="3" style="width: 67px;"/> -
            <input type="text" class="phone1 require_numeric" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="3" style="width: 67px;"/> -
            <input type="text" class="phone2 require_numeric" name="phone1[]" value="<?php echo set_value('phone1[]'); ?>" size="4" style="width: 67px;"/>
            <?php echo form_error('phone1[]');?>
        </td>
      </tr>
      <tr>

        <td><label for="phone2">Alternate Phone:</label></td>
        <td>
            <input type="text" class="phone1 require_numeric" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="3" style="width: 67px;"/> -
            <input type="text" class="phone1 require_numeric" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="3" style="width: 67px;"/> -
            <input type="text" class="phone2 require_numeric" name="phone2[]" value="<?php echo set_value('phone2[]'); ?>" size="4" style="width: 67px;"/>
            <?php echo form_error('phone2[]');?>
        </td>
      </tr>
      <tr class="shade">
        <td><label for="email">E-mail Address:<span class="red">*</span></label></td>
        <td><input type="text" name="email" class="required email textfield" value="<?php echo $email;?>" /><?php echo form_error('email');?></td>
      </tr>
         </table>
	</div>
    <p>&nbsp;</p>
    
    <!-- OTHERS BOX -->
    <h3 class="subtitle">Others</h3>
    <div class="border">
    <table cellpadding="0" cellspacing="1" border="0" class="chart">      
      <tr class="shade" style="background:#b3bb92">
        <td width="120"><label for="insurance">Insurance</label></td>
        <td><input type="text" name="insurance" value="<?php echo $insurance;?>" class="textfield" /><?php echo form_error('insurance');?></td>
      </tr>    

      <tr class="select-2">
        <td colspan="2">
        <label for="number_of_guests">Excluding yourself, how many guests will you bring?</label>
		<?php echo form_dropdown('number_of_guests', number_dropdown(0, 4), set_value('number_of_guests') , 'class="required"');?>
        <?php echo form_error('number_of_guests');?>
        </td>
      </tr>
    </table>
    </div>
    <p style="padding-bottom: 0;">&nbsp;</p>

    <div style="margin-bottom: 30px;">
        <input type="submit" name="submit" value="Submit" />
        <input type="reset" value="Clear" />
        <input type="button" onclick="confirmAction('<?php echo $link; ?>')" value="View Other Seminar Dates"/>
    </div>
</form>
<?php } ?>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#c5b2a0" );</script>