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

$product_sid = $_POST['product_sid'];

include '../lib/connect_iamahair.php';

echo "=================================";echo "<br />";


$sql = "SELECT count(*) as cnt FROM  tmp_product_upc where product_code = '$product_sid'";
$result20 = mysql_query($sql);
$row20 = mysql_fetch_assoc($result20);

if ($row20[cnt] == 0) {

$sql = "SELECT * FROM  cscart_products 	where product_code = '$product_sid'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

	echo "<br />";
	$sql = "SELECT *  FROM cscart_product_descriptions where product_id = $row[product_id]";
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_assoc($result1);

	$sql = "SELECT *  FROM cscart_product_options where product_id = $row[product_id]";
	$result2 = mysql_query($sql);

	while ($row2 = mysql_fetch_assoc($result2)) {

		$sql = "SELECT *  FROM cscart_product_options_descriptions 
			where option_id = '$row2[option_id]' and  option_name = '1st Color'";
		$result3 = mysql_query($sql);
		$row3 = mysql_fetch_assoc($result3);

		$sql = "SELECT *  FROM cscart_product_option_variants 
			where option_id = $row3[option_id]";
		$result4 = mysql_query($sql);
		while ($row4 = @mysql_fetch_assoc($result4)) {

			$sql = "SELECT *  FROM cscart_product_option_variants_descriptions 
				where variant_id = $row4[variant_id]";
			$result5 = mysql_query($sql);
			$row5 = mysql_fetch_assoc($result5);
			$str = str_replace("'", "''", $row1[product]);
			$sql = "insert into tmp_product_upc (product_id,color,product_name,product_code) values
	 			($row[product_id],'$row5[variant_name]','$str','$row[product_code]')";
			$result6 = mysql_query($sql);
  			echo $row[product_id]." : ".$row5[variant_name]." : ".$row[product_code]."<br/>";

		}
	}
}

echo "=================================";echo "<br />";
echo "iamahair UPC Insert finished";echo "<br />";


mysql_close();
//echo "<script>history.go(-1);</script>";
?>