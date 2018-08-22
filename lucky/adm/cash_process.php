<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
print_r($_REQUEST);
$case      = $_REQUEST["case"];
$indate    = date("Y-m-d H:i",time());
if($case=="update"){
    for ($i=0;$i < count($_REQUEST['sel']);$i++) {
        $num = $_REQUEST['sel'][$i];
        $no = $_REQUEST['no'][$num];
        $name = $_REQUEST['name'][$num];
        $phone = $_REQUEST['phone'][$num];
        $use = $_REQUEST['use_'.$num];
        $state = $_REQUEST['state_'.$num];

        $sql = "update cash set cash_name='{$name}',cash_phone='{$phone}',cash_use='{$use}',state='{$state}' where no='{$no}'";
        $db->sql_query($sql);
    }

}else if($case == "delete"){
    for ($i=0;$i < count($_REQUEST['sel']);$i++) {
        $num = $_REQUEST['sel'][$i];
        $no = $_REQUEST['no'][$num];

        $sql = "delete from cash where no='{$no}'";
        $db->sql_query($sql);
    }
}
?>