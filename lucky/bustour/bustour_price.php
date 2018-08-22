<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_POST['no'];
$start_date = $_POST['start_date'];
$adult_number = $_POST['adult_number'];
$child_number = $_POST['child_number'];
$number = $adult_number + $child_number;
$bustour = new bustour();
$bustour->bustour_no = $no;
$bustour->start_date = $start_date;
$bustour->number = $number;
$price = $bustour->bustour_price();

echo "<input type='hidden' id='total_price' value='{$price[0]}'>";
?>