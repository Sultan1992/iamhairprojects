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

<body>
<table border="0" width="800" height="55">
	<tr>
		<td>
		</td>
	</tr>
</table>
<?php

$nowDate = date("Y-m-d H:i",time());

?>

<table border="0" width="100%" height="26">
	<tr>
<td width="20%" align="left">
<form method="post" action="./tmp_done.php">
<input type="text" size="10" name="ordno">
<input type="submit" value="Done(X)">
</form>
</td>
	</tr>
</table>
<?

include "lib/connect_iamahair.php";

$sql = "SELECT *  FROM  tmp_order_m 
	where  gubun in ('R','B','O') and done != 'Y' order by order_id desc";

$result = mysql_query($sql);
?>
<table border="1" width="800" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#F4f4f4">INV#</td>
    <td height="16" align="center" bgcolor="#F4f4f4">OrderDate</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer Notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Staff only notes</td>
    <td height="16" align="center" bgcolor="#F4f4f4">CS Memo</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Status</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Button</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Customer</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Phone</td>
    <td height="16" align="center" bgcolor="#F4f4f4">Payment</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

$sql2 = "SELECT *,DATE_FORMAT(from_unixtime(timestamp),'%m/%d/%Y') as timestamp  FROM  cscart_orders 
	where order_id = $row[order_id]";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($result2);

if ($row2[user_id] > 0) {
$sql33 = "SELECT count(*) as cnt FROM  `cscart_orders` where status = 'C' and user_id = $row2[user_id]";
$result33 = mysql_query($sql33);
$row33 = mysql_fetch_assoc($result33);
$cnt = $row33[cnt];
} else {
$cnt = 0;
}

$sql3 = "SELECT payment  FROM  cscart_payment_descriptions where payment_id = $row2[payment_id]";
$result3 = mysql_query($sql3);
$row3 = mysql_fetch_assoc($result3);

?>

<tr>

    <td height="17" align="center" bgcolor="#F4f4f4"><a href="http://iamahair.com/myadmin.php?dispatch=orders.details&order_id=<?=$row[order_id];?>" target="_blank">#<?=$row[order_id];?></a></td>
    <td height="17" width="80" align="center" bgcolor="#F4f4f4">
<?
 echo $row2[timestamp];
if ($cnt > 0 ) {
?>
<a href="http://iamahair.com/myadmin.php?dispatch=orders.manage&user_id=<?=$row2[user_id];?>" target="_blank">
<?
echo "<br/>+".$cnt."+";
?></a>
<?

} else {
//echo "<br/>+".$cnt."+";
}
?></td>

<form method="post" action="./tmp_write3.php">
<input type="hidden" name="order_id" value="<?=$row[order_id];?>">
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea style="background-color:#F4F4F4;" name="notes" rows="6" cols="20"><?=$row2[notes];?></textarea></td>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="details" rows="6" cols="30"><?=$row2[details];?></textarea></td>
    <td width="150" height="17" align="center" bgcolor="#F4f4f4"><textarea name="cs_memo" rows="6" cols="30"><?=$row[cs_memo];?></textarea></td>
<td>
<input type="radio" name="gubun" value="B" <?if($row["gubun"] == 'B'){?>checked<?}?>>B
<input type="radio" name="gubun" value="R" <?if($row["gubun"] == 'R'){?>checked<?}?>>R
<input type="radio" name="gubun" value="O" <?if($row["gubun"] == 'O'){?>checked<?}?>>O
</td>
    <td height="17" align="center" bgcolor="#F4f4f4">	<div class="buttons-container nowrap">
		<div class="float-center">
<input type="checkbox" name="done" value="Y">Done<p>			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Submit"/></span>
		</div>

	</div></td>
    <td width="120" height="17" align="center" bgcolor="#F4f4f4"><?=$row2[s_firstname]." ".$row2[s_lastname];?></td>
    <td width="200" height="17" align="center" bgcolor="#F4f4f4"><?=$row2[phone];?></td>
    <td width="400" height="17" align="center" bgcolor="#F4f4f4"><?=$row3[payment];?></td>
</tr>
 </form>
<?php
}
?>
</table>
<?php
?>

</html>