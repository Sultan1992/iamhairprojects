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


$sql = "SELECT *  FROM  tmp_products limit 20";
$result = mysql_query($sql);
$j = 0;
while ($row = mysql_fetch_assoc($result)) {

	$t_product = $row[brand]." ".$row[featured_brand_name]." ".$row[fiber]." ".$row[hair_type]." - ".$row[item_name];
	$t_product = str_replace("'", "''", $t_product);
	$t_short_description = $t_product." ".$row[fiber]." hair ".$row[pattern]." ".$row[length]." Length Style ".$row[hair_type];

	$t_full_01 = $row[item_name]." ".$row[featured_brand_name]." ".$row[hair_type]." by ".$row[brand];
	$t_full_01 = str_replace("'", "''", $t_full_01);
	$t_full_02 = $row[brand]." ".$row[featured_brand_name]." ".$row[item_name]." ".$row[hair_type];
	$t_full_02 = str_replace("'", "''", $t_full_02);
	$t_full_05 = $row[brand]." ".$row[hair_type];
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
	$t_full_description = str_replace("##5", $row[detail_logo], $t_full_description);
	$t_full_description = str_replace("##6", $t_brand, $t_full_description);
	$t_full_description = str_replace("##7", $item_name, $t_full_description);
	$t_full_description = str_replace("##8", $row[hair_type], $t_full_description);
	$t_full_description = str_replace("##9", $row[fiber], $t_full_description);
	$t_full_description = str_replace("##10", $row[pattern], $t_full_description);
	$t_full_description = str_replace("##11", $row[length], $t_full_description);
	$t_full_description = str_replace("##12", $detail_description, $t_full_description);

echo $t_full_description;

}
mysql_close();
?>
</html>