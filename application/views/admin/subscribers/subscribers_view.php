<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Mailing List Manager [View]
        </h1>
        </div>                     
        <div class="clear"></div>
    </div>
	<div class="content-text"> 
        <ul>
            <li><a href='<?php echo base_url().index_page(); ?>admin/subscribers'>Back</a></li>
            <?php if(count($subscriber)): ?>
            <li><a href='<?php echo base_url().index_page(); ?>admin/subscribers/edit/<?php echo $subscriber['id_subscriber']; ?>'>Edit</a></li>
            <?php endif; ?>
        </ul>
        
        <?php if(count($subscriber)): ?>
        <table>
        <tr><td>Hospital</td><td><?php echo $subscriber['hospital']; ?></td></tr>
        <tr><td>Contact No.</td><td><?php echo $subscriber['contact']; ?></td></tr>
        <tr><td>Website</td><td><?php echo $subscriber['website']; ?></td></tr>
        <tr><td>Email</td><td><?php echo $subscriber['email']; ?></td></tr>
        <tr><td>Marketing Head</td><td><?php echo $subscriber['marketing_head']; ?></td></tr>
        <tr><td>Proper Designation</td><td><?php echo $subscriber['proper_designation']; ?></td></tr>
        <tr><td>Address</td><td><?php echo $subscriber['address']; ?></td></tr>
        <tr><td>Contact Person</td><td><?php echo $subscriber['contact_person']; ?></td></tr>
        <tr><td>Remarks</td><td><?php echo $subscriber['remarks']; ?></td></tr>
        </table>
        
        <?php else: ?>
            <p>Couldn't view subscriber</p>
        <?php endif; ?>
	</div><!--end of content-text-->
</div><!--end of content-container-->