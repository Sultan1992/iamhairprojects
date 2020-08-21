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
<font color="#FFFFFF" size="3"><b>Product Name&nbsp;&nbsp;</b></font>
<input height="30" type="text" name="keyword" value="<?=$_GET['keyword'];?>" style=height:22px onfocus="this.select()">
<input type="submit" value="search" style=height:22px>
</table>
</form>
<br><br><br>

<?
$keyword = $_GET['keyword'];
$sdate = $_GET['sdate'];
$edate = $_GET['edate'];

if ($keyword != "") {

include "lib/connect_iamahair.php";

$sql = "SELECT * FROM  cscart_product_descriptions
	 where product like '%$keyword%' order by product_id desc";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1100" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4"></td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product ID</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Product Name</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Description</td>

  </tr>
<?php

while ($row = mysql_fetch_assoc($result)) {


?>
<form method="post" action="./tmp_order_qry.php">
<tr>
    <td><input type="checkbox" name="ck[]" value="<?=$row[product_id];?>"></td> 
    <td height="30" width="50" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank">#<?=$row[product_id];?></a></td>
    <td height="30" width="400" align="left" bgcolor="#FFFFFF"><?=$row[product];?></td>
    <td height="30" width="700" align="left" bgcolor="#FFFFFF"><?=$row[short_description];?></td>
</tr>
<?php
}
}
?>
</table>
<table border="0" width="1100" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
<div class="float-center">Date(yyyy/mm) <input height="10" type="text" name="sdate" value="<?=$_GET['sdate'];?>" style=height:22px onfocus="this.select()"> ~ <input height="10" type="text" name="edate" value="<?=$_GET['edate'];?>" style=height:22px onfocus="this.select()"></div>
</td></tr>
<tr><td height="17" align="center" bgcolor="#F4f4f4">
	<div class="buttons-container nowrap">
		<div class="float-center">		
	<span  class="submit-button cm-button-main "><input   type="submit" value="View History"/></span>
		</div>

	</div>
</td></tr>
</table>
 </form>

</html>