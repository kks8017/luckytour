<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
echo $start_date;
$start_airline = $_REQUEST['start_airline'];
$pagenum = $_REQUEST['pagenum'];
$case   = $_REQUEST['case'];

$area = $_REQUEST['area'];
$adult_number = $_REQUEST['adult_number'];
$child_number = $_REQUEST['child_number'];
$baby_number = $_REQUEST['baby_number'];
echo $_REQUEST['start_airline']."====".$_REQUEST['child_number']."=======".$_REQUEST['baby_number'];

$type = $_REQUEST['type'];
$time = $_REQUEST['time'];
$sale = $_REQUEST['sale'];
$air = new air();
$main = new main();

if($start_airline) {
    $sql_line = "and a_sch_departure_airline_name='{$start_airline}'";
}
if($start_company) {
    $sql_company = "and a_sch_company='{$start_company}'";
}
switch ($time){
    case 1 :
        $sql_time = "and (a_sch_departure_time between '06:00:00' and  '07:59')";
        break;
    case 2 :
        $sql_time = "and (a_sch_departure_time between '08:00' and '09:59')";
        break;
    case 3 :
        $sql_time = "and (a_sch_departure_time between '10:00' and  '11:59')";
        break;
    case 4 :
        $sql_time = "and (a_sch_departure_time between '12:00' and '13:59')";
        break;
    case 5 :
        $sql_time = "and (a_sch_departure_time between '14:00' and  '17:59')";
        break;
    case 6 :
        $sql_time = "and (a_sch_departure_time between '18:00' and  '21:59')";
        break;
    default :
        $sql_time = "";
}
switch ($sale){
    case 1 :
        $sql_sale = "and a_sch_adult_sale  >= '50'";
        break;
    case 2 :
        $sql_sale = "and (a_sch_adult_sale between '30' and '49')";
        break;
    case 3 :
        $sql_sale = "and (a_sch_adult_sale between '20' and  '29')";
        break;
    case 4 :
        $sql_sale = "and (a_sch_adult_sale between '10' and '19')";
        break;
    case 5 :
        $sql_sale = "and (a_sch_adult_sale between '0' and  '9')";
        break;
    default :
        $sql_sale = "";
}
if($start_airline!=""){
    $sql_airline = "and a_sch_departure_airline_name  = '{$start_airline}'";
}else{
    $sql_airline = "";
}
$ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;

$stay = $ddy."박".($ddy+1)."일";
$pagenum_limit = $pagenum * 50;
$sql = "select no,a_sch_company_no,
                a_sch_departure_area_name,
                a_sch_arrival_area_name,
                a_sch_departure_airline_name,
                a_sch_arrival_airline_name,
                a_sch_departure_date,
                a_sch_departure_time,
                a_sch_arrival_date,
                a_sch_arrival_time,
                a_sch_stay,
                a_sch_adult_normal_price,
                a_sch_child_normal_price,
                a_sch_adult_sale,
                a_sch_child_sale,
                a_sch_adult_deposit_sale,
                a_sch_child_deposit_sale,
                a_sch_adult_sale_price,
                a_sch_child_sale_price,
                a_sch_adult_deposit_price,
                a_sch_child_deposit_price,
                a_sch_bigo,
                a_sch_company
        from air_schedule  where a_sch_departure_date = '{$start_date}' and a_sch_departure_area_name='{$area}' and a_sch_stay='{$stay}'  {$sql_line} {$sql_company} {$sql_time} {$sql_sale} {$sql_airline}  order by a_sch_departure_date,a_sch_departure_time,a_sch_arrival_date,a_sch_arrival_time limit $pagenum_limit,50";
echo $sql;
$rs  = $db->sql_query($sql);

if($rs) {
    while ($row = $db->fetch_array($rs)) {
        $result_list[] = $row;
    }
}

?>

<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $air->air_name = $data['a_sch_departure_airline_name'];
        $airline_img =  $air->air_line_img();
        $start_time = explode(":",$data['a_sch_departure_time']);
        $end_time = explode(":",$data['a_sch_arrival_time']);
        $air_oil = get_oil($data['a_sch_departure_date']);
        if($data['a_sch_adult_sale']==0){
            $air_com = get_comm($data['a_sch_departure_date']);
        }else{
            $air_com = 0;
        }
        $air->air_name = $data['a_sch_departure_airline_name'];
        $air_img = $air->s_air_line_img();
        $main->sdate = $data['a_sch_departure_date'];
        $start_week = $main->week();
        $main->sdate = $data['a_sch_arrival_date'];
        $end_week = $main->week();
        $a_sch_normal_price = $data['a_sch_adult_normal_price'] -8000 ;

        $a_sch_adult_sale_price = ($data['a_sch_adult_sale_price'] + $air_oil +$air_com) * $adult_number;
        $a_sch_child_sale_price = ($data['a_sch_child_sale_price'] + $air_oil +$air_com) * $child_number;
        $a_sch_adult_deposit_price = ($data['a_sch_adult_deposit_price'] + $air_oil +$air_com) * $adult_number;
        $a_sch_child_deposit_price = ($data['a_sch_child_deposit_price'] + $air_oil +$air_com) * $child_number;

        $total_price = $a_sch_adult_sale_price + $a_sch_child_sale_price;
        ?>
        <tr class="odd">
            <td><p><img src="<?=$airline_img?>" style="position:relative;top:0px"/></p><p><span style="position:relative;top:3px"><?=$data['a_sch_departure_airline_name']?></span></p></td>
            <td><p><span class="position"><?=$data['a_sch_departure_date']?>(<?=$start_week?>)</span></p><p class="break"><span class="time" style="position:relative;top:-10px"><?=$start_time[0]?>:<?=$start_time[1]?></span></p></td>
            <td><p><span class="position"><?=$data['a_sch_arrival_date']?>(<?=$end_week?>)</span></p><p class="break"><span class="time" style="position:relative;top:-10px"><?=$end_time[0]?>:<?=$end_time[1]?></span></p></td>
            <td><p><span style="position:relative;top:-5px"><?=$data['a_sch_stay']?></span></p></td>
            <td><p><span class="strike" style="position:relative;top:-5px"><?=set_comma($a_sch_normal_price)?>원</span></p></td>
            <td><p><span class="dis" style="position:relative;top:-5px"><?=$data['a_sch_adult_sale']?>%</span></p></td>
            <td><p><span  class="position" style="position:relative;top:-25px">성인<span class="b"><?=$adult_number?></span></span></p>
                <p class="break"><span class="position" style="position:relative;top:-17px">소인<span class="b"><?=$child_number?></span></span></p><p class="break"><span class="position" style="position:relative;top:-9px">유아<span class="b"><?=$baby_number?></span></span></p></td>
            <td><p><span class="disprice" style="position:relative;top:-5px"><?=set_comma($total_price)?>원</span></p></td>
            <td><p><span class="position"><?=$data['a_sch_bigo']?></span></p></td>
            <?php
            if($case=="dan"){
            ?>
                <td><p><img src="/sub_img/select_btn.png" style="position:relative;top:12px;cursor: pointer;" onclick="reservation(<?=$i?>)"/></td>
            <?php
            }else{
            ?>
                <td><p><img src="/sub_img/select_btn.png" onclick="air_selected(<?=$i?>)" style="position:relative;top:12px;cursor: pointer;"/></td>
            <?
            }
            ?>


            <input type="hidden" name="air_no" id="air_no_<?=$i?>" value="<?=$data['no']?>">
             <input type="hidden" name="air_company_no" id="air_company_no_<?=$i?>" value="<?=$data['a_sch_company_no']?>">
            <input type="hidden" name="air_img" id="air_img_<?=$i?>" value="<?=$airline_img?>">
            <input type="hidden" name="air_line" id="air_line_<?=$i?>" value="<?=$data['a_sch_departure_airline_name']?>">
            <input type="hidden" name="air_departure_date" id="air_departure_date_<?=$i?>" value="<?=$data['a_sch_departure_date']?>">
            <input type="hidden" name="air_start_week" id="air_start_week_<?=$i?>" value="<?=$start_week?>">
            <input type="hidden" name="air_start_hour" id="air_start_hour_<?=$i?>" value="<?=$start_time[0]?>">
            <input type="hidden" name="air_start_minute" id="air_start_minute_<?=$i?>" value="<?=$start_time[1]?>">
            <input type="hidden" name="air_arrival_date" id="air_arrival_date_<?=$i?>" value="<?=$data['a_sch_arrival_date']?>">
            <input type="hidden" name="air_end_week" id="air_end_week_<?=$i?>" value="<?=$end_week?>">
            <input type="hidden" name="air_end_hour" id="air_end_hour_<?=$i?>" value="<?=$end_time[0]?>">
            <input type="hidden" name="air_end_minute" id="air_end_minute_<?=$i?>" value="<?=$end_time[1]?>">
            <input type="hidden" name="air_stay" id="air_stay_<?=$i?>" value="<?=$data['a_sch_stay']?>">
            <input type="hidden" name="air_stay2" id="air_stay2_<?=$i?>" value="<?=$ddy?>">
            <input type="hidden" name="air_area" id="air_area_<?=$i?>" value="<?=$data['a_sch_departure_area_name']?>">
            <input type="hidden" name="air_total_price" id="air_total_price_<?=$i?>" value="<?=$total_price?>">
            <input type="hidden" name="air_type" id="air_type_<?=$i?>" value="S">
            <input type="hidden" name="air_img" id="air_img_<?=$i?>" value="<?=$air_img?>">


        </tr>


        <?php
        $i++;
    }
}else {
    ?>
<tr class="odd">
    <td colspan="10">등록된 스케줄이 없습니다.</td>
</tr>
    <?php
}
?>
