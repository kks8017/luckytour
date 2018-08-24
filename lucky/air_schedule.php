<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
set_time_limit(1000);
ini_set('memory_limit', '8192M');

$start_time = microtime(); // 페이지 상단

function Print_Exe_Time($start_time) {
    $end_time = microtime() ; // 종료시간
    $start_sec = explode(" ", $start_time); // 초와 마이크로초를 공백으로 구분
    $end_sec = explode(" ", $end_time);
    $rap_micsec = $end_sec[0] - $start_sec[0] ; // 실행시간 microsecond
    $rap_sec = $end_sec[1] - $start_sec[1] ; // 실행시간 second
    $rap = $rap_sec + $rap_micsec ;
    echo("실행시간 $rap 초 \n");
}


$query_company = "select air_name from air_company where air_type='S' and air_sch_ok='Y'";
$rs_company    = $db->sql_query($query_company);
while($row_company   = $db->fetch_assoc($rs_company)){
    $air_company[] = $row_company;
}
$sql_del = "truncate air_schedule";
$db->sql_query($sql_del);

foreach ($air_company as $air_com) {
    if ($air_com['air_name'] == "dcjeju") {
        $url = "http://www.dcjeju.net/RDT/schedule.php";
        $output = get_air($url,"dcjeju");
        $output_data = explode("<br />", $output);
        get_dcjeju($output_data);
    }else if($air_com['air_name']=="미스터제주"){
        $url = "http://mrjeju.co.kr/schedule.php";
        $output = get_air($url,"미스터제주");

        $output_data = explode("<br />",$output);

     //  print_r($output_data);

        get_mrjeju($output_data);
    }else if($air_com['air_name']=="우리항공"){
        $url = "http://woori-air.com/agent/airlist_airline.php";
        $output = get_air($url,"우리항공");

        $output_data = explode("<br />",$output);

        //  print_r($output_data);

        get_woori($output_data);
    }
}

Print_Exe_Time($start_time); // 페이지 하단

?>