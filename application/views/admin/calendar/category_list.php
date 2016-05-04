<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title left">
        <h1>
            Calendar Manager
        </h1>
        </div>
            <?php $this->load->view('admin/calendar/tabs', array('categories' => 'active'));?>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class='msg'><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($categories)): ?>
            <div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" width="100%" class="list">
                <tr class="title">                    
                    <td width="30%">Category</td>
                    <td width="60%">Color</td>
                    <td width="10%">Actions</td>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($categories as $row): ?>
                    <?php $ctr++; ?>
                    <tr>                        
                        <td><?php echo $row->category_name; ?></td>
                        <td style="background-color: #<?php echo $row->category_color;?>;"><?php echo $row->category_color;?></td>
                        <td width="70">
                            <ul class="action-btns">
                            <!--<li class="link01">
                                <?php echo anchor('admin/seminars/view','<span class="hide">View</span>');?>
                            </li>-->
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/seminars/edit/' . $row->seminar_id);?>'></a>
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
            <p>No page found.</p>
            <?php endif; ?>
        </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->
