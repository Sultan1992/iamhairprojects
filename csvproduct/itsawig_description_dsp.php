<?
include '../lib/session.php';
?>
<html>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

<table border="0" width="100%" height="100">
	<tr>
		<td>
		</td>
	</tr>
</table>

<?

$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';


$sql = "SELECT *  FROM  tmp_products";
$result = mysql_query($sql);
$j = 0;
while ($row = mysql_fetch_assoc($result)) {

	$t_product = $row[brand]." ".$row[fiber]." ".$row[featured_brand_name]." ".$row[hair_type]." - ".$row[item_name];
	$t_product = str_replace("'", "''", $t_product);
	$t_short_description = $t_product." ".$row[fiber]." hair ".$row[pattern]." ".$row[length]." Length Style ".$row[hair_type];

	$t_full_01 = $row[item_name]." ".$row[featured_brand_name]." ".$row[hair_type]." by ".$row[brand];
	$t_full_01 = str_replace("'", "''", $t_full_01);
	$t_full_02 = $row[brand]." ".$row[item_name]." ".$row[hair_type];
	$t_full_02 = str_replace("'", "''", $t_full_02);
	$t_full_05 = str_replace("It's a wig","It's a",$row[brand])." ".$row[hair_type];
	$t_full_05 = str_replace("'", "''", $t_full_05);
	$t_full_12 = str_replace(":",",",$row[all_color]);
	$t_full_13 = str_replace(":",",",$row[can_color]);

	$t_brand = str_replace("'", "''", $row[brand]);
	$sql2 = "SELECT * FROM  tmp_products_description
                where brand = '$t_brand' and site_gubun = '0'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_assoc($result2);

	$item_code = str_replace("'", "''", $row[item_code]);
	$item_name = str_replace("'", "''", $row[item_name]);
	$detail_description = str_replace(":",",",$row[detail_description]);
	$detail_description = str_replace("'", "''", $detail_description);
	$t_full_description = $row2[long_description];
	$t_full_description = str_replace("'", "''", $t_full_description);
	$t_full_description = str_replace("###", $t_full_01, $t_full_description);
	$t_full_description = str_replace("##2", $t_full_02, $t_full_description);
	$t_full_description = str_replace("##3", $item_code, $t_full_description);
	$t_full_description = str_replace("##4", $item_code, $t_full_description);
	$t_full_description = str_replace("##5", $t_full_05, $t_full_description);
	$t_full_description = str_replace("##6", $row[shown_color], $t_full_description);
	$t_full_description = str_replace("##7", $item_name, $t_full_description);
	$t_full_description = str_replace("##8", $row[hair_type], $t_full_description);
	$t_full_description = str_replace("##9", $row[fiber], $t_full_description);
	$t_full_description = str_replace("##10", $detail_description, $t_full_description);
	$t_full_description = str_replace("##11", $row[detail_logo], $t_full_description);
	$t_full_description = str_replace("##12", $t_full_12, $t_full_description);

echo $t_full_description;
$t_full_05 = str_replace("Lace Front", "Lace Front Wig", $t_full_05);
$t_full_05 = str_replace("Full Wig", "Full Cap", $t_full_05);
$t_full_05 = rtrim($t_full_05);
	$sql1 = "SELECT variant_id, variant FROM  cscart_product_feature_variant_descriptions
                where variant = '$t_full_05'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_assoc($result1);
echo $sql1."<br />";
echo $t_full_05."<br />";
echo $row1[variant_id]." : ".$row1[variant];


}
mysql_close();
?>
</html>