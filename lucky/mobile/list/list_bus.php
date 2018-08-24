<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$bus = new bus();
$main = new main();
$bus_date = $_POST['start_date'];
$stay = $_POST['bus_stay'];
$bus_type = $_POST['bus_type'];

$bus_vehicle = $_POST['bus_vehicle'];
$bus_type = $_POST['bus_type'];
$sql = "select * from bus_taxi_car where  bus_open='Y' and bus_type='{$bus_type}' order by bus_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = KS_DOMAIN."/".KS_DATA_DIR."/".KS_BUS_DIR;

$main->sdate = $bus_date;
$start_week = $main->week();


$i=0;
if(is_array($result_list)) {
foreach ($result_list as $data){

$bus->bus_no = $data['no'];
$bus->stay   = $stay;
$bus->bus_vehicle = $bus_vehicle;

$bus_price = $bus->bus_price();
// echo $bus_price;
switch ($data['bus_type']){
    case 'B' :
        $bus_type = "버스";
        break;
    case 'T' :
        $bus_type = "택시";
        break;
}
//  echo $bus_date;
?>
    <style>
        .select-bus-list td.bus-img-area{
            width: 30%;
            margin : 10px;
            border-right: 1px solid #848484;
            background : url('<?=$image_dir?>/<?=$data['bus_image']?>') no-repeat;
            background-size : 100%;
        }

    </style>
<table>
    <tr>
        <td class="bus-img-area" rowspan="4"></td>
        <td class="bus-name"><?=$data['bus_name']?></td>
    </tr>
    <tr>
        <td class="bus-info">기사봉사료 포함</td>
    </tr>
    <tr>
        <td class="bus-price"><?=set_comma($bus_price[0])?>원<span class="bus-time"><?=$stay?></span><span class="bus-time-text">일</span></td>
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