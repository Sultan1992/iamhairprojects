<?php
$conn = mysql_connect("localhost", "ehair", "depot123!@#");

if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("ehair_db")) {
     echo "Unable to select mydbname: " . mysql_error();
     exit;
 }
?>