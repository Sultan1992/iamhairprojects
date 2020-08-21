<?php  
// 1. DB 관련 변수 정리
$db_host = "localhost";
$db_user = "cocos";
$db_pass = "hair123!@#";
$db_name = "cocos_com";

// 2. DB 연결
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 연결 체크
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

// 3. 디비 관련 기타 사용자 함수
// 쿼리 함수
function sql_query($sql)
{
    global $mysqli;
	$result = $mysqli->query($sql) or die("Error_message:".$mysqli->error);
    return $result;
}

// DB 닫기
function db_close()
{
    global $mysqli;
	$mysqli->close();
}

// 쿼리를 실행한 후 결과값에서 1열을 구하는 함수
function sql_get_row($sql, $error=TRUE)
{
    $result = sql_query($sql, $error);
    $row = $result->fetch_assoc();
    return $row;
}

// 갯수 구하는 함수
function sql_total($sql)
{
    global $mysqli;
	$data_get = $mysqli->query($sql);
	$data_get_value = $data_get->fetch_array(MYSQLI_NUM);
    return $data_get_value[0];
}

// 4. 페이징 사용자 함수
function paging($page, $page_row, $page_scale, $total_count, $keyword)
{
    $total_page  = ceil($total_count / $page_row);			// 4-1. 전체 페이지 계산
    $paging_str = "";											// 4-2. 페이징을 출력할 변수 초기화
   
    if ($page > 1) {												 // 4-3. 처음 페이지 링크 만들기
        $paging_str .= "<a href='".$_SERVER[PHP_SELF]."?page=1&keyword=".$keyword."'>First</a>";
    }
    
    $start_page = ( (ceil( $page / $page_scale ) - 1) * $page_scale ) + 1;			// 4-4. 페이징에 표시될 시작 페이지 구하기
    
    $end_page = $start_page + $page_scale - 1;										// 4-5. 페이징에 표시될 마지막 페이지 구하기
    if ($end_page >= $total_page) $end_page = $total_page;
   
    if ($start_page > 1){																		 // 4-6. 이전 페이징 영역으로 가는 링크 만들기
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($start_page - 1)."&keyword=".$keyword."'>Previous</a>";
    }
    
    if ($total_page > 1) {																	// 4-7. 페이지들 출력 부분 링크 만들기
        for ($i=$start_page;$i<=$end_page;$i++) {										           
            if ($page != $i){																	// 현재 페이지가 아니면 링크 걸기
                $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$i."&keyword=".$keyword."'><span>$i</span></a>";
            }else{																				// 현재페이지면 굵게 표시하기
                $paging_str .= " &nbsp;<b>$i</b> ";
            }
        }
    }
    
    if ($total_page > $end_page){															// 4-8. 다음 페이징 영역으로 가는 링크 만들기
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($end_page + 1)."&keyword=".$keyword."'>Next</a>";
    }

    if ($page < $total_page) {																 // 4-9. 마지막 페이지 링크 만들기
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$total_page."&keyword=".$keyword."'>Last</a>";
    }

    return $paging_str;
}
?>