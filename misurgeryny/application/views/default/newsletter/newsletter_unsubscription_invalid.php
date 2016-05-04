<div class="red" style="margin-bottom: 10px;">The email address is not subscribed!</div>
 
 
<?php echo form_open(base_url().index_page(). '{url_key}/unsubscribe'); ?>
  <div class="content">
	<h2>Unsubscribe</h2>						
    <input name="email" type="text" value="Email Address" class="field left"  onFocus="this.value=''" />
    <input type="submit" value="Unsubscribe" class="sign-up left" />
  </div>
 
  <div class="clear"></div>              
<?php echo form_close(); ?>

 <div>
	<p>Choose to stay updated! Browse through our <a href='<?php echo base_url(); ?>'>website</a>, <a href='<?php echo base_url().index_page(); ?>{url_key}'>newsletter</a> archive</p>
  </div>