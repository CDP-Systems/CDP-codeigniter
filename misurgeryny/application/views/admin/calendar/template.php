<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<base href="<?=base_url();?>" />
<link rel="stylesheet" href="<?= base_url();?>assets/styles/master.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?= base_url();?>assets/styles/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script src="<?= base_url();?>assets/js/calendar.js" type="text/javascript"> </script>

</head>
<body>
<div id="container">

<div id="navcontainer">
<ul>
<li><?php echo anchor('calendar/create', 'Add Events to Calendar');?> </li>
<li><?php echo anchor('calendar/index/', 'Show Site Calendar');?></li>

</ul>
</div>
<div id="header">
    <?php $this->load->view($main);?>

  </div>
</body>
</html>



