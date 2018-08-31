<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
print_r($_REQUEST);
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$reserv_no = $_REQUEST['reserv_no'];
$use  = $_REQUEST['use'];
$indate = date("Y-m-d",time());

$subject = $name."님 접수되었습니다.";



$sql = "insert into cash(reserv_no,cash_subject,cash_name,cash_phone,cash_use,state,indate) value('{$reserv_no}','{$subject}','{$name}','{$phone}','{$use}','미발급','{$indate}')";
echo $sql;
$db->sql_query($sql);

echo "<script>
            window.location.href='/board/board.php?board=cash';
       </script>";
?>