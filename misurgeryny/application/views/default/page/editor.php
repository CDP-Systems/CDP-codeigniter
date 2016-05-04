<script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/config.js"></script>

<script type='text/javascript'>
//<![CDATA[

var editor;
function createEditor(){  
	jQuery('#editLink').hide();
	jQuery('#saveLink').show();
	jQuery('.cancelLink').show();
	if ( editor )
		return;
	var html = document.getElementById( 'editorcontents' ).innerHTML;
	editor = CKEDITOR.appendTo('editor');
	editor.setData(html);
	CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' );
	jQuery('#editorcontents').hide();
	jQuery('#loading').show(function(){
		jQuery('#loading').fadeTo(1500,100,function(){
			jQuery('#loading').fadeOut(function(){
				jQuery('#editor').fadeIn('slow');			
			});
		});
	});	
}

function removeEditor()
{	
	jQuery('#editLink').show();
	jQuery('#saveLink').hide();
	jQuery('.cancelLink').hide();
	if ( !editor )
		return;
	jQuery('#editor').fadeOut('slow',function(){
		editor.destroy();
		editor = null;	
		jQuery('#editorcontents').fadeIn('slow');
	});
}
function saveEditor(){
	jQuery('#editLink').show();
	jQuery('#saveLink').hide();
	jQuery('.cancelLink').hide();
	if ( !editor )
		return;
	var content = editor.getData();
	var url_key = jQuery('#url_key').val();
	saveData(url_key, content);
	jQuery('#editor').fadeOut();
	jQuery('#saving').fadeIn();	
}
function saveData(url_key, content){
	jQuery.post('<?php echo base_url().index_page(); ?>default/page/save_page', {url_key: url_key, content: content},
		function(data){
			if(data != 'false'){
				jQuery('#saving').fadeTo(1500,100,function(){
					jQuery('#saving').fadeOut(function(){
						jQuery('#editor').fadeOut(function(){
							editor.destroy();
							editor = null;
							jQuery('#editorcontents').html(data);	
							jQuery('#editorcontents').fadeIn('slow');
						});			
					});
				});
			}else{
				alert('error');
			}
		}
	);
}
//]]>


</script>

<a id="editLink" href="javascript:void(0);" onClick="createEditor();" >Edit</a> 
<a id="saveLink" style="display:none;" href="javascript:void(0)" onclick="saveEditor();">Save</a>
<span class="cancelLink" style="display:none;">|</span> <a class="cancelLink" style="display:none;" href="javascript:;" onclick="removeEditor();">Cancel</a>
<br /><br />
<input type="hidden" id="url_key" name="url_key" value="<?php echo $url_key; ?>">
<div id="loading" style="display:none; position: relative; text-align: left; height: 35px;"><img style='vertical-align: middle' src="<?php echo base_url(); ?>images/ajax-loader.gif" /> Loading Editor...</div>
<div id="saving" style="display:none;"><img style='vertical-align: middle' src="<?php echo base_url(); ?>images/ajax-loader.gif" /> Saving Data...</div>
<div id="editor" style="display:none;"></div>