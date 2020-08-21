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
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>

<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<font color="#FFFFFF" size="3"><b>Order ID&nbsp;&nbsp;</b></font>
<input height="30" type="text" name="keyword" value="<?=$_GET['keyword'];?>" style=height:22px onfocus="this.select()" onkeydown="this.value=this.value.replace(/[^0-9]/g,'')" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onblur="this.value=this.value.replace(/[^0-9]/g,'')">
<input type="submit" value="search" style=height:22px>
</table>
</form>
<br><br><br>

<?
$keyword = $_GET['keyword'];

if ($keyword != "") {

include "lib/connect_iamahair.php";

$sql = "SELECT *,DATE_FORMAT(from_unixtime(b.timestamp),'%Y/%m/%d') as timestamp  
	FROM  cscart_order_details as a	left JOIN cscart_orders as b on a.order_id = b.order_id
        where a.order_id = $keyword";


$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="900" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">Product</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Option</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Qty</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Price</td>

  </tr>
<?php

while ($row = mysql_fetch_assoc($result)) {

	$sql8 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row[product_id]";
	$result8 = mysql_query($sql8);
	$row8 = mysql_fetch_assoc($result8);

?>
<tr>
    <td width="500" height="30" align="left" bgcolor="#FFFFFF"><?=$row8[product];?></td>
    <td width="300" height="30" align="center" bgcolor="#FFFFFF">
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
	echo $row[product_code];
 } else {
 	echo $color1." ,  ".$color2;
 }

?></td>
<td height="30" widht="40" align="center" bgcolor="#F4f4f4"><?=$row[amount];?></td>

    <td align="center""><?=$row[price];?></td>
</tr>

<?php
}
}
?>
</table>
</html>