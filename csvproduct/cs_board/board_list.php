<?php  
// 1. 공통 인클루드 파일 
include ("./include.php");

if ($_SESSION['password']==""){
    ?>
    <script>
        alert("You must be logged in to post messages.");
        location.replace("../login.php");
    </script>
    <?
}
?>
<link href="/skins/basic/admin/styles.css" rel="stylesheet" type="text/css" />
<style> 
body { style=margin-top:0;margin-right:0;margin-bottom:0;margin-left:10} 
</style>

<script language="JavaScript">
 <!--
 function op(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
 {
 toolbar_str = toolbar ? 'yes' : 'no';
 menubar_str = menubar ? 'yes' : 'no';
 statusbar_str = statusbar ? 'yes' : 'no';
 scrollbar_str = scrollbar ? 'yes' : 'no';
 resizable_str = resizable ? 'yes' : 'no';
 window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
 }

 // -->
 </script>

<body>
<?
$keyword = $_GET['keyword'];
$mode = $_GET['mode'];
$b_idx = $_GET['b_idx'];
$page = $_GET['page'];

if(!strcmp($mode, "read")) {   

	if(!is_numeric($b_idx)) {
		echo "<script>alert('An invalid value.');history.go(-1);</script>";
		exit;
	}

	// 2. 글 데이터 불러오기
	$sql = "select * from tb_board where b_idx = '".$b_idx."'";
	$data = sql_get_row($sql);

	// 3. 글이 없으면 메세지 출력후 되돌리기
	if(!$data[b_idx]){
		echo "<script>alert('Posts that do not exist.');history.go(-1);</script>";
		exit;
	}
// 4. 출력 HTML 출력
?>
<br/>
<table cellspacing="1" style="width:1000px;height:50px;border:0px;background-color:#999999;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;background-color:#CEEEF8;">Subject</td>
        <td colspan="3" align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;background-color:#FEFEE2;"><?=$data[b_title]?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;background-color:#CEEEF8;">Contents</td>
        <td colspan="3" align="left" valign="top" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=nl2Br($data[b_contents])?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="font-size:15px;width:200px;background-color:#CEEEF8;">Date</td>
        <td align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=substr($data[b_regdate],0,10)?></td>
        <td align="center" valign="middle" style="font-size:15px;width:200px;background-color:#CEEEF8;">Name</td>
        <td align="left" valign="middle" style="width:800px;background-color:#FFFFFF;padding:5px;"><?=$data[m_name]?></td>
    </tr>
</table>
<br/>
<table style="width:1000px;height:50px;">
    <tr>
        <td align="center" valign="middle">
        <input type="button" value=" List " onClick="location.href='./board_list.php?page=<?=$page?>?keyword=<?=$keyword?>';">
        <!-- // 5. 로그인 한 경우면 글쓰기,댓글쓰기 버튼 보여주기 -->
        <?if($_SESSION[user_id]){?>
        &nbsp;&nbsp;<input type="button" value=" Write " onClick="location.href='./board_write.php';">
        &nbsp;&nbsp;<input type="button" value=" Reply " onClick="location.href='./board_reply.php?b_idx=<?=$data[b_idx]?>';">
        <?}?>
        <!-- // 6. 자신의 글이면 삭제하기 버튼 보여주기 -->
        <?if($_SESSION[user_id] == $data[m_id] or $_SESSION[user_id] == 'Admin'){?>
        &nbsp;&nbsp;<input type="button" value=" Delete " onClick="board_delete('<?=$data[b_idx]?>');">
        &nbsp;&nbsp;<input type="button" value=" Modify " onClick="location.href='./board_modify.php?b_idx=<?=$data[b_idx]?>';">
        <?}?>
        </td>
    </tr>
</table>
<script>
function board_delete(b_idx)
{
    if(confirm('Are you sure you want to delete the article, including comments?')){
        location.href='./board_delete.php?b_idx=' + b_idx;
    }
}
</script>
<?
}
?>

<table cellspacing="1" style="width:1000px;height:25px;border:0px;">
	<td align="left">
	<form name="form1" action="<?=$_SERVER[PHP_SELF]?>">
	<input height="30" type="text" name="keyword" value="<?=$keyword;?>" style=width:130;height:22px onfocus="this.select()">
	<input type="submit" value="search" style=height:22px>
	</form>
	</td>
    	<td align="right"><a href="javascript:op('new', './address.php', 50, 50, 800, 620, 1, 1, 1, 0, 1)">Company Address</a></td>
</table>

<table cellspacing="1" style="width:1000px;height:50px;border:0px;background-color:#999999;">
    <tr>
        <td align="center" valign="middle" width="5%" style="height:35px;background-color:#CEEEF8;">No</td>
        <td align="center" width="75%" style="height:35px;background-color:#CEEEF8;">Subject</td>
        <td align="center" valign="middle" width="10%" style="height:35px;background-color:#CEEEF8;">Name</td>
        <td align="center" valign="middle" width="10%" style="height:35px;background-color:#CEEEF8;">Date</td>
    </tr>
<?
// 2. 페이지 변수 설정
$page = ($page && $page>0) ? $page : 1;		// 현재 페이지 값이 존재하고 0 보다 크면 그대로 사용, 그 외의 경우는  1
$page_row = 30;										// 한 페이지에 보일 글 수
$page_scale = 10;										// 한줄에 보여질 페이지 수
$paging_str = "";										// 페이징을 출력할 변수 초기화

$sql = "select count(*) as cnt from tb_board where b_title like '%$keyword%' or b_contents like '%$keyword%'";		// 3. 전체 글 갯수 알아내기
$total_count = sql_total($sql);

$total_page  = ceil($total_count / $page_row);			// 8. 전체 페이지 계산
$page = ($page <= $total_page) ? $page : $total_page;
$list_Item_Count = ($total_page == $page) ? $total_count-($page*$page_row)+$page_row : $page_row; 

$paging_str = paging($page, $page_row, $page_scale, $total_count, $keyword);			// 4. 페이지 출력 내용 만들기

// limit 쿼리 실행 속도 향상 - 인덱스가 있는 m_idx  값 이용
$min_m_idx_limit = $page_row * ($page-1);

// 9.쿼리문 적용하여 $result 에 대입
$query = "select * from tb_board where thread <= (select thread FROM tb_board where ( b_title like '%$keyword%' or b_contents like '%$keyword%') order by thread desc limit {$min_m_idx_limit},1) and ( b_title like '%$keyword%' or b_contents like '%$keyword%') order by thread desc limit {$list_Item_Count}";
$result = $mysqli->query($query);

// 7.데이터 갯수 체크를 위한 변수 설정
$i = 0;

if ($total_count > 0) {
// 8.데이터가 있을 동안 반복해서 값을 한 줄씩 읽기
while($data = $result->fetch_assoc()){

     // 9. 댓글 앞에 붙을 기호 만들기
    $reply_str = "";
     $reply_depth = $data[depth];
     if ($reply_depth > 0){
         for ($k=0; $k<$reply_depth; $k++){
             $reply_str .= '&nbsp;&nbsp;&nbsp;';
         }
     }
 ?>
     <tr>
<?
if ($data[m_id] == 'Admin') {
?>
         <td align="center" valign="middle" style="height:30px;background-color:#FEFEE2;"> * </td>
         <td valign="middle" style="height:30px;background-color:#FEFEE2;"><?

  if ($reply_depth > 0) { echo $reply_str;?>
	<img src="re.gif" border="0">
  <?
  }

?><a href="./board_list.php?mode=read&b_idx=<?=$data[b_idx]?>&page=<?=$page?>&keyword=<?=$keyword?>"><?=$data[b_title]?></a></td>
         <td align="center" valign="middle" style="height:30px;background-color:#FEFEE2;"><?=$data[m_name]?></td>
         <td align="center" valign="middle" style="height:30px;background-color:#FEFEE2;"><?=substr($data[b_regdate],0,10)?></td>
<?
} else { ?>
         <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=($total_count - (($page - 1) * $page_row) - $i )?></td>
         <td valign="middle" style="height:30px;background-color:#FFFFFF;"><?

  if ($reply_depth > 0) { echo $reply_str;?>
	<img src="re.gif" border="0">
  <?
  }


?><a href="./board_list.php?mode=read&b_idx=<?=$data[b_idx]?>&page=<?=$page?>&keyword=<?=$keyword?>"><?=$data[b_title]?></a></td>
         <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=$data[m_name]?></td>
         <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=substr($data[b_regdate],0,10)?></td>
     </tr>
 <?
}
     // 10.데이터 갯수 체크를 위한 변수를 1 증가시킴
    ++$i;
}
}
// 11.데이터가 하나도 없으면 
if($i == 0){
?>
    <tr>
        <td align="center" valign="middle" colspan="4" style="height:50px;background-color:#FFFFFF;">Not Found.</td>
    </tr>
<?
}
?>
</table>
<br/>
<table style="width:1000px;height:50px;">
    <tr>
        <td align="center" valign="middle"><?=$paging_str?></td>
    </tr>
    <?// 12. 로그인 한 경우면 글쓰기 버튼 보여주기?>
    <?if($_SESSION[user_id]){?>
    <tr>
        <td align="center" valign="middle"><input type="button" value=" Write " onClick="location.href='./board_write.php';"></td>
    </tr>
    <?}?>
</table>
</body>
<?php
// DB 닫기
db_close();
?>