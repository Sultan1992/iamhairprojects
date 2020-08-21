<?php

$order_id = $_POST['ordno'];

include "lib/connect_iamahair.php";

$sql1 = "select count(*) as cnt from tmp_order_m where order_id = $order_id";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($result1);

if ($row1[cnt] > 0) {
	$sql = "update tmp_order_m set done = '' where order_id = $order_id";
	$result = mysql_query($sql);
echo $sql;
}
mysql_close();
?>
    <script>
        history.back();
    </script>