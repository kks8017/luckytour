<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];
$indate    = date("Y-m-d H:i",time());
if($case=="insert"){
    $tour_id     = $_REQUEST["tour_id"];
    $tour_name   = addslashes($_REQUEST["tour_name"]);

    $sql =  "select * from tour_company where tour_id='{$tour_id}'"; // 아이디 중복 쿼리
    $rs  = $db->sql_query($sql);
    $num = $db->num_rows($rs);
    if($num==0) {
        $sql = "insert into tour_company(tour_id,tour_name,indate) VALUES('{$tour_id}','{$tour_name}','{$indate}') "; // 사이트등록 쿼리
        $db->sql_query($sql);
        $tour_com_id = $db->insert_id();

        $sql_con = "insert into tour_config(tour_com_no) VALUES('{$tour_com_id }')"; //사이트등록 과 동시에 기본설정 등록 하는 쿼리
        $db->sql_query($sql_con);
    }else{
        echo "NO"; // 아이디가 중복되었슬때 0을 표시해준다
    }
}else if($case == "update"){
    $no              = $_REQUEST["no"];
    $tour_name       = addslashes($_REQUEST["tour_name"]);
    $tour_title      = addslashes($_REQUEST["tour_title"]);
    $tour_domain     = addslashes($_REQUEST["tour_domain"]);
    $tour_ceo        = addslashes($_REQUEST["tour_ceo"]);
    $tour_com_number = addslashes($_REQUEST["tour_com_number"]);
    $tour_phone      = addslashes($_REQUEST["tour_phone"]);
    $tour_fax        = addslashes($_REQUEST["tour_fax"]);
    $tour_insurance  = addslashes($_REQUEST["tour_insurance"]);
    $tour_tourism    = addslashes($_REQUEST["tour_tourism"]);
    $tour_online     = addslashes($_REQUEST["tour_online"]);
    $tour_cancel     = $_REQUEST["tour_cancel"];
    $tour_address    = addslashes($_REQUEST["tour_address"]);
    $tour_privacy    =$_REQUEST["tour_privacy"];
    $tour_main       = addslashes($_REQUEST["tour_main"]);
    $tour_account     = addslashes($_REQUEST["tour_account"]);
    $tour_sms_account     = addslashes($_REQUEST["tour_sms_account"]);
    $tour_average    = $_REQUEST["tour_average"];
    $tour_commerce    = $_REQUEST["tour_commerce"];
    $tour_privacy_provide    =$_REQUEST["tour_privacy_provide"];


    $sql_main = "select * from tour_company where tour_main='Y' where no='{$no}'";
    $rs_main  = $db->sql_query($sql_main);
    $num_main = $db->num_rows($rs_main);

    if($tour_main=="Y") {
        if ($num_main > 0) {
            echo "NO";
        } else {
            $sql = "update tour_company set tour_name='{$tour_name}',tour_title='{$tour_title}',tour_domain='{$tour_domain}',tour_ceo='{$tour_ceo}',tour_com_number='{$tour_com_number}',tour_phone='{$tour_phone}',tour_fax='{$tour_fax}',tour_insurance='{$tour_insurance}',tour_tourism='{$tour_tourism}'
                ,tour_cancel='{$tour_cancel}',tour_address='{$tour_address}',tour_privacy='{$tour_privacy}',tour_average='{$tour_average}',tour_commerce='{$tour_commerce}',tour_privacy_provide='{$tour_privacy_provide}',tour_main='{$tour_main}' ,tour_account='{$tour_account}',tour_sms_account='{$tour_sms_account}' where no='{$no}'";
            echo $sql;
            $db->sql_query($sql);

        }
    }else{
        $sql = "update tour_company set tour_name='{$tour_name}',tour_title='{$tour_title}',tour_domain='{$tour_domain}',tour_ceo='{$tour_ceo}',tour_com_number='{$tour_com_number}',tour_phone='{$tour_phone}',tour_fax='{$tour_fax}',tour_insurance='{$tour_insurance}',tour_tourism='{$tour_tourism}'
                ,tour_cancel='{$tour_cancel}',tour_address='{$tour_address}',tour_privacy='{$tour_privacy}',tour_main='{$tour_main}' where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case=="delete"){
    $no     = $_REQUEST["no"];

    $sql =  "delete from tour_company where no='{$no}'";
    $db->sql_query($sql);
    $sql_con =  "delete from tour_config where tour_com_no='{$no}'";

    $db->sql_query($sql_con);
}
?>