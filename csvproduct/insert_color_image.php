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
    <td height="20" align="center" bgcolor="#F4f4f4">Option Color</td>
    <td height="20" align="center" bgcolor="#F4f4f4">Color Text</td>
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

<?
$sql = "SELECT a.option_id FROM  `cscart_product_options` as a inner join `cscart_product_options_descriptions` as b on a.option_id = b.option_id 
         where b.option_name = '1st Color' and a.product_id = $row[product_id]";
$result1 = mysql_query($sql);
$row1 = @mysql_fetch_assoc($result1);

if (@mysql_num_rows($result1) != 0) {

$sql = "SELECT variant_id FROM  `cscart_product_option_variants`  where option_id =$row1[option_id] order by position";
$result3 = mysql_query($sql);

$cnt1 = 0;
$color = "";
while ($row3 = @mysql_fetch_assoc($result3)) {

$sql = "SELECT variant_name FROM  `cscart_product_option_variants_descriptions`  where variant_id = $row3[variant_id]";
$result7 = mysql_query($sql);
$row7 = mysql_fetch_assoc($result7);

$color1 = str_replace("/", "",$row7[ variant_name]);
$color1 = str_replace("-", "",$color1);
$color1 = str_replace("_", "",$color1);
$color1 = str_replace(".", "",$color1);
$color1 = str_replace(" (Low)", "",$color1);
$color1 = trim($color1);

$color = $color.$color1."<br/>";

$sql = "SELECT count(*) as cnt FROM  `cscart_images_links`  where object_id =$row3[variant_id] and object_type='variant_image'";
$result4 = mysql_query($sql);
$row4 = @mysql_fetch_assoc($result4);
$cnt1 = $cnt1 + $row4[cnt];
}

}

?>    
    <td height="20" align="center" bgcolor="yellow"><?=$cnt1."(".mysql_num_rows($result3).")";?></td></td>
    <td height="20" align="center" bgcolor="#FFFFFF"><?=$color;?></td>

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