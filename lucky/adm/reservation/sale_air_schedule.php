<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$start_airline = $_REQUEST['start_airline'];
$start_company = $_REQUEST['start_company'];
$area = $_REQUEST['sch_departure_area'];
$adult_number = $_REQUEST['adult_number'];
$child_number = $_REQUEST['child_number'];
$baby_number = $_REQUEST['baby_number'];
$type = $_REQUEST['type'];
$time = $_REQUEST['time'];
$sale = $_REQUEST['sale'];

if($start_company) {
    $sql_company = "and a_sch_company='{$start_company}'";
}
if($type!="update") {
    if ($start_airline) {
        $sql_airline = "and a_sch_departure_airline_name='{$start_airline}'";
    }
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
        $sql_time = "and (a_sch_departure_time between '14:00' and  '15:59')";
        break;
    case 6 :
        $sql_time = "and (a_sch_departure_time between '16:00' and  '17:59')";
        break;
    case 7 :
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
$ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;

$stay = $ddy."박".($ddy+1)."일";
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
        from air_schedule  where a_sch_departure_date = '{$start_date}' and a_sch_departure_area_name='{$area}' and a_sch_stay='{$stay}'  $sql_airline $sql_company $sql_time $sql_sale  order by a_sch_departure_date,a_sch_departure_time,a_sch_arrival_date,a_sch_arrival_time";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>

        <table class="conbox" >
            <tr>
                <td class="titbox">출발일</td>
                <td class="titbox">리턴일</td>
                <td class="titbox">일정</td>
                <td class="titbox">인원</td>
                <td class="titbox">성인할인<br>소아할인</td>
                <td class="titbox">성인판매<br>소아판매</td>
                <td class="titbox">성인입금<br>소아입금</td>
                <td class="titbox">항공사<br>판매사</td>
                <td class="titbox">비고</td>
                <td class="titbox">추가</td>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
                $start_time = explode(":",$data['a_sch_departure_time']);
                $end_time = explode(":",$data['a_sch_arrival_time']);
                $air_oil = get_oil($data['a_sch_departure_date']);
                if($data['a_sch_adult_sale']==0){
                    $air_com = get_comm($data['a_sch_departure_date']);
                }else{
                    $air_com = 0;
                }
                $a_sch_adult_normal_price = ($data['a_sch_adult_normal_price'] - 8000) ;
                $a_sch_child_normal_price = ($data['a_sch_child_normal_price'] - 4000) ;
                $a_sch_adult_sale_price = ($data['a_sch_adult_sale_price'] + $air_oil +$air_com) * $adult_number;
                $a_sch_child_sale_price = ($data['a_sch_child_sale_price'] + $air_oil +$air_com) * $child_number;
                $a_sch_adult_deposit_price = ($data['a_sch_adult_deposit_price'] + $air_oil +$air_com) * $adult_number;
                $a_sch_child_deposit_price = ($data['a_sch_child_deposit_price'] + $air_oil +$air_com) * $child_number;
            ?>
            <tr>
                <td ><?=$data['a_sch_departure_date']?><br>(<?=$start_time[0]?>:<?=$start_time[1]?>)</td>
                <td ><?=$data['a_sch_arrival_date']?><br>(<?=$end_time[0]?>:<?=$end_time[1]?>)</td>
                <td ><?=$data['a_sch_stay']?></td>
                <td >성인:<?=$adult_number?><br>소아:<?=$child_number?></td>
                <td ><?=$data['a_sch_adult_sale']?><br><?=$data['a_sch_child_sale']?></td>

                <td ><?=set_comma($a_sch_adult_sale_price)?><br><?=set_comma($a_sch_child_sale_price)?></td>
                <td ><?=set_comma($a_sch_adult_deposit_price)?><br><?=set_comma($a_sch_child_deposit_price)?></td>
                <td ><?=$data['a_sch_departure_airline_name']?><br><?=$data['a_sch_company']?></td>
                <td ><?=$data['a_sch_bigo']?></td>
                <td ><?if($type=="add"){?><input type="button"   value="추가" onclick="air_add('<?=$data['no']?>','<?=$data['a_sch_company_no']?>','<?=$adult_number?>','<?=$child_number?>','<?=$baby_number?>');"><?}else{?><input type="button" value="변경" onclick="air_update('<?=$data['no']?>','<?=$adult_number?>','<?=$child_number?>','<?=$baby_number?>');"><?}?></td>
            </tr>
                <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <td colspan="10" class="scont" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
            <?}?>
        </table>
