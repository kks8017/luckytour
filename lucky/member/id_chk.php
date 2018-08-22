<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$id = $_POST['user_id'];

$SQL ="select * from user_member where user_id='{$id}'";

$rs  = $db->sql_query($SQL);
$num = $db->num_rows($rs);
$len = strlen($id);
if($num >0){
    echo "<input type='hidden' id='id_chk' value='NO'>";
}else{
    if( $len > 5) {
        echo "<input type='hidden' id='id_chk' value='YES'>";
    }else{
        echo "<input type='hidden' id='id_chk' value='NO_CHK'>";
    }
}
?>