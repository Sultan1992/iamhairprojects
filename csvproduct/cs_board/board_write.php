<?php  
// 1. ���� ��Ŭ��� ���� 
include ("./include.php");

// 2. �α��� ���� ȸ���� �α��� �������� ������
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
	// 3. �Է� HTML ���
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
    <!-- 4. �۾��� ��ư Ŭ���� �Է��ʵ� �˻� �Լ� write_save ���� -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Write " onClick="write_save();"></td>
    </tr>
</table>
</form>
<script>
// 5.�Է��ʵ� �˻��Լ�
function write_save()
{
    // 7.�Է��� �˻�
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

    // 8.�˻簡 �����̸� form �� submit �Ѵ�
    bWriteForm.submit();

}
</script>
<?php
} else if(!strcmp($mode, "post")) {

// 3. �Ѿ�� ���� �˻�
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

//���� �ۿ��� ���� ū thread ���� �����´�.
$sql = "select  ifnull(max(thread),0) from tb_board";
$data = sql_total($sql);
$max_thread = floor($data/1000)*1000+1000;

// 4. ������
$sql = "insert into tb_board set thread = ".$max_thread.", depth = 0, m_id = '".$_SESSION[user_id]."', m_name = '".$_SESSION[user_name]."', b_title = '".$_POST[b_title]."', b_contents = '".$_POST[b_contents]."', b_regdate = now()";
sql_query($sql);

// 7. �۸�� �������� ������
?>
<script>
alert("This artcle has been saved.");
location.replace("./board_list.php");
</script>
</body>
<?php
}

// DB �ݱ�
db_close();
?>