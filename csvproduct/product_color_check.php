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

@set_time_limit(0);
@ini_set('memory_limit',-1);

$gubun = $_POST['gubun'];
$vendor = $_POST['vendor'];
$ck = $_POST['ck'];

if ($vendor == 'sensationnel') {
	$vendor = 'HZ';
}

include '../lib/connect_'.$gubun.'.php';

echo "Products Color Stock Update";echo "<br />";
echo "=================================";echo "<br />";
if ($vendor <> 'Alicia') {
$sql = "SELECT * FROM `tmp_product_upc` WHERE SUBSTRING_INDEX(product_code, '-', 1) = '$vendor' and upc <> ''";
} else {
$sql = "SELECT * FROM `tmp_product_upc` WHERE SUBSTRING_INDEX(product_code, '-', 1) in ('FoxySilver','FoxyLady','CareFree') and upc <> ''";
}

if ($vendor == 'itsawig') {
$sql = "SELECT * FROM `tmp_product_upc` WHERE SUBSTRING_INDEX(product_code, '-', 1) in ('Itsawig','Mimosa') and upc <> ''";
}

$result = mysql_query($sql);


while ($row = mysql_fetch_assoc($result)) {

	$sql = "SELECT *  FROM  xls_inventory where x_upc = '$row[upc]'";

	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_assoc($result1);

	$sw = "";

		if ($row1[x_qty] <= "5" or strtoupper($row1[x_qty]) == "LOW STOCK" or strtoupper($row1[x_qty]) == "NOT IN STOCK" or $row1[x_qty] == "N" or strtoupper($row1[x_qty]) == "OUT OF STOCK" or mysql_num_rows($result1) == 0) {

			$sw = ' (Low)';
		}

		$sql = "SELECT b.option_id FROM  cscart_products as a inner join cscart_product_options as b 
			on a.product_id = b.product_id where a.product_code = '$row[product_code]' and a.status = 'A'";

		$result2 = @mysql_query($sql);

$cnt = 0;

		while ($row2 = @mysql_fetch_assoc($result2)) {

		if ($cnt == 0) {
			echo "--".$row[product_name]."<br/>";
		}

			$sql = "SELECT b.variant_id, variant_name FROM  cscart_product_option_variants as a inner join 
				cscart_product_option_variants_descriptions as b 
				on a.variant_id = b.variant_id where a.option_id = $row2[option_id]";
			$result3 = @mysql_query($sql);

			while ($row3 = @mysql_fetch_assoc($result3)) {


				if (trim(str_replace(' (Low)','',$row[color])) == trim(str_replace(' (Low)','',$row3[variant_name]))) {

					$color_name = str_replace(' (Low)','',$row3[variant_name]).$sw;

					$sql = "update cscart_product_option_variants_descriptions set variant_name = '$color_name'
							 where variant_id = $row3[variant_id]";

					if ($cnt == 0) {
						echo $sql."<br/>";
						echo $row2[option_id]." : ".$row3[variant_id]." : ".$color_name."<br/>";
					}
					if ($ck == 'on'){
						$result4 = mysql_query($sql);
						if ($sw == ''){
							$sql2 = "update cscart_product_option_variants set status = 'A'
							 	where variant_id = $row3[variant_id]";
							$result5 = mysql_query($sql2);
						}
					}
	
				}

			}
$cnt = $cnt + 1;

	}
}
echo "==================================="."<br/>";
echo "Products Color Stock Update END";echo "<br />";
echo "==================================="."<br/>";


mysql_close();
?>