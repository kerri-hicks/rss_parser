<?php

// declare string to be used later
$rss_items = "" ; 

// The number of items you want to pull from the feed. 
$number_of_items = 6 ;

// URI of your feed
$url = "https://mystuff.xyz/feed.rss" ;

// use curl to get your data as a string named $feed
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, 2); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$feed = curl_exec($ch);
curl_close($ch);

if ($feed !='') {

  // change your time zone if appropriate
  date_default_timezone_set('America/New_York') ;

  // load the feed string into a variable and turn it into a simpleXML object for parsing
  $xml = simplexml_load_string($feed) ;

  // iterate through the items in the object, pulling out relevant information -- add your own fields as appropriate
  for($i = 0; $i < $number_of_items ; $i++){
    $title = $xml->channel->item[$i]->title ;
    $link = $xml->channel->item[$i]->link ;
    $description = $xml->channel->item[$i]->description ;
    $pubDate = $xml->channel->item[$i]->pubDate ;

    // convert the pubDate string to a timestamp
    $event_unix_timestamp = strtotime($pubDate) ;
    
    // set the timestamp to be human readable and pretty
    $display_date = date( 'F j \a\t g:i a', $event_unix_timestamp) ;

    // turn the feed back into a string that you display on a web page
    $rss_items .= "<span class='display_date'>$display_date</span><br /><a href='$link' class='link'>$title</a><br /><span class='description'>$description</span>";
  }
  
} else {
  $rss_items = "No data available." ;
}

echo $rss_items ; 

?>
