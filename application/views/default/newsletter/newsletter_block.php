<div class="newsletter">
	<?php $newsletter = $this->M_newsletter->get_newsletter(1); ?>
	<?php if(count($newsletter)): ?>
         <h1>Newsletter</h1>
         <h2><?php echo $newsletter['title']; ?></h2>
         <div>
            <div class="left"><img src="images/img-01.jpg" border="0" /></div>
			<p><?php echo word_limiter($newsletter['body'], 30); ?></p>
            <p> <span><a href="<?php echo base_url().index_page(); ?>newsletter">more &raquo;</a></span> </p>
        </div>
	<?php else: ?>
	<p>No newsletter found.</p>
	<?php endif; ?>
</div>