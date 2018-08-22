<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_POST['case'];


    if ($case == "insert") {

        $id = $_POST['user_id'];
        $passwd = $_POST['passwd'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $indate = date("Y-m-d H:i");


        $sql = "insert into user_member(user_id,user_passwd,user_name,user_phone,user_email,user_point,city,user_ip,indate) value
                                       ('{$id}','{$passwd}','{$name}','{$phone}','{$email}','2000','{$city}','{$ip}','{$indate}')";
        echo $sql;
        $db->sql_query($sql);
    }

?>