<?php  
// 1. ���� ��Ŭ��� ����
include ("./include.php");

// 2. ��� ���ǰ��� ������ 
$_SESSION[user_idx] = "";
$_SESSION[user_id] = "";
$_SESSION[user_name] = "";

?>
<script>
location.replace("board_list.php");
</script>
<?php
// DB �ݱ�
db_close();
?>