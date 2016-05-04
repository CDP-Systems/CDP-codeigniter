<?php if(count($podcasts)): ?>
<?php
	/**
   |------------------------------------
   | Assemble the XML code for PLAYLIST
   |------------------------------------
   */
	$playlist_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
	$playlist_xml.="<songs>\r\n";
	foreach($podcasts as $item){
	 $playlist_xml.= sprintf(" <display>\r\n");
     $playlist_xml.= sprintf(" <id>%s</id>\r\n", $item['id_podcast']);
     $playlist_xml.= sprintf(" <title>%s</title>\r\n", $item['title']);
     $playlist_xml.= sprintf(" <author>%s</author>\r\n", $item['author']);
     $playlist_xml.= sprintf("<url>".base_url()."uploads/podcasts/%s</url>\r\n",$item['file_name']);
     $playlist_xml.= " </display>\r\n";
	}
	$playlist_xml.="</songs>";
	// Write the XML code 
   $playlist_xml_path = str_replace('system/','',BASEPATH).'podcast/playlist.xml'; 
   write_file($playlist_xml_path, $playlist_xml);
   
   /**
   |------------------------------------
   | Assemble the XML code for FEED
   |------------------------------------
   */
   $feed_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
   $feed_xml.="<rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\" xmlns:feedburner=\"http://rssnamespace.org/feedburner/ext/1.0\">\r\n";
   $feed_xml.= sprintf( "<title>".$sitename."</title>\r\n");
   $feed_xml.= sprintf("<link>".base_url()."</link>\r\n");
   $feed_xml.= sprintf("<description>".$desc."</description>\r\n");
   $feed_xml.="<channel>\r\n";
   foreach($podcasts as $item){
	$feed_xml.= sprintf("<item>\r\n");
	$feed_xml.= sprintf(" <title>%s</title>\r\n", $item['title']);
	$feed_xml.= sprintf(" <link>".base_url()."uploads/podcasts/%s</link>\r\n", $item['file_name']);
	$feed_xml.=sprintf("<description>%s</description>\r\n",$item['desc']);
	$feed_xml.= sprintf("<language>en-us</language>\r\n"); 
	$feed_xml.= sprintf("</item>\r\n");
   }
   $feed_xml.="</channel>\r\n";
   $feed_xml.="</rss>\r\n";
   // Write the XML code 
   $feed_xml_path = str_replace('system/','',BASEPATH).'podcast/feed.xml'; 
   write_file($feed_xml_path, $feed_xml);
?>
	<iframe src="<?php echo base_url(); ?>podcast/podcast.html" width="100%" height="260" frameborder="0" scrolling="no"></iframe>
	<div><?php echo $subscription_text; ?></div>
	<br />
	<div><a href="<?php echo base_url(); ?>podcast/feed.xml" target="_blank"><img src="<?php echo base_url(); ?>images/default/rss_feed_button.gif" style="border:none;" alt="Go to RSS Feed"/></a></div>
	<br />
<?php else: ?>
<p>No podcasts found.</p>
<?php endif; ?>