<ul class="tab right">
    <li><?php echo anchor('admin/seo', '<span>SEO</span>', array('class' => isset($meta) ? $meta : ''));?></li>
    <li><?php echo anchor('admin/statistics', '<span>Basic Site Statistics</span>', array('class' => isset($basic) ? $basic : ''));?></li>
    <?php if($this->session->userdata('super_admin')): ?>
    <li><?php echo anchor('admin/seo/advanced', '<span>Advanced Site Statistics</span>', array('class' => isset($advanced) ? $advanced : ''));?></li>
    <?php endif;?>
</ul>
