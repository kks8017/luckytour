<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];

$stay = $_REQUEST['stay'];

if(!$end_date){$end_date =  date("Y-m-d", strtotime($start_date . " +{$stay} days"));}
$pagenum = $_REQUEST['pagenum'];
$case   = $_REQUEST['case'];

$area = $_REQUEST['area'];
$adult_number = $_REQUEST['adult_number'];
$child_number = $_REQUEST['child_number'];
$baby_number = $_REQUEST['baby_number'];

$type = $_REQUEST['type'];
$time = $_REQUEST['time'];
$sale = $_REQUEST['sale'];
$package = $_REQUEST['package_type'];
$air = new air();
$main = new main();



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


$ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;

$stay = $ddy."박".($ddy+1)."일";
$pagenum_limit = $pagenum * 50;
$sql = "select no,
                a_sch_company_no,
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
        from air_schedule  where a_sch_departure_date = '{$start_date}' and a_sch_departure_area_name='{$area}' and a_sch_stay='{$stay}'   {$sql_time}    order by a_sch_departure_date,a_sch_departure_time,a_sch_arrival_date,a_sch_arrival_time limit $pagenum_limit,50";

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
    $airline_img = $air->air_line_img();
    $start_time = explode(":", $data['a_sch_departure_time']);
    $end_time = explode(":", $data['a_sch_arrival_time']);
    $air_oil = get_oil($data['a_sch_departure_date']);
    if ($data['a_sch_adult_sale'] == 0) {
        $air_com = get_comm($data['a_sch_departure_date']);
    } else {
        $air_com = 0;
    }

    $main->sdate = $data['a_sch_departure_date'];
    $start_week = $main->week();
    $main->sdate = $data['a_sch_arrival_date'];
    $end_week = $main->week();
    $a_sch_normal_price = ($data['a_sch_adult_normal_price'] + $air_oil + $air_com);
    $a_sch_start_date = explode("-", $data['a_sch_departure_date']);
    $a_sch_end_date = explode("-", $data['a_sch_arrival_date']);

    $a_sch_adult_sale_price = ($data['a_sch_adult_sale_price'] + $air_oil + $air_com) * $adult_number;
    $a_sch_child_sale_price = ($data['a_sch_child_sale_price'] + $air_oil + $air_com) * $child_number;
    $a_sch_adult_deposit_price = ($data['a_sch_adult_deposit_price'] + $air_oil + $air_com) * $adult_number;
    $a_sch_child_deposit_price = ($data['a_sch_child_deposit_price'] + $air_oil + $air_com) * $child_number;

    $total_price = $a_sch_adult_sale_price + $a_sch_child_sale_price;
?>
<table class="odd">
    <tr >
        <td class="air-company-img"><img src="<?=KS_DOMAIN?>/<?=$airline_img?>" alt="" width="50"  style="  vertical-align:middle;"></td>
        <td class="air-place"><?= $data['a_sch_departure_area_name'] ?>발 <?= $a_sch_start_date[1] ?>
            /<?= $a_sch_start_date[2] ?> <span class="air-place-time"><?= $start_time[0] ?>:<?= $start_time[1] ?></span>
        </td>
        <td class="air-sale">0%</td>
        <?php
        if ($case == "dan") {
            ?>
            <td rowspan="2" class="air-select">
                <button class="select-button" onclick="location.href='../res/res_check.php?air_no=<?=$data['a_sch_company_no']?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&start_date=<?=$start_date?>&package_type=A&air_type=S'">선택</button>

            </td>
            <?php
        } else {
            if($package=="AC"){
            ?>
                <td rowspan="2" class="air-select">
                    <button class="select-button" onclick="location.href='package_car.php?air_no=<?=$data['a_sch_company_no']?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&start_date=<?=$start_date?>&package_type=<?=$package?>&air_type=S'">선택</button>

                </td>
            <?
            }else{
            ?>
            <td rowspan="2" class="air-select">
                <button class="select-button" onclick="location.href='package_tel.php?air_no=<?=$data['a_sch_company_no']?>&company_no=<?=$data['a_sch_company_no']?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&start_date=<?=$start_date?>&package_type=<?=$package?>&air_type=S'">선택</button>

            </td>
        <?}

        } ?>
    </tr>
    <tr >
        <td class="air-company"><?= $data['a_sch_departure_airline_name'] ?></td>
        <td class="air-place">제주발 <?= $a_sch_end_date[1] ?>/<?= $a_sch_end_date[2] ?> <span
                    class="air-place-time"><?= $end_time[0] ?>:<?= $end_time[1] ?></span></td>
        <td class="air-price"><?= set_comma($total_price) ?>원</td>
    </tr>
</table>
    <?
       }
    }
    ?>
