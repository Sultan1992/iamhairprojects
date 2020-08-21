<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<table border="0" width="100%" height="100">
	<tr>
		<td>
		</td>
	</tr>
</table>

<?
$product_id = $_POST['product_id'];
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';

echo "==================================="."<br/>";
echo "Products+Description+Option관련 Table ".$product_id."  이상 Delete Start";echo "<br />";
echo "==================================="."<br/>";
if ($product_id != ""){
	$sql1 = "delete from cscart_products where product_id >= $product_id";
	$result1 = mysql_query($sql1);
	$sql1 = "delete from cscart_product_descriptions where product_id >= $product_id";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$sql1 = "delete from cscart_product_features_values where product_id >= $product_id";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$sql1 = "delete from cscart_products_categories where product_id >= $product_id";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$sql1 = "delete from cscart_seo_names where object_id >= $product_id";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$sql1 = "delete from cscart_product_prices where product_id >= $product_id";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

/// Products Option 관련 Table Delete
	$sql2 = "SELECT option_id FROM  cscart_product_options where product_id >= $product_id";
	$result2 = mysql_query($sql2);
	while ($row2 = mysql_fetch_assoc($result2)) {
		$sql3 = "SELECT variant_id FROM  cscart_product_option_variants where option_id = $row2[option_id]";
		$result3 = mysql_query($sql3);
		while ($row3 = mysql_fetch_assoc($result3)) {
			$sql1 = "delete from cscart_product_option_variants_descriptions 
				where variant_id = $row3[variant_id]";
			$result1 = mysql_query($sql1);
			echo $sql1."<br/>";
		}
		$sql1 = "delete from cscart_product_options_descriptions where option_id = $row2[option_id]";
		$result1 = mysql_query($sql1);
		echo $sql1."<br/>";
		$sql1 = "delete from cscart_product_option_variants where option_id = $row2[option_id]";
		$result1 = mysql_query($sql1);
		echo $sql1."<br/>";
	}
		$sql1 = "delete from cscart_product_options where product_id >= $product_id";
		$result1 = mysql_query($sql1);
		echo $sql1."<br/>";
}
mysql_close();
echo "==================================="."<br/>";
echo "Products+Description+Option관련 Table ".$product_id." 이상 DELETE 완료...";echo "<br />";
echo "==================================="."<br/>";


?>