<?php echo form_open('newsletter/subscribe'); ?>
  <div class="content">
    <h1>Subscribe Now!</h1>
    <h2>Receive Legal Updates</h2>                            
    <input name="email" type="text" value="Email Address" class="field left"  onFocus="this.value=''" />
    <input type="submit" value="Sign Up" class="sign-up left" />
  </div>
  
  <div class="clear"></div>              
<?php echo form_close(); ?>

<div>
	<p>For subscribers who for any reason want to discontinue receiving newsletters, 
	please <a href='<?php echo base_url().index_page(); ?>newsletter/unsubscribe-form'>unsubscribe</a> from the mailing list.</p>
  </div>
