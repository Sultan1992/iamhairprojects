<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Orders :: View orders - Administration panel</title>
<link href="/skins/basic/admin/images/icons/favicon.ico" rel="shortcut icon" />

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

</head>

<body onload="document.stock_chk.bt.focus()">
<table border="0" width="100%" height="55">
	<tr>
		<td>
		</td>
	</tr>
</table>



<?php
 
$hostname="localhost";
$username="cocos";
$password="hair123!@#";
$db="cocos_com";

$conn = mysqli_connect("$hostname", "$username", "$password",$db);

if (mysqli_connect_errno()){
echo "not connected to database";
}

 ?>
 <?phP
 
$sql = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  `cscart_orders`
order by order_id desc";

$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) == 0) {
   echo "No rows found, nothing to print so am exiting";
   exit;
}

$sql= "SELECT qty_c,qty_p1,qty_p3 from cscart_product_option_variants_descriptions ";


$result = mysqli_query($conn,$sql);

/*
select*FROM  cscart_products p INNER JOIN cscart_product_options po ON p.product_id=po.product_id
INNER JOIN cscart_product_options_descriptions pod ON po.option_id=pod.option_id
INNER JOIN cscart_product_option_variants pov on pod.option_id=pov.option_id
INNER JOIN cscart_product_option_variants_descriptions povd ON pov.variant_id=povd.variant_id" ;
*/
$result=mysqli_query($conn,$sql);
?>
<table border='1' width='800'border-color='#f3f3f3' cellspacing='0'>
    <tr>
     <th colspan="3">Stock</th>
    </tr>
  <tr>
   <th height='16' align='center' bgcolor='#F4f4f4'>Qty-C</th>
  <th height='16' align='center' bgcolor='#F4f4f4'> Qty-p1</th>
  <th height='16' align='center' bgcolor='#F4f4f4'>Qty_p3</th>

</tr>

  <?php


 while($row=mysqli_fetch_array($result)){
     
  ?>
 <tr>
 <td><?php echo $row["qty_c"];?></td>
 <td><?php echo $row["qty_p1"];?> </td>
 <td><?php echo $row["qty_p3"];?> </td>
 </tr>
<?php
 }
 mysqli_free_result($result);
?>
</table>

</html>