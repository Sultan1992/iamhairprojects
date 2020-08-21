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
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?

include "lib/connect_iamahair.php";

?>

<table border="0" width="100%" height="10">
	<tr>
		<td>
	<h1 class="mainbox-title">
			

	</h1><p>
		</td>
	</tr>
</table>

<?


$sql = "SELECT * FROM  tmp_both_dup order by email";



$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="900" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="20" align="center" bgcolor="#f4f4f4">email</td>
    <td height="20" align="center" bgcolor="#f4f4f4">Last Date</td>

  </tr>
<?

while ($row = mysql_fetch_assoc($result)) {

$sql2 = "SELECT DATE_FORMAT(from_unixtime(max(timestamp)),'%m/%d/%Y') as timestamp
          from cscart_orders 
	where email = '$row[email]'";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($result2);

?>
<tr>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row[email];?></td>
    <td height="30" align="center" bgcolor="#FFFFFF"><?=$row2[timestamp];?></td>

</tr>
<?php
}
?>
</table>

</html>