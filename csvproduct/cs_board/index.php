<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

echo "<script>location.replace('board_list.php');</script>";

// DB 닫기
db_close();
?>