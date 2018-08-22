<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$carno = $_REQUEST['carno'];
$sale = $_REQUEST['sale'];
$sale_deposit = $_REQUEST['sale_deposit'];

$rent_vehicle = $_REQUEST['rent_vehicle'];
$reserv_type= $_REQUEST['reserv_type'];

$main_com_no  = $_REQUEST['company_list'];

$company_type = get_rentcar_company($main_com_no,"");
if($company_type[1]=="대표"){
    $sql_type = "and no='{$carno}'";
}else{
    $sql_type = "and rent_car_no='{$carno}'";
}

$sql = "select * from rent_car_detail where rent_com_no='{$main_com_no}' {$sql_type}   order by rent_car_sort asc";
//echo $sql;
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);


$rent->comno = $row['rent_com_no'];
$rent->carno = $carno;
$rent->start_date = $start_date;
$rent->end_date   = $end_date;

$time = $rent->rent_time();
$basic_price = $rent->rent_basic_price();

$sale_car_price = ($basic_price*($sale/100)) * $rent_vehicle;
$sale_car_price_deposit = ($basic_price *($sale_deposit/100))* $rent_vehicle;
$sale_car_price = $basic_price - $sale_car_price;
$sale_car_price_deposit = $basic_price - $sale_car_price_deposit;
echo $time[0]."|".$sale_car_price."|".$sale_car_price_deposit."|".$sale_deposit;

?>