<?php  
// 1. ���� ��Ŭ��� ���� 
include ("./include.php");

// 2. �α��� ���� ȸ���� �α��� �������� ������
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("Please LOGIN...");
        location.replace("board_login.php");
    </script>
    <?
}

?>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>
<?

$mode = $_GET['mode'];

if(!$mode) 
  $mode = "form";

if(!strcmp($mode, "form")) {
// 3. �Է� HTML ���
?>
<br/>
<form name="modifyForm" method="post" action="./board_member_modify.php?mode=post" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">New Password</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Confirm Password</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass2" style="font-size:20px;width:380px;height:50px;"></td>
    </tr>
</table>
    <!-- 4. �������� ��ư Ŭ���� �Է��ʵ� �˻� �Լ� member_save ���� -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value="Submit" onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.�Է��ʵ� �˻��Լ�
function member_save()
{
    if(!modifyForm.m_pass.value){
        alert("Please enter a password.");
        return false;
    }

    if(modifyForm.m_pass.value != modifyForm.m_pass2.value){
        // 8.��й�ȣ�� Ȯ���� ���� �ٸ��� ���â���� �޼��� ��� �� �Լ� ����
        alert("Please Confirm password..");
        return false;
    }

    // 10.�˻簡 �����̸� form �� submit �Ѵ�
    modifyForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {
// 3. �Ѿ�� ���� �˻�
if($_POST[m_pass] == ""){
    ?>
    <script>
        alert("Please enter a password.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[m_pass] != $_POST[m_pass2]){
    ?>
    <script>
        alert("Please Confirm password...");
        history.back();
    </script>
    <?
    exit;
}

// 4. ȸ������ ����
$sql = "update tb_member set m_pass = password('".$_POST[m_pass]."') where m_id = '".$_SESSION[user_id]."'";
sql_query($sql);

// 8. ù �������� ������
?>
<script>
alert("Member information was modified.");
location.replace("index.php");
</script>
<?php
}

// DB �ݱ�
db_close();
?>