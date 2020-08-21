<?php
$itemid = $_POST['itemid'];
$orderid = $_POST['orderid'];

$ct = count($itemid);

include "lib/connect_iamahair.php";

for($i=0;$i<$ct;$i++) {

$sdate = date('m/d');
$week = date("w");
switch($week){
case 0 : $edate = date('m/d',strtotime("+3 day")); break;
case 1 : $edate = date('m/d',strtotime("+2 day")); break;
case 2 : $edate = date('m/d',strtotime("+2 day")); break;
case 3 : $edate = date('m/d',strtotime("+2 day")); break;
case 4 : $edate = date('m/d',strtotime("+4 day")); break;
case 5 : $edate = date('m/d',strtotime("+4 day")); break;
case 6 : $edate = date('m/d',strtotime("+3 day")); break;
}

$sql1 = "select count(*) as cnt from tmp_order where item_id = $itemid[$i]
          and order_id = $orderid[$i]";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($result1);

if ($row1[cnt] > 0) {
	$sql = "update tmp_order set order_dt = '$sdate', expire_dt = '$edate'
		 where item_id = $itemid[$i] and order_id = $orderid[$i]";
}else{
	$sql = "insert into tmp_order (item_id,order_id,order_dt,expire_dt) values  
     	     ($itemid[$i],$orderid[$i],'$sdate','$edate')";
}

$result = mysql_query($sql);
$row = @mysql_fetch_assoc($result);

}
mysql_close();
echo "<meta http-equiv='refresh' content='0;url=iamahair_order__4.php'>";
?>
