<?php if(isset($newsletter) && count($newsletter)): ?>
<div>
<h1><?php echo $newsletter['title']; ?></h1>
<div>
	<?php echo $newsletter['body']; ?>
</div>
</div>
<?php endif; ?>


<a href='<?php echo base_url().index_page(); ?>{url_key}'>Back to newsletter index</a>
