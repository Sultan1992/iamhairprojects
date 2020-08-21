<?php  

// 1. 공통 인클루드 파일 
include ("./include.php");

if ($_SESSION['password']==""){
    ?>
    <script>
        alert("You must be logged in to post messages.");
        location.replace("../login.php");
    </script>
    <?
}

// 2. 로그인한 회원은 뒤로 보내기
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

// 3. 입력 HTML 출력
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
    <!-- 4. 회원가입 버튼 클릭시 입력필드 검사 함수 member_save 실행 -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Register " onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function member_save()
{
    // 7.입력폼 검사
	 if(!registForm.m_id.value) {
        // 8.값이 없으면 경고창으로 메세지 출력 후 함수 종료
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
        // 9.비밀번호와 확인이 서로 다르면 경고창으로 메세지 출력 후 함수 종료
        alert("Please confirm password.");
		registForm.m_pass2.focus();
        return false;
    }

    // 10.검사가 성공이면 form 을 submit 한다
    registForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {
// 3. 넘어온 변수 검사
/*
2. 회원아이디(m_id) : 4~12자까지 가능하도록 하고 중복이 되면 안됩니다. (영문숫자만 가능)
 3. 회원이름(m_name) : 4자이상 10자 이하(한글2자 이상 5자이하 )
 4. 비밀번호(m_pass) : 4자이상 20자이하 암호화 되는 비밀번호 입니다.(암호화되면 자리수가 길어집니다.)
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
	echo "<script>alert('아이디는 영문숫자만  4~12자이내로 입력해 주세요.');history.go(-1);</script>";
	exit;
}

if(trim($m_name) == ""){
	echo "<script>alert('Please enter a name.');history.back();</script>";
    exit;
}

if(preg_match("/[:;'\" ]+/", $m_name)){
	echo "이름은 특수문자(:;') 제외 5자이내로 입력해 주세요";
	exit;
}

if(!preg_match("/^.{1,20}$/", $m_name)){
	echo "이름은 특수문자(:;') 제외 10자이내로 입력해 주세요";
	exit;
}

if($m_pass == ""){
	echo "<script>alert('Please enter a password.');history.back();</script>";
    exit;
}

if(!preg_match("/^[a-zA-Z0-9_@#$%^&*!-]{4,20}$/", $m_pass)){
	echo "<script>alert('비밀번호는 영대문자/영소문자/숫자/특수문자  4~20자이내로 입력해 주세요.');history.go(-1);</script>";
	exit;
}

if($m_pass != $m_pass2){
   	echo "<script>alert('Please enter a password.');history.back();</script>";
    exit;
}

// 4. 같은 아이디가 있는지 검사
$chk_sql = "select * from tb_member where m_id = '".trim($m_id)."'";
$chk_data = sql_get_row($chk_sql);

// 5. 가입된 아이디가 있으면 되돌리기
if($chk_data[m_idx]){
   	echo "<script>alert('ID is already registered.');history.back();</script>";
    exit;
}

// 6. 회원정보 적기
$sql = "insert into tb_member (m_id, m_name, m_pass) values ('".trim($m_id)."', '".trim($m_name)."', password('".$m_pass."'))";
sql_query($sql);

// 7. 로그인 페이지로 보내기
?>
<script>
alert("Register was successed.");
location.replace("board_login.php");
</script>
</body>
<?php 
}

// DB 닫기
db_close();
?>