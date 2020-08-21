<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

<?
$product_id = $_POST['product_id'];
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';

$sql = "SELECT * FROM  `cscart_product_descriptions` where product_id >= $product_id limit 1000";

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
<table border="1" width="800" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="30" align="center" bgcolor="#F4f4f4">Product ID</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Product Name</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Status</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

	$sql2 = "SELECT status FROM  cscart_products  where product_id = $row[product_id]";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_assoc($result2);
?>
<tr>


    <td width="10%" height="30" align="center" bgcolor="#FFFFFF"><?
if($gubun == "iamahair"){
	?><a href="http://iamahair.com/myadmin.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank"><?=$row[product_id];?></a><?
}else{
	?><a href="http://ehairdepot.com/ehair.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank"><?=$row[product_id];?></a><?
}
?></td>
    <td height="20" align="left" bgcolor="#FFFFFF"><?=$row[product];?></td>

<?
if ($row2[status] == "H") {
?>    <td height="20" align="center" bgcolor="yellow"><?=$row2[status];?></td> <?
}elseif ($row2[status] == "D") {
?>    <td height="20" align="center" bgcolor="red"><?=$row2[status];?></td> <?
}else{
?>    <td height="20" align="center" bgcolor="#FFFFFF"><?=$row2[status];?></td> <?
}

}
?>
</tr>
</table>
</html>