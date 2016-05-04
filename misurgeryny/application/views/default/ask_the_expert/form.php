<?php
// Get absolute link
$ci =& get_instance();
$ci->load->library('CS_Url_Tree', null, 'tree');
$ci->tree->clear();
$ci->tree->id_page = $ci->view_data['id_page'];
$link = $ci->tree->get_link();

?>
<style>
.subtext { font-size: 11px; }
.red { color: red; font-weight: bold; }
.form { font-size: 12px; width: 100%; }
.form td { padding: 8px 0 8px 8px; }
label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }
</style>


	<p class="green bold"><?php echo $this->session->flashdata('msg_sent'); ?></p>

<br />
<div class="border" style="width:500px">
<form action="<?php echo base_url(). index_page() . $link; ?>/send" method="POST" class="require-validation" style="border: 1px solid #EEEEEE;">
<table cellpadding="8" cellspacing="1" border="0" class="form" style="width:500px">
  <tr>
    <td width="120">Name:</td>
    <td><input type='text' name='name' class="required" value='<?php echo set_value("name"); ?>' style="width: 222px; height:22px" />
    <br /><?php echo form_error('name');?></td>
  </tr>
    <tr>
    <td>Email:</td>
    <td><input type='text' name='email' class="required" value='<?php echo set_value("email"); ?>' style="width: 222px; height:22px" />
    <br /><?php echo form_error('email');?></td>
  </tr>
  <tr>
    <td>Subject:</td>
    <td>
	<textarea name='subject' class="required" style="width: 222px; height:22px" rows="4"><?php echo set_value('subject'); ?></textarea>	
    <br /><?php echo form_error('subject');?></td>
  </tr>
  <tr>
    <td>Question:</td>
    <td><textarea name='question' class="required" style="width: 222px; height:22px" rows="4"><?php echo set_value('question'); ?></textarea>
    <br /><?php echo form_error('question');?></td>
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
  <tr>
    <td>&nbsp;</td>
    <td><input type='submit' value='Send' onmouseover='this.style.cursor="pointer"' class="blue-btn">&nbsp;<input type='reset' value='Reset' onmouseover='this.style.cursor="pointer"' class="blue-btn"></td>
  </tr>
</table>
</form>
</div>
<p>&nbsp;</p>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#EEEEEE" );</script>
