<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$passwd = $_REQUEST['passwd'];



$pass_sql = "select passwd from board_reply where no='{$no}'";
//echo $pass_sql;
$pass_rs  = $db->sql_query($pass_sql);
$pass_row = $db->fetch_array($pass_rs);

if($passwd == $pass_row['passwd']) {
    echo "<input type='hidden' id='pwd' value='OK'>";
}else{
    echo "<input type='hidden' id='pwd' value='NO'>";
}
?>