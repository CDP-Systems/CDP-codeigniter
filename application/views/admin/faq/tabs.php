<ul class="tab right">
   <li><a href="<?php echo base_url().index_page(); ?>admin/faq"  <?php if((($this->uri->segment(2) == 'faq') && !($this->uri->segment(3))) || ($this->uri->segment(3) == 'index')): ?>class="active"<?php endif; ?>><span>FAQ List</span></a></li>
   <li><a href='<?php echo base_url().index_page(); ?>admin/faq/add' <?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>class="active"<?php endif; ?>><span>Add New FAQ</span></a></li>
   <li><a href="<?php echo base_url().index_page(); ?>admin/faq/category" <?php if(($this->uri->segment(3) == 'category') || ($this->uri->segment(3) == 'category_save')): ?>class="active"<?php endif; ?>><span>FAQ Category</span></a></li>
</ul>