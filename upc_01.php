<?php
include "session.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Stock :: View Stocks - Administration panel</title>
<link href="/skins/basic/admin/images/icons/favicon.ico" rel="shortcut icon" />

<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

	<style>
	/* 
	Generic Styling, for Desktops/Laptops 
	*/
	table { 
		width: 100%; 
		border-collapse: collapse; 
	}
	/* Zebra striping */
	tr:nth-of-type(odd) { 
		background: #eee; 
	}
	th { 
		background: #333; 
		color: white; 
		font-weight: bold; 
	}
	td, th { 
		padding: 6px; 
		border: 1px solid #ccc; 
/*		text-align: left;   */
	}
	</style>

</head>

<body onload="document.form1.keyword.focus()">

<table border="0" width="100%" height="72">
	<h1 class="mainbox-title">
			<font color=white>iamahair.com -- Product UPC Update</font>

	</h1><p>
</table>

<br>
<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
<table border="0" width="100%" height="5"><div align=center>
<select name="cmbData">
	<option value="" <?if ($_GET['cmbData'] == ""){echo "selected";}?>>::::ALL::::</option>
	<option value="VIVICAFOX" <?if ($_GET['cmbData'] == "VIVICAFOX"){echo "selected";}?>>VIVICAFOX</option>
	<option value="CHADE" <?if ($_GET['cmbData'] == "CHADE"){echo "selected";}?>>CHADE</option>
	<option value="ITSAWIG" <?if ($_GET['cmbData'] == "ITSAWIG"){echo "selected";}?>>ITSAWIG</option>
	<option value="HZ" <?if ($_GET['cmbData'] == "HZ"){echo "selected";}?>>HZ</option>
	<option value="MOTOWN" <?if ($_GET['cmbData'] == "MOTOWN"){echo "selected";}?>>MOTOWN</option>
	<option value="MODELMODEL" <?if ($_GET['cmbData'] == "MODELMODEL"){echo "selected";}?>>MODELMODEL</option>
	<option value="OUTRE" <?if ($_GET['cmbData'] == "OUTRE"){echo "selected";}?>>OUTRE</option>
	<option value="VANESSA" <?if ($_GET['cmbData'] == "VANESSA"){echo "selected";}?>>VANESSA</option>
	<option value="SNG" <?if ($_GET['cmbData'] == "SNG"){echo "selected";}?>>SNG</option>
</select>
<input height="30" type="text" name="keyword" value="<?=$_GET['keyword'];?>" style=height:22px>
<input type="submit" value="search" style=height:22px>
</table>
<br>
</form>

<form method="post" action="./upc_insert_notfound.php">
<div align=right>
	<tr>
		<td height="40" bgcolor="#f9efd1">RECREATE<input type="checkbox" name="ck">[Product Code]:<input size="30" type="text" name="product_code" style="color:white;background-color:#00A651;></td>
		<td bgcolor="#FFFFFF"><input   type="submit" value="CREATE"></td>
	</tr>
</div>
</form>
<br>


<?php

$keyword = $_GET['keyword'];
$cmbData = $_GET['cmbData'];
$currentPage = $_REQUEST["page"]; 
if(!$currentPage) $currentPage = 1; 

$recordPerPage = 16; // ǤL¶ ´堻Ѹ± ·¹Śµ㠼�$pagePerBlock = 15; // [1] ~ [10] ± ȑ¹�0°³¾¿ 
$stno = ($currentPage -1) * $recordPerPage;

?>
<!--
<table border="0" width="100%" height="10">
	<tr>
		<td>
		</td>
	</tr>
</table>
-->
<?

include "lib/connect_iamahair.php";

if ($cmbData == "") {
$sql = "SELECT *  FROM  `tmp_product_upc` 
         where (product_name like '%$keyword%') or (product_code like '%$keyword%') or (upc like '%$keyword%')
	order by product_id desc,color limit $stno,$recordPerPage";
$result = mysql_query($sql);
$sql = "SELECT count(*) as cnt  FROM  `tmp_product_upc`  
        where (product_name like '%$keyword%') or (product_code like '%$keyword%') or (upc like '%$keyword%')";                  $temp =  mysql_query($sql);  // |ü ·¹Śµ彶
}else{
$sql = "SELECT *  FROM  `tmp_product_upc` 
         where ((product_name like '%$keyword%') or (product_code like '%$keyword%') or (upc like '%$keyword%'))
               and product_code  like '%$cmbData%'
	order by product_id desc,color limit $stno,$recordPerPage";
$result = mysql_query($sql);
$sql = "SELECT count(*) as cnt  FROM  `tmp_product_upc`  
        where ((product_name like '%$keyword%') or (product_code like '%$keyword%') or (upc like '%$keyword%'))                              and product_code  like '%$cmbData%'";
$temp =  mysql_query($sql);  // |ü ·¹Śµ彶
}
while($row = mysql_fetch_array($temp)) {
$totalRecord = $row['cnt'];
}

if (mysql_num_rows($result) == 0) {
     echo "No rows found, nothing to print so am exiting";
     exit;
 }
$totalNumOfPage = ceil($totalRecord/$recordPerPage); //16page 
?>
<table border="1" width="1000" border-color="#f3f3f3" cellspacing="0">
<div align="right">Page : <?=$currentPage?> / <?=$totalNumOfPage?>&nbsp;&nbsp;&nbsp;&nbsp;</div>
</table>
<form method="post" action="./upc_write.php">
<table border="1" width="1000" border-color="#f3f3f3" cellspacing="0">
  <tr>
    <td height="16" align="center" bgcolor="#FFFFFF">Product ID</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Product Name</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Product Code</td>
    <td height="16" align="center" bgcolor="#FFFFFF">Color</td>
    <td height="16" align="center" bgcolor="#FFFFFF">UPC Code</td>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {

?>
<tr>

    <td width="80" height="17" align="center" bgcolor="#F4f4f4"><?=$row[product_id];?></td>
    <td height="17" align="center" bgcolor="#F4f4f4"><?=$row[product_name];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><input size="30" type="text" name="product_code[]" value="<?=$row[product_code];?>"></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><?=$row[color];?></td>
    <td height="17" align="center" bgcolor="#FFFFFF"><input size="12" type="text" name="upc[]" value="<?=$row[upc];?>"></td>
    <input type="hidden" name="product_id[]" value="<?=$row[product_id];?>">
    <input type="hidden" name="color[]" value="<?=$row[color];?>">
</tr>
<?php
}
?>
</table>
<table border="0" width="1300" border-color="#f3f3f3" cellspacing="10" cellpadding="10">
<tr><td height="17" align="center" bgcolor="#F4f4f4">
	<div class="buttons-container nowrap">
		<div class="float-center">			
	<span  class="submit-button cm-button-main "><input   type="submit" value="Submit"/></span>
		</div>

	</div>
</td></tr>
</table>
 </form>
<?php


	$pagePerBlock=10;
 $totalNumOfBlock = ceil($totalNumOfPage/$pagePerBlock); //2block 
 $currentBlock = ceil($currentPage/$pagePerBlock); // 1page 

 $startPage = ($currentBlock-1)*$pagePerBlock+1;  // 1page 
 $endPage = $startPage+$pagePerBlock -1; // 10page 
 if($endPage > $totalNumOfPage) $endPage = $totalNumOfPage; 

 //NEXT,PREV xg ¿©º̠
 $isNext = false; 
 $isPrev = false; 

 if($currentBlock < $totalNumOfBlock) $isNext = true; 
 if($currentBlock > 1) $isPrev = true; 

 if($totalNumOfBlock == 1){ 
 $isNext = false; 
 $isPrev = false; 
 }  
?>
<table border="0" width="1000" border-color="#f3f3f3" cellspacing="0">
<br><td align="center">
<?

 if($isPrev){ 
 $goPrevPage = $startPage-$pagePerBlock; // 11page 
 echo "<a href=\"$PHP_SELF?cmbData=$cmbData&keyword=$keyword&page=$goPrevPage\"  target='main'><font color='4C566C'>  [<]  </font></a>"; 
 } 
 for($i=$startPage;$i<=$endPage;$i++){ 
 echo "<a href=\"$PHP_SELF?cmbData=$cmbData&keyword=$keyword&page=$i\"  target='main'><font color='4C566C'>  [".$i."]  </font></a>"; 
 } 
 if($isNext){ 
 $goNextPage = $startPage+$pagePerBlock; // 11page 
 echo "<a href=\"$PHP_SELF?cmbData=$cmbData&keyword=$keyword&page=$goNextPage\"  target='main'><font color='4C566C'>  [>]  </font></a>"; 
 } 
mysql_close($conn);
?>
</td>
</table>
</html>