<style>
#wrap { margin: 20px 0 0; }
</style>
<div class="dash-container">
    <div class="title"><h1>Dashboard</h1></div>
    <!--NAV-->
    <div class="dash-nav">
        <div>
            <?php if(count($modules)): ?>
                <?php foreach($modules as $row): ?>
                <div class="blocks left">
                    <div class="block-title">
                        <div class="left" style="margin-right:10px; min-height: 70px;">
                            <img src="<?php echo base_url(); ?>images/admin/<?php echo $row['image']; ?>" border="0" />
                         </div>
                        <a href="<?php echo base_url().index_page(); ?>admin/<?php echo $row['url_key']; ?>">
                            <?php echo $row['name']; ?>
                        </a>
                    </div>
                    <div class="clear"></div>
                    <p><?php echo $row['desc']; ?></p>
                </div> 
                <?php endforeach; ?>
           <?php else: ?>
            <p>No modules found.</p>
           <?php endif; ?>
        </div>
    </div><!--end of dash-nav-->
</div><!--end of dash-container-->