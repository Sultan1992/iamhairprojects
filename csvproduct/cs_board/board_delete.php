<?php  
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("You need Login");
        location.replace("board_login.php");
    </script>
    <?
}

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

// 5. 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("This article is written by someone else.");
        history.back();
    </script>
    <?
}

$parent_thread = $data[thread];
$parent_thread_start =  floor($parent_thread/1000)*1000;
$parent_depth = $data[depth];
$parent_thread_end = ($data[depth] == 0) ? $parent_thread_start - 1000 : $parent_thread_start;

if($data[depth] == 0){
	// 6. 글 삭제하기
	$sql_delete = "delete from tb_board where thread <= '".$parent_thread."' and thread > '" . $parent_thread_end . "'";
}
else
{
	$sql = "select max(thread) from tb_board where thread < '".$parent_thread."' and thread > '" . $parent_thread_end . "' and depth <= ".$parent_depth;
	$data2 = sql_total($sql);

	if(!$data2)
		$sql_delete = "delete from tb_board where thread <= '".$parent_thread."' and thread > '" . $parent_thread_end . "' and depth <= ".$parent_depth;
	else
		$sql_delete = "delete from tb_board where thread <= '".$parent_thread."' and thread > '" . $data2 . "'";
}

sql_query($sql_delete);

// 7. 글목록 페이지로 보내기
?>
<script>
alert("Delete complete.");
location.replace("./board_list.php");
</script>
<?php
// DB 닫기
db_close();
?>