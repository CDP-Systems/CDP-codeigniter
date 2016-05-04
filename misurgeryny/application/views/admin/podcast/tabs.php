<div style="background:#d1dde0;">
        <div class="title">
        <h1>
        	Podcast Manager  
			<?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>		
            	<!--&gt; Add-->
			<?php endif; ?>
        </h1>
                           
        <ul class="tab right">
           <li>
           <a href="<?php echo base_url().index_page(); ?>admin/podcast" <?php if(($this->uri->segment(2) == 'podcast') && !($this->uri->segment(3))): ?>class="active"<?php endif; ?>>
           	 <span>Manage MP3s</span>
           </a>
           </li>
           <li>
           <a href='<?php echo base_url().index_page(); ?>admin/podcast/add' <?php if(($this->uri->segment(3) == 'add') || ($this->uri->segment(3) == 'save')): ?>class="active"<?php endif; ?>>
           	 <span>Add</span>
           </a>
           </li>
		   <li>
           <a href='<?php echo base_url().index_page(); ?>admin/podcast/subscription' <?php if(($this->uri->segment(3) == 'subscription') || ($this->uri->segment(3) == 'save_subscription')): ?>class="active"<?php endif; ?>>
           	 <span>Subscription Text</span>
           </a>
           </li>
        </ul>
         <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div> 
        <div class="clear"></div>
</div>
   