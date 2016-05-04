<?php if(isset($downloads) && count($downloads)): ?>
		<?php foreach($downloads as $row): ?>
		<h5 style="margin-bottom: 0;" class="pdf-download"><a href='<?php echo base_url().index_page(); ?>download/index/<?php echo $row['id_download']; ?>' title="<?php echo $row['file_name'];?>"><?php echo $row['title']; ?></a></h5>
		<p><?php echo $row['desc']; ?><br />
		</p>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>