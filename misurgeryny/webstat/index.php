<?php
//dv at josheli.com
		if ($_GET['hash'] != base64_encode(date('Ymd') . 'MahalNaAraw'))
		{
			//exit();
		}
		$user = 'mddemo';//your cpanel username
		//$pass = 'th3romanjun0';//your cpanel password
		$pass = 'MahalNaAraw';//your cpanel password
		$domain = 'mdnetdemo.com';//your domain name do not include 'http://' or 'www.'
		
		/*
		NO NEED TO TOUCH ANYTHING BELOW HERE
		*/		
		
		//it's a .png file...
		if(strpos($_SERVER['QUERY_STRING'],'.png')!==false) {
		  $fileQuery = $_SERVER['QUERY_STRING'];
		}
		//probably first time to access page...
		elseif(empty($_SERVER['QUERY_STRING'])){
		  $fileQuery = "awstats.pl?config=$domain";
		}
		//otherwise, all other accesses
		else {
		  $fileQuery = 'awstats.pl?'.$_SERVER['QUERY_STRING'];
		}
		
		//now get the file
		$file = getFile($fileQuery,$user, $pass, $domain);

		//check again to see if it was a .png file
		//if it's not, replace the links
		if(strpos($_SERVER['QUERY_STRING'],'.png')===false) {
		  $file = str_replace('awstats.pl', basename($_SERVER['PHP_SELF']), $file);
		  $file = str_replace('="/images','="'.basename($_SERVER['PHP_SELF']).'?images',$file);
		}
		//if it is a png, output appropriate header
		else {
		  header("Content-type: image/png");
		}
		
		//output the file
		echo $file;	
	
	
		//retrieves the file, either .pl or .png
	function getFile($fileQuery,$user, $pass, $domain){			
		return file_get_contents("http://$user:$pass@$domain:2082/".$fileQuery);

	//	return file_get_contents("http://$domain:2082/".$fileQuery);
	}	