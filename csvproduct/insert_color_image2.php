<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />

<?
$company_id = $_POST['company_id'];
$product_sid = $_POST['product_sid'];
$product_eid = $_POST['product_eid'];
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';

if($gubun == "iamahair"){
	$feature_id = 13;
} else {
	$feature_id = 156;
}

$sql = "SELECT * FROM  `cscart_product_descriptions` as a inner join `cscart_product_features_values` as b on a.product_id = b.product_id 
	 inner join `cscart_products` as c on a.product_id = c.product_id 
         where b.feature_id = $feature_id and b.variant_id = $company_id  and c.status = 'A' 
               and a.product_id  between $product_sid and $product_eid order by a.product_id limit 1000";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }

?>
<table border="0" width="700" height="130">
	<tr>
		<td width="350" align="center"><h4>- Work Site : <?=$gubun;?></h4></td>
		<td width="350" align="center"><h4>- Vendor : <?=$vendor;?></h4></td>
	</tr>
</table>
<script type="text/JavaScript"> 
function chkBox(bool) {  
 var obj = document.getElementsByName("ck[]"); 
 for (var i=0; i<obj.length; i++) obj[i].checked = bool; 
} 
function revBox() { 
 var obj = document.getElementsByName("ck[]"); 
 for (var i=0; i<obj.length; i++) obj[i].checked = !obj[i].checked; 
} 
</script>
<table border="1" width="1000" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4"><INPUT type=checkbox onclick=chkBox(this.checked)></td>
    <td height="30" align="center" bgcolor="#F4f4f4">Product ID</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Product Name</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Product CODE</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

?>
<tr>

<form method="post" action="./tmp_insert_color.php">
	<input type="hidden" name="gubun" value="<?=$gubun;?>">
	<input type="hidden" name="vendor" value="<?=$vendor;?>">
    <td><input type="checkbox" name="ck[]" value="<?=$row[product_id];?>"></td> 
    <td width="10%" height="30" align="center" bgcolor="#FFFFFF"><?
if($gubun == "iamahair"){
	?><a href="http://iamahair.com/myadmin.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank"><?=$row[product_id];?></a><?
}else{
	?><a href="http://ehairdepot.com/ehair.php?dispatch=products.update&product_id=<?=$row[product_id];?>" target="_blank"><?=$row[product_id];?></a><?
}
?></td>
    <td height="20" align="center" bgcolor="#FFFFFF"><?=$row[product];?></td>
    <td height="20" align="center" bgcolor="#FFFFFF"><?=$row[product_code];?></td>

<?

}
?>
<input type="hidden" name="gubun" value="<?=$gubun;?>">
</tr>
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4"><INPUT type=checkbox onclick=chkBox(this.checked)></td>
  </tr>
</table>
<table border="0" width="1300" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Insert Color Table"/></span>
		</div>

	</div>
</td></tr>
</table>
 </form>
</html>