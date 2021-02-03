<?php
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

?>