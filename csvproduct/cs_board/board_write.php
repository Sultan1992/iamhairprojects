<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        location.replace("board_login.php");
    </script>
    <?
}

?>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>
<body onload="document.bWriteForm.b_title.focus()">
<?

$mode = $_GET['mode'];

if(!$mode) 
  $mode = "form";

if(!strcmp($mode, "form")) {
	// 3. 입력 HTML 출력
?>

<br/>
<form name="bWriteForm" method="post" action="./board_write.php?mode=post" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Subject</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="font-family:Arial;font-size:15px;width:800px;height:50px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:200px;background-color:#CEEEF8;">Contents</td>
        <td align="left" valign="middle" style="width:800px;height:400px;">
        <textarea name="b_contents" style="font-family:Arial;font-size:15px;width:800px;height:400px;"></textarea>
        </td>
    </tr>
    <!-- 4. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Write " onClick="write_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function write_save()
{
    // 7.입력폼 검사
    if(!bWriteForm.b_title.value){
        alert("Please enter a subject.");
		bWriteForm.b_title.focus();
        return false;
    }

    if(!bWriteForm.b_contents.value){
        alert("Please enter a contents.");
		bWriteForm.b_contents.focus();
        return false;
    }

    // 8.검사가 성공이면 form 을 submit 한다
    bWriteForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {

// 3. 넘어온 변수 검사
if(trim($_POST[b_title]) == ""){
    ?>
    <script>
        alert("Please enter a subject.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[b_contents]) == ""){
    ?>
    <script>
        alert("Please enter a contents.");
        history.back();
    </script>
    <?
    exit;
}

//현재 글에서 가장 큰 thread 값을 가져온다.
$sql = "select  ifnull(max(thread),0) from tb_board";
$data = sql_total($sql);
$max_thread = floor($data/1000)*1000+1000;

// 4. 글저장
$sql = "insert into tb_board set thread = ".$max_thread.", depth = 0, m_id = '".$_SESSION[user_id]."', m_name = '".$_SESSION[user_name]."', b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."', b_regdate = now()";
sql_query($sql);

// 7. 글목록 페이지로 보내기
?>
<script>
alert("This artcle has been saved.");
location.replace("./board_list.php");
</script>
</body>
<?php
}

// DB 닫기
db_close();
?>