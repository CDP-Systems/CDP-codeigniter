<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (isset($page_content))
{
    echo $page_content;
}
?>

<style>
.border { border: 1px solid #c3decb; padding: 4px; }
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; width: 100%; background: #dbefe1; }
.form td { padding: 8px 0 8px 8px; }
.form td.title { width: 120px; }
.form td.captcha-section label.error { margin-left: -165px; }
label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }
</style>

<div id="message-div" class="green bold"><?php echo $this->session->flashdata('message') . '<br/>'. $this->session->flashdata('mailing_msg');?></div>

<p class="subtext"><em>Fields with an asterisk (<span class="red">*</span>) are required.</em></p>

<div class="border">
<form action="" method="POST" class="require-validation">
<table cellpadding="0" cellspacing="0" border="0" class="form">
  <tr class="shade">
    <td>Name:<span class="red">*</span></td>
    <td>
    <input type="text" name="name" class="required" style="width: 200px;" /><br />
    <?php echo form_error('name');?>
    </td>
  </tr>
  <tr>
    <td>Email:<span class="red">*</span>    </td>
    <td>
    <input type="text" name="email" class="required email" style="width: 200px;" /><br />
    <?php echo form_error('email');?>
    </td>
  </tr>
  <tr class="shade">
    <td valign="top">Address:</td>
    <td>
    <textarea name="address" style="width: 200px;" rows="4"></textarea><br />
    <?php echo form_error('address');?>
    </td>
  </tr>
  <tr>
    <td><label for="phone">Phone:</label></td>
    <td>
    <input type="text" class="phone1 require_numeric" name="phone[]" size="3" maxlength="3" style="width:50px;" />&nbsp; -&nbsp;
    <input type="text" class="phone1 require_numeric" name="phone[]" size="3" maxlength="3" style="width:50px;" />&nbsp;-&nbsp;
    <input type="text" class="phone2 require_numeric" name="phone[]" size="4" maxlength="4" style="width:50px;" /> <br />                    
    <?php echo form_error('phone');?>
    </td>
  </tr>	 
  <tr class="shade">
    <td><label>Date Selected:</label><span class="red">*</span></td>        
    <td id="date-select"> 
    <input type="text" class="required date valid_date datepick" name="date_selected" /><br />
    <?php echo form_error('date_selected');?>
    <noscript>                    
    <?php echo form_dropdown('month', month_dropdown());?>
    <?php echo form_dropdown('date', date_dropdown());?>
    <?php echo form_dropdown('year', year_dropdown());?>                                                        
    </noscript>            
    </td>
  </tr>   
  <tr>
    <td valign="top">Other request:</td>
    <td>
    <textarea name="other" style="width: 200px;" rows="4"></textarea><br />
    <?php echo form_error('other');?>
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
  <tr class="shade">
    <td></td>
    <td>
    <input type="submit" name="submit" value="Send">&nbsp;
	<input type="reset" name="reset" value="Reset">
    </td>
  </tr>
</table>
</form>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#c3decb" );</script>