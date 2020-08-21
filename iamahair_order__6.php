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

<body onload="document.form1.sdate.focus()">
<table border="0" width="100%" height="55">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?
	$sdate = date("m/d",strtotime("-1 week 6 hours"));
	$edate = date("m/d",strtotime("-6 hours"));

	$s_ym = date("Y/m",strtotime("-3 month"));
	$e_ym = date("Y/m",strtotime("-6 hours"));
?>
&nbsp;&nbsp;<a  href="iamahair_order__1.php"  target="main">INV# Sorting</a>
&nbsp;&nbsp;<a  href="iamahair_order__4.php"  target="main">Select Page</a>
&nbsp;&nbsp;<a  href="iamahair_stock_01.php"  target="main">Stock Check</a>
&nbsp;&nbsp;<a  href="iamahair_order__6.php?sdate=<?=$sdate?>&edate=<?=$edate?>"  target="main">ExpDate Query</a>
&nbsp;&nbsp;<a  href="iamahair_order_export.php?sdate=<?=$s_ym?>&edate=<?=$e_ym?>"  target="main">Export</a>
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table><br>


<form name="form1" action="<?=$_SERVER[PHP_SELF]?>" target="main">
<table border="0" width="100%" height="5"><div class="float-center">ExpDate(mm/dd) <input height="10" size="5" type="text" name="sdate" value="<?=$_GET['sdate'];?>" style=height:22px onfocus="this.select()"> ~ <input height="10" size="5" type="text" name="edate" value="<?=$_GET['edate'];?>" style=height:22px onfocus="this.select()">
<input type="submit" value="search" style=height:22px></div>
</table>
</form>
<br>

<?

include "lib/connect_iamahair.php";

$s_orderid = 0;

$sdate = $_GET['sdate'];
$edate = $_GET['edate'];
$c_Y = date("Y",strtotime("-5 days 6 hours"));

$sql = "SELECT *  FROM  `tmp_order` where order_id > $s_orderid
        and expire_dt between '$sdate' and '$edate' order by order_id asc";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1300" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Company</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product code</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Option</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Qty</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrdDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">ExpDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Staff only notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">B.O. notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>
<!--
    <td height="16" align="center" bgcolor="#F4f4f4">Phone</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>
-->
  </tr>
  
<?php


while ($row = mysql_fetch_assoc($result)) {


$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  `cscart_orders`
        where order_id = $row[order_id]";
$result1 = mysql_query($sql);
$row1 = mysql_fetch_assoc($result1);

$sql = "SELECT *  FROM  `cscart_order_details`
        where order_id = $row[order_id] and item_id = $row[item_id]";
$result11 = mysql_query($sql);
$row11 = mysql_fetch_assoc($result11);

$sql22 = "SELECT sum(amount) as amount FROM  `cscart_shipment_items` where item_id = $row[item_id] 
           and order_id = $row[order_id]";
$result22 = mysql_query($sql22);
$row22 = mysql_fetch_assoc($result22);
if (mysql_num_rows($result22) == 0 or $row11[amount] != $row22[amount]) {


$temp = $row11[product_code];
$sql5 = "SELECT * FROM  `cscart_images` where image_path like '$temp%'";
$result5 = mysql_query($sql5);

if (mysql_num_rows($result5) != 0) {
$row5 = mysql_fetch_assoc($result5);
$sql6 = "SELECT * FROM  `cscart_images_links` where detailed_id = $row5[image_id]";
$result6 = mysql_query($sql6);
$row6 = mysql_fetch_assoc($result6);
$sql7 = "SELECT * FROM  `cscart_seo_names` where object_id = $row6[object_id] and type = 'p'";
$result7 = mysql_query($sql7);
$row7 = mysql_fetch_assoc($result7);
}

if (substr($row1[timestamp],6,4) == $c_Y) {

?>
<tr>
<!--
    <td height="17" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.print_invoice&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
-->

    <td height="17" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><?=$row1[timestamp];?></td>
    <td height="17" align="center" bgcolor="#F4f4f4">
<?

 $company = $row11[product_code];
 $pos = strpos($company,"-");
 $company = substr($company,0,$pos);
 echo $company;
?></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4"><?if (mysql_num_rows($result5) != 0) {?><a href="http://iamahair.com/<?=$row7[name].'.html';?>" target="_blank"><?}?><?=$row11[product_code];?></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4">
<?php

 $str=$row11['extra'];

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

 if (mysql_num_rows($result11) == 0) {
	echo "*************";
 } elseif ($color1 == "" and $color2 == "") {

	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row11[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);

	echo $row8[product];

 } else {
	echo $color1." ,  ".$color2;
 }

?></td>

<?
switch ($row1["shipping_ids"]) {
  case 5  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row11[amount]-$row22[amount];?></b></td><? break;
  case 8  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row11[amount]-$row22[amount];?></b></td><? break;
  case 13  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row11[amount]-$row22[amount];?></b></td><? break;
  case 14  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row11[amount]-$row22[amount];?></b></td><? break;
  default  : ?><td height="17" widht="40" align="center" bgcolor="#F4f4f4"><?=$row11[amount]-$row22[amount];?></td><? break;

}
?>
    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="ord_dt" value="<?=$row[order_dt];?>"></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="exp_dt" value="<?=$row[expire_dt];?>"></td>

<input type="hidden" name="item_id" value="<?=$row[item_id];?>">
<input type="hidden" name="order_id" value="<?=$row[order_id];?>">
<input type="hidden" name="gb" value="2">
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="notes" rows="5" cols="20"><?=$row1[notes];?></textarea></td>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="details" rows="5" cols="20"><?=$row1[details];?></textarea></td>
    <td width="100" height="17" align="center" bgcolor="#F4f4f4"><textarea name="remarks" rows="5" cols="12"><?=$row[remarks];?></textarea></td>

    <td width="100" height="17" align="center" bgcolor="#F4f4f4">
<?
switch ($row1["status"]) {
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

?></td>

<?
}
}
?>

</tr>
<?php
//}
}


?>
</table>

</html>