<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- Display CMS content here. -->
<?php //echo $page_content;?>
<br />

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

<!-- End CMS content. -->
<div class="green bold"><?php echo $this->session->flashdata('message');?></div>
<p class="subtext"><em>Fields with an asterisk (<span class="red">*</span>) are required.</em></p>
<form action=""  name="testimonial-form" method="POST" enctype="multipart/form-data" class="require-validation">
<div class="border">
<table cellpadding="0" cellspacing="1" border="0" class="form">
  <tr>
    <td width="150"><label for="first_name">First name:</label><span class="red">*</span></td>
    <td><input type="text" name="first_name" class="required" value="<?php echo $first_name;?>" style="width: 200px;" /><?php echo form_error('first_name');?></td>
  </tr>
  <tr>
    <td><label for="last_name">Last name:</label></td>
    <td><input type="text" name="last_name" value="<?php echo $last_name;?>" style="width: 200px;" /><?php echo form_error('last_name');?></td>
  </tr>
  <tr>
    <td><label for="email">Email:</label><span class="red">*</span></td>
    <td><input type="text" name="email" class="required email" value="<?php echo $email;?>" style="width: 200px;" /><?php echo form_error('email');?></td>
  </tr>
  <?php if (isset($category)):?>
  <tr>
    <td><label for="email">Cateogry:</label></td>
    <td>
    <div><?php echo $category_dropdown;?></div>
    </td>
  </tr>
  <?php endif;?>
 
  <tr>
    <td valign="top"><label for="body">Testimonial Text:</label><span class="red">*</span></td>
    <td><textarea cols="30" rows="5" name="body" class="required"><?php echo $body;?></textarea><?php echo form_error('body');?></td>
  </tr>
  <tr>
    <td><label for="before_picture">Before Photo:</label></td>
    <td><input type="file" name="before_picture" /><?php echo form_error('field_before_picture');?></td>
  </tr>
  <tr>
    <td><label for="after_picture">After Photo:</label></td>
    <td><input type="file" name="after_picture" /><?php echo form_error('field_after_picture');?></td>
  </tr>
  
  <!-- reCAPTCHA -->
  <?php if (isset($recaptcha) && $recaptcha != ''):?>
  <tr>
    <td></td>
    <td>
	<?php echo $recaptcha ; ?>
    <?php echo form_error('recaptcha_response_field');?>
    </td>
  </tr>
  <?php endif;?>
  
  <tr>
    <td></td>
    <td>
    <input onmouseover='this.style.cursor="pointer"' type="submit" name="submit" value="submit" />
    <input type="reset" value="Clear" onmouseover='this.style.cursor="pointer"' /></td>
  </tr>
</table>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#c3decb" );</script>

<p>&nbsp;</p>    
    <input type="hidden" name="field_before_picture" value="before_picture" />
    <input type="hidden" name="field_after_picture" value="after_picture" />
</form>