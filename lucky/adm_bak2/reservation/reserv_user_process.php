<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="update"){
    $no = $_REQUEST['no'];
    $reserv_name = $_REQUEST['reserv_name'];
    $reserv_phone = $_REQUEST['reserv_phone'];
    $reserv_email = $_REQUEST['reserv_email'];
    $reserv_real_name = $_REQUEST['reserv_real_name'];
    $reserv_real_phone= $_REQUEST['reserv_real_phone'];
    $reserv_adult_number = $_REQUEST['reserv_adult_number'];
    $reserv_child_number = $_REQUEST['reserv_child_number'];
    $reserv_baby_number = $_REQUEST['reserv_baby_number'];
    $reserv_adult_list = $_REQUEST['reserv_adult_list'];
    $reserv_child_list = $_REQUEST['reserv_child_list'];
    $reserv_baby_list = $_REQUEST['reserv_baby_list'];
    $reserv_summarize = $_REQUEST['reserv_summarize'];

    $sql = "update reservation_user_content set 
                                                reserv_name='{$reserv_name}',
                                                reserv_phone='{$reserv_phone}',
                                                reserv_email='{$reserv_email}',
                                                reserv_real_name='{$reserv_real_name}',
                                                reserv_real_phone='{$reserv_real_phone}',
                                                reserv_adult_number='{$reserv_adult_number}',
                                                reserv_child_number='{$reserv_child_number}',
                                                reserv_baby_number='{$reserv_baby_number}',
                                                reserv_adult_list='{$reserv_adult_list}',
                                                reserv_child_list='{$reserv_child_list}',
                                                reserv_baby_list='{$reserv_baby_list}',
                                                reserv_summarize='{$reserv_summarize}'
             where no='{$no}'                                   
                                                ";
    $db->sql_query($sql);
}else if ($case=="list_delete") {

    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST['no'][$num];

        $sql = "update reservation_user_content set reserv_del_mark='Y' where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case=="state_update"){
    $no = $_REQUEST['reserv_user_no'];
    $state = $_REQUEST['state'];

    $sql = "update reservation_user_content set reserv_state='{$state}' where no='{$no}'";
    $db->sql_query($sql);
}else if($case=="person_update"){
    $no = $_REQUEST['reserv_user_no'];
    $state = $_REQUEST['person'];

    $sql = "update reservation_user_content set reserv_person='{$state}' where no='{$no}'";
    $db->sql_query($sql);
}
?>