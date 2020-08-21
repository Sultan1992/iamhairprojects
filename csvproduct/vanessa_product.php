
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

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
<?

include '../lib/connect_iamahair.php';
?>
<body>
<table border="0" width="100%" height="100">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?


$sql = "SELECT * FROM `tmp_product_upc` WHERE SUBSTRING_INDEX(product_code, '-', 1) = 'Vanessa'	order by product_code, color";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1300" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">CODE</td>
    <td height="16" align="center" bgcolor="#F4f4f4">COLOR</td>
    <td height="16" align="center" bgcolor="#F4f4f4">PRODUCT NAME</td>
    <td height="16" align="center" bgcolor="#F4f4f4">UPC</td>
  </tr>
<?php

while ($row = mysql_fetch_assoc($result)) {

?>
<tr>

    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[product_code];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[color];?></td>
    <td height="17" align="left" bgcolor="#FFFFFF"><?=$row[product_name];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[upc];?></td>
<?
}
?>
</tr>
</table>
</html>