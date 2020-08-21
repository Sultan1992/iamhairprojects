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

<script type="text/JavaScript"> 
function chkBox(bool) {  
 var obj = document.getElementsByName("gbn"); 
 obj.checked = bool; 
} 

</script>

<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<font color="#FFFFFF" size="3"><b>Date(yyyy/mm)&nbsp;&nbsp;</b></font>
<input size= "10" height="30" type="text" name="sdate" value="<?=$_GET['sdate'];?>" style=height:22px onfocus="this.select()"> ~ <input size= "10" height="30" type="text" name="edate" value="<?=$_GET['edate'];?>" style=height:22px onfocus="this.select()">
<input type="submit" value="search" style=height:22px><font color="#FFFFFF" size="3"></font>&nbsp;&nbsp;-----<input size= "1" height="30"  type="checkbox" name="gbn" onclick=chkBox(this.checked)"><font color="#FFFFFF"><b>ALL</b></font>&nbsp;&nbsp;
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
			iamahair.com -- Order Export [ <?=$sdate;?> ]  ~ [ <?=$edate;?> ]<? if($gbn==on) echo "--- ALL"; ?><br>

	</h1><p>
		</td>
	</tr>
</table>

<?

if ($gbn != on) {
$sql = "SELECT order_id, user_id, timestamp, total, subtotal, shipping_cost, details, firstname, lastname, email,
	b_address, b_address_2,	b_city, b_state,b_country, b_zipcode, phone, status, payment_id
	FROM  cscart_orders
        where status in ('C','P','A') and DATE_FORMAT(from_unixtime(timestamp),'%Y/%m') between '$sdate' and '$edate'
	order by order_id asc";
} else {
$sql = "SELECT order_id, user_id, timestamp, total, subtotal, shipping_cost, details, firstname, lastname, email,
	b_address, b_address_2,	b_city, b_state,b_country, b_zipcode, phone, status, payment_id
	FROM  cscart_orders
        where DATE_FORMAT(from_unixtime(timestamp),'%Y/%m') between '$sdate' and '$edate'
	order by order_id asc";
}
$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="900" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="20" align="center" bgcolor="#f4f4f4">Order ID</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Year</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Order Date</td>
    <td height="20" align="center" bgcolor="#F4f4f4">User ID</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Firstname</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Lastname</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Email</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Total</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Subtotal</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Shipping Cost</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Address_1</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Address_2</td>
    <td height="20" align="center" bgcolor="#f4f4f4">City</td>
    <td height="20" align="center" bgcolor="#f4f4f4">State</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Country</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Zipcode</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Phone</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Notes</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Status</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Payment</td>
  </tr>
<?

while ($row = mysql_fetch_assoc($result)) {

	$orderdate = date("m/d",$row[timestamp]);
	$order_yy = date("Y",$row[timestamp]);
$sql2 = "SELECT payment FROM  `cscart_payment_descriptions` where payment_id = $row[payment_id]";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($result2);

?>
<tr>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[order_id];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$order_yy;?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$orderdate;?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[user_id];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[firstname];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[lastname];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[email];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[total];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[subtotal];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[shipping_cost];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[b_address];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[b_address_2];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[b_city];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[b_state];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[b_country];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[b_zipcode];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[phone];?></td>
    <td height="30" align="left" bgcolor="#FFFFFF"><?=$row[details];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[status];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row2[payment];?></td>
</tr>
<?php
}
?>
</table>

</html>