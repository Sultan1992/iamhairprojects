<?php
include "session.php";
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

include '../lib/connect_'.$gubun.'.php';

$sql = "SELECT distinct parent  FROM  tmp_chemical where parent <> ''";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {

	$t_option = '';
	$sql1 = "SELECT *  FROM  tmp_chemical where itemcode = '$row[parent]'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_assoc($result1);

	$m_weight = $row1[weight];
	$m_price = number_format(floor($row1[price]*1.3)+0.99,2);
	$t_option = trim($row1[option])."!".trim($row1[barcode])."!0!0";

	$sql2 = "SELECT *  FROM  tmp_chemical where parent = '$row[parent]' order by seq";
	$result2 = mysql_query($sql2);

	while ($row2 = mysql_fetch_assoc($result2)) {

		$h_weight =  $row2[weight] - $m_weight;
		$h_price = number_format(floor($row2[price]*1.3)+0.99,2) - $m_price;
		$t_option = $t_option.",".trim($row2[option])."!".trim($row2[barcode])."!".$h_price."!".$h_weight;

	}
$sql3 =  "update tmp_chemical set barcode = '' , tmp_chemical.option = '$t_option' where itemcode = '$row[parent]'";
$result3 = mysql_query($sql3);
echo $sql3."<br/>";
}
echo "==================================="."<br/>";
echo "CHEMICAL UPDATE ¿Ï·á...";echo "<br />";
echo "==================================="."<br/>";

mysql_close();
?>