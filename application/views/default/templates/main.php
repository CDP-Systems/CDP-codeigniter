<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>        

        <?php echo $this->load->view('default/includes/head');?>
        
        <!-- Anything Slider -->
        <script type="text/javascript">
function formatText(index, panel) {
  return index + "";
}
$(function () {    
	$('.anythingSlider').anythingSlider({
		easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
		autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
		delay: 4000,                    // How long between slide transitions in AutoPlay mode
		startStopped: false,            // If autoPlay is on, this can force it to start stopped
		animationTime: 600,             // How long the slide transition takes
		hashTags: true,                 // Should links change the hashtag in the URL?
		buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
		pauseOnHover: false,             // If true, and autoPlay is enabled, the show will pause on hover
		startText: "Go",             // Start text
		stopText: "Stop",               // Stop text
		navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
	});
	
	$("#slide-jump").click(function(){
		$('.anythingSlider').anythingSlider(6);
	});        
});
</script>

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

             

           		<?php echo $this->load->view('default/includes/main-nav.php');?>

            

            <div class="clear"></div>

            

            <!-- home banner -->

            <div id="home-banner">
            
            <div class="anythingSlider">
                <div class="wrapah">
                <ul>
                    <li><img src="<?php echo $image_dir;?>/default/banners/banner-1.jpg" alt="" /></li>
                    <li><img src="<?php echo $image_dir;?>/default/banners/banner-2.jpg" alt="" /></li
                     <li><img src="<?php echo $image_dir;?>/default/banners/banner-3.jpg" alt="" /></li>
                    <li><img src="<?php echo $image_dir;?>/default/banners/banner-4.jpg" alt="" /></li>
                    <li><img src="<?php echo $image_dir;?>/default/banners/banner-5.jpg" alt="" /></li
                </ul>
                </div>
            </div>

            
         
            
            </div>

            <!-- home banner -->

            

            	<?php echo $this->load->view('default/includes/callouts');?>

            

            <div class="clear"></div>

            

            <!-- content -->

            <div id="content">    

                

		<!-- right content -->    

		<div class="right-content left">

	

			<h1><?php echo $title;?></h1>

                   	<div><?php $this->load->view($page); ?></div>

		<div class="green-btn"><a href="<?php echo base_url();?>meet-dr-teixeira">Learn more about us</a></div>

						

		</div>

            	

      

               <!-- right content ends -->

				

                <!-- home sidebar -->

                <?php echo $this->load->view('default/includes/home-sidebar');?>

                <!-- home sidebar ends -->    

            

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