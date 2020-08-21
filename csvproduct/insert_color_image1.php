<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

<?
$company_id = $_POST['company_id'];
$product_sid = $_POST['product_sid'];
$product_eid = $_POST['product_eid'];
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';

if($gubun == "iamahair"){
	$feature_id = 13;
} else {
	$feature_id = 156;
}

$sql = "SELECT * FROM  `cscart_product_descriptions` as a inner join `cscart_product_features_values` as b on a.product_id = b.product_id 
	 inner join `cscart_products` as c on a.product_id = c.product_id 
         where b.feature_id = $feature_id and b.variant_id = $company_id  and c.status = 'A' 
               and a.product_id  between $product_sid and $product_eid order by a.product_id limit 1000";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="0" width="700" height="130">
	<tr>
		<td width="350" align="center"><h4>- Work Site : <?=$gubun;?></h4></td>
		<td width="350" align="center"><h4>- Vendor : <?=$vendor;?></h4></td>
	</tr>
</table>

<?php
while ($row = mysql_fetch_assoc($result)) {

$sql = "SELECT a.option_id FROM  `cscart_product_options` as a inner join `cscart_product_options_descriptions` as b on a.option_id = b.option_id 
         where b.option_name = '1st Color' and a.product_id = $row[product_id]";
$result1 = mysql_query($sql);
$row1 = @mysql_fetch_assoc($result1);

if (@mysql_num_rows($result1) != 0) {

$sql = "SELECT variant_id FROM  `cscart_product_option_variants`  where option_id =$row1[option_id] order by position";
$result3 = mysql_query($sql);

$cnt1 = 0;

while ($row3 = @mysql_fetch_assoc($result3)) {

$sql = "SELECT count(*) as cnt FROM  `cscart_images_links`  where object_id =$row3[variant_id] and object_type='variant_image'";
$result4 = mysql_query($sql);
$row4 = @mysql_fetch_assoc($result4);
$cnt1 = $row4[cnt];
//if ($cnt1 == 0) {
$sql = "SELECT variant_name FROM  `cscart_product_option_variants_descriptions`  where variant_id = $row3[variant_id]";
$result7 = mysql_query($sql);
$row7 = mysql_fetch_assoc($result7);

$color1 = str_replace("/", "",$row7[ variant_name]);
$color1 = str_replace("-", "",$color1);
$color1 = str_replace(".", "",$color1);
$color1 = str_replace(" (Low)", "",$color1);
$color1 = trim($color1);

	echo $row[product_id].",".$color1."<br/>";
}
//}

}

}
?>

</html>