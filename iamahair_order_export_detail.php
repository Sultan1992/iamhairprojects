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
<table border="0" width="100%" height="10">
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


<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<font color="#FFFFFF" size="3"><b>Date(yyyy/mm)&nbsp;&nbsp;</b></font>
<input size= "10" height="30" type="text" name="sdate" value="<?=$_GET['sdate'];?>" style=height:22px onfocus="this.select()"> ~ <input size= "10" height="30" type="text" name="edate" value="<?=$_GET['edate'];?>" style=height:22px onfocus="this.select()">
<input type="submit" value="search" style=height:22px>
</table>
</form>
<br><br>
&nbsp;&nbsp;<a  href="iamahair_order__1.php"  target="main">INV# Sorting</a>
&nbsp;&nbsp;<a href="iamahair_order__2.php"  target="main">Company Sorting</a>
&nbsp;&nbsp;<a  href="iamahair_stock_01.php"  target="main">Stock Check</a>
&nbsp;&nbsp;<a  href="iamahair_order__6.php?sdate=<?=$sdate?>&edate=<?=$edate?>"  target="main">ExpDate Query</a>
&nbsp;&nbsp;<a  href="iamahair_order_export.php?sdate=<?=$s_ym?>&edate=<?=$e_ym?>"  target="main">Export</a>
&nbsp;&nbsp;<a  href="iamahair_order_export_detail.php?sdate=<?=$s_ym?>&edate=<?=$e_ym?>"  target="main">Export Detail</a>
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?php

$sdate = $_GET['sdate'];
$edate = $_GET['edate'];
$gbn = $_GET['gbn'];
//$ct = count($ck);

include "lib/connect_iamahair.php";


if ($sdate == "" or $edate == "") {
	$sdate = date("Y/m",strtotime("-3 month"));
	$edate = date("Y/m",strtotime("-6 hours"));
}

?>

<table border="0" width="100%" height="10">
	<tr>
		<td>
	<h1 class="mainbox-title">
			iamahair.com -- Order Export Detail [ <?=$sdate;?> ]  ~ [ <?=$edate;?> ]<br>

	</h1><p>
		</td>
	</tr>
</table>

<?

$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  
	FROM  cscart_order_details as a	left JOIN cscart_orders as b on a.order_id = b.order_id
	where DATE_FORMAT(from_unixtime(b.timestamp),'%Y/%m') between '$sdate' and '$edate' 
	order by b.order_id desc";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1200" border-color="#f3f3f3" cellspacing="0">

  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Company</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Option</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Qty</td>
    <td height="16" align="center" bgcolor="#F4f4f4">User ID</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Phone</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Email</td>
    <td height="16" align="center" bgcolor="#F4f4f4">UPC</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>
  </tr>

<?

while ($row = mysql_fetch_assoc($result)) {


	$orderdate = date("m/d",$row[timestamp]);
	$order_yy = date("Y",$row[timestamp]);



?>
<tr>
    <td height="17" align="center"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[timestamp];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF">
<?

 $company = $row[product_code];
 $pos = strpos($company,"-");
 $company = substr($company,0,$pos);
 echo $company;
?></td>

    <td width="200" height="17" align="left" bgcolor="#FFFFFF">
<?php
/*
	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row2[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $row8[product];
*/
echo $row[product_code];

?></td>

    <td width="200" height="17" align="center" bgcolor="#FFFFFF">
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
 echo $color1." ,  ".$color2;

?></td>

<td height="17" widht="40" align="center" bgcolor="#FFFFFF"><b><?=$row[amount];?></b></td>

<td height="17" align="center" bgcolor="#FFFFFF"><?=$row[user_id];?></td>

<td width="150" height="17" align="left" bgcolor="#FFFFFF"><?=$row[s_firstname]." ".$row[s_lastname];?></td>

<td height="17" align="center" bgcolor="#FFFFFF"><?=$row[phone];?></td>

<td height="17" align="center" bgcolor="#FFFFFF"><?=$row[email];?></td>

    <td width="200" height="17" align="left" bgcolor="#FFFFFF">
<?php

 $color = str_replace('"', '', $color1);
 $color = trim(str_replace(' (Low)','',$color));
	$sql8 = "SELECT upc FROM  `tmp_product_upc` where product_code = '$row[product_code]' and color = '$color'";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $row8[upc];

?></td>

<td width="50" height="17" align="center" bgcolor="#FFFFFF"><?=$row[status];?></td>

</tr>
<?php
}
?>
</table>

</html>