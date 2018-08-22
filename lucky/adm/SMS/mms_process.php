<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$reserv_no = $_REQUEST['reserv_no'];
$phone     = $_REQUEST['phone'];
$call      = $_REQUEST['call'];
$content   = $_REQUEST['content'];
$company   = $_REQUEST['company'];
$name   = $_REQUEST['name'];
$person = $_SESSION['member_name'];

$sms = new message();
$main = new main();
$main_config = $main->tour_config();

$sms->reserv_no = $reserv_no;
$sms->phone = $phone;
$sms->name  = $name;
$sms->call = $call;
$sms->content =$content;
$sms->company = $company;
$sms->subject = $main_config['tour_name']."입니다.";
$sms->person = $person;

$send = $sms->send();

if($send=="OK"){
    echo "<script>
              alert('문자 전송완료');
              window.close();
           </script>   
    ";
}else{
    echo "<script>
              alert('문자 전송실패');
              window.close();
           </script>   
    ";
}
?>