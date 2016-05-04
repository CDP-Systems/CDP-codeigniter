<ul class="tab right">
    <li><a href="<?php echo base_url().index_page(); ?>admin/subscribers" <?php if((($this->uri->segment(2) == 'subscribers') && !($this->uri->segment(3))) || ($this->uri->segment(3) == 'index')): ?>class="active"<?php endif; ?> ><span>Mailing List</span></a></li>
    <li><a href='<?php echo base_url().index_page(); ?>admin/subscribers/add'  <?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>class="active"<?php endif; ?>><span>Add New</span></a></li>
    <li><a href='<?php echo base_url().index_page(); ?>admin/subscribers/import'  <?php if(($this->uri->segment(3) == 'import') || ($this->uri->segment(3) == 'do_import')): ?>class="active"<?php endif; ?>><span>Import</span></a></li>
    <li><a href='<?php echo base_url().index_page(); ?>admin/subscribers/email'  <?php if(($this->uri->segment(3) == 'email') || ($this->uri->segment(3) == 'saveEmail')): ?>class="active"<?php endif; ?>><span>Confirmation Email</span></a></li>
</ul>