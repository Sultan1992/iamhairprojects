<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Stock :: View Stocks - Administration panel</title>
<link href="/skins/basic/admin/images/icons/favicon.ico" rel="shortcut icon" />

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

	<style>
	/* 
	Generic Styling, for Desktops/Laptops 
	*/
	table { 
		width: 100%; 
		border-collapse: collapse; 
	}
	/* Zebra striping */
	tr:nth-of-type(odd) { 
		background: #eee; 
	}
	th { 
		background: #333; 
		color: white; 
		font-weight: bold; 
	}
	td, th { 
		padding: 6px; 
		border: 1px solid #ccc; 
/*		text-align: left;   */
	}
	</style>

</head>

<body>

<table border="0" width="100%" height="72">
	<h1 class="mainbox-title">

	</h1><p>
</table>

<br><br><br>
<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<select name="cmbData">
	<option value="10881" <?if ($_GET['cmbData'] == 10881){echo "selected";}?>>Best Selling Items</option>
	<option value="10885" <?if ($_GET['cmbData'] == 10885){echo "selected";}?>>New Arrival Items</option>
	<option value="4788" <?if ($_GET['cmbData'] == 4788){echo "selected";}?>>unbelievable</option>
</select>
<input type="submit" value="search" style=height:22px>
</table>
</form>
<br><br><br>


<?php

$cmbData = $_GET['cmbData'];

?>
<!--
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>
-->
<?

include "lib/connect_iamahair.php";

if ($cmbData != "") {

$sql = "SELECT *  FROM  `cscart_product_features_values` as a
         left join cscart_product_descriptions as b on a.product_id = b.product_id
         where feature_id = 9 and variant_id = $cmbData
	order by a.product_id desc";
$result = mysql_query($sql);
$sql = "SELECT count(*) as cnt  FROM  `cscart_product_features_values`
         where feature_id = 9 and variant_id = $cmbData";
$temp =  mysql_query($sql);  // 전체 레코드수
} else {
	exit;
}

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }
?>
<form method="post" action="./main_product_write.php">
<table border="1" width="1000" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#FFFFFF">Feature ID</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Variant ID</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Product Name</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Product ID</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Product ID(New)</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

?>
<tr>

    <td width="80" height="17" align="center" bgcolor="#F4f4f4"><?=$row[feature_id];?></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><?=$row[variant_id];?></td>
    <td height="17" align="left" bgcolor="#F4f4f4"><?=$row[product];?></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><?=$row[product_id];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><input size="12" type="text" name="product_new[]"></td>
    <input type="hidden" name="product_id[]" value="<?=$row[product_id];?>">
    <input type="hidden" name="feature_id[]" value="<?=$row[feature_id];?>">
    <input type="hidden" name="variant_id[]" value="<?=$row[variant_id];?>">
</tr>
<?php
}
?>
</table>
<table border="0" width="1300" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Submit"/></span>
		</div>

	</div>
</td></tr>
</table>
 </form>
<?php


mysql_close($conn);
?>
</td>
</table>
</html>