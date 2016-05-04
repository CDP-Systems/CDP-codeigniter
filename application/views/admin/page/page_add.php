<div class="content-container">
	<div style="background:#d1dde0;">
    	<div class="title">
				<h1>
				Page Manager
				</h1>
				<?php $this->load->view('admin/page/tabs'); ?>
			   <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div><!--end of title-->   
        <div class="clear"></div>
    </div>

	<div class="content-text"> 
        <form action="<?php echo base_url().index_page(); ?>admin/page/save" method="post" >
            <fieldset>
                <legend><b>Page Information</b></legend>
                <table cellpadding="0" border="0" cellspacing="20">
                <tr>
                    <td>Page Title</td>
                    <td>
						<?php echo form_error('page_title','<div class="red">','</div>'); ?>
						<input type='text' name='page_title' value="<?php echo set_value('page_title'); ?>" style="width: 450px;" />
					</td>
                </tr>
                <tr>
                    <td>URL key</td>
                    <td>
						<?php echo form_error('url_key','<div class="red">','</div>'); ?>
						<input type='text' name='url_key' value="<?php echo set_value('url_key'); ?>" style="width: 450px;" />
					</td>
                </tr>
                  <tr>
                    <td>Parent</td>
                    <td>
                        <select name="parent_id">
                        <option value="0">Home</value>
                        <?php foreach ($parents as $key => $value):?>
                            <option value="<?php echo $key;?>"><?php echo $value;?></option>
                        <?php endforeach;?>
                        </select>
                    </td>
                  </tr>
                <tr>
                    <td>Class</td>
                    <td>
                        <select name='class' >
                        <?php foreach($classes as $row): ?>
                            <?php if($row['class_name'] == 'page') $selected = "selected='selected'"; else $selected=''; ?>
                            <option <?php echo $selected; ?> value='<?php echo $row['class_name']; ?>'><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name='status'>
                        
                            <option value='1' <?php if(set_value('status')==='1')echo "selected='selected'" ?> >Enabled</option>
                            <option value='0' <?php if(set_value('status')==='0')echo "selected='selected'" ?> >Disabled</option>
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
                <legend style="margin-bottom:20px;"><b>Page Content</b></legend>
                <textarea name="page_content" id="page_content" ><?php echo set_value('page_content'); ?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'page_content' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
            </fieldset>
            <fieldset  style="margin-top:20px;">
                <legend><b>Meta Data</b> </legend>If you leave these fields blank, the global meta details will be applied.
                
                <table cellpadding="0" cellspacing="20" border="0">
                    <tr>
                      <td>Keywords </td>
                      <td><input type="text" name='meta_keywords' value="<?php echo set_value('meta_keywords'); ?>" style="width: 600px;" /></td>
                    </tr>
                    <tr>
                      <td>Description </td>
                      <td><input type="text"  name='meta_desc' value="<?php echo set_value('meta_desc'); ?>" style="width: 600px;" /></td>
                    </tr>
                </table>               
            </fieldset>
            <input type='submit' value='Save' class="green-btn" style="margin-top:20px;" />
        </form>
	</div><!--end of content-text-->
</div><!--end of content-container-->
