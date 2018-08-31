<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$id = $_REQUEST['user_id'];
$passwd = $_REQUEST['passwd'];

$sql = "update user_member set user_passwd='{$passwd}' where user_id='{$id}'";
$db->sql_query($sql);

echo "<script>
            window.location.href='login.php';
       </script>
      "

?>