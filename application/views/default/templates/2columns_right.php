<?php
$ci =& get_instance();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>        

	<!--[if IE 7]>
   	<link rel="stylesheet" type="text/css" href="<?php echo $css_dir;?>/default/ie7.css" />
 	<![endif]-->

        <?php echo $this->load->view('default/includes/head');?>

    </head>

<body>



<!-- wrap -->

<div class="wrap">



	<!-- outline bg -->

    <div id="outline-bg">

    

    	<!-- container -->

        <div id="container">

        

	     <!-- header -->

            <div id="header">

            	<!--logo -->

                <div id="logo" class="left"><a href="<?php echo base_url();?>"></a></div>

                <!--logo ends -->

                

			<?php echo $this->load->view('default/includes/header');?>



            </div>

            <!-- header ends -->

            

            <div class="clear"></div>            

            

 		<?php echo $this->load->view('default/includes/main-nav');?>

            

            <div class="clear"></div>

            

            <!-- home banner -->

            <?php echo $this->load->view('default/includes/inner-banner');?>

            <!-- home banner -->           

           

            

            <!-- content -->

            <div id="content">    

                    

            	<!-- right content -->

                <div class="right-content left">

                

				<?php echo $this->load->view('default/includes/breadcrumbs');?>

                    

                    <div class="clear"></div>

                

                	<h1><?php echo $title;?></h1>

                   	<div><?php $this->load->view($page); ?></div>                    

                    

                </div>

                <!-- right content ends -->        

                

                <!-- inner sidebar -->

			<?php echo $this->load->view('default/includes/inner-sidebar');?>                

                <!-- inner sidebar ends -->    

                

                <div class="clear"></div>

            

            </div>

            <!-- content ends -->    

            

            <div class="clear"></div>

        

        </div>

        <!-- container ends -->

        

        <!-- content btm -->

        <div><img src="<?php echo $image_dir;?>/default/content-btm.png" border="0" /></div>

        <!-- content btm -->

        

       <!-- footer--> 

            	<?php echo $this->load->view('default/includes/footer');?>

			<!-- footer ends --> 

        

        <div class="clear"></div>

    

    </div>

    <!-- outline bg -->

    

    <div class="clear"></div>

    

    <!-- footer btm -->

    <div id="footer-btm"></div>

    <!-- footer btm ends -->



</div>

<!-- wrap ends -->



</body>

</html>

