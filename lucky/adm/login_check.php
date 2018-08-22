<?php
include_once('./_common.php');
//print_r($_POST);
$ad_id       = trim($_POST['member_id']);
$ad_password = trim($_POST['member_passwd']);

//if (!$ad_id || !$ad_password)
 //   alert('회원아이디나 비밀번호가 공백이면 안됩니다.');

$ad_sql = "select no,ad_id,ad_level,ad_name from ad_member where ad_id='{$ad_id}'";
$ad_rs  = $db->sql_query($ad_sql);
$ad_row = $db->fetch_array($ad_rs);
if($ad_row['ad_id']) {
    $pass_sql = "select ad_passwd from ad_member where no='{$ad_row['no']}'";

    $pass_rs = $db->sql_query($pass_sql);
    $pass_row = $db->fetch_array($pass_rs);
    if($ad_password==$pass_row['ad_passwd']) {


        $_SESSION['member_id'] =  $ad_row['ad_id'];
        $_SESSION['member_name'] =  $ad_row['ad_name'];
        $_SESSION['member_level'] =  $ad_row['ad_level'];
        set_session("member_id", $ad_row['ad_id']);
        set_session("member_name", $ad_row['ad_name']);
        set_session("member_level", $ad_row['ad_level']);

        goto_url("/adm/index.php");
    }else{
        echo "<script>
            alert('비밀번호가 틀렸습니다. 다시 확인해주세요.');
            history.back(-1);
           </script>
    ";
    }
}else {
    echo "<script>
            alert('{$ad_row['ad_id']}는 존제하지 않는 아이디 입니다. 다시 확인해주세요.');
            history.back(-1);
           </script>
    ";

}
?>