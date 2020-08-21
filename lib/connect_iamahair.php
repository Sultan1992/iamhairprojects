<?php

$conn = mysql_connect("localhost", "cocos", "hair123!@#");

if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("cocos_com")) {
     echo "Unable to select mydbname: " . mysql_error();
     exit;
 }
?>