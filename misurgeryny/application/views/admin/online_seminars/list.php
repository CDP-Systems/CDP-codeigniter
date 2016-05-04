<script type='text/javascript'>
    	function deleteSeminar(id){
		var ans = confirm("Delete this seminar?");
		if(ans){
			window.location = "<?php echo site_url('admin/online_seminars/delete_seminar');?>/" + id;
		}
	}
</script>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
        <h1>
        	Online Seminars Manager
        </h1>
            <?php $this->load->view('admin/online_seminars/tabs', array('list' => 'active'));?>
            <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($seminars)): ?>
            <div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" class="list" width='100%'>
                <tr class="title">                    
                    <td>Date Posted</td>
                    <td>Title</td>
                    <td>Link</td>
                    <td>Description</td>
                    <td>Actions</td>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($seminars as $row): ?>
                    <?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">                        
                        <td><?php echo date('F d, Y', strtotime($row->date_posted)); ?></td>
                        <td><?php echo $row->title; ?></td>
						<td><?php echo $row->link;?></td>
                        <td><?php echo $row->description;?></td>
                        <td width="70">
                            <ul class="action-btns">
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/online_seminars/edit/' . $row->seminar_id);?>'></a>
                            </li>
                            <li class="link03">
                                <a title="Delete"  onclick='deleteSeminar(<?php echo $row->seminar_id; ?>);'></a>
                            </li>
                            </ul><!--end of action-btns-->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
            <ul class="pagination right">
                <?php echo $this->pagination->create_links(); ?>
            </ul>
            <div class="clear"></div>
            <?php else: ?>
            <p>No records found.</p>
            <?php endif; ?>
        </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->
