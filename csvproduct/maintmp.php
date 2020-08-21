<?php
include "../lib/session.php";

$gubun = 'iamahair';
$vendor = 'vanessa';

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
<table border="0" width="700" height="130">
	<tr>
		<td width="350" align="center"><h4>- Work Site : <?=$gubun;?></h4></td>
		<td width="350" align="center"><h4>- Vendor : <?=$vendor;?></h4></td>
	</tr>
</table>

<table border="1" width="800" id="table1">


<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./upc_insert_tmp.php">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** iamahair DB UPC Insert ****** Start Product Code ***<input size="10" type="text" name="product_sid" value="0"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="UPC Insert Start!!"¡¡</td></tr>
</form>
</tr>

</table>
</body>
</html>