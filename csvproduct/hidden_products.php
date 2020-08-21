<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

<?
$company_id = $_POST['company_id'];
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];
$chk = $_POST['chk'];

include '../lib/connect_'.$gubun.'.php';

if($gubun == "iamahair"){
	$feature_id = 13;
} else {
	$feature_id = 156;
}

$sql = "SELECT * FROM  `cscart_product_descriptions` as a inner join `cscart_product_features_values` as b on a.product_id = b.product_id 
	 inner join `cscart_products` as c on a.product_id = c.product_id 
         where b.feature_id = $feature_id and b.variant_id = $company_id  and c.status = 'A' 
               order by a.product_id";

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

$ck = 'N';
while ($row3 = @mysql_fetch_assoc($result3)) {

$sql = "SELECT variant_name FROM  `cscart_product_option_variants_descriptions`  where variant_id = $row3[variant_id]";
$result7 = mysql_query($sql);
$row7 = mysql_fetch_assoc($result7);
if (strpos($row7[variant_name],"(Low)") == 0 ) {
	$ck = 'Y';
}

}

if ($ck == 'N') {
if ($chk == 'on') {
	$sql4 = "update cscart_products set amount = 0, status = 'H'   where tracking = 'B' and product_id = $row[product_id]";
	$result4 = mysql_query($sql4);
}
echo $row[product_id]."--".$row[product]."<br/>";

}
}

}
?>


</html>