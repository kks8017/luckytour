<?php
include_once('./_common.php');
//print_r($_POST);
$user_id       = trim($_POST['user_id']);
$user_password = trim($_POST['user_passwd']);
//echo $ad_id;
//if (!$ad_id || !$ad_password)
//   alert('회원아이디나 비밀번호가 공백이면 안됩니다.');

$user_sql = "select no,user_id,user_name,user_phone,user_email from user_member where user_id='{$user_id}'";
echo $user_sql;
$user_rs  = $db->sql_query($user_sql);
$user_row = $db->fetch_array($user_rs);
if($user_row['user_id']) {
    $pass_sql = "select user_passwd from user_member where no='{$user_row['no']}'";

    $pass_rs = $db->sql_query($pass_sql);
    $pass_row = $db->fetch_array($pass_rs);

    if($user_password==$pass_row['user_passwd']) {

        set_session("user_id", $user_row['user_id']);
        set_session("user_name", $user_row['user_name']);
        set_session("user_phone", $user_row['user_phone']);
        set_session("user_email", $user_row['user_email']);
        echo "<input type='hidden' id='id_chk' value='YES'>";
        // goto_url("/index.html");
    }else{
        echo "<input type='hidden' id='id_chk' value='NO'>";
    }
}else {
    echo "<input type='hidden' id='id_chk' value='ID'>";

}
?>