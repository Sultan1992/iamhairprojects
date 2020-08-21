<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
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
// 3. 입력 HTML 출력
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
    <!-- 4. 정보수정 버튼 클릭시 입력필드 검사 함수 member_save 실행 -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value="Submit" onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function member_save()
{
    if(!modifyForm.m_pass.value){
        alert("Please enter a password.");
        return false;
    }

    if(modifyForm.m_pass.value != modifyForm.m_pass2.value){
        // 8.비밀번호와 확인이 서로 다르면 경고창으로 메세지 출력 후 함수 종료
        alert("Please Confirm password..");
        return false;
    }

    // 10.검사가 성공이면 form 을 submit 한다
    modifyForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {
// 3. 넘어온 변수 검사
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

// 4. 회원정보 적기
$sql = "update tb_member set m_pass = password('".$_POST[m_pass]."') where m_id = '".$_SESSION[user_id]."'";
sql_query($sql);

// 8. 첫 페이지로 보내기
?>
<script>
alert("Member information was modified.");
location.replace("index.php");
</script>
<?php
}

// DB 닫기
db_close();
?>