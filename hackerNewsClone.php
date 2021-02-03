<?php
    //database connection file
    require('database.php');
    //turn off error reporting/warnings/notices
    error_reporting(0);
class hackerNewsClone
{
   
   public static function connectAPI()
   {
    //connect hacker news api via curl
    $curl = curl_init();
    //hacker news api url to connect
    $url = "https://hacker-news.firebaseio.com/v0/topstories.json?print=pretty";
 
    // Set the url
    curl_setopt($curl, CURLOPT_URL, $url);
    // Set the result output to be a string.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
    $output = curl_exec($curl);
    //$output = array($output);
    //echo $output;

    //split data using explode function
    //remove any characters in the response
    $top = explode(",", $output);
    $top = preg_replace('/[^A-Za-z0-9\-]/', '', $top);

    foreach($top as $item => $value)
    {
        //counter
        $x++;
        $item = $value;
        $url2 = "https://hacker-news.firebaseio.com/v0/item/$item.json?print=pretty";
        curl_setopt($curl, CURLOPT_URL, $url2);
        $resp = curl_exec($curl);
        $resp = json_decode($resp, true);

        
        //declare and store endpoints
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
        echo("<tr><td>".$x.". ".$resp["title"]."(<a href='$site_url'>".$resp['url']."</a>)</td></tr>");
        echo '<tr><td><span class="small" id="small">' . $resp["score"]. " points |" . '</span>';
        echo '<span class="small" id="small">' ." by " . $resp["by"]." ". '</span>';
        echo '<span class="small" id="small">' ." " . $final_time ." |". '</span>';
        echo '<span class="small" id="small"><a href=comments.php?$item>' . $resp["descendants"]." comments" . '</a></span></td></tr>';

        //store in database
        //insert records into database
        $sql = "INSERT INTO news(author, time, url, score, title, descendants) 
        VALUES (\"$author\", \"$time\", \"$site_url\", \"$score\", \"$title\", \"$comments\")";
       
       //verify insert
        if (mysqli_query($conn, $sql)) 
        {
            "New record created successfully";
        } 
        else 
        {
            "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }

    curl_close($curl);

    mysqli_close($conn);

}
//store in database
}