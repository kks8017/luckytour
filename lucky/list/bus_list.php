<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$bus = new bus();
$main = new main();
$bus_date = $_POST['start_date'];
$stay = $_POST['bus_stay'];


$bus_vehicle = $_POST['bus_vehicle'];
$bus_type = $_POST['bus_type'];
$sql = "select * from bus_taxi_car where  bus_open='Y' and bus_type='{$bus_type}' order by bus_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_BUS_DIR;

$main->sdate = $bus_date;
$start_week = $main->week();

?>
<ul class="pkg">
    <?php
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

    <li><a href="javascript:bus_selected(<?=$i?>);"><img src="<?=$image_dir?>/<?=$data['bus_image']?>" width="278" height="208"/></a>
        <p class="name"><?=$data['bus_name']?></p>
        <p class="txt">(기사봉사료 포함 / <?=$stay?>일 / <?=$bus_vehicle?>대)</p>
        <p class="price"><?=set_comma($bus_price[0])?>원</p>
        <p><a href="javascript:bus_selected(<?=$i?>);"><img src="../sub_img/select_btn3.png" /></a></p>
    </li>
        <input type="hidden" id="bus_name_<?=$i?>" value="<?=$data['bus_name']?>">
        <input type="hidden" id="b_date_<?=$i?>" value="<?=$bus_date?>">
        <input type="hidden" id="bus_stay_<?=$i?>" value="<?=$stay?>">
        <input type="hidden" id="bus_vehicle_<?=$i?>" value="<?=$bus_vehicle?>">
        <input type="hidden" id="bus_no_<?=$i?>" value="<?=$data['no']?>">
        <input type="hidden" id="bus_price_<?=$i?>" value="<?=$bus_price[0]?>">
        <input type="hidden" id="bus_week_<?=$i?>" value="<?=$start_week?>">
       <?php
                $i++;
            }
        }else{
    ?>
    <?}?>

</ul>