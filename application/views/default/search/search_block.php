<?php echo form_open('search/construct', array('name' => 'search_block')); ?>
<div id="search"> 
    <table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td><input type="button" onclick='document.search_block.submit();' class="left" /></td>
        <td><input name="search" type="text"  value="search our site" class="left" /></td>
            
        </tr>
    </table>
    <div class="fold"><img src="<?php echo base_url(); ?>images/default/search-fold.png" width="10" height="10"></div>
</div>
<?php echo form_close(); ?>
