<?php  

// 1. ���� ��Ŭ��� ���� 
include ("./include.php");

if ($_SESSION['password']==""){
    ?>
    <script>
        alert("You must be logged in to post messages.");
        location.replace("../login.php");
    </script>
    <?
}

// 2. �α����� ȸ���� �ڷ� ������
if($_SESSION[user_id]){
	echo "<script>alert('Login has already.');history.go(-1);</script>";
}

?>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>
<body onload="document.registForm.m_id.focus()">
<?

$mode = $_GET['mode'];

if(!$mode) 
  $mode = "form";

if(!strcmp($mode, "form")) {

// 3. �Է� HTML ���
?>
<br/>
<form name="registForm" method="post" action="./board_register.php?mode=post" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">ID</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="m_id" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Name</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="m_name" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Password</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Confirm Password</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass2" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
</table>
    <!-- 4. ȸ������ ��ư Ŭ���� �Է��ʵ� �˻� �Լ� member_save ���� -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Register " onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.�Է��ʵ� �˻��Լ�
function member_save()
{
    // 7.�Է��� �˻�
	 if(!registForm.m_id.value) {
        // 8.���� ������ ���â���� �޼��� ��� �� �Լ� ����
        alert("Please enter a ID.");
		registForm.m_id.focus();
        return false;
    }

	if(!registForm.m_name.value) {
        alert("Please enter a name.");
		registForm.m_name.focus();
        return false;
    }

	if(!registForm.m_pass.value) {
        alert("Please enter a password.");
		registForm.m_pass.focus();
        return false;
    }

	if(registForm.m_pass.value != registForm.m_pass2.value) {
        // 9.��й�ȣ�� Ȯ���� ���� �ٸ��� ���â���� �޼��� ��� �� �Լ� ����
        alert("Please confirm password.");
		registForm.m_pass2.focus();
        return false;
    }

    // 10.�˻簡 �����̸� form �� submit �Ѵ�
    registForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {
// 3. �Ѿ�� ���� �˻�
/*
2. ȸ�����̵�(m_id) : 4~12�ڱ��� �����ϵ��� �ϰ� �ߺ��� �Ǹ� �ȵ˴ϴ�. (�������ڸ� ����)
 3. ȸ���̸�(m_name) : 4���̻� 10�� ����(�ѱ�2�� �̻� 5������ )
 4. ��й�ȣ(m_pass) : 4���̻� 20������ ��ȣȭ �Ǵ� ��й�ȣ �Դϴ�.(��ȣȭ�Ǹ� �ڸ����� ������ϴ�.)
 */

$m_id = $_POST[m_id];
$m_name = $_POST[m_name];
$m_pass = $_POST[m_pass];
$m_pass2 = $_POST[m_pass2];

if(trim($m_id) == ""){
	echo "<script>alert('Please enter a ID.');history.back();</script>";
    exit;
}

if(!preg_match("/^[a-zA-Z0-9]{4,12}$/", $m_id)){
	echo "<script>alert('���̵�� �������ڸ�  4~12���̳��� �Է��� �ּ���.');history.go(-1);</script>";
	exit;
}

if(trim($m_name) == ""){
	echo "<script>alert('Please enter a name.');history.back();</script>";
    exit;
}

if(preg_match("/[:;'\" ]+/", $m_name)){
	echo "�̸��� Ư������(:;') ���� 5���̳��� �Է��� �ּ���";
	exit;
}

if(!preg_match("/^.{1,20}$/", $m_name)){
	echo "�̸��� Ư������(:;') ���� 10���̳��� �Է��� �ּ���";
	exit;
}

if($m_pass == ""){
	echo "<script>alert('Please enter a password.');history.back();</script>";
    exit;
}

if(!preg_match("/^[a-zA-Z0-9_@#$%^&*!-]{4,20}$/", $m_pass)){
	echo "<script>alert('��й�ȣ�� ���빮��/���ҹ���/����/Ư������  4~20���̳��� �Է��� �ּ���.');history.go(-1);</script>";
	exit;
}

if($m_pass != $m_pass2){
   	echo "<script>alert('Please enter a password.');history.back();</script>";
    exit;
}

// 4. ���� ���̵� �ִ��� �˻�
$chk_sql = "select * from tb_member where m_id = '".trim($m_id)."'";
$chk_data = sql_get_row($chk_sql);

// 5. ���Ե� ���̵� ������ �ǵ�����
if($chk_data[m_idx]){
   	echo "<script>alert('ID is already registered.');history.back();</script>";
    exit;
}

// 6. ȸ������ ����
$sql = "insert into tb_member (m_id, m_name, m_pass) values ('".trim($m_id)."', '".trim($m_name)."', password('".$m_pass."'))";
sql_query($sql);

// 7. �α��� �������� ������
?>
<script>
alert("Register was successed.");
location.replace("board_login.php");
</script>
</body>
<?php 
}

// DB �ݱ�
db_close();
?>