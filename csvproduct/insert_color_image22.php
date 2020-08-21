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


	echo $row[product_id].",".$row[product].",".$row[product_code]."<br/>";



}
?>

</html>