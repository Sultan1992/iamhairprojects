<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("You need Login.");
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
$b_idx = $_GET['b_idx'];

if(!$mode) 
  $mode = "form";

if(!strcmp($mode, "form")) {

// 3. 글 데이터 불러오기
$sql = "select * from tb_board where b_idx = '".$b_idx."'";
$data = sql_get_row($sql);

// 4. 글이 없으면 메세지 출력후 되돌리기
if(!$data[b_idx]){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 5. 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("This article is written by someone else");
        history.back();
    </script>
    <?
}

// 5. 입력 HTML 출력
?>
<br/>
<form name="bWriteForm" method="post" action="./board_modify.php?mode=post&b_idx=<?=$b_idx?>" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CEEEF8;">Subject</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="font-family:Arial;width:800px;height:50px;" value="<?=$data[b_title]?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:200px;height:50px;background-color:#CEEEF8;">Contents</td>
        <td align="left" valign="middle" style="width:800px;height:200px;">
        <textarea name="b_contents" style="font-family:Arial;width:800px;height:200px;"><?=$data[b_contents]?></textarea>
        </td>
    </tr>
    <!-- 4. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Modify " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" Back " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function write_save()
{
    // 6.form 을 f 에 지정
    var f = document.bWriteForm;

    // 7.입력폼 검사

    if(f.b_title.value == ""){
        alert("Please enter a subject.");
        return false;
    }

    if(f.b_contents.value == ""){
        alert("Please enter a contents.");
        return false;
    }

    // 8.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
<?
}else if(!strcmp($mode, "post")) {   
// 3. 넘어온 변수 검사
if(trim($b_idx) == ""){
    ?>
    <script>
        alert("없는 글입니다.");
        history.back();
    </script>
    <?
    exit;
}

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

// 4. 글 데이터 불러오기
$sql = "select * from tb_board where b_idx = '".$b_idx."'";
$data = sql_get_row($sql);

// 5. 글이 없으면 메세지 출력후 되돌리기
if(!$data[b_idx]){
    ?>
    <script>
        alert("존재하지 않는 글입니다.");
        history.back();
    </script>
    <?
}

// 6. 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("This article is written by someone else");
        history.back();
    </script>
    <?
}

// 7. 글저장
//$sql = "update tb_board set b_title = '".addslashes(htmlspecialchars($_POST[b_title]))."', b_contents = '".addslashes(htmlspecialchars($_POST[b_contents]))."' where b_idx = '".$b_idx."'";
$sql = "update tb_board set b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."' where b_idx = '".$b_idx."'";
sql_query($sql);

// 8. 글목록 페이지로 보내기
?>
<script>
alert("This artcle has been saved.");
//location.replace("./board_list.php");
history.back();history.back();
</script>
</body>
<?
}

// DB 닫기
db_close();
?>