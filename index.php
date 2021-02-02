<?php
//include template file
    include "index.html";
    error_reporting(0);
            //connect database
        // we connect to localhost at port 3307
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "hacker_news_db";
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        //echo 'Connected successfully';

        //connect hacker news api via curl
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
    foreach($top as $item => $value)
    {
        //counter
        $x++;
        $item = $value;
        $url2 = "https://hacker-news.firebaseio.com/v0/item/$item.json?print=pretty";
        curl_setopt($curl, CURLOPT_URL, $url2);
        $resp = curl_exec($curl);
        $resp = json_decode($resp, true);


        $type = $resp["type"];
        $time = $resp["time"];
        $author = $resp["by"];
       // $text = $resp["text"];
        $site_url = $resp["url"];
        $title = $resp["title"];
        $comments = $resp["descendants"]; 
        $score = $resp["score"];

        //convert time to readable format
        $date = date_create();
        date_format($date, 'U = Y-m-d H:i:s') . "\n";
        
        date_timestamp_set($date, $time);
        $final_time = date_format($date, 'Y-m-d H:i:s') . "\n";

        //display/print to table
        print_r("<tr><td>".$x.". ".$resp["title"]."(".$resp['url'].")</td></tr>");
        echo '<tr><td><span class="small" id="small">' . $resp["score"]. " points |" . '</span>';
        echo '<span class="small" id="small">' ." by " . $resp["by"]." ". '</span>';
        echo '<span class="small" id="small">' ." " . $final_time ." |". '</span>';
        echo '<span class="small" id="small">' . $resp["descendants"]." comments" . '</span></td></tr>';

        //store in database
        //insert records into database
        $sql = "INSERT INTO $db.news(type, author, time, url, score, title, descendants) 
        VALUES ($type, $author, \"$time\", \"$site_url\", $score, \"$title\", \"$comments\")";
       
       /* if (mysqli_query($conn, $sql)) 
        {
            echo "New record created successfully";
        } 
        else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }*/

    }
   
    curl_close($curl);
    mysqli_close($conn);


//store in database

include "index-footer.html";