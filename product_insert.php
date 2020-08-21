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

$sql = "select * from tmp_products";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
	echo $row[brand];echo "<br />";
	echo $row[fiber];echo "<br />";
	echo $row[item_code];echo "<br />";
}
mysql_close();
?>