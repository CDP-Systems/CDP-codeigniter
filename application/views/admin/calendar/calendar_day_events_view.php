<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<base href="<?=base_url();?>" />
<link rel="stylesheet" href="<?= base_url();?>css/style.css" type="text/css" media="screen" charset="utf-8" />
</head>

<body>
  <div id="container">

<div id="logo"><a href="index.html"><img src="img/logo.png" width="172" height="58" alt="logo" /></a></div>
<div id="navcontainer">
<ul>
<li><?php echo anchor('calendar/create', 'Add Events to Calendar');?> </li>
<li><?php echo anchor('calendar/index/', 'Show Site Calendar');?></li>

</ul>
</div>
<div id="header">
  <?php 
  // print_r ($dayevents);
  	foreach ($dayevents as $dayevent){
  		echo "<div class=\"dayevents\">";
  		echo "<h3>Event date: </h3>";
  		echo $dayevent['eventDate'];
  		echo "<br />\n";
  		echo "<h3>Event Title: </h3>";
  		echo $dayevent['eventTitle'];
  		echo "<br />\n";
  		echo "<h3>Event Content: </h3>";
  		echo $dayevent['eventContent'];
  		echo "</div>";
  	}
  		
  
  ?>
	
 </div>
  
 




<div id="footer">&copy; My Company &bull; Telephone: 99 99 99 99 &bull; My address goes here <br />Template by: <a href="http://www.csstemplateheaven.com">CssTemplateHeaven</a></div>


</body>
</html>