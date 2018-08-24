<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$lodging = new lodging();

$lodging->lodno = $_REQUEST['tel_no'];
$lodging->roomno = $_REQUEST['room_no'];
$lodging->start_date = $_REQUEST['start_date'];
$lodging->stay = $_REQUEST['tel_stay'];
$lodging->adult_number = $_REQUEST['adult_number'];
$lodging->child_number = $_REQUEST['child_number'];
$lodging->baby_number  = $_REQUEST['baby_number'];
$lodging->lodging_vehicle = $_REQUEST['lodging_vehicle'];

$lodging_price = $lodging->lodging_main_price();

$sale_lod_price = (($lodging_price[0] * $_REQUEST['lodging_vehicle']));

echo set_comma($sale_lod_price)."원";
?>