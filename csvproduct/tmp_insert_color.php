<?php
include "../lib/session.php";
?>

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<table border="0" width="100%" height="100">
	<tr>
		<td>
		</td>
	</tr>
</table>

<?
$ck = $_POST['ck'];
$gubun = $_POST['gubun'];
$ct = count($ck);

include '../lib/connect_'.$gubun.'.php';
echo '../lib/connect_'.$gubun.'.php'."<br/><br/>";

echo "cscart_images +cscart_images_links Table Insert";echo "<br />";
echo "=================================";echo "<br />";
$sql = "SELECT max(image_id) as id FROM  cscart_images";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_assoc($result4);
$max_image_id = $row4[id] + 1;

for($i=0;$i<$ct;$i++) {

 $product_id = $ck[$i];

echo "[Product ID : ".$product_id."]<br/>";
echo "-------------------------";echo "<br />";
$sql = "SELECT a.option_id FROM  `cscart_product_options` as a inner join `cscart_product_options_descriptions` as b on a.option_id = b.option_id 
         where b.option_name = '1st Color' and a.product_id = $product_id";
$result1 = mysql_query($sql);
$row1 = @mysql_fetch_assoc($result1);

if (@mysql_num_rows($result1) != 0) {

$sql = "SELECT variant_id FROM  `cscart_product_option_variants`  where option_id =$row1[option_id] order by position";
$result3 = mysql_query($sql);

$cnt1 = 0;
while ($row3 = @mysql_fetch_assoc($result3)) {

$sql = "SELECT count(*) as cnt FROM  `cscart_images_links`  where object_id =$row3[variant_id] and object_type='variant_image'";
$result8 = mysql_query($sql);
$row8 = mysql_fetch_assoc($result8);

if ( $row8[cnt] == 0 ) {

$sql = "SELECT variant_name FROM  `cscart_product_option_variants_descriptions`  where variant_id = $row3[variant_id]";
$result7 = mysql_query($sql);
$row7 = mysql_fetch_assoc($result7);

$color1 = str_replace("/", "",$row7[ variant_name]);
$color1 = str_replace("-", "",$color1);
$color1 = str_replace("_", "",$color1);
$color1 = str_replace(".", "",$color1);
$color1 = str_replace("(Low)", "",$color1);
$color1 = str_replace(" ", "",$color1);
$color1 = trim($color1);

$image_path = floor($max_image_id / 1000);
$image_nm = $product_id."_".$color1.".gif";
echo "   - Variant ID : ".$row3[variant_id]."-------------".$image_path."/70/70/"."------------".$image_nm."<br/>";

$sql = "insert into cscart_images (image_id,image_path,image_x,image_y) values ($max_image_id,'$image_nm',70,70)";
$result5 = mysql_query($sql);

$sql = "insert into cscart_images_links (object_id,object_type,image_id,type) values ($row3[variant_id],'variant_image',$max_image_id,'V')";
$result6 = mysql_query($sql);


$max_image_id = $max_image_id + 1;
}

}

}


}
?>