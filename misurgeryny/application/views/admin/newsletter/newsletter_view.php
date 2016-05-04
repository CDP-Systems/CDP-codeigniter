<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
			<h1>
				Newsletter Manager 
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
	
    <div class="content-text"> 
            <ul>
                <li class="back-arrow"><a href='<?php echo base_url(); ?>index.php/admin/newsletter'>Back</a></li>
            </ul>
    	<p>&nbsp;</p>
        
		<?php if(count($newsletter)): ?>
        <table cellpadding="8" cellspacing="1">
          <tr>
            <td colspan="2">
            <div class="green-btn left" style="margin-right: 10px;"><a href='<?php echo base_url(); ?>index.php/admin/newsletter/edit/<?php echo $newsletter['id_newsletter']; ?>'>Edit</a></div>
            <div class="green-btn left"><a href='<?php echo base_url(); ?>index.php/admin/newsletter/send/<?php echo $newsletter['id_newsletter']; ?>'>Send</a></div>
            </td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td width="80">Title:</td>
            <td><?php echo $newsletter['title']; ?></td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td valign="top">Body:</td>
            <td><?php echo $newsletter['body']; ?></td>
          </tr>
          <?php if($newsletter['attachment']): ?>
          <tr bgcolor="#F1F1F1">
            <td>File Attachment:</td>
            <td><?php echo $newsletter['attachment']; ?>
                <a href='<?php echo base_url(); ?>index.php/admin/newsletter/download/<?php echo $newsletter['id_newsletter']; ?>'>Download</a></td>
          </tr>
          <?php endif; ?>
        </table>
            
        <?php else: ?>
            <p>Couldn't view newsletter</p>
        <?php endif; ?>
	</div><!--end of content-text-->
</div><!--end of content-container-->