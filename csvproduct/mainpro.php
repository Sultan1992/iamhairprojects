<?php
include "../lib/session.php";

$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

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

<form method="post" action="./csv_import.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>

		<td width="80%" align="center" height="40" bgcolor="#FFFFFF">CSV FILE IMPORT</td>
		<td bgcolor="#FFFFFF"><input   type="submit" value="CSV FILE Insert Start!!"</td>
	</tr>
</form>

<tr><td colspan="2" height="30"></td></tr>

<form method="post" action="./product_list.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<tr>

		<td width="80%" align="center" height="40" bgcolor="#FFFFFF">IMPORT RESULT VIEW</td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="VIEW"</td>
	</tr>
</form>

<tr><td colspan="2" height="30"></td></tr>


<form method="post" action='./<?=$vendor;?>_description_dsp.php'>
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td width="80%" align="center" height="40" bgcolor="#FFFFFF">Preview Description( max:20 )</td>

		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Description View"</td>
</form>
	</tr>

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./product_link.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#f9efd1">*** Start Product ID ***<input size="10" type="text" name="product_id"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Product ID Link"　</td>
</form>
	</tr>
<tr><td colspan="2" height="30"></td></tr>

<!--  Vanessa   imahair: 4750, ehair: 5362 -->

<form method="post" action="./insert_color_image.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Company ID ***<input size="10" type="text" name="company_id" value="5362">*** Start Product ID ***<input size="10" type="text" name="product_sid" value="0">~<input size="10" type="text" name="product_eid" value="9999999999"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Insert Color Image"　</td>
</form>
	</tr>
<tr><td colspan="2" height="30"></td></tr>


<form method="post" action="./insert_color_image1.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Company ID ***<input size="10" type="text" name="company_id" value="5362">*** Start Product ID ***<input size="10" type="text" name="product_sid" value="0">~<input size="10" type="text" name="product_eid" value="9999999999"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Insert Color Image"　</td>
</form>
	</tr>

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./upc_insert.php">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** iamahair DB UPC Insert ****** Start Product ID ***<input size="10" type="text" name="product_sid" value="0">~<input size="10" type="text" name="product_eid" value="9999999999"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="UPC Insert Start!!"　</td></tr>
</form>
</tr>

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action='./<?=$vendor;?>_product_insert.php'>
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td width="80%" align="center" height="40" bgcolor="#FFFFFF">*** Table Insert ***</td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Products Insert Start!!"</td>
</form>
	</tr>
<!--
<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./product_delete.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Delete Start Product ID ***<input size="10" type="text" name="product_id"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Products Delete Start!!"　</td>
</form>
	</tr>
-->

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./product_color_check.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Product Color Stock Update ***  UPDATE : <input type="checkbox" name="ck"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Start Checking"　</td>
</form>
	</tr>

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./hidden_products.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Company ID ***  UPDATE : <input type="checkbox" name="chk"><input size="10" type="text" name="company_id" value="4745"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="Check No Stock"　</td>
</form>
	</tr>

<tr><td colspan="2" height="30"></td></tr>
<form method="post" action="./online_products.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
	<tr>
		<td  align="center" height="40" bgcolor="#FFFFFF">*** Company ID <input size="10" type="text" name="company_id" value="4745"></td>
		<td bgcolor="#FFFFFF" align="center"><input   type="submit" value="View Products"　</td>
</form>
	</tr>

</table>
</body>
</html>