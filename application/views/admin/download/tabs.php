<ul class="tab right">
           <li>
           <a href="<?php echo base_url().index_page(); ?>admin/download" <?php if((($this->uri->segment(2) == 'download') && !($this->uri->segment(3))) || ($this->uri->segment(3) == 'index')): ?>class="active"<?php endif; ?>>
           	 <span>Files</span>
           </a>
           </li>
           <li>
           <a href='<?php echo base_url().index_page(); ?>admin/download/add' <?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>class="active"<?php endif; ?>>
           	 <span>Add New</span>
           </a>
           </li>
</ul>
        
   