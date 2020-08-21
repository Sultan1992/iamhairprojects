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
<table border="0" width="900" height="55">
	<tr>
		<td>
		</td>
	</tr>
</table>

<?
	$sdate = date("Y/m/d",strtotime("-6 hours"));
?>

&nbsp;&nbsp;<a  href="http://mycom/stock/shipping_insert.php"  target="main">Shipping Item Insert(WEB)</a>
&nbsp;&nbsp;<a  href="iamahair_shipping_qry.php?sdate=<?=$sdate?>&edate=<?=$sdate?>"  target="main">Tracking Number</a>
<table border="0" width="100%" height="26">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?

include "lib/connect_iamahair.php";

$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  `cscart_orders`
	where status in ('E') order by s_firstname asc";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="900" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer Notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Memo</td>
    <td height="16" align="center" bgcolor="#F4f4f4">SubTotal</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Shipment</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Shipping Address</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Button</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

$sql3 = "select * from tmp_order_m where order_id = $row[order_id]";
$result3 = mysql_query($sql3);
$row3 = mysql_fetch_assoc($result3);

$days = round(abs(strtotime(date('d-m-Y'))-strtotime($row[timestamp])-6)/86400);
?>

<tr>
    <td height="17" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" width="80" align="center" bgcolor="#F4f4f4">
<?

echo $row[timestamp];

if ( $days > 4 and $row3[remarks] == "") {
?>
<font color=red><b>
<?
echo "<br/>[".$days."]";
?></b></font><?
} else {
echo "<br/>[".$days."]";
}

?></td>
<form method="post" action="./tmp_write1.php">
<input type="hidden" name="item_id" value="<?=$row[item_id];?>">
<input type="hidden" name="order_id" value="<?=$row[order_id];?>">
<input type="hidden" name="gb" value="1">

<?

$b_name = $row[b_firstname]." ".$row[b_lastname];
$s_name = $row[s_firstname]." ".$row[s_lastname];

switch ($row["shipping_ids"]) {
  case 5  : ?><td width="120" height="17" align="center" bgcolor="red"><b><?=$s_name;?></b></td><? break;
  case 8  : ?><td width="120" height="17" align="center" bgcolor="red"><b><?=$s_name;?></b></td><? break;
  case 10  : ?><td width="120" height="17" align="center" bgcolor="FFFF00"><b><?=$s_name;?></br>(DON'T USE USPS BOX)</b></td><? break;
  case 13  : ?><td width="120" height="17" align="center" bgcolor="red"><b><?=$s_name;?></b></td><? break;
  case 14  : ?><td width="120" height="17" align="center" bgcolor="red"><b><?=$s_name;?></b></td><? break;
  case 15  : ?><td width="120" height="17" align="center" bgcolor="FFFF00"><b><?=$s_name;?></br>**UPS**</b></td><? break;
  default  : ?><td width="120" height="17" align="center" bgcolor="#F4f4f4"><?=$s_name;?></td><? break;

}

?>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="notes" rows="5" cols="20"><?=$row[notes];?></textarea></td>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="remarks" rows="5" cols="20"><?=$row3[remarks];?></textarea></td>

<?if ($row[subtotal] < 150) {?>
    <td height="17" align="center" bgcolor="#F4f4f4"><?="$".$row[subtotal];?></td>
<?}else{?>
    <td height="17" align="center" bgcolor="black"><font color="white"><b><?="$".$row[subtotal];?></b></font></td>
<?
}
?>

<?
$sql = "select shipping from cscart_shipping_descriptions where shipping_id = $row[shipping_ids]";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_assoc($result4);
?>
    <td height="17" width="180" align="center" bgcolor="#F4f4f4"><?=$row4[shipping]."<br/>( $".$row["shipping_cost"]." )";?></td>
<?if ($b_name != $s_name) {?>
    <td height="17" width="400" bgcolor="#00FFFF"><?=$row[s_address];?></td>
<?}elseif ($row["b_address"] != $row["s_address"]) {
?>
    <td height="17" width="400" bgcolor="#FFFF00"><?=$row[s_address];?></td>
<?}else{?>
    <td height="17" width="400" bgcolor="#F4F4F4"><?=$row[s_address];?></td>
<?
}
?>
    <td height="17" align="center" bgcolor="#F4f4f4">

	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input type="submit" value="Submit"/></span>
		</div>

	</div></td>
</tr>
 </form>
<?php
}
?>
</table>
</html>