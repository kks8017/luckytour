<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$start_date = $_REQUEST['start_date']." ".$_REQUEST['start_hour'].":".$_REQUEST['start_minute'];
$end_date = $_REQUEST['end_date']." ".$_REQUEST['end_hour'].":".$_REQUEST['end_minute'];
$type = $_REQUEST['type'];
$rent_vehicle = $_REQUEST['reserv_rent_vehicle'];
$reserv_type = $_REQUEST['reserv_type'];
$reserv_rent_option = $_REQUEST['reserv_rent_option'];
$reserv_search = $_REQUEST['search_name'];
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
if($reserv_search){
    $name_sql = "and rent_car_name like '%{$reserv_search}%'";
}else{
    $name_sql = "";
}

$sql = "select no,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where   rent_com_no='{$row_com['no']}' {$name_sql} {$type_sql} {$fuel_sql}   order by rent_car_sort asc";
///echo $sql;
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
        //echo $sale_car_price;
    }else if(strlen($reserv_type) > 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
    }
    ?>

        <table class="conbox3"  >
            <tr>
                <td class="photo">
                        <img src="<?=$image_dir."/".$data['rent_car_image']?>" width="300" height="200">
                </td>
                <td >
                    <div class="rent"><span class="car"><?=$data['rent_car_name']?>(<?=$rent_fuel_name?>)</span> <span class="de"><?=$rent_vehicle?> 대</span> <span class="time"><?=$use_time[0]?>시간</span>(선택옵션 : <?=$reserv_rent_option?>) <span class="sale">판매가격 : <?=set_comma($sale_car_price)?>원</span></div>

                            <table style="width:100%;border: 1px solid #d6d9e0;">
                               <tr>
                                   <th>업체</th>
                                   <th >입금가</th>
                                   <th >추가/변경</th>
                               </tr>
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
                                    <td class="cont"><?=$com['rent_com_name']?></td>
                                    <td class="cont">입금가격 : <?=set_comma($rent_price[3])?>원</td>
                                    <td class="cont">
                                        <?if($type=="add"){?>
                                            <input type="button" value="추가" onclick="rent_add('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$com['rent_com_no']?>')">
                                        <?}else{?>
                                            <input type="button" value="변경" onclick="rent_update('<?=$data['no']?>','<?=$start_date?>','<?=$end_date?>','<?=$rent_vehicle?>','<?=$reserv_rent_option?>','<?=$com['rent_com_no']?>')">
                                        <?}?></td>
                                </tr>
                                <?}?>
                            </table>

                </td>
            </tr>
        </table>


        <?php
        $i++;
    }
    }else{
    ?>
        <div></div>
    <?}?>
</div>