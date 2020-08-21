<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<?
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';
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
<table border="0" width="100%" height="100">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?


$sql = "SELECT * FROM  `tmp_products`";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1300" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">No.</td>
    <td height="16" align="center" bgcolor="#F4f4f4">brand</td>
    <td height="16" align="center" bgcolor="#F4f4f4">hair type</td>
    <td height="16" align="center" bgcolor="#F4f4f4">fiber</td>
    <td height="16" align="center" bgcolor="#F4f4f4">pattern</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Length</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Item code</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Item name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Featured brand name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Price</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Price2</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Shown color</td>
    <td height="16" align="center" bgcolor="#F4f4f4">All color</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Can color</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Detail description</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Detail logo</td>
  </tr>
<?php
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
$i = $i + 1;

?>
<tr>

    <td height="17" align="center" bgcolor="#FFFFFF"><?=$i;?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[brand];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[hair_type];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[fiber];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[pattern];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[length];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[item_code];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[item_name];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[featured_brand_name];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[price];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[price2];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[shown_color];?></td>
    <td height="17" align="left" bgcolor="#FFFFFF"><?=$row[all_color];?></td>
    <td height="17" align="left" bgcolor="#FFFFFF"><?=$row[can_color];?></td>
    <td height="17" align="left" bgcolor="#FFFFFF"><?=$row[detail_description];?></td>
    <td height="17" align="left" bgcolor="#FFFFFF"><?=$row[detail_logo];?></td>
<?
}
?>
</tr>
</table>
</html>