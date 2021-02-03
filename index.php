<?php
//include template file
include "views/index.html";
    //database connection file
    require_once('database.php');
    require('HackerNewsClone.php');
    //turn off error reporting/warnings/notices
    error_reporting(0);
   
    $api = new hackerNewsClone;

   // $api->connectAPI();
    $api->connectAPI();
  

    include "index-footer.html";