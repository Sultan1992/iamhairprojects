<?php  
// 1. ���� ��Ŭ��� ����
include ("./include.php");

// 2. �α����� ȸ���� �ڷ� ������
if($_SESSION[user_id]){
	echo "<script>alert('Login has already.');history.go(-1);</script>";
}

?>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<!--
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>
-->
<body onload="document.loginForm.m_id.focus()">
<?

$mode = $_GET['mode'];

if(!$mode) 
  $mode = "form";

if(!strcmp($mode, "form")) {
// 3. �Է� HTML ���
?>
<br/>
<form name="loginForm" method="post" action="./board_login.php?mode=post" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">ID</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="m_id" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Password</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
</table>
    <!-- 4. �α��� ��ư Ŭ���� �Է��ʵ� �˻� �Լ� login_chk ���� -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Login " onClick="login_chk();"></td>
    </tr>
</table>
</form>
<script>
// 5.�Է��ʵ� �˻��Լ�
function login_chk()
{
    // 7.�Է��� �˻�
    if(!loginForm.m_id.value){
        // 8.���� ������ ���â���� �޼��� ��� �� �Լ� ����
        alert("Please enter a ID.");
        return false;
    }

    if(!loginForm.m_pass.value){
        alert("Please enter a Password.");
        return false;
    }

    // 9.�˻簡 �����̸� form �� submit �Ѵ�
    loginForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {

	$m_id = $_POST[m_id];
	$m_pass = $_POST[m_pass];

	// 3. �Ѿ�� ���� �˻�
	if(trim($m_id) == ""){
		echo "<script>alert('Please enter a ID.');history.back();</script>";
		exit;
	}

	if($m_pass == ""){
		echo "<script>alert('Please enter a Password.');history.back();</script>";
		exit;
	}

	// 4. ���� ���̵� �ִ��� �˻�
	$chk_sql = "select m_pass, m_idx, m_id, m_name, password('".trim($m_pass)."') input_pass from tb_member where m_id = '".trim($m_id)."'";
	$chk_data = sql_get_row($chk_sql);

	// 5. ���̵� ���� �ϴ� ���
	if($chk_data[m_idx]){

		// 5. �Էµ� ��й�ȣ�� ����� ��й�ȣ�� ������ ���ؼ�
		if($chk_data[input_pass] == $chk_data[m_pass]){
			// 6. ��й�ȣ�� ������ ���ǰ� �ο� �� �̵�
			$_SESSION[user_idx] = $chk_data[m_idx];
			$_SESSION[user_id] = $chk_data[m_id];
			$_SESSION[user_name] = $chk_data[m_name];

			echo "<script>location.replace('board_list.php');</script>";
			exit;
		}else{
			// 7. ��й�ȣ�� �ٸ���
			echo "<script>alert('Password is incorrect.');history.back();</script>";
			exit;
		}
	}else{
		// 8. ���̵� �������� ������
		echo "<script>alert('Menber does not exist.');history.back();</script>";
		exit;
	}

}

// DB �ݱ�
db_close();
?>