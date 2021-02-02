<?php
echo "<a href='https://'>Top Stories</a> |";
echo "<a href='https://'>New Stories</a> |";
echo "<a href='https://'>Best Stories</a> |";

$handle = curl_init();
 
$url = "https://hacker-news.firebaseio.com/v0/topstories.json?print=pretty";
 
// Set the url
curl_setopt($handle, CURLOPT_URL, $url);
// Set the result output to be a string.
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
 
$output = curl_exec($handle);
 $output = array($output);
curl_close($handle);
$count=0;
 foreach($output as $key=>$item){
     $count++;
    echo $count.".".$item;

 }

//store in database

