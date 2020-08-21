
<html>
<head>
<!--
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" /><title>Company Address</title>
<link href="/skins/basic/customer/images/icons/favicon.ico" rel="shortcut icon" />

<link href="/skins/basic/customer/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

</head>
<?php

$conn = mysql_connect("localhost", "cocos", "hair123!@#");
if (!$conn) {
     echo "Unable to connect to DB: " . mysql_error();
     exit;
 }
   
 if (!mysql_select_db("cocos_com")) {
     echo "Unable to select mydbname: " . mysql_error();
     exit;
 }

$sql = "select * from tb_board where b_idx = 252";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);


?>
<body bgcolor="#F4F4F4">

<table border=0>
<tr>
    <td  width="800" align="left"><?=str_replace("\n","<br/>",$row[b_contents]);?></td>
</tr>
</table>

</body>
</html>