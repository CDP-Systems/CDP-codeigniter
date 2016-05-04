<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="noindex, nofollow">
    <title>{sitename} | Admin &#45; {title}</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/default/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/admin/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/admin/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('styles/admin/jquery.datepick.css');?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/styles/master.css" />
    
    <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>ckfinder/ckfinder.js"></script>
	
	 
	
    <script type="text/javascript" src="<?php echo site_url('js/jquery.min.js');?>"></script>    
    <script type="text/javascript" src="<?php echo site_url('js/jquery.datepick.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/js/calendar.js"></script>
    
    <!-- soratble tables -->
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
        var $j = jQuery.noConflict(); 
        $j(document).ready(function () {
            $j('.sortable').tablesorter();
        });
    </script> 

    <script type="text/javascript" src="<?php echo site_url('js/admin.js');?>"></script>   
</head>
<body>
    <div id="container">
            <div id="header">
            <div class="logo left"><a href="<?php echo base_url().index_page(); ?>admin"></a></div>
            <div class="top-links right">
                    <div class="right">
                    <p class="admin">Welcome <b><?php echo $this->session->userdata('username'); ?></b></p>
                    <!--<span class="mail"><a href="">4 new messages</a></span>-->
                </div>
            </div><!--end of top-links-->
            <!--

                    <h1><a href='<?php echo base_url(); ?>index.php/admin'>{sitename}</a></h1>
            -->
            </div><!--end of header-->
            <div class="clear"></div>

            <div id="main-nav" class="right">
                    <?php echo $this->load->view('admin/includes/menu'); ?>
            </div><!--end of main-nav-->

        <div class="clear"></div>


            <div id="<?php if(isset($dashboard)): ?>wrap<?php else: ?>content<?php endif; ?>">
            <div id="dashboard">
                    <div class="border-white">
                     <?php echo $this->load->view($content); ?>
                </div><!--end of border-white-->
            </div><!--end of dashboard-->
            </div><!--end of wrap-->

    </div><!--container-->

    <div style="width: 20px; height:20px;"></div>

    <div id='footer'>
            <div class="footer-text">
           <p>Copyright &copy; <?php echo date('Y'); ?>. <a href="http://www.mdnetsolutions.com" target="_blank">MDnetSolutions</a>. All Rights Reserved</p>
           </div><!--end of footer-text-->
    </div><!--end of footer-->

</body>
</html>