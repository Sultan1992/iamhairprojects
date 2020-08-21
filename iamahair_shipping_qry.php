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

<body onload="document.form1.keyword.focus()">
<table border="0" width="100%" height="20">
	<tr>
		<td>
		</td>
	</tr>
</table>

<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<font color="#FFFFFF" size="3"><b>Traking Number&nbsp;&nbsp;</b></font>
<input height="30" type="text" name="keyword" value="<?=$_GET['keyword'];?>" style=height:22px onfocus="this.select()">
<input type="submit" value="search" style=height:22px>
</table>

<br><br><br>

<?
$keyword = $_GET['keyword'];
$sdate = $_GET['sdate'];
$edate = $_GET['edate'];

include "lib/connect_iamahair.php";



$i = 0;

if ($_GET['keyword'] == "") {
$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%Y/%m/%d') as timestamp FROM  cscart_shipments
	 where DATE_FORMAT(from_unixtime(timestamp),'%Y/%m/%d') between '$sdate'
	and '$edate' order by DATE_FORMAT(from_unixtime(timestamp),'%Y/%m/%d') desc";
} else {
$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%Y/%m/%d') as timestamp FROM  cscart_shipments
	 where tracking_number like '%$keyword%' order by DATE_FORMAT(from_unixtime(timestamp),'%Y/%m/%d')  desc limit 100";
}

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
 } else {

?>
<table border="1" width="800" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">No.</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Shipping Date</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Order ID</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Total</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Shipping Method</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Traking Number</td>

  </tr>
<?php
$amt = 0;

while ($row = mysql_fetch_assoc($result)) {

$i = $i + 1;

$sql = "SELECT max(order_id) as order_id FROM  cscart_shipment_items
	 where shipment_id = $row[shipment_id]";
$result2 = mysql_query($sql);
$row2 = mysql_fetch_assoc($result2);

$sql = "SELECT shipping FROM  cscart_shipping_descriptions
	 where shipping_id = $row[shipping_id]";
$result3 = mysql_query($sql);
$row3 = mysql_fetch_assoc($result3);

$sql = "SELECT s_firstname,s_lastname,total FROM  cscart_orders
	 where order_id = $row2[order_id]";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_assoc($result4);

?>
<tr>
    <td height="10" width="50" align="center" bgcolor="#FFFFFF"><?=$i;?></td>
    <td height="30" width="100" align="center" bgcolor="#FFFFFF"><?=$row[timestamp];?></td>

    <td height="30" width="100" align="center" bgcolor="#FFFFFF"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row2[order_id];?>" target="_blank">#<?=$row2[order_id];?></a></td>

    <td height="30" width="200" align="left" bgcolor="#FFFFFF"><?=$row4[s_firstname]." ".$row4[s_lastname];?></td>
    <td height="30" width="200" align="center" bgcolor="#FFFFFF"><?=$row4[total];?></td>
    <td height="30" width="200" align="center" bgcolor="#FFFFFF"><?=$row3[shipping];?></td>

<?  if (substr($row[tracking_number],0,2) == "1Z" ) { ?>
    <td height="30" width="200" align="center" bgcolor="#FFFFFF"><a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=<?=$row[tracking_number];?>" target="_blank"><?=$row[tracking_number];?></a></td>
<? } else { ?>
    <td height="30" width="200" align="center" bgcolor="#FFFFFF"><a href="https://tools.usps.com/go/TrackConfirmAction_input?origTrackNum=<?=$row[tracking_number];?>" target="_blank"><?=$row[tracking_number];?></a></td>
<? } ?>

</tr>
<?php
$amt = $amt + $row4[total];
}
?>
<tr>
    <td colspan="4" bgcolor="#f3f3f3"></td>   
    <td bgcolor="#f3f3f3" align="center"><h1 class="mainbox-title"><?=$amt;?></h1></td>
    <td colspan="2" bgcolor="#f3f3f3"></td>
<?
}
?>
</table>
<table border="0" width="800" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
<div class="float-center">Date(yyyy/mm/dd) <input height="10" type="text" name="sdate" value="<?=$_GET['sdate'];?>" style=height:22px onfocus="this.select()"> ~ <input height="10" type="text" name="edate" value="<?=$_GET['edate'];?>" style=height:22px onfocus="this.select()"></div>
</td></tr>
</table>
 </form>

</html>