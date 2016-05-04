<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Settings [Modules]
        </h1>
        </div>                     
           <ul class="tab right">
           	   <li><a href="<?php echo base_url().index_page(); ?>admin/administrator"><span>Settings</span></a></li>
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/modules" class="active"><span>Modules</span></a></li>           	   
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/password"><span>Change Password</span></a></li>
           </ul>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
            <?php if (count($modules) > 0):?>
            <table cellpadding="10" cellspacing="0" border="0" class="list" width="100%">
                <thead>
                    <tr class="title">
                        <td>Module Name</td>
                        <td>Action</td>
                    </tr>                        
                </thead>
                <tbody>
                    <?php foreach ($modules as $module):?>
                    <tr>
                        <td><?php echo ucwords($module->url_key);?></td>
                        <td><?php echo anchor('admin/administrator/toggle_module/' . $module->id_module, ($module->activated == 1) ? 'Disable' : 'Enable');?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php endif;?>
        </div>
    </div><!--end of content-text-->
</div><!--end of content-container-->
