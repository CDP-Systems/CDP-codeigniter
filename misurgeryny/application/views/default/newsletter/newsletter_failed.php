<?php echo validation_errors('<div class="red" style="margin-bottom: 10px;">','</div>'); ?>

<form action='<?php echo base_url().index_page(); ?><?php if($class=='newsletter'):?>{url_key}<?php else: ?>newsletter<?php endif; ?>/subscribe' method='post' >
    <h2>Receive Legal Updates</h2> <br />                           
    <input name="email" type="text" value="Email Address" class="field left" onFocus="this.value=''" />
    <input type="submit" value="Sign Up" class="sign-up left" />
  	<div class="clear"></div>                    
</form>

<p>
<a href='<?php echo base_url().index_page(); ?>{url_key}'>Back to newsletter index</a>
</p>