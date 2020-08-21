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

<body onload="document.stock_chk.bt.focus()">
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

<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?

include "lib/connect_iamahair.php";

$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  `cscart_orders`
	where status in ('P','B','A','H') order by order_id desc";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<form method="post" name=stock_chk action="http://mycom/iamahair/iamahair_stock.php">
<table border="1" width="800" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product code</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Option</td>
	<td height="16" align="center" bgcolor="#F4f4f4">Order Qty</td>
	<!--
	<td height="16" align="center" bgcolor="#F4f4f4">Qty-Compony</td>
	<td height="16" align="center" bgcolor="#F4f4f4">qty-P1</td>
	<td height="16" align="center" bgcolor="#F4f4f4">Qty-p2</td>
-->
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

$sql2 = "SELECT * FROM  `cscart_order_details` where order_id = $row[order_id] order by item_id desc";
$result2 = mysql_query($sql2);

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
?>
<tr>

    <td height="17" width="120" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" width="120" align="center" bgcolor="#F4f4f4"><?=$row[timestamp];?></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4"><?if (mysql_num_rows($result5) != 0) {?><a href="http://iamahair.com/<?=$row7[name].'.html';?>" target="_blank"><?}?><?=$row2[product_code];?></a></td>
    <td width="200" height="17" align="center" bgcolor="#FFFFFF">
<?php


	$c1 = "";$c2 = "";$color1 = "";$color2 = "";$upc1 = "";$upc2 = "";

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

$c1 = str_replace('"','',$color1);
$c1 = str_replace(' (Low)','',$c1);
$c2 = str_replace('"','',$color2);
$c2 = str_replace(' (Low)','',$c2);
 if ($color1 == "" and $color2 == "") {
	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row2[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);
	echo $row8[product];

 } else {
	$sql9 = "SELECT upc FROM  `tmp_product_upc` where product_code = '$row2[product_code]'
		and trim(color) = trim('$c1')";
	$result9 = mysql_query($sql9);
	$row9 = mysql_fetch_assoc($result9);
	$upc1 = $row9[upc];
	echo $color1." [".$upc1."]"."<br />";

	$sql9 = "SELECT upc FROM  `tmp_product_upc` where product_code = '$row2[product_code]'
		and trim(color) = trim('$c2')";
	$result9 = mysql_query($sql9);
	$row9 = mysql_fetch_assoc($result9);
	$upc2 = $row9[upc];
	echo $color2." [".$upc2."]";
 }

//



?></td>

<?
switch ($row["shipping_ids"]) {
  case 5  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount];?></b></td><? break;
  case 8  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount];?></b></td><? break;
  case 13  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount];?></b></td><? break;
  case 14  : ?><td height="17" widht="40" align="center" bgcolor="red"><b><?=$row2[amount];?></b></td><? break;
  default  : ?><td height="17" widht="40" align="center" bgcolor="#FFFFFF"><?=$row2[amount];?></td><? break;

}
?>
    <input type="hidden" name="order_id[]" value="<?=$row2[order_id];?>">
    <input type="hidden" name="timestamp[]" value="<?=$row[timestamp];?>">
    <input type="hidden" name="product_code[]" value="<?=$row2[product_code];?>">
    <input type="hidden" name="color1[]" value="<?=$c1;?>">
    <input type="hidden" name="color2[]" value="<?=$c2;?>">
    <input type="hidden" name="upc1[]" value="<?=$upc1;?>">
    <input type="hidden" name="upc2[]" value="<?=$upc2;?>">
    <input type="hidden" name="qty[]" value="<?=$row2[amount];?>">
    <input type="hidden" name="order_dt[]" value="<?=$row3[order_dt];?>">
</tr>
<?
}
}
}
?>

<!--
SELECT qty_c,qty_p1,qty_p2 FROM cscart_product_options_descriptions 
INNER JOIN cscart_product_option_variants ON cscart_product_options_descriptions.option_id = cscart_product_option_variants.option_id INNER JOIN cscart_product_option_variants_descriptions ON cscart_product_option_variants.variant_id= cscart_product_option_variants_descriptions.variant_id 
WHERE cscart_product_options_descriptions.option_id AND cscart_product_option_variants.variant_id
-->



</table>
<table border="0" width="800" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" name=bt value="Stock Result"/></span>
		</div>
	</div>
</td></tr>
</table>
 </form>
</html>