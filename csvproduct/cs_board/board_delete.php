<?php  
// 1. ���� ��Ŭ��� ����
include ("./include.php");

// 2. �α��� ���� ȸ���� �α��� �������� ������
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("You need Login");
        location.replace("board_login.php");
    </script>
    <?
}

// 3. �� ������ �ҷ�����
$sql = "select * from tb_board where b_idx = '".$_GET[b_idx]."'";
$data = sql_get_row($sql);

// 4. ���� ������ �޼��� ����� �ǵ�����
if(!$data[b_idx]){
    ?>
    <script>
        alert("�������� �ʴ� ���Դϴ�.");
        history.back();
    </script>
    <?
}

// 5. ������ ���� �ƴϸ� �޼��� ����� �ǵ�����
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
	// 6. �� �����ϱ�
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

// 7. �۸�� �������� ������
?>
<script>
alert("Delete complete.");
location.replace("./board_list.php");
</script>
<?php
// DB �ݱ�
db_close();
?>