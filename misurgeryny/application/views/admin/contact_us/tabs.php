<ul class="tab right">
    <li><a href="<?php echo base_url().index_page(); ?>admin/contact_us" <?php if((($this->uri->segment(2) == 'contact_us') && !($this->uri->segment(3))) || ($this->uri->segment(3) == 'index')): ?>class="active"<?php endif; ?> ><span>Contact List</span></a></li>
    <li><a href='<?php echo base_url().index_page(); ?>admin/contact_us/settings' <?php if(($this->uri->segment(3) == 'settings') || ($this->uri->segment(3) == 'settings_save')): ?>class="active"<?php endif; ?>><span>Settings</span></a></li>
</ul>