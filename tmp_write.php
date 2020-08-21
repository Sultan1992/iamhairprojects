<?php

$ord_dt = $_POST['ord_dt'];
$exp_dt = $_POST['exp_dt'];
$item_id = $_POST['item_id'];
$order_id = $_POST['order_id'];
$remarks = $_POST['remarks'];
$notes = $_POST['notes'];
$details = $_POST['details'];
$status = $_POST['status'];
$gb = $_POST['gb'];

include "lib/connect_iamahair.php";

$sql1 = "select count(*) as cnt from tmp_order where item_id = $item_id
          and order_id = $order_id";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($result1);

if ($row1[cnt] > 0) {
	$sql = "update tmp_order set order_dt = '$ord_dt', expire_dt = '$exp_dt',
                 remarks = '$remarks' where item_id = $item_id 
             and order_id = $order_id";
}else{
	$sql = "insert into tmp_order values
     	     ('$item_id','$order_id','$ord_dt','$exp_dt','$remarks')";
}
$result = mysql_query($sql);
$row = @mysql_fetch_assoc($result);

$sql2 = "update cscart_orders set notes = '$notes', details = '$details'
               where order_id = $order_id";
$result2 = mysql_query($sql2);
$row2 = @mysql_fetch_assoc($result2);
mysql_close();
if ($gb == "1"){
echo "<meta http-equiv='refresh' content='0;url=iamahair_order__1.php'>";
}else{
echo "<meta http-equiv='refresh' content='0;url=iamahair_order__2.php'>";
}
?>