<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$case = $_POST['case'];
$start_date = $_REQUEST['rent_start_date']." ".$_REQUEST['start_hour'].":".$_REQUEST['start_minute'];
$end_date = $_REQUEST['rent_end_date']." ".$_REQUEST['end_hour'].":".$_REQUEST['end_minute'];

$rent_vehicle = $_REQUEST['rent_vehicle'];
$package_type = $_REQUEST['package_type'];
echo $package_type;

$sql_com = "select no from rent_company where rent_com_type='대표'";
$rs_com  = $db->sql_query($sql_com);
$row_com = $db->fetch_array($rs_com);

$rent_car_type = $_REQUEST['car_type'];

if($rent_car_type){
    $type_sql = "and rent_car_type='{$rent_car_type}'";
}else{
    $type_sql = "";
}



$sql = "select no,rent_com_no,rent_car_seater,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where   rent_com_no='{$row_com['no']}' {$type_sql}  order by rent_car_sort asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$rent = new rent();
$main = new main();
$image_dir = KS_DOMAIN."/".KS_DATA_DIR."/".KS_RENT_DIR;
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
    if(strlen($package_type)  == 1 and $package_type !="C" ){
        $sale_car_price = $rent_price[1] * $rent_vehicle;
        $car_sale = $rent_price[5];
        //     echo $sale_car_price;
    }else if(strlen($package_type) > 1 and $package_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
        $car_sale = $rent_price[6];
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
        $car_sale = $rent_price[4];
    }
    $main->sdate = $start_date;
    $start_week = $main->week();
    $main->sdate = $end_date;
    $end_week = $main->week();
?>
<style>

    .select-car-list td.car-img-area_<?=$i?>{
        width: 40%;
        margin : 10px;
        border-right: 1px solid #848484;
        background : url('<?=$image_dir?>/<?=$data['rent_car_image']?>') no-repeat;
        background-size : 100%;
    }
</style>
<table>
    <tr>
        <td class="car-img-area_<?=$i?>" rowspan="4">
        </td>
        <td class="car-name"><?=$data['rent_car_name']?></td>
    </tr>
    <tr>
        <td class="car-info"><?=$rent_fuel_name?> / <?=$data['rent_car_seater']?>인승 / <?=$data['rent_car_year_type']?>년식</td>
    </tr>
    <tr>
        <td class="car-price"><?=set_comma($sale_car_price)?>원 <span class="car-time"><?=$use_time[0]?></span><span class="car-time-text">시간</span></td>
    </tr>
    <tr>
        <td>
            <button  class="select-button-left" onclick="reservation(<?=$data['no']?>)">선택</button>
        </td>
    </tr>
</table>
    <?php
    $i++;
}
}else{
    ?>
<?}?>
