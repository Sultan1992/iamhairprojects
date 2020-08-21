<?php

$product_id = $_POST['product_id'];
$product_new = $_POST['product_new'];
$feature_id = $_POST['feature_id'];
$variant_id = $_POST['variant_id'];

$ct = count($product_id);

include "lib/connect_iamahair.php";

for($i=0;$i<$ct;$i++) {
if ($product_new[$i] != "") {
	$sql = "update cscart_product_features_values set product_id = $product_new[$i] where product_id = $product_id[$i] 
             and feature_id = $feature_id[$i] and variant_id = $variant_id[$i]";
	$result = mysql_query($sql);
//echo $sql."<br/>";
	$row = @mysql_fetch_assoc($result);
}
}
mysql_close();
echo "<script language='JavaScript'>alert('It has been changed.');history.back(); </script>";
?>