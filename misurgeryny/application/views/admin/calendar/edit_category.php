<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script src="<?php echo $js_dir;?>/ifx.js" type="text/javascript"></script>
<script src="<?php echo $js_dir;?>/idrop.js" type="text/javascript"></script>
<script src="<?php echo $js_dir;?>/idrag.js" type="text/javascript"></script>
<script src="<?php echo $js_dir;?>/iutil.js" type="text/javascript"></script>
<script src="<?php echo $js_dir;?>/islider.js" type="text/javascript"></script>

<script src="<?php echo $js_dir;?>/color_picker.js" type="text/javascript"></script>


<link href="<?php echo $css_dir;?>/colorpicker/color_picker.css" rel="stylesheet" type="text/css">
<!-- compliance patch for microsoft browsers -->

<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php echo $js_dir;?>/colorpicker/color_picker-ie6.css" type="text/css">
<![endif]-->
<!--[if gte IE 7]>
	<link rel="stylesheet" href="<?php echo $js_dir;?>/colorpicker/color_picker-ie7.css" type="text/css">
<![endif]-->


<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title left">
                <h1>Calendar Manager</h1>
        </div>
        <?php $this->load->view('admin/calendar/tabs', array('category_add' => 'active'));?>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <form action="" method="POST">
            <div>
                <label for="name">Category Name:</label>
                <input type="text" name="category_name" />
            </div>
            <div>
                <label for="color">Category Color:</label>
                <input type="text" name="category_color" id="myhexcode" value="" style="width:60px;">
                <a href="javascript:void(0);" rel="colorpicker&objcode=myhexcode&objshow=myshowcolor&showrgb=1&okfunc=myokfunc" style="text-decoration:none" >
                    <div id="myshowcolor" style="width:15px;height:15px;border:1px solid black">&nbsp;</div>
                </a>
            </div>
            <div><input type="submit" name="submit" value="Save" /></div>
        </form>
    </div>
</div>
<script type="text/javascript">

	function myokfunc(){
		alert("This is my custom function which is launched after setting the color");
	}
	//init colorpicker:
	$(document).ready(
		function()
		{
                    $.ColorPicker.init();
		}
	);
</script>