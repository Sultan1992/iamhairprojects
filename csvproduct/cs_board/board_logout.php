<?php  
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 모든 세션값을 빈값으로 
$_SESSION[user_idx] = "";
$_SESSION[user_id] = "";
$_SESSION[user_name] = "";

?>
<script>
location.replace("board_list.php");
</script>
<?php
// DB 닫기
db_close();
?>