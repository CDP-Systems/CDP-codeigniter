<script type='text/javascript'>
	function updateUrlkey(){
		var ans = confirm("Are you sure you want to change the URL of this page? This might affect the navigation or break links on the site.");
		
	}

</script>

<style>
#hide { display: none; }
</style>

<div class="content-container">
	<div style="background:#d1dde0;">
    	<div class="title">
			<h1>Page Manager</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
	</div>
    
    <div class="content-text">
    <ul class="options">
      <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/page'>Back</a></li>
    </ul>
    <div class="clear"></div>
    
    <div class='errors' style="margin-bottom:20px">
    <?php echo validation_errors(); ?>
    </div>
    
    <form action="<?php echo base_url().index_page(); ?>admin/page/update" method="post" >
    
    <?php if($this->session->userdata('super_admin')) { ?>

    <input type='hidden' value='<?php echo $page['id_page']; ?>' name='id_page' />
    <fieldset>
    	<legend><b>Page Information</b></legend>
        <table cellpadding="0" cellspacing="20" border="0">
          <tr>
            <td>Page Title</td>
            <td><input type='text' name='page_title' value="<?php echo $page['page_title']; ?>" style="width: 450px;" /></td>
          </tr>
          <tr>
            <td>URL key</td>
            <td><input onclick='updateUrlkey();' type='text' name='url_key' value="<?php echo $page['url_key']; ?>" style="width: 450px;" /></td>
          </tr>
          <tr>
            <td>Parent</td>
            <td>
                <select name="parent_id">
                <option value="0">Home</value>
                <?php foreach ($parents as $key => $value):
                        $selected = '';
                        if ($page['parent_id'] == $key)
                        {
                            $selected = 'selected="selected"';
                        }

                        if ($key != $page['id_page']):
                ?>
                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $value;?></option>
                <?php endif; endforeach;?>
                </select>
            </td>
          </tr>

          <?php /////TEMPORARY ?>
	  <?php if($this->session->userdata('super_admin')): ?>
          <tr>
            <td>Class</td>
            <td>
            <select name='class' >
            <?php foreach($classes as $row): ?>
            <?php if($row['class_name'] == $page['class']) $selected = "selected='selected'"; else $selected=''; ?>
            	<option <?php echo $selected; ?> value='<?php echo $row['class_name']; ?>'><?php echo $row['name']; ?></option>
            <?php endforeach; ?>
            </select>
            </td>
          </tr>
          <?php endif; ///end of TEMPORARY ?>
          <tr class="status_field">
            <td>Status</td>
            <td>
            <select name='status'>
            	<option value='1' <?php if($page['status']==='1')echo "selected='selected'" ?> >Enabled</option>
                <option value='0' <?php if($page['status']==='0')echo "selected='selected'" ?> >Disabled</option>
            </select>
            </td>
          </tr>
          <tr>
            <td>Related Pages</td>
            <td>
            <select name="related_pages[]" multiple size="10">
            <?php
			$related_pages = json_decode($page['related_pages']);
			if (count($pages) > 0) foreach ($pages as $_page):?>
                <option value="<?php echo $_page['id_page'];?>" <?php if (!is_null($related_pages) && in_array($_page['id_page'], $related_pages)) echo "selected='selected'";?>>
                <?php echo $_page['page_title'];?>
                </option>
            <?php endforeach;?>
            </select>
            </td>
          </tr>
        </table>
    </fieldset>
    
    <fieldset>
    	<legend><b style="line-height:40px">Page Content</b></legend>
        <textarea name="page_content" id="page_content" ><?php echo $page['content']; ?></textarea>
		<script type='text/javascript'>
		var editor = CKEDITOR.replace( 'page_content' );
		CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' );
        </script>
	</fieldset>
        
        <div style="height:20px;"></div>
        
	<fieldset>
        <legend>Meta Data</legend> If you leave these fields blank, the global meta details will be applied.
        <table cellpadding="0" cellspacing="20" border="0">
          <tr>
            <td>Keywords</td>
            <td><input type="text" name='meta_keywords' value="<?php echo $page['keywords']; ?>" style="width: 600px;" /></td>
          </tr>
          <tr>
            <td>Description</td>
            <td> <input type="text" name='meta_desc' value="<?php echo $page['desc']; ?>" style="width: 600px;" /></td>
          </tr>
        </table>
    </fieldset>
    
    <table cellpadding="0" cellspacing="20" border="0" >
      <tr>
        <td><input type='submit' value='Save' class="green-btn" /></td>
        <td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url(); ?>index.php/admin/page"' /></td>
      </tr>


    </table>

   <?php } else {?> 

        <input type='hidden' value='<?php echo $page['id_page']; ?>' name='id_page' />
        <fieldset>
    	<legend><b>Page Information</b></legend>
        <table cellpadding="0" cellspacing="20" border="0">
          <tr>
            <td>Page Title</td>
            <td><input type='text' name='page_title' value="<?php echo $page['page_title']; ?>" style="width: 450px;" /></td>
          </tr>
          <tr id="hide">
            <td>URL key</td>
            <td><input onclick='updateUrlkey();' type='text' name='url_key' value="<?php echo $page['url_key']; ?>" style="width: 450px;" /></td>
          </tr>
          <tr id="hide">
            <td>Parent</td>
            <td>
                <select name="parent_id">
                <option value="0">Home</value>
                <?php foreach ($parents as $key => $value):
                        $selected = '';
                        if ($page['parent_id'] == $key)
                        {
                            $selected = 'selected="selected"';
                        }

                        if ($key != $page['id_page']):
                ?>
                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $value;?></option>
                <?php endif; endforeach;?>
                </select>
            </td>
          </tr>

          <?php /////TEMPORARY ?>
	  <?php if($this->session->userdata('super_admin')): ?>
          <tr>
            <td>Class</td>
            <td>
            <select name='class' id="hide" >
            <?php foreach($classes as $row): ?>
            <?php if($row['class_name'] == $page['class']) $selected = "selected='selected'"; else $selected=''; ?>
            	<option <?php echo $selected; ?> value='<?php echo $row['class_name']; ?>'><?php echo $row['name']; ?></option>
            <?php endforeach; ?>
            </select>
            </td>
          </tr>
          <?php endif; ///end of TEMPORARY ?>
          <tr class="status_field" id="hide">
            <td>Status</td>
            <td>
            <select name='status'>
            	<option value='1' <?php if($page['status']==='1')echo "selected='selected'" ?> >Enabled</option>
                <option value='0' <?php if($page['status']==='0')echo "selected='selected'" ?> >Disabled</option>
            </select>
            </td>
          </tr>
          <tr>
            <td>Related Pages</td>
            <td>
            <select name="related_pages[]" multiple size="10">
            <?php
			$related_pages = json_decode($page['related_pages']);
			if (count($pages) > 0) foreach ($pages as $_page):?>
                <option value="<?php echo $_page['id_page'];?>" <?php if (!is_null($related_pages) && in_array($_page['id_page'], $related_pages)) echo "selected='selected'";?>>
                <?php echo $_page['page_title'];?>
                </option>
            <?php endforeach;?>
            </select>
            </td>
          </tr>
        </table>
    </fieldset>
    
    <fieldset>
    	<legend><b style="line-height:40px">Page Content</b></legend>
        <textarea name="page_content" id="page_content" ><?php echo $page['content']; ?></textarea>
		<script type='text/javascript'>
		var editor = CKEDITOR.replace( 'page_content' );
		CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' );
        </script>
	</fieldset>
        
        <div style="height:20px;"></div>
        
	<fieldset id="hide">
        <legend>Meta Data</legend> <p id="hide">If you leave these fields blank, the global meta details will be applied.</p>
        <table cellpadding="0" cellspacing="20" border="0" id="hide">
          <tr>
            <td>Keywords</td>
            <td><input type="text" name='meta_keywords' value="<?php echo $page['keywords']; ?>" style="width: 600px;" /></td>
          </tr>
          <tr>
            <td>Description</td>
            <td> <input type="text" name='meta_desc' value="<?php echo $page['desc']; ?>" style="width: 600px;" /></td>
          </tr>
        </table>
    </fieldset>
    
    <table cellpadding="0" cellspacing="20" border="0" >
      <tr>
        <td><input type='submit' value='Save' class="green-btn" /></td>
        <td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url(); ?>index.php/admin/page"' /></td>
      </tr>


    </table>

   <?php } ?>

    </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
