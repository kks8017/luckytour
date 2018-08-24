<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$user = new member();
$user->name = $_REQUEST['user_name'];
$user->phone = $_REQUEST['user_phone'];
$user->email = $_REQUEST['user_email'];

$user_id = $user->user_id_find();

if($user_id){
?>
    회원님의 아이디는<br>
    <?=substr($user_id,0,4)?>**
    입니다.
<?}else{?>
    조회하신아이디는 존재하지 않습니다.
<?}?>
