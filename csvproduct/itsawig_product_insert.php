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
$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];

include '../lib/connect_'.$gubun.'.php';

echo "==================================="."<br/>";
echo "Products+Description Table";echo "<br />";
echo "==================================="."<br/>";
$sql = "SELECT max(product_id) as id FROM  cscart_products";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$max_id = $row[id] + 1;

$sql = "SELECT *  FROM  tmp_products";
$result = mysql_query($sql);

$j = 0;
while ($row = mysql_fetch_assoc($result)) {

	$sql9 = "SELECT count(*) as cnt  FROM  cscart_products where product_code = '$row[item_code]'";
	$result9 = mysql_query($sql9);
	$row9 = mysql_fetch_assoc($result9);
if ($row9[cnt] == 0) {

	$Q = 1000;
	if ($row[can_color] == "") {
		$Q = 0;
	}

	$sql1 = "insert into cscart_products (product_id,product_code, status, amount, weight,
                 timestamp, tracking, min_qty, tax_ids, options_type, list_price) values 
     	     	($max_id,'$row[item_code]','H',$Q,1.10,unix_timestamp(now()),'B',1,6,'S',$row[price2])";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$t_product = $row[brand]." ".$row[fiber]." ".$row[featured_brand_name]." ".$row[hair_type]." - ".$row[item_name];
	$t_product = str_replace("'", "''", $t_product);
	$t_short_description = $t_product." ".$row[fiber]." hair ".$row[pattern]." ".$row[length]." Length Style ".$row[hair_type];

	$t_full_01 = $row[item_name]." ".$row[featured_brand_name]." ".$row[hair_type]." by ".$row[brand];
	$t_full_01 = str_replace("'", "''", $t_full_01);
	$t_full_02 = $row[brand]." ".$row[item_name]." ".$row[hair_type];
	$t_full_02 = str_replace("'", "''", $t_full_02);
	$t_full_05 = str_replace("It's a wig","It's a",$row[brand])." ".$row[hair_type];
	$t_full_05 = str_replace("'", "''", $t_full_05);
	$t_full_12 = str_replace(":",",",$row[all_color]);
	$t_full_13 = str_replace(":",",",$row[can_color]);

	$t_brand = str_replace("'", "''", $row[brand]);
	$sql2 = "SELECT * FROM  tmp_products_description
                where brand = '$t_brand' and site_gubun = '0'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_assoc($result2);

	$item_code = str_replace("'", "''", $row[item_code]);
	$item_name = str_replace("'", "''", $row[item_name]);
	$detail_description = str_replace(":",",",$row[detail_description]);
	$detail_description = str_replace("'", "''", $detail_description);
	$t_full_description = $row2[long_description];
	$t_full_description = str_replace("'", "''", $t_full_description);
	$t_full_description = str_replace("###", $t_full_01, $t_full_description);
	$t_full_description = str_replace("##2", $t_full_02, $t_full_description);
	$t_full_description = str_replace("##3", $item_code, $t_full_description);
	$t_full_description = str_replace("##4", $item_code, $t_full_description);
	$t_full_description = str_replace("##5", $t_full_05, $t_full_description);
	$t_full_description = str_replace("##6", $row[shown_color], $t_full_description);
	$t_full_description = str_replace("##7", $item_name, $t_full_description);
	$t_full_description = str_replace("##8", $row[hair_type], $t_full_description);
	$t_full_description = str_replace("##9", $row[fiber], $t_full_description);
	$t_full_description = str_replace("##10", $detail_description, $t_full_description);
	$t_full_description = str_replace("##11", $row[detail_logo], $t_full_description);
	$t_full_description = str_replace("##12", $t_full_12, $t_full_description);
	$t_full_description = str_replace("##13", $t_full_13, $t_full_description);

	$t_page_title = $t_brand." ".$row[item_name]." ".$row[hair_type];
	$t_meta_keywords = $row[item_name].",".$row[hair_type].",".$t_brand.",".$row[item_code].",".
		$t_page_title.",".$row[pattern]." ".$row[length]." Length";
	$t_meta_description = $t_product." ".$row[fiber]." hair ".$row[pattern]." ".$row[length].
		" Length Style ".$row[hair_type];
	$t_search_words = $row[item_name].",".$row[hair_type].",".$t_brand.",".$row[item_code].",".
		$t_page_title.",".$row[pattern]." ".$row[length]." Length";

	$sql1 = "insert into cscart_product_descriptions (product_id,product,short_description,full_description,
		meta_keywords,meta_description,search_words,page_title) values ($max_id,'$t_product','$t_short_description','$t_full_description','$t_meta_keywords','$t_meta_description',
		'$t_search_words','$t_page_title')";
	$result1 = mysql_query($sql1);


if($gubun == "iamahair"){
	$sql1 = "insert into cscart_products_categories values 	($max_id,113,'M',0)";
}else{
	$sql1 = "insert into cscart_products_categories values 	($max_id,166,'M',0)";
}
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$a = str_replace("'", "", $row[brand]);
	$b = str_replace(" ","-",$a);
	$c = str_replace(" ","-",$row[fiber]);
	$d = str_replace(" ","-",$row[hair_type]);
	$e = str_replace(" ","-",$row[item_name]);
	$seo = $b."-".$c."-".$d."-".$e;
	$seo = strtolower($seo);
	$sql1 = "insert into cscart_seo_names (name,object_id,type) values 
		('$seo',$max_id,'p')";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";

	$sql1 = "insert into cscart_product_prices (product_id,price,lower_limit) values
	 	($max_id,$row[price],1)";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";


if($gubun == "iamahair"){
//cscart_product_features_values--------------------------------------
//feature id : 2(Hair Brand Name)
//             3(Hair Fibers)
//	       4(Hair Patterns)
//	       5(Hair Length)
//	       6(Hair Types)
//	       8(Estimated Shipping Day)==>36
//	       13(Manufacturer)
//--------------------------------------------------------------------
$t_full_05 = str_replace("Lace Front", "Lace Front Wig", $t_full_05);
$t_full_05 = str_replace("Full Wig", "Full Cap", $t_full_05);
$t_features_brand_id = call_variant($t_full_05);
call_variant_insert(2,$max_id,$t_features_brand_id);

$t_features_fiber_id = call_variant($row[fiber]);
call_variant_insert(3,$max_id,$t_features_fiber_id);

$t_features_pattern_id = call_variant($row[pattern]);
call_variant_insert(4,$max_id,$t_features_pattern_id);

$t_features_length_id = call_variant($row[length]);
call_variant_insert(5,$max_id,$t_features_length_id);

$t_features_type_id = call_variant($row[hair_type]);
call_variant_insert(6,$max_id,$t_features_type_id);

$t_features_day_id = "36";
call_variant_insert(8,$max_id,$t_features_day_id);

$t_features_manufacturer_id = call_variant($t_brand);
call_variant_insert(13,$max_id,$t_features_manufacturer_id);

}else{
//cscart_product_features_values--------------------------------------
//feature id : 15(Hair Brand Name)
//             16(Hair Fibers)
//	       17(Hair Patterns)
//	       19(Hair Length)
//	       20(Hair Types)
//	       157(Estimated Shipping Day)==>36
//	       156(Manufacturer)
//--------------------------------------------------------------------
$t_full_05 = str_replace("Lace Front", "Lace Front Wig", $t_full_05);
$t_full_05 = str_replace("Full Wig", "Full Cap", $t_full_05);
$t_features_brand_id = call_variant($t_full_05);
call_variant_insert(15,$max_id,$t_features_brand_id);

$t_features_fiber_id = call_variant($row[fiber]);
call_variant_insert(16,$max_id,$t_features_fiber_id);

$t_features_pattern_id = call_variant($row[pattern]);
call_variant_insert(17,$max_id,$t_features_pattern_id);

$t_features_length_id = call_variant($row[length]);
call_variant_insert(19,$max_id,$t_features_length_id);

$t_features_type_id = call_variant($row[hair_type]);
call_variant_insert(20,$max_id,$t_features_type_id);

$t_features_day_id = "5365";
call_variant_insert(157,$max_id,$t_features_day_id);

$t_features_manufacturer_id = call_variant($t_brand);
call_variant_insert(156,$max_id,$t_features_manufacturer_id);
}

//cscart_product_options ---------------------------------------------
$sql2 = "SELECT max(option_id) as id FROM  cscart_product_options";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($result2);
$option_max_id = $row2[id] + 1;
// product_option
	$sql1 = "insert into cscart_product_options (option_id,product_id,required) values ($option_max_id,$max_id,'Y')";
	$result1 = mysql_query($sql1);

	$sql1 = "insert into cscart_product_options (option_id,product_id,inventory,position,required) values ($option_max_id+1,$max_id,'N',10,'Y')";
	$result1 = mysql_query($sql1);
// product_options_descriptions
	$sql1 = "insert into cscart_product_options_descriptions
                (option_id,option_name) values ($option_max_id,'1st Color')";
	$result1 = mysql_query($sql1);
// cscart_product_option_variants--1
	$sql2 = "SELECT max(variant_id) as id FROM  cscart_product_option_variants";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_assoc($result2);
	$option_variant_id = $row2[id] + 1;
	$org = $option_variant_id;
	
	$pos = 10;
	$arraycolor = split(',',$t_full_12);
	for($i=0;$i< sizeof($arraycolor);$i++){

		$arrayc = split('!',$arraycolor[$i]);
		$coltxt = $arrayc[0];
		$upc = $arrayc[1];
		//echo $arrayc[0].":".$arrayc[1];echo "<br />";

		$sql1 = "insert into cscart_product_option_variants
            	    (variant_id,option_id,position) values ($option_variant_id,$option_max_id,$pos)";
		$result1 = mysql_query($sql1);
// cscart_product_option_variants_descriptions
		$sql1 = "insert into cscart_product_option_variants_descriptions
            	    (variant_id,variant_name) values ($option_variant_id,'$coltxt')";
		$result1 = mysql_query($sql1);
		echo $sql1."<br/>";

// tmp_product_upc

		$str = str_replace("'", "''", $t_product);
		$sql1 =  "insert into tmp_product_upc (product_id,color,product_name,product_code,upc) values
            	    		($max_id,'$coltxt','$str','$row[item_code]','$upc')";
		$result1 = mysql_query($sql1);

		echo $sql1."<br/>";
		$option_variant_id = $option_variant_id + 1;
		$pos = $pos + 10;		
	}


	$sql1 = "insert into cscart_product_options_descriptions
                (option_id,option_name,comment) values 
		($option_max_id+1,'2nd Color','If your 1st color choice is not available, your 2nd color will be processed.')";
	$result1 = mysql_query($sql1);
// cscart_product_option_variants--2
	$pos = 10;
	for($i=0;$i< sizeof($arraycolor);$i++){

		$arrayc = split('!',$arraycolor[$i]);
		$coltxt = $arrayc[0];

		$sql1 = "insert into cscart_product_option_variants
            	    (variant_id,option_id,position) values ($option_variant_id,$option_max_id+1,$pos)";
		$result1 = mysql_query($sql1);
// cscart_product_option_variants_descriptions
		$sql1 = "insert into cscart_product_option_variants_descriptions
            	    (variant_id,variant_name) values ($option_variant_id,'$coltxt')";
		$result1 = mysql_query($sql1);
		echo $sql1."<br/>";
		$option_variant_id = $option_variant_id + 1;
		$pos = $pos + 10;		
	}
} else {
echo $row[item_code]." Product code duplicate Error..."."<br/>";
}
//--------------------------------------------------------------------
	$j = $j + 1;
if($gubun == "iamahair"){
	?><a href="http://iamahair.com/myadmin.php?dispatch=products.update&product_id=<?=$max_id;?>" target="_blank"><?=$max_id;?></a><?
}else{
	?><a href="http://ehairdepot.com/ehair.php?dispatch=products.update&product_id=<?=$max_id;?>" target="_blank"><?=$max_id;?></a><?
}
	echo "<br />";
	$max_id = $max_id + 1;
}
echo "==================================="."<br/>";
echo "Products+Description Table에 ".$j."건 Insert 완료...";echo "<br />";
echo "==================================="."<br/>";

function call_variant($str){
	$sql1 = "SELECT variant_id, variant FROM  cscart_product_feature_variant_descriptions
                where variant = '$str'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_assoc($result1);
	return $row1[variant_id];
}
function call_variant_insert($str1,$str2,$str3){
	$sql1 = "insert into cscart_product_features_values (feature_id,product_id, variant_id) values 
     	     	('$str1','$str2','$str3')";
	$result1 = mysql_query($sql1);
	echo $sql1."<br/>";
}


mysql_close();
?>