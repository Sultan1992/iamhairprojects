<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Orders :: View orders - Administration panel</title>
<link href="/skins/basic/admin/images/icons/favicon.ico" rel="shortcut icon" />

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>
</head>

<body>
<table border="0" width="100%" height="55">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?
$ck = $_POST['ck'];
$sdate = $_POST['sdate'];
$edate = $_POST['edate'];
$ct = count($ck);


?>
<table border="0" width="100%" height="40">
	<tr>
		<td>

		</td>
	</tr>
</table>
<?

include "lib/connect_iamahair.php";

for($i=0;$i<$ct;$i++) {
	$str = $str.",".$ck[$i];
}
$str = substr($str,1);

if (!$ck[0]) {
	$str = 999999999;
}

if ($sdate == "" or $edate == "") {
	$sdate = '2014/01';
	$edate = '2020/12';
}

$sql = "SELECT *,DATE_FORMAT(from_unixtime(b.timestamp),'%Y/%m/%d') as timestamp  
	FROM  cscart_order_details as a	left JOIN cscart_orders as b on a.order_id = b.order_id
        where product_id in ($str) and DATE_FORMAT(from_unixtime(timestamp),'%Y/%m') between '$sdate'
	and '$edate' order by a.order_id desc";

$result = mysql_query($sql);

echo "[ ".$sdate." ~ ".$edate." ] -- Count : ".mysql_num_rows($result)."<br/>";

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1100" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Company</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product code</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Option</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Qty</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>

  </tr>
<?php

while ($row = mysql_fetch_assoc($result)) {



?>
<form method="post" action="./tmp_print.php">
<tr>
    <td height="30" align="center" bgcolor="#FFFFFF"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[timestamp];?></td>
    <td height="30" align="center" bgcolor="#E0FCF8"><?=$row[firstname]." ".$row[lastname];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF">
<?

 $company = $row[product_code];
 $pos = strpos($company,"-");
 $company = substr($company,0,$pos);
 echo $company;
?></td>
    <td width="200" height="30" align="center" bgcolor="#FFFFFF"><?=$row[product_code];?></td>
    <td width="200" height="30" align="center" bgcolor="#FFFFFF">
<?php

 $str=$row['extra'];

 $str1 = strstr($str, "variant_name");
 $str1 = strstr($str1, ":");
 $str1 = strstr($str1, ":");
 $pos = strpos($str1,";");
 $color1 = substr($str1,3,$pos-3);
 $color1 = str_replace(":", "", $color1);
 $str2 = substr($str1,20);
 $color2 = strstr($str2, "variant_name");
 $color2 = strstr($color2, ":");
 $color2 = strstr($color2, ":");
 $pos = strpos($color2,";");
 $color2 = substr($color2,3,$pos-3);
 $color2 = str_replace(":", "", $color2);
 if ($color1 == "" and $color2 == "") {

	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $row8[product];

 } else {
	echo $color1." ,  ".$color2;
 }

?></td>
<td height="30" widht="40" align="center" bgcolor="#F4f4f4"><?=$row[amount];?></td>

    <td align="center"  bgcolor="yellow">
<?
switch ($row["status"]) {
  case "C"  : ?>Complete<? break;
  case "P"  : ?>Processed<? break;
  case "O"  : ?>Open<? break;
  case "F"  : ?>Fail<? break;
  case "D"  : ?>Declined<? break;
  case "B"  : ?>Backordered<? break;
  case "I"  : ?>Canceled<? break;
  case "A"  : ?>In Transit<? break;
  case "G"  : ?>Partial Completed<? break;
  case "H"  : ?>Pending<? break;
  case "E"  : ?>Ready To Ship<? break;
}
?>
    </td>
</tr>
<?php
}
?>
</table>
 </form>

</html>