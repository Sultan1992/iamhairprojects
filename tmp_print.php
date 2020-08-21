<html>
<head>

</head>

<body style="margin:50px 100px 100px 50px">

<?php
$ck = $_POST['ck'];
$gb = $_POST['gb'];
$ct = count($ck);

include "lib/connect_iamahair.php";

 $pos = strpos($ck[0],":");
 $orderid = substr($ck[0],0,$pos);
 $itemid = substr($ck[0],$pos+1);

$sql9 = "SELECT * FROM  cscart_order_details where order_id = $orderid and item_id = $itemid";
$result9 = mysql_query($sql9);
$row9 = @mysql_fetch_assoc($result9);

 $company = $row9[product_code];
 $pos = strpos($company,"-");
 $company = substr($company,0,$pos);

?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="main-table" style="height: 100%; background-color: #f4f6f8; font-size: 12px; font-family: Arial;">
<tr>
	<td align="center" style="width: 100%; height: 100%;">
	<table cellpadding="0" cellspacing="0" border="0" style=" width: 780px; table-layout: fixed; margin: 14px 0 14px 0;">
	<tr>
		<td style="background-color: #ffffff; border: 1px solid #e6e6e6; margin: 0px auto 0px auto; padding: 0px 44px 0px 46px; text-align: left;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding: 27px 0px 0px 0px; border-bottom: 0px solid #868686; margin-bottom: 8px;">
			<tr>
				<td align="left" style="padding-bottom: 3px;" valign="middle"></td>
				<td>
				</td>
								
				<td width="100%" valign="top" style="padding-left: 20px;">
					<h2 style="font: bold 22px Tahoma; margin: 0px;">ORDER FORM</h2>
					<div align="right">
						<table width="95%" cellpadding="0" cellspacing="0" border="0" align="right">
							<tr valign="top">
								<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;" align="right"></td>
								<td style="font-size: 12px; font-family: Arial;" align="right" width="80">
								</td>
							</tr>
							<tr valign="top">
								<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;" align="right"></td>
								<td style="font-size: 12px; font-family: Arial;" align="right" width="80"></td>
							</tr>
							<tr valign="top">
								<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;" align="right">
								Date:</td>
								<td style="font-size: 12px; font-family: Arial;" align="right" width="80">
								<?=date('m/d/Y');?></td>
							</tr>
						</table></div>
				</td>
							</tr>
			</table>

			<hr style="margin:15px 0 15px 0;">

			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr valign="top">
								<td style="width: 34%; padding: 0 0px 0px 2px; font-size: 12px; font-family: Arial;">
					<h3 style="font: bold 17px Tahoma; padding: 0px 0px 3px 1px; margin: 0px;">
					To : <?=$company;?></h3></td>
																<td width="33%" style="font-size: 12px; font-family: Arial; padding-right: 10px; "></td>
				

												<td width="33%" style="font-size: 12px; font-family: Arial;">
					<h2 style="font: bold 19px Arial; margin: 0px 0px 3px 0px;">
					From : Hair Depot Plus</h2>317 Mannheim Rd,<br />
					Bellwood, Illinois 60104<br />
					<table cellpadding="0" cellspacing="0" border="0" id="table1">
										<tr valign="top">
						<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px;	white-space: nowrap; font-style:normal; font-variant:normal; font-weight:normal">Phone:</td>
						<td width="100%" style="font-size: 12px; font-family: Arial; color:#000000; font-style:normal; font-variant:normal; font-weight:normal">708-632-4333</td>
					</tr>
																				</table>
					<p style="font: bold 17px Tahoma; padding: 0px 0px 3px 1px; margin: 0px;"></td>
																</tr>
			</table>

		<hr style="margin:20px 0 30px 0">
		
			<p><b>&nbsp;( If 1st color is not available, Please send 2nd color)</b></p>
		
			<table width="100%" cellpadding="0" border="1" cellspacing="0" style="background-color: #dddddd; -webkit-print-color-adjust:exact; border-collapse:collapse;">
			<tr>
				<th width="50%" style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial; -webkit-print-color-adjust:exact; ">Product</th>
				<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial; -webkit-print-color-adjust:exact; ">
				Option(1st Color,2nd Color)</th>
				<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial; -webkit-print-color-adjust:exact; ">Q'ty</th>
				<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial; -webkit-print-color-adjust:exact; ">Notes</th>
			</tr>
<form method="post" action="./tmp_dateset.php">
<?

for($i=0;$i<$ct;$i++) {

 $pos = strpos($ck[$i],":");
 $orderid = substr($ck[$i],0,$pos);
 $itemid = substr($ck[$i],$pos+1);

$sql = "SELECT * FROM  cscart_order_details where order_id = $orderid and item_id = $itemid";
$result = mysql_query($sql);
$row = @mysql_fetch_assoc($result);

 $str=$row['extra'];

 $str1 = strstr($str, "variant_name");
 $str1 = strstr($str1, ":");
 $str1 = strstr($str1, ":");
 $pos = strpos($str1,";");
 $color1 = substr($str1,3,$pos-3);
 $color1 = str_replace(":", "", $color1);
 $str2 = substr($str1,20);
 $color2 = strstr($str2, "variant_name");
 $color2 = strstr($color2, ":");
 $color2 = strstr($color2, ":");
 $pos = strpos($color2,";");
 $color2 = substr($color2,3,$pos-3);
 $color2 = str_replace(":", "", $color2);


$sql8 = "SELECT remarks FROM  tmp_order where order_id = $orderid and item_id = $itemid";
$result8 = mysql_query($sql8);
$row8 = mysql_fetch_assoc($result8);
if ($row8[remarks] == ""){
	$t_remarks = "-";
} else {
	$t_remarks = $row8[remarks];
}

$sql22 = "SELECT * FROM  `cscart_shipment_items` where item_id = $itemid 
           and order_id = $orderid";
$result22 = mysql_query($sql22);
$row22 = mysql_fetch_assoc($result22);

 $sql1 = "SELECT * FROM  `cscart_product_descriptions` where product_id = $row[product_id]";
 $result1 = mysql_query($sql1);
 $row1 = @mysql_fetch_assoc($result1);

 $sql2 = "SELECT * FROM  `cscart_products` where product_id = $row[product_id]";
 $result2 = mysql_query($sql2);
 $row2 = @mysql_fetch_assoc($result2);

 if ($color1 != "" and $color2 != ""){
/*
 $col1 = str_replace(' (Low)','',$color1);
 $sql3 = "SELECT * FROM  `tmp_product_upc` where product_id = $row[product_id] and color = trim($col1)";
 $result3 = mysql_query($sql3);
 $row3 = @mysql_fetch_assoc($result3);
 $upc1 = $row3[upc];

 $col2 = str_replace(' (Low)','',$color2);
 $sql3 = "SELECT * FROM  `tmp_product_upc` where product_id = $row[product_id] and color = trim($col2)";
 $result3 = mysql_query($sql3);
 $row3 = @mysql_fetch_assoc($result3);
 $upc2 = $row3[upc];
*/
 $color =  $color1." , ".$color2;
 }else if ($color1 != ""){
 $color =  $color1."[CODE:".$row2[product_code]."]";
 }else{
 $color =  "[CODE:".$row2[product_code]."]";
 }

?>
														<tr>
					<td style="padding: 1px 10px; background-color: #ffffff; font-size: 12px; font-family: Arial;"><?=$row1[product];?></td>
					<td style="padding: 3px 10px; background-color: #ffffff; text-align: center; font-size: 12px; font-family: Arial;"><?=$color;?></td>
						
<?
	if ($row[amount]-$row22[amount] > 1) {
?>						
					<td style="padding: 3px 10px; background-color: #ffffff; text-align: center; white-space: nowrap; font-size: 16px; font-family: Arial;  color: RED; font-weight:bold;"><?=$row[amount]-$row22[amount];?></td>
<?
	} else {
?>
					<td style="padding: 3px 10px; background-color: #ffffff; text-align: center; white-space: nowrap; font-size: 12px; font-family: Arial;"><?=$row[amount]-$row22[amount];?></td>
<?
}
?>
					<td style="padding: 3px 10px; background-color: #ffffff; font-size: 12px; font-family: Arial;"><?=$t_remarks;?></td>
<input type="hidden" name="itemid[]" value="<?=$itemid;?>">
<input type="hidden" name="orderid[]" value="<?=$orderid;?>">

				</tr>										
<?
}
?>
														</table>

																					
				<p>		</td>
	</tr>

	</table>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr></tr>
<tr><p><td height="17" align="center" ><input type="submit" value="If you do click, then OrdDate will be Update..." onclick="submit()"></td></tr>
</form>
</table>
</body>
</html>