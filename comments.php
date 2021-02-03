<?php
error_reporting(0);
//include template file
include "views/index.html";
$curl = curl_init();
 
    $url = "https://hacker-news.firebaseio.com/v0/topstories.json?print=pretty";
 
    // Set the url
    curl_setopt($curl, CURLOPT_URL, $url);
    // Set the result output to be a string.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
    $output = curl_exec($curl);
    //$output = array($output);
    //echo $output;

    //split data using explode function
    $top = explode(",", $output);
    $top = preg_replace('/[^A-Za-z0-9\-]/', '', $top);

    //print_r($top);
    //foreach($top as $item)
    $x=0;
    echo "Comments";

    foreach($top as $item => $value)
    {
        //counter
        $x++;
        $item = $value;
        $url2 = "https://hacker-news.firebaseio.com/v0/item/$item.json?print=pretty";
        curl_setopt($curl, CURLOPT_URL, $url2);
        $resp = curl_exec($curl);
     
        $resp = json_decode($resp, true);

      //display/print to table
      echo '<tr><td><strong>' . $resp["title"]." ". '</strong>';

      echo '<p>' ." by " . $resp["by"]." ". '</p>';
      echo '<p>'  . $resp["text"]." ". '</p></td></tr>';


    }
   
    curl_close($curl);
    include "index-footer.html";



