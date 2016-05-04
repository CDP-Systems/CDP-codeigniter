<ul class="tab right">
    <li><a href="<?php echo base_url().index_page(); ?>admin/ask-the-expert" <?php if((($this->uri->segment(2) == 'ask-the-expert') && !($this->uri->segment(3))) || ($this->uri->segment(3) == 'index')): ?>class="active"<?php endif; ?> ><span>Ask The Expert List</span></a></li>
    <li><a href='<?php echo base_url().index_page(); ?>admin/ask-the-expert/settings' <?php if(($this->uri->segment(3) == 'settings') || ($this->uri->segment(3) == 'settings_save')): ?>class="active"<?php endif; ?>><span>Settings</span></a></li>
</ul>