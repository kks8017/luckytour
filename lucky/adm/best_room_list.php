<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$lodging_no = $_REQUEST['lodging_no'];

$sql = "select no,lodging_room_name from lodging_room where lodging_no='{$lodging_no}'";
$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result[] = $row;
}
echo json_encode($result);
?>