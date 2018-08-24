<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case=="update"){
    $no               = $_REQUEST["no"];
    $start_date       = addslashes($_REQUEST["start_date"]);
    $join_type        = addslashes($_REQUEST["join_type"]);
    $card_type        = addslashes($_REQUEST["card_type"]);
    $free_type        = addslashes($_REQUEST["free_type"]);
    $air_area         = addslashes($_REQUEST["air_area"]);
    $car_type         = addslashes($_REQUEST["car_type"]);
    $fuel_type        = addslashes($_REQUEST["fuel_type"]);
    $tel_area         = addslashes($_REQUEST["tel_area"]);
    $tel_type         = addslashes($_REQUEST["tel_type"]);
    $rent_option      = addslashes($_REQUEST["rent_option"]);


    $sql =  "update tour_config set start_date='{$start_date}',tour_type='{$free_type}',tour_member_type='{$join_type}',tour_card='{$card_type}',tour_air_area='{$air_area}',tour_rent_code='{$car_type}',tour_rent_fuel_code='{$fuel_type}',tour_tel_code='{$tel_area}'
             ,tour_tel_type_code='{$tel_type}' where no='{$no}'";
    $db->sql_query($sql);
}

?>