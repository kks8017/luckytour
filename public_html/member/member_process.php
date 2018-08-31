<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_POST['case'];

if($_SESSION['scode']==$_POST['s_code'] && !empty($_SESSION['scode']) ) {
    unset($_SESSION['scode']);

    if ($case == "insert") {

        $id = $_POST['user_id'];
        $passwd = $_POST['passwd'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $city = $_POST['city'];
        $phone1 = $_POST['phone1'];
        $phone2 = $_POST['phone2'];
        $phone3 = $_POST['phone3'];
        $email = $_POST['email'];
        $user_sms_chk = $_POST['user_sms_chk'];
        $user_email_chk = $_POST['user_email_chk'];
        $phone = $phone1 . "-" . $phone2 . "-" . $phone3;
        $ip = $_SERVER['REMOTE_ADDR'];
        $indate = date("Y-m-d H:i");


        $sql = "insert into user_member(user_id,user_passwd,user_name,user_phone,user_email,user_point,user_email_chk,user_sms_chk,user_ip,indate) value
                                       ('{$id}','{$passwd}','{$name}','{$phone}','{$email}','2000','{$user_email_chk}','{$user_sms_chk}','{$ip}','{$indate}')";
        echo $sql;
        $db->sql_query($sql);
    }
}else{
    echo "<input type='hidden' id='er_code' value='wrong'>";
}
?>