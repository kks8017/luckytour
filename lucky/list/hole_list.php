<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$golf_no = $_REQUEST['golf_no'];

$sql = "select no,hole_name from golf_hole_list where golf_no='{$golf_no}'";

$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result2[] = $row;
}
$result['query'] = $sql;
$result['list'] = $result2;
echo json_encode($result);
?>