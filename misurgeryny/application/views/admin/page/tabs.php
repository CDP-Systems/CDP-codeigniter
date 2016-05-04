<ul class="tab right">
	 <li>
	 <a href="<?php echo base_url().index_page(); ?>admin/page" <?php if(($this->uri->segment(2) == 'page') && !($this->uri->segment(3))): ?>class="active"<?php endif; ?>><span>Page List</span></a>
	 </li>
	 
		<?php //TEMPORARY ?>
		<?php if($this->session->userdata('super_admin')): ?>
		 <li><a href="<?php echo base_url().index_page(); ?>admin/page/add" <?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>class="active"<?php endif; ?>><span>Add New</span></a></li>
		<?php endif; //end of TEMPORARY ?>
		
</ul>