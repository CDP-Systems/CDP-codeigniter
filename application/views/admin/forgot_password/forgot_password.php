<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="" />
<title>{sitename} | {title}</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/admin/style.css" />
</head>
<body class="bg-login">

<div id='wrapper' style="margin: 0 auto; width: 960px; margin-top: 100px;">
	
    <div style="margin: 0 auto; text-align:center"><img src="<?php echo base_url(); ?>images/admin/teixeira-logo.png" border="0" /></div>
	<!--div style="text-align:center; color: #fff; margin-bottom: 40px;"><h1>{sitename}</h1></div-->
	<div id='login' style="margin: 0 auto; width: 300px; margin-top: 40px; color: #fff">   
    <h2 style="line-height: 25px; font-size: 17px;">Forgot your username or password?</h2>
    <?php if(isset($error)): ?>
    	<p style="color: white;"><?php echo $error; ?></p>
    <?php elseif(isset($msg)): ?>
    	<p style="color: white;"><?php echo $msg; ?></p>
	<?php endif; ?>
      <form action='<?php echo base_url().index_page(); ?>admin/forgot-password/retrieve' method='post'>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td><p style="color: #fff">Email Address </p></td>
          <td><input type='text' name='email' style="margin-left: 20px;" /></td>
        </tr> 
        <tr>
          <td>&nbsp;</td>
          <td align="right"><p style="margin-top:0"><input type='submit' value='Retrieve Password' class="green-btn-large" /></p></td>
        </tr> 
        <tr>
          <td>&nbsp;</td>
          <td align="right"><a href='<?php echo base_url().index_page(); ?>admin/login' style="color: #fff;">&laquo; Back to Login</a></td>
        </tr>
    </table>
		
	</form>
    
	</div>
</div>
</body>
</html>
