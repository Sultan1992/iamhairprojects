<?php  
// 1. ���� ��Ŭ��� ���� 
include ("./include.php");

// 2. �α��� ���� ȸ���� �α��� �������� ������
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

// 3. �� ������ �ҷ�����
$sql = "select * from tb_board where b_idx = '".$b_idx."'";
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
        alert("This article is written by someone else");
        history.back();
    </script>
    <?
}

// 5. �Է� HTML ���
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
    <!-- 4. �۾��� ��ư Ŭ���� �Է��ʵ� �˻� �Լ� write_save ���� -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Modify " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" Back " onClick="history.back();"></td>
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
        alert("Please enter a subject.");
        return false;
    }

    if(f.b_contents.value == ""){
        alert("Please enter a contents.");
        return false;
    }

    // 8.�˻簡 �����̸� form �� submit �Ѵ�
    f.submit();

}
</script>
<?
}else if(!strcmp($mode, "post")) {   
// 3. �Ѿ�� ���� �˻�
if(trim($b_idx) == ""){
    ?>
    <script>
        alert("���� ���Դϴ�.");
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

// 4. �� ������ �ҷ�����
$sql = "select * from tb_board where b_idx = '".$b_idx."'";
$data = sql_get_row($sql);

// 5. ���� ������ �޼��� ����� �ǵ�����
if(!$data[b_idx]){
    ?>
    <script>
        alert("�������� �ʴ� ���Դϴ�.");
        history.back();
    </script>
    <?
}

// 6. ������ ���� �ƴϸ� �޼��� ����� �ǵ�����
if($data[m_id] != $_SESSION[user_id]){
    ?>
    <script>
        alert("This article is written by someone else");
        history.back();
    </script>
    <?
}

// 7. ������
//$sql = "update tb_board set b_title = '".addslashes(htmlspecialchars($_POST[b_title]))."', b_contents = '".addslashes(htmlspecialchars($_POST[b_contents]))."' where b_idx = '".$b_idx."'";
$sql = "update tb_board set b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."' where b_idx = '".$b_idx."'";
sql_query($sql);

// 8. �۸�� �������� ������
?>
<script>
alert("This artcle has been saved.");
//location.replace("./board_list.php");
history.back();history.back();
</script>
</body>
<?
}

// DB �ݱ�
db_close();
?>