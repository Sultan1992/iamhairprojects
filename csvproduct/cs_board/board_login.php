<?php  
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
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
// 3. 입력 HTML 출력
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
    <!-- 4. 로그인 버튼 클릭시 입력필드 검사 함수 login_chk 실행 -->
<table style="width:600px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Login " onClick="login_chk();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function login_chk()
{
    // 7.입력폼 검사
    if(!loginForm.m_id.value){
        // 8.값이 없으면 경고창으로 메세지 출력 후 함수 종료
        alert("Please enter a ID.");
        return false;
    }

    if(!loginForm.m_pass.value){
        alert("Please enter a Password.");
        return false;
    }

    // 9.검사가 성공이면 form 을 submit 한다
    loginForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {

	$m_id = $_POST[m_id];
	$m_pass = $_POST[m_pass];

	// 3. 넘어온 변수 검사
	if(trim($m_id) == ""){
		echo "<script>alert('Please enter a ID.');history.back();</script>";
		exit;
	}

	if($m_pass == ""){
		echo "<script>alert('Please enter a Password.');history.back();</script>";
		exit;
	}

	// 4. 같은 아이디가 있는지 검사
	$chk_sql = "select m_pass, m_idx, m_id, m_name, password('".trim($m_pass)."') input_pass from tb_member where m_id = '".trim($m_id)."'";
	$chk_data = sql_get_row($chk_sql);

	// 5. 아이디가 존재 하는 경우
	if($chk_data[m_idx]){

		// 5. 입력된 비밀번호와 저장된 비밀번호가 같은지 비교해서
		if($chk_data[input_pass] == $chk_data[m_pass]){
			// 6. 비밀번호가 같으면 세션값 부여 후 이동
			$_SESSION[user_idx] = $chk_data[m_idx];
			$_SESSION[user_id] = $chk_data[m_id];
			$_SESSION[user_name] = $chk_data[m_name];

			echo "<script>location.replace('board_list.php');</script>";
			exit;
		}else{
			// 7. 비밀번호가 다르면
			echo "<script>alert('Password is incorrect.');history.back();</script>";
			exit;
		}
	}else{
		// 8. 아이디가 존재하지 않으면
		echo "<script>alert('Menber does not exist.');history.back();</script>";
		exit;
	}

}

// DB 닫기
db_close();
?>