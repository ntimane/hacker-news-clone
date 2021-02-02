<?php
//include template file
include "index.html";
$curl = curl_init();
 
    $url = "https://hacker-news.firebaseio.com/v0/newstories.json?print=pretty";
 
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
    foreach($top as $item => $value)
    {
        //counter
        $x++;
        $item = $value;
        $url2 = "https://hacker-news.firebaseio.com/v0/item/$item.json?print=pretty";
        curl_setopt($curl, CURLOPT_URL, $url2);
        $resp = curl_exec($curl);
        $resp = json_decode($resp, true);

        print_r($x.". ".$resp["title"]."(".$resp['url'].")<br>");
        echo '<span class="small" id="small">' ."by " . $resp["by"]." ". '</span>';
        echo '<span class="small" id="small">' . $resp["score"]." points" . '</span>';
        echo "<br>";

    }
   
    curl_close($curl);
    include "index-footer.html";



