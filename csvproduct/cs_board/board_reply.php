<?php  
// 1. ���� ��Ŭ��� ���� 
include ("./include.php");

// 2. �α��� ���� ȸ���� �α��� �������� ������
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("�α��� �ϼž� �մϴ�.");
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

$parent_thread = $data[thread];
$parent_thread_start =  floor($parent_thread/1000)*1000;
$parent_thread_end = $parent_thread_start + 1000;
$parent_title = "RE:" . $data[b_title];
$parent_content = "\n>" . str_replace("\n", "\n>", $data[b_contents]);
$parent_depth = $data[depth];

// 5-2 ����� ������ 1000 �������� �˻�

$sql2 = "select count(*) from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 1000){
    ?>
    <script>
        alert("���̻� ����� ������ �����ϴ�.");
        history.back();
    </script>
    <?
}

// 5-3 ����� depth�� 255�������� �˻�
$sql2 = "select max(depth) max_depth from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 255){
    ?>
    <script>
        alert("���̻� ����� ������ �����ϴ�.");
        history.back();
    </script>
    <?
}

// 6. �Է� HTML ���
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
    <!-- 4. �۾��� ��ư Ŭ���� �Է��ʵ� �˻� �Լ� write_save ���� -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Reply " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" Back " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 5.�Է��ʵ� �˻��Լ�
function write_save()
{
    // 6.form �� f �� ����
    var f = document.bWriteForm;

    // 7.�Է��� �˻�

    if(f.b_title.value == ""){
        alert("�������� �Է��� �ּ���.");
        return false;
    }

    if(f.b_contents.value == ""){
        alert("�۳����� �Է��� �ּ���.");
        return false;
    }

    // 8.�˻簡 �����̸� form �� submit �Ѵ�
    f.submit();

}
</script>
<?
}else if(!strcmp($mode, "post")) {   
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

$parent_thread = $data[thread];
$parent_thread_start =  floor($parent_thread/1000)*1000;
$parent_thread_end = $parent_thread_start + 1000;
$parent_depth = $data[depth];


// 5-2 ����� ������ 1000 �������� �˻�

$sql2 = "select count(*) from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 1000){
    ?>
    <script>
        alert("���̻� ����� ������ �����ϴ�.");
        history.back();
    </script>
    <?
}

// 5-3 ����� depth�� 255�������� �˻�
$sql2 = "select max(depth) max_depth from tb_board where thread > ".$parent_thread_start." and thread <= ".$parent_thread_end ;
$data2 = sql_total($sql2);

if($data2 > 255){
    ?>
    <script>
        alert("���̻� ����� ������ �����ϴ�.");
        history.back();
    </script>
    <?
}

// 6. �Ѿ�� ���� �˻�
if(trim($_POST[b_title]) == ""){
    ?>
    <script>
        alert("�������� �Է��� �ּ���.");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[b_contents]) == ""){
    ?>
    <script>
        alert("�۳����� �Է��� �ּ���.");
        history.back();
    </script>
    <?
    exit;
}

$prev_parent_thread = floor($parent_thread/1000)*1000; 
$sql = "update tb_board set thread=thread-1 where thread > $prev_parent_thread and thread < $parent_thread ";
sql_query($sql);

// 4. ������
$sql = "insert into tb_board set thread = ".($parent_thread-1).", depth = ".($parent_depth+1).", m_id = '".$_SESSION[user_id]."', m_name = '".$_SESSION[user_name]."', b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."', b_regdate = now()";
sql_query($sql);

// 9. �۸�� �������� ������
?>
<script>
alert("This artcle has been modified.");
location.replace("./board_list.php");
</script>
<?
}

// DB �ݱ�
db_close();
?>