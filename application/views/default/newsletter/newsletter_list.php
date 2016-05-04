<?php if(isset($newsletters) && count($newsletters)): ?>
<div>
	<?php foreach($newsletters as $row): ?>
        
         <h2><?php echo $row['title']; ?></h2>
         <div>
            <!--div class="left"><img src="images/img-01.jpg" border="0" /></div-->
			<p><?php echo word_limiter($row['description'], 30); ?></p>
            <p> <span><a href="<?php echo base_url().index_page(); ?>{url_key}/view/<?php echo $row['id_newsletter']; ?>">more &raquo;</a></span> </p>
        </div>
		<hr />
	<?php endforeach; ?>
</div>
<?php else: ?>
<h2>No newsletter found.</h2>
<?php endif; ?>


<?php $this->load->view('default/newsletter/newsletter_form'); ?>