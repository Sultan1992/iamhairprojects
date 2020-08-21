<?php  
 // 1. 세션사용은 위한 초기화
 session_start();
 
// 2. 사용자 정의 함수 include
 include ("./lib.php");
 
// 4. head 부분 
?>

<table border="0" width="100%" height="45">
	<tr>
		<td>

		</td>
	</tr>
</table>

 <table style="width:1000px;height:20px;">
     <tr>
	<h1 class="mainbox-title"><font color="#0794C2">
			CS Board
	</font></h1><p>
     </tr>

 <td align="right">
<a href="./board_list.php">List</a>
&nbsp;&nbsp;&nbsp;
<a href="./board_write.php">Write</a>
&nbsp;&nbsp;&nbsp;
<?
         if($_SESSION[user_id]){
         ?>
         <a href="./board_logout.php">Logout</a>
         <?}else{?>
         <a href="./board_login.php">Login</a>
         <?}?>
&nbsp;&nbsp;&nbsp;
<?
         if($_SESSION[user_id]){
         ?>
         <a href="./board_member_modify.php">Change PW</a>
         <?}else{?>
         <a href="./board_register.php">Register</a>
         <?}?>
&nbsp;&nbsp;&nbsp;[<?=$_SESSION[user_name]?>]
</td>
</table>
 <p>