<?
include '../lib/session.php';
?>
<html>
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
echo $vendor." Import starting..."."<br/>";
echo "==================================="."<br/>";

$file_path = "./csv/".$vendor.".csv";
$file_list = file($file_path); 
$file_date = explode(",",$file_list[0]); 

	$sql1 = "delete from tmp_products";
	$result1 = mysql_query($sql1);

for($i=0, $a=count($file_list);$i<$a;$i++){ 
	$array = split(',',$file_list[$i]);
	for($j=0;$j< sizeof($array);$j++){
		 echo "[".$j."]".$array[$j]."<br />";
	}
	$array[0] = str_replace("'", "''", $array[0]);
	$array[12] = str_replace("'", "''", $array[12]);
	$array[12] = str_replace('CHR(10)',"",$array[12]);
	$array[12] = str_replace('CHR(13)',"",$array[12]);
	$sql1 = "insert into tmp_products
		values ('$array[0]','$array[1]','$array[2]','$array[3]',
		'$array[4]',trim('$array[5]'),'$array[6]','$array[7]',$array[8],$array[9],'$array[10]',
		'$array[11]','$array[12]','$array[13]','$array[14]')";
	$result1 = mysql_query($sql1);
echo $sql1."<br/>";
}
//mysql_close();
echo "==================================="."<br/>";
echo $vendor." Import Finished."."<br/>";
echo "==================================="."<br/>";
?>
</html>