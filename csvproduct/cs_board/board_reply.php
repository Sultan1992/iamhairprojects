<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("로그인 하셔야 합니다.");
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

// 3. 글 데이터 불러오기
$sql = "select * from tb_board where b_idx = '".$_GET[b_idx]."'";
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

$parent_thread = $data[thread];
$parent_thread_start =  floor($parent_thread/1000)*1000;
$parent_thread_end = $parent_thread_start + 1000;
$parent_title = "RE:" . $data[b_title];
$parent_content = "\n>" . str_replace("\n", "\n>", $data[b_contents]);
$parent_depth = $data[depth];

// 5-2 댓글의 갯수가 1000 이하인지 검사

$sql2 = "select count(*) from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 1000){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 5-3 댓글의 depth가 255이하인지 검사
$sql2 = "select max(depth) max_depth from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 255){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 6. 입력 HTML 출력
?>
<br/>
<form name="bWriteForm" method="post" action="./board_reply.php?mode=post&b_idx=<?=$_GET[b_idx]?>" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:50px;background-color:#CEEEF8;">Subject</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="font-family:Arial;font-size:15px;width:780px;height:50px;" value="<?=$parent_title?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;height:200px;background-color:#CEEEF8;">Contents</td>
        <td align="left" valign="middle" style="width:800px;height:400px;">
        <textarea name="b_contents" style="font-family:Arial;font-size:15px;width:800px;height:400px;"><?php
echo "\n".$parent_content;
?></textarea>
        </td>
    </tr>
    <!-- 4. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Reply " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" Back " onClick="history.back();"></td>
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
        alert("글제목을 입력해 주세요.");
        return false;
    }

    if(f.b_contents.value == ""){
        alert("글내용을 입력해 주세요.");
        return false;
    }

    // 8.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
<?
}else if(!strcmp($mode, "post")) {   
// 3. 글 데이터 불러오기
$sql = "select * from tb_board where b_idx = '".$_GET[b_idx]."'";
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

$parent_thread = $data[thread];
$parent_thread_start =  floor($parent_thread/1000)*1000;
$parent_thread_end = $parent_thread_start + 1000;
$parent_depth = $data[depth];


// 5-2 댓글의 갯수가 1000 이하인지 검사

$sql2 = "select count(*) from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 1000){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 5-3 댓글의 depth가 255이하인지 검사
$sql2 = "select max(depth) max_depth from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 255){
    ?>
    <script>
        alert("더이상 댓글을 쓸수가 없습니다.");
        history.back();
    </script>
    <?
}

// 6. 넘어온 변수 검사
if(trim($_POST[b_title]) == ""){
    ?>
    <script>
        alert("글제목을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[b_contents]) == ""){
    ?>
    <script>
        alert("글내용을 입력해 주세요.");
        history.back();
    </script>
    <?
    exit;
}

$prev_parent_thread = floor($parent_thread/1000)*1000; 
$sql = "update tb_board set thread=thread-1 where thread > $prev_parent_thread and thread < $parent_thread ";
sql_query($sql);

// 4. 글저장
$sql = "insert into tb_board set thread = ".($parent_thread-1).", depth = ".($parent_depth+1).", m_id = '".$_SESSION[user_id]."', m_name = '".$_SESSION[user_name]."', b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."', b_regdate = now()";
sql_query($sql);

// 9. 글목록 페이지로 보내기
?>
<script>
alert("This artcle has been modified.");
location.replace("./board_list.php");
</script>
<?
}

// DB 닫기
db_close();
?>