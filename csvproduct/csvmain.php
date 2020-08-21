<?php
include "../lib/session.php";




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

<table border="1" width="800" id="table1">
<form method="post" action="./mainpro.php">
	<tr>
		<td align="center" height="40" bgcolor="#FFFFFF">Work Site : <input type="radio" name="gubun" value="iamahair" checked>iamahair<input type="radio" name="gubun" value="ehair">ehairdepot<input type="radio" name="gubun" value="localtest">localtest</td>
<td align="center" bgcolor="#FFFFFF">
<select name="vendor">
	<option value="">::::SELECT::::</option>
	<option value="Alicia">Alicia</option>
	<option value="chade">chade</option>
	<option value="itsawig">itsawig</option>
	<option value="sensationnel">sensationnel</option>
	<option value="vivicafox">vivicafox</option>
	<option value="vanessa">vanessa</option>
	<option value="outre">outre</option>
	<option value="modelmodel">modelmodel</option>
	<option value="Motown">Motown</option>
	<option value="Estetica">Estetica</option>
	<option value="Beshe">Beshe</option>
	<option value="Thewig">Thewig</option>
	<option value="Diana">Diana</option>
	<option value="SNG">SNG</option>
</select></td>
	</tr>
	<tr>
		<td height="40" bgcolor="#FFFFFF" colspan="2" align="center"><input   type="submit" value="NEXT"</td>
	</tr>
</form>


</table>
</body>
</html>