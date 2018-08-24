<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_POST['case'];
$start_date = $_REQUEST['rent_start_date']." ".$_REQUEST['start_hour'].":".$_REQUEST['start_minute'];
$end_date = $_REQUEST['rent_end_date']." ".$_REQUEST['end_hour'].":".$_REQUEST['end_minute'];

$rent_vehicle = $_REQUEST['rent_vehicle'];
$reserv_type = $_REQUEST['package'];

$sql_com = "select no from rent_company where rent_com_type='대표'";
$rs_com  = $db->sql_query($sql_com);
$row_com = $db->fetch_array($rs_com);

$rent_car_type = $_REQUEST['rent_type'];
$rent_fuel_type = $_REQUEST['fuel_type'];

if($rent_car_type){
    $type_sql = "and rent_car_type='{$rent_car_type}'";
}else{
    $type_sql = "";
}
if($reserv_rent_fuel_type){
    $fuel_sql = "and rent_car_fuel='{$reserv_rent_fuel_type}'";
}else{
    $fuel_sql = "";
}


$sql = "select no,rent_car_seater,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where   rent_com_no='{$row_com['no']}' {$type_sql} {$fuel_sql}    order by rent_car_sort asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$rent = new rent();
$main = new main();
$image_dir = "../".KS_DATA_DIR."/".KS_RENT_DIR;
?>


    <?php
    $i=0;
    if(is_array($result_list)) {
    foreach ($result_list as $data){
    $rent_type_name = $rent->rent_code_name($data['rent_car_type']);
    $rent_fuel_name = $rent->rent_code_name($data['rent_car_fuel']);
    $rent->carno = $data['no'];
    $rent->start_date =$start_date;
    $rent->end_date = $end_date;
    $rent->comno = $data['rent_com_no'];
    $use_time = $rent->rent_time();
    $rent_price = $rent->rent_price_main();
    $rent_default_price =$rent->rent_basic_price();
    if(strlen($reserv_type)  == 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[1] * $rent_vehicle;
        $car_sale = $rent_price[5];
        //     echo $sale_car_price;
    }else if(strlen($reserv_type) > 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
        $car_sale = $rent_price[6];
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
        $car_sale = $rent_price[4];
    }
      if($car_sale > 0){
          $car_sale = $car_sale;
      }else{
          $car_sale = 0;
      }
        $main->sdate = $start_date;
        $start_week = $main->week();
        $main->sdate = $end_date;
        $end_week = $main->week();
    ?>
    <li>
        <?php
            if($case=="dan"){
        ?>
        <p><a href="javascript:reservation(<?=$i?>)"><img src="<?=$image_dir?>/<?=$data['rent_car_image']?>" /></a></p>
        <?}else{?>
                <p><a href="javascript:rent_selected(<?=$i?>);"><img src="<?=$image_dir?>/<?=$data['rent_car_image']?>" /></a></p>
        <?}?>
        <p><?=$data['rent_car_name']?></p>
        <p><?=$rent_vehicle?>대/<?=$use_time[0]?>시간</p>
        <p><?=$rent_fuel_name?>/<?=$data['rent_car_seater']?>인승/<?=$data['rent_car_year_type']?>년식</p>
        <p><span><?=$car_sale?>%</span><span><?=set_comma($rent_default_price)?>원</span><span><?=set_comma($sale_car_price)?>원</span></p>
        <input type="hidden" name="car_no" id="car_no_<?=$i?>" value="<?=$data['no']?>">
        <input type="hidden" name="car_name" id="car_name_<?=$i?>" value="<?=$data['rent_car_name']?>">
        <input type="hidden" name="car_time" id="car_time_<?=$i?>" value="<?=$use_time[0]?>">
        <input type="hidden" name="car_sdate" id="car_sdate_<?=$i?>" value="<?=$_REQUEST['rent_start_date']?>">
        <input type="hidden" name="car_edate" id="car_edate_<?=$i?>" value="<?=$_REQUEST['rent_end_date']?>">
        <input type="hidden" name="car_stime" id="car_stime_<?=$i?>" value="<?=$_REQUEST['start_hour']?>:<?=$_REQUEST['start_minute']?>">
        <input type="hidden" name="car_etime" id="car_etime_<?=$i?>" value="<?=$_REQUEST['end_hour']?>:<?=$_REQUEST['end_minute']?>">
        <input type="hidden" name="car_sweek" id="car_sweek_<?=$i?>" value="<?=$start_week?>">
        <input type="hidden" name="car_eweek" id="car_eweek_<?=$i?>" value="<?=$end_week?>">
        <input type="hidden" name="car_vehicle" id="car_vehicle_<?=$i?>" value="<?=$rent_vehicle?>">
        <input type="hidden" name="car_total_price" id="car_total_price_<?=$i?>" value="<?=$sale_car_price?>">
    </li>

        <?php
        $i++;
    }
    }else{
    ?>
    <?}?>

