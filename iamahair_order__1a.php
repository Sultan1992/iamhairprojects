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
 body {margin: 0px 0px 0px 10px;}
</style>

<script language="JavaScript">
 <!--
 function op(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
 {
 toolbar_str = toolbar ? 'yes' : 'no';
 menubar_str = menubar ? 'yes' : 'no';
 statusbar_str = statusbar ? 'yes' : 'no';
 scrollbar_str = scrollbar ? 'yes' : 'no';
 resizable_str = resizable ? 'yes' : 'no';
 window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
 }

 // -->
 </script>

</head>

<body>
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
<a href="iamahair_order__2.php"  target="main">Company Sorting</a>&nbsp;&nbsp;<a  href="iamahair_order__4.php"  target="main">Select Page</a>
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
<?

include "lib/connect_iamahair.php";
include "lib/connect_internal.php";

$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  `cscart_orders`
	where status in ('P','B','A','H') order by order_id desc";

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
    <td height="16" align="center" bgcolor="#F4f4f4">Button</td>
    <td height="16" align="center" bgcolor="#F4f4f4">CS Notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer</td>
<!--
    <td height="16" align="center" bgcolor="#F4f4f4">Phone</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>
-->
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

$sql2 = "SELECT * FROM  `cscart_order_details` where order_id = $row[order_id] order by item_id desc";
$result2 = mysql_query($sql2);

if ($row[user_id] > 0) {
$sql33 = "SELECT count(*) as cnt FROM  `cscart_orders` where status = 'C' and user_id = $row[user_id]";
$result33 = mysql_query($sql33);
$row33 = mysql_fetch_assoc($result33);
$cnt = $row33[cnt];
} else {
$cnt = 0;
}

?>

<?php

while ($row2 = mysql_fetch_assoc($result2)) {

$sql22 = "SELECT sum(amount) as amount FROM  `cscart_shipment_items` where item_id = $row2[item_id]
            and order_id = $row2[order_id]";
$result22 = mysql_query($sql22);
$row22 = mysql_fetch_assoc($result22);
if (mysql_num_rows($result22) == 0 or $row2[amount] != $row22[amount]) {

$sql3 = "SELECT * FROM  `tmp_order` where item_id = $row2[item_id]
            and order_id = $row2[order_id]";
$result3 = mysql_query($sql3);
$row3 = mysql_fetch_assoc($result3);

$sql4 = "SELECT * FROM  `cscart_products` where product_id = $row2[product_id]";
$result4 = mysql_query($sql4);
$row4 = mysql_fetch_assoc($result4);

//$temp = $row4[product_code].".jpg";
//$sql5 = "SELECT * FROM  `cscart_images` where image_path = '$temp'";
$temp = str_replace("'", "''", $row4[product_code]);
$sql5 = "SELECT * FROM  `cscart_images` where image_path like '%$temp%'";
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
?>
<tr>

    <td height="17" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" align="center" bgcolor="#F4f4f4">
<? 
echo $row[timestamp];

if ($cnt > 0 ) {
?>
<a href="http://iamahair.com/myadmin.php?dispatch=orders.manage&user_id=<?=$row[user_id];?>" target="_blank">
<?
echo "<br/>+".$cnt."+";
?></a>
<?

} else {
//echo "<br/>+".$cnt."+";
}
?></td>
    <td height="17" align="center" bgcolor="#F4f4f4">
<?

 $company = $row2[product_code];
 $pos = strpos($company,"-");
 $company = substr($company,0,$pos);
 echo $company;
?></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4"><?if (mysql_num_rows($result5) != 0) {?><a href="http://iamahair.com/<?=$row7[name].'.html';?>" target="_blank"><?}?><?=$row2[product_code];?></a></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4">
<?php

 $str=$row2['extra'];

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

	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row2[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $row8[product];

 } else {
	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row2[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
        $style = $row8[shortname];
	$sql8 = "SELECT * FROM  `a_inventory` where x_style = $style and x_color= $color1";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
        $x_qty_p1=$row8[x_qty_p1];
        $x_qty_p2=$row8[x_qty_p2];
        $x_qty_p3=$row8[x_qty_p3];
        $x_qty_c=$row8[x_qty_c];
	$sql8 = "SELECT * FROM  `a_inventory` where x_style = $style and x_color= $color1";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $color1. "($x_qty_p1-$x_qty_p2-$x_qty_p3-$x_qty_c) , ".$color2 ."($row8[x_qty_p1]-$row8[x_qty_p2]-$row8[x_qty_p3]-$row8[x_qty_c])";
 }

?></td>
<?
switch ($row["shipping_ids"]) {
  case 5  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount]-$row22[amount];?></b></td><? break;
  case 8  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount]-$row22[amount];?></b></td><? break;
  case 13  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount]-$row22[amount];?></b></td><? break;
  case 14  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount]-$row22[amount];?></b></td><? break;
  default  : ?><td height="17" widht="40" align="center" bgcolor="#F4f4f4"><?=$row2[amount]-$row22[amount];?></td><? break;

}
?>

<form method="post" action="./tmp_write.php">

<?
$c_md = date("m/d",strtotime("-5 days 6 hours"));
$c_Y = date("Y",strtotime("-5 days 6 hours"));
$e_md = substr($row3[expire_dt],0,5);
$o_md = substr($row[timestamp],0,5);
$o_Y = substr($row[timestamp],6,4);
$ck = substr($row3[expire_dt],6,2);
if (($c_Y == $o_Y && $ck == "" && $c_md >= $e_md &&  $o_md <= $c_md) || ($c_Y != $o_Y && $ck == ""))  {?>

    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="ord_dt" value="<?=$row3[order_dt];?>" style="background-color: #FFFF00;"></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="exp_dt" value="<?=$row3[expire_dt];?>" style="background-color: #FFFF00;"></td>
<?} else { ?>
    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="ord_dt" value="<?=$row3[order_dt];?>"></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><input size="10" type="text" name="exp_dt" value="<?=$row3[expire_dt];?>"></td>
<?}?>

<input type="hidden" name="item_id" value="<?=$row2[item_id];?>">
<input type="hidden" name="order_id" value="<?=$row2[order_id];?>">
<input type="hidden" name="gb" value="1">

    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="notes" rows="5" cols="20"><?=$row[notes];?></textarea></td>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="details" rows="5" cols="20"><?=$row[details];?></textarea></td>
    <td width="100" height="17" align="center" bgcolor="#F4f4f4"><textarea name="remarks" rows="5" cols="12"><?=$row3[remarks];?></textarea></td>
    <td height="17" align="center" bgcolor="#F4f4f4">	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Submit"/></span>
		</div>

	</div></td>
 </form>
    <td align="center"><a href="javascript:op('new', './pop.php?order_id=<?=$row2[order_id];?>', 400, 250, 400, 320, 1, 1, 1, 0, 1)">Notes</a></td>
    <input type="hidden" name="order_id" value="<?=$row2[order_id];?>">
<?
$sql = "SELECT * FROM  `cscart_orders` where status = 'J' and (b_phone = '$row[b_phone]' or email = '$row[b_email]' or ip_address = '$row[ip_address]')";
$result20 = mysql_query($sql);
if (mysql_num_rows($result20) != 0 or $row[b_country] == 'ID') {?>
    <td width="300" height="17" align="center" bgcolor="red"><font color="white"><b>CHECK FRAUD</b></font></td>
<?}else{?>
    <td width="300" height="17" align="center" bgcolor="#F4f4f4"><?=$row[s_firstname]." ".$row[s_lastname];?></td>
<?}?>

<!--
    <td width="200" height="17" align="center" bgcolor="#F4f4f4"><?=$row[phone];?></td>
    <td align="center" class="text-group-message">
-->
<?

}
?>
<!--
    </td>
-->
</tr>
<?php
}
}
?>
</table>
</body>
</html>