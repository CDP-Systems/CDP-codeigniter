<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="" />
<title><?php echo $website['name']; ?> | <?php echo $title; ?></title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/default/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/admin/style.css" />
</head>
<style>
body { margin: 0; }
</style>
<body class="bg-login">

<div id='wrapper' style="margin: 95px auto 0; width: 960px;">
	
    <div style="margin: 0 auto; text-align:center;">
    	<?php if($website['site_logo']): ?>
   			 <img src="<?php echo base_url(); ?>uploads/admin/<?php echo $website['site_logo']; ?>" border="0" title="<?php echo $website['name']; ?>" />     
        <?php endif; ?>
   </div>
	<!--div style="text-align:center; color: #fff; margin-bottom: 40px;"><h1>{sitename}</h1></div-->
	<div id='login' style="margin: 0 auto; width: 300px; margin-top: 40px; color: #fff">    
    <form action='<?php echo base_url().index_page(); ?>admin/login/do_login' method='post'>
    
    	<table cellpadding="0" cellspacing="05" border="0">
        	 <tr>
              <td colspan="2"> <?php if(isset($error)): ?><p style="color: #f93d3d; text-align:center; border: 1px solid #f93d3d; padding: 10px 0"><i>Invalid Usename or Password.</i></p><?php endif ?></td>  
            </tr>
        	<tr>
              <td><h2>Login</h2></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Username</td>
              <td><input type='text' name='username' style="margin-left: 20px; width: 150px;" /></td>
            </tr>
            <tr>
              <td>Password</td>
              <td><input type='password' name='password' style="margin-left: 20px; width: 150px;" /></td>
            </tr>
            <tr height="50px">
              <td>&nbsp;</td>
              <td align="right"><input type='submit' value='Submit' class="green-btn" /></td>
            </tr>
        </table>
		</form>
        
        <table cellpadding="0" cellspacing="0">
        	<tr>
            	<td width="220px" style="background: url(<?php echo base_url(); ?>images/admin/login-home-icon.png) no-repeat; line-height: 15px; padding-left: 20px"><a href='<?php echo base_url().index_page(); ?>' style="color: #fff">&laquo; Back to home</a></td>                
                <td width="280px" style="background: url(<?php echo base_url(); ?>images/admin/login-password-icon.png) no-repeat; line-height: 15px; padding-left: 20px"><a href='<?php echo base_url().index_page(); ?>admin/forgot-password' style="color: #fff">Forgot your password?</a></td>            
            </tr>        
        </table>  
   
	</div>
</div>
</body>
</html>
