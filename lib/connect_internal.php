<?php

$conn = mysql_connect("e7mile.com", "cocos", "hair123!@#");

if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("cocos_internal")) {
     echo "Unable to select mydbname (cocos_internal): " . mysql_error();
     exit;
 }
?>