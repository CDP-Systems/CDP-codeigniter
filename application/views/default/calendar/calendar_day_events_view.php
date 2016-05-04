<?php


echo '<a href="javascript: history.go(-1);">Back to calendar</a>' . '<br /><br />';

// print_r ($dayevents);
foreach ($dayevents as $dayevent){  		
    echo "<h3>Event date: </h3>";
    echo $dayevent['eventDate'];
    echo "<br />\n";
    echo "<h3>Event Title: </h3>";
    echo $dayevent['eventTitle'];
    echo "<br />\n";
    echo "<h3>Event Content: </h3>";
    echo $dayevent['eventContent'];
    echo "<hr />";
}