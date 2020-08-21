<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Product Option Admin :: View Product - Administration panel</title>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

</head>

<body onload="document.form1.keyword.focus()">
<table border="0" width="100%" height="75">
	<tr>
		<td>
		</td>
	</tr>
</table>
<br>
<form action="<?=$_SERVER[PHP_SELF]?>">
<table align=center border="0" width="1000" height="5">
<input height="30" type="text" name="keyword" value="<?=$_GET['keyword'];?>" style=height:22px>
<input type="submit" value="search" style=height:22px>
</table>
</form>
<br>

<?php
$keyword = $_GET['keyword'];
$keyword = strtoupper($keyword);

$conn = mysql_connect("localhost", "cocos", "hair123!@#");

if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("cocos_com")) {
     echo "Unable to select mydbname: " . mysql_error();
     exit;
 }



$sql = "SELECT * FROM  cscart_product_descriptions
	where upper(product) like '%$keyword%' order by product_id desc  limit 50";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="1" width="1000" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="17" align="center" bgcolor="#F4f4f4">Product ID</td>
    <td height="17" align="center" bgcolor="#F4f4f4">Name</td>
    <td height="17" align="center" bgcolor="#F4f4f4">Color (ex:1,2,1B,...)</td>
    <td height="17" align="center" bgcolor="#F4f4f4">Button</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

?>
<tr>
<form method="post" action="./product_option_02.php">
   <td height="15" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank"><?=$row[product_id];?></a></td>
    <td height="15" bgcolor="#ffffff"><?=$row[product];?></td>
    <td height="15" bgcolor="#ffffff"><input size="40" type="text" name="color"></td>

<input type="hidden" name="product_id" value="<?=$row[product_id];?>">
    <td height="15" align="center" bgcolor="#F4f4f4">	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Option Creation"/></span>
		</div>

	</div></td>
</form>

</tr>
<?php
}
?>
</table>
<?php
mysql_close($conn);
?>

</html>