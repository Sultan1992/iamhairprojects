<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Product Option Admin :: View Product - Administration panel</title>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

</head>

<body>
<table border="0" width="100%" height="25">
	<tr>
		<td>
		</td>
	</tr>
</table>
<br>
<br><br><br>

<?php

$color = $_POST['color'];
$color = str_replace(" ", "", $color);
$product_id = $_POST['product_id'];

echo "# Product ID : ".$product_id."<br />"."<br />";

if(!$color) {
 echo(" 
 <script> 
 window.alert('Please put the color!') 
 history.go(-1)
 </script> 
 ") ; 
 exit ; 
 }

$conn = mysql_connect("localhost", "cocos", "hair123!@#");

if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("cocos_com")) {
     echo "Unable to select mydbname: " . mysql_error();
     exit;
 }

$sql = "SELECT max(variant_id) as id FROM cscart_product_option_variants";
$result5 = mysql_query($sql);
$row5 = mysql_fetch_assoc($result5);
$option_variant_id = $row5[id] + 1;

$sql = "SELECT option_id FROM  cscart_product_options where product_id = $product_id";
$result = mysql_query($sql);

echo $color."<br />";

while ($row = mysql_fetch_assoc($result)) {

     echo "<br />"."Color option creation...."."<br />"."<br />";

     $sql = "select variant_id FROM cscart_product_option_variants where option_id = $row[option_id]";
     $result2 = mysql_query($sql);
     while ($row2 = mysql_fetch_assoc($result2)) {

        $sql = "delete FROM cscart_product_option_variants where variant_id = $row2[variant_id]";
echo $sql."<br />";
        $result3 = mysql_query($sql);
        $sql = "delete FROM cscart_product_option_variants_descriptions where variant_id = $row2[variant_id]";
echo $sql."<br />";
        $result4 = mysql_query($sql);

     }

	$pos = 10;
	$arraycolor = split(',',$color);
	for($i=0;$i< sizeof($arraycolor);$i++){
		$sql = "insert into cscart_product_option_variants
            	    (variant_id,option_id,position) values ($option_variant_id,$row[option_id],$pos)";
echo $sql."<br />";
		$result10 = mysql_query($sql);
// cscart_product_option_variants_descriptions
		$sql = "insert into cscart_product_option_variants_descriptions
            	    (variant_id,variant_name) values ($option_variant_id,'$arraycolor[$i]')";
echo $sql."<br />";
		$result20 = mysql_query($sql);
		$option_variant_id = $option_variant_id + 1;
		$pos = $pos + 10;		
	}
}
     echo "<br />"."Color option remake finished !!!"."<br />";

mysql_close($conn);
?>