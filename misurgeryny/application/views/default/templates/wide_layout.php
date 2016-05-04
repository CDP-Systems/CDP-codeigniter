<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php $this->load->view('default/includes/head'); ?>
    </head>

    <body id="article">
        <!-- .wrap -->
        <div class="wrap">
            <!-- #header -->
            <?php $this->load->view('default/includes/header'); ?>
            <!-- #header ends -->

            <!-- #main-menu -->
            <div id="main-menu"></div>
            <!-- #main-menu ends -->

            <!-- .page -->
            <div class="page">        
                <!-- #content -->
                <div id="content">
                    <!-- .region -->
                    <div class="region">
                        <!-- #main-column -->
                        <div id="main-column" class="left">
                            <h1><?php echo $title; ?></h1>
                            <div><?php $this->load->view($page); ?></div>                 
                        </div>
                        <!-- #main-column ends -->

                        <div class="clear"></div>
                    </div>
                    <!-- .region ends -->
                </div>
                <!-- #content ends -->            
            </div>
            <!-- .page ends -->

            <!-- #footer -->
            <?php $this->load->view('default/includes/footer-wide'); ?>
            <!-- #footer ends -->
        </div>
        <!-- .wrap ends -->
    </body>
</html>