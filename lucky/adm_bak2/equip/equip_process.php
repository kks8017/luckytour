<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case=="insert"){

    $indate = date("Y-m-d H:i",time());
    $equip_name      = $_REQUEST["equip_name"];
    $equip_amount      = $_REQUEST["equip_amount"];
    $equip_amount_deposit = $_REQUEST["equip_amount_deposit"];

    $sql = "insert into equipment_list(equip_name,equip_amount,equip_amount_deposit,indate) VALUES('{$equip_name}','{$equip_amount}','{$equip_amount_deposit}','{$indate}') "; // 거래처등록 쿼리

    $db->sql_query($sql);

}else if($case =="all_update"){
    // print_r($_REQUEST);
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num               = $_REQUEST["sel"][$i];
        $no1               = $_REQUEST["no"][$num] ;
        $equip_sort_no   = $_REQUEST["equip_sort_no"][$num] ;
        $equip_name      = $_REQUEST["equip_name"][$num];
        $equip_amount      = get_comma($_REQUEST["equip_amount"][$num]);
        $equip_amount_deposit = get_comma($_REQUEST["equip_amount_deposit"][$num]);

        $sql = "update equipment_list set equip_sort_no='{$equip_sort_no}',equip_name='{$equip_name}',equip_amount='{$equip_amount}' ,equip_amount_deposit='{$equip_amount_deposit}' where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "all_delete"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num              = $_REQUEST["sel"][$i];
        $no               = $_REQUEST["no"][$num] ;

        $sql = "delete from equipment_list where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);
    }
}
?>