<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$start_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day']." ".$_REQUEST['start_hour'].":".$_REQUEST['start_minute'];
$end_date = $_REQUEST['end_year']."-".$_REQUEST['end_month']."-".$_REQUEST['end_day']." ".$_REQUEST['end_hour'].":".$_REQUEST['end_minute'];
$type = $_REQUEST['type'];
$rent_vehicle = $_REQUEST['reserv_rent_vehicle'];
$reserv_type = $_REQUEST['reserv_type'];
$reserv_rent_option = $_REQUEST['reserv_rent_option'];
$reserv_rent_option  = implode(",",$reserv_rent_option);
$sql_com = "select no from rent_company where rent_com_type='대표'";
$rs_com  = $db->sql_query($sql_com);
$row_com = $db->fetch_array($rs_com);

$reserv_rent_car_type = $_REQUEST['reserv_rent_car_type'];
$reserv_rent_fuel_type = $_REQUEST['reserv_rent_fuel_type'];

if($reserv_rent_car_type){
    $type_sql = "and rent_car_type='{$reserv_rent_car_type}'";
}else{
    $type_sql = "";
}
if($reserv_rent_fuel_type){
    $fuel_sql = "and rent_car_fuel='{$reserv_rent_fuel_type}'";
}else{
    $fuel_sql = "";
}

$sql = "select no,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where   rent_com_no='{$row_com['no']}' {$type_sql} {$fuel_sql}   order by rent_car_sort asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$rent = new rent();
$image_dir = "/".KS_DATA_DIR."/".KS_RENT_DIR;
?>
<div class="rentcar_list">
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

    if(strlen($reserv_type)  == 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[1] * $rent_vehicle;
        echo $sale_car_price;
    }else if(strlen($reserv_type) > 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
    }
    ?>
    <div class="rent_detail">
        <table>
            <tr>
                <td>
                         <div ><img src="<?=$image_dir."/thumbnail_".$data['rent_car_image']?>" class="photo"></div>
                </td>
                <td>
                    <div >
                        <div>
                            <table>
                                <tr>
                                    <td colspan="3"><?=$data['rent_car_name']?>(<?=$rent_fuel_name?>) <?=$rent_vehicle?> 대 <?=$use_time[0]?>시간(선택옵션 : <?=$reserv_rent_option?>) </td>
                                </tr>
                                <tr>
                                    <td>판매가격 : <?=$sale_car_price?></td>
                                    <td>입금가격 : <?=$rent_price[3]?></td>
                                    <td><?if($type=="add"){?>
                                            <input type="button" value="추가" onclick="rent_add('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$data['rent_com_no']?>')">
                                        <?}else{?>
                                            <input type="button" value="변경" onclick="rent_update('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$data['rent_com_no']?>')">
                                        <?}?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table>
                                <?php
                                $company = $rent->company_list();
                                foreach ($company as $com){
                                    $rent->carno = $data['no'];
                                    $rent->start_date =$start_date;
                                    $rent->end_date = $end_date;
                                    $rent->comno = $com['rent_com_no'];
                                    $use_time = $rent->rent_time();
                                    $rent_price = $rent->rent_price_main();
                                ?>
                                <tr>
                                    <td><?=$com['rent_com_name']?></td>
                                    <td>입금가격<?=$rent_price[3]?></td>
                                    <td>
                                        <?if($type=="add"){?>
                                            <input type="button" value="추가" onclick="rent_add('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$com['rent_com_no']?>')">
                                        <?}else{?>
                                            <input type="button" value="변경" onclick="rent_update('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$com['rent_com_no']?>')">
                                        <?}?></td>
                                </tr>
                                <?}?>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>
        <?php
        $i++;
    }
    }else{
    ?>
        <div></div>
    <?}?>
</div>