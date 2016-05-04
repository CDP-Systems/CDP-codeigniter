<?php $ci =& get_instance();?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>{sitename} | {title}</title>

<meta name="description" content="{desc}" />
<meta name="keywords" content="{keywords}" />
<meta name="robots" content="{robots}" />
<link rel="shortcut icon" href="<?php echo $image_dir;?>/default/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/master.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/jquery.datepick.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/tabcontent.css" />



<script type="text/javascript">
    var BASE_URL = "<?php echo base_url();?>";
    var CURR_MODULE = "<?php if (is_subclass_of($ci, 'MY_Controller')) echo $ci->get_current_module();?>";
    var ROOT_PAGE = "<?php if (is_subclass_of($ci, 'MY_Controller')) echo $ci->uri->segment(1);?>";
</script>


<script type="text/javascript" src="<?php echo $js_dir;?>/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $js_dir;?>/jquery.datepick.js"></script>
<script type="text/javascript" src="<?php echo $js_dir;?>/scripts.js"></script>
<script type="text/javascript" src="<?php echo $js_dir;?>/calendar.js"></script>

<!-- jQuery validation -->
<script type="text/javascript" src="<?php echo $js_dir;?>/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $js_dir;?>/validate.js"></script>
<!-- jQuery validation ends -->

<!-- Image Lightbox -->
<script src="<?php echo $js_dir;?>/lightbox/jquery-1.6.1.min.js" type="text/javascript"></script>
<!--script src="<?php echo $js_dir;?>/lightbox/jquery.lint.js" type="text/javascript" charset="utf-8"></script-->
<link rel="stylesheet" href="<?php echo $css_dir;?>/lightbox.css" type="text/css" media="screen" charset="utf-8" />
<script src="<?php echo $js_dir;?>/lightbox/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<!-- Image Lightbox ends -->

<script type="text/javascript" src="<?php echo $js_dir;?>/default/tabcontent/tabcontent.js"></script>

<!-- Any Link CSS Menu -->
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/anylinkcssmenu.css" />
<script type="text/javascript" src="<?php echo $js_dir;?>/default/anylinkcssmenu/anylinkcssmenu.js"></script>

<!-- slider -->
<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/slider.css" />
<script type="text/javascript" src="<?php echo $js_dir;?>/default/slider/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $js_dir;?>/default/slider/jquery.easing.1.2.js"></script>
<script type="text/javascript" src="<?php echo $js_dir;?>/default/slider/jquery.anythingslider.js"></script>
<!-- slider ends -->


<!-- DD Accordion 
ddaccordion.init({
	headerclass: "level-1", //Shared CSS class name of headers group
	contentclass: "level-2", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content.
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["closed", "open"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix",
				 "<img style='height: 14px;' src='<?php echo $image_dir?>/default/icon-arrow-open.png' /> ",
				 "<img style='height: 14px;' src='<?php echo $image_dir?>/default/icon-arrow-close.png' /> "],
				//Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
-->














