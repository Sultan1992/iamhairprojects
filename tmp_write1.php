<?php

$order_id = $_POST['order_id'];
$remarks = $_POST['remarks'];
$gb = $_POST['gb'];

include "lib/connect_iamahair.php";

$sql1 = "select count(*) as cnt from tmp_order_m where order_id = $order_id";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($result1);

if ($remarks != "") {
$remarks = "---[".date("m/d/Y",strtotime("-6 hours"))."]---\r\n".$remarks;
}
if ($row1[cnt] > 0) {
	$sql = "update tmp_order_m set remarks = '$remarks' where order_id = $order_id";
}else{
	$sql = "insert into tmp_order_m (order_id,remarks) values    ('$order_id','$remarks')";
}

$result = mysql_query($sql);
$row = @mysql_fetch_assoc($result);

mysql_close();
if ($gb == "1"){
echo "<meta http-equiv='refresh' content='0;url=iamahair_order__3.php'>";
}else{
echo "<meta http-equiv='refresh' content='0;url=iamahair_order__33.php'>";
}
?>