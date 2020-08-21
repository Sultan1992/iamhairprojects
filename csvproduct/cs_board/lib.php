<?php  
// 1. DB ���� ���� ����
$db_host = "localhost";
$db_user = "cocos";
$db_pass = "hair123!@#";
$db_name = "cocos_com";

// 2. DB ����
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// ���� üũ
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

// 3. ��� ���� ��Ÿ ����� �Լ�
// ���� �Լ�
function sql_query($sql)
{
    global $mysqli;
	$result = $mysqli->query($sql) or die("Error_message:".$mysqli->error);
    return $result;
}

// DB �ݱ�
function db_close()
{
    global $mysqli;
	$mysqli->close();
}

// ������ ������ �� ��������� 1���� ���ϴ� �Լ�
function sql_get_row($sql, $error=TRUE)
{
    $result = sql_query($sql, $error);
    $row = $result->fetch_assoc();
    return $row;
}

// ���� ���ϴ� �Լ�
function sql_total($sql)
{
    global $mysqli;
	$data_get = $mysqli->query($sql);
	$data_get_value = $data_get->fetch_array(MYSQLI_NUM);
    return $data_get_value[0];
}

// 4. ����¡ ����� �Լ�
function paging($page, $page_row, $page_scale, $total_count, $keyword)
{
    $total_page  = ceil($total_count / $page_row);			// 4-1. ��ü ������ ���
    $paging_str = "";											// 4-2. ����¡�� ����� ���� �ʱ�ȭ
   
    if ($page > 1) {												 // 4-3. ó�� ������ ��ũ �����
        $paging_str .= "<a href='".$_SERVER[PHP_SELF]."?page=1&keyword=".$keyword."'>First</a>";
    }
    
    $start_page = ( (ceil( $page / $page_scale ) - 1) * $page_scale ) + 1;			// 4-4. ����¡�� ǥ�õ� ���� ������ ���ϱ�
    
    $end_page = $start_page + $page_scale - 1;										// 4-5. ����¡�� ǥ�õ� ������ ������ ���ϱ�
    if ($end_page >= $total_page) $end_page = $total_page;
   
    if ($start_page > 1){																		 // 4-6. ���� ����¡ �������� ���� ��ũ �����
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($start_page - 1)."&keyword=".$keyword."'>Previous</a>";
    }
    
    if ($total_page > 1) {																	// 4-7. �������� ��� �κ� ��ũ �����
        for ($i=$start_page;$i<=$end_page;$i++) {										           
            if ($page != $i){																	// ���� �������� �ƴϸ� ��ũ �ɱ�
                $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$i."&keyword=".$keyword."'><span>$i</span></a>";
            }else{																				// ������������ ���� ǥ���ϱ�
                $paging_str .= " &nbsp;<b>$i</b> ";
            }
        }
    }
    
    if ($total_page > $end_page){															// 4-8. ���� ����¡ �������� ���� ��ũ �����
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($end_page + 1)."&keyword=".$keyword."'>Next</a>";
    }

    if ($page < $total_page) {																 // 4-9. ������ ������ ��ũ �����
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$total_page."&keyword=".$keyword."'>Last</a>";
    }

    return $paging_str;
}
?>