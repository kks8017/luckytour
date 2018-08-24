<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가


$lodging = new lodging();

$case = $_POST['dan'];

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$stay = $_POST['tel_stay'];
$sale_price =0;
$percent =0;
$lodging_area = $_POST['area'];
$lodging_type = $_POST['type'];
$search_name         = $_POST['search_name'];
$adult_number        = $_POST['adult_number'];
$child_number        = $_POST['child_number'];
$baby_number         = $_POST['baby_number'];
$lodging_vehicle      = $_POST['room_vehicle'];
$package = $_POST['package_type'];
$case = $_POST['case'];

//print_r($_POST);
if($lodging_area){
    $sql_area = "and lodging_area='{$lodging_area}' ";
}else{
    $sql_area = "";
}
if($lodging_type){
    $sql_type = "and lodging_type='{$lodging_type}' ";
}else{
    $sql_type = "";
}
if($search_name){
    $sql_name = "and lodging_name like '%{$search_name}%' ";
}else{
    $sql_name = "";
}

$sql = "select no,lodging_name,lodging_type,lodging_area,lodging_manager_phone,lodging_real_phone,lodging_account 
        from lodging_list where  lodging_open='Y'   {$sql_area} {$sql_type} {$sql_name}  order by lodging_sort asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = KS_DOMAIN."/".KS_DATA_DIR."/".KS_LOD_DIR;

?>
<script>
    function room_layler(tel_no) {
        overlays_view("overlay","layer_d");
        room_list(tel_no);
    }
</script>
<?
$i=0;
if(is_array($result_list)) {
foreach ($result_list as $data){

    $lodging->lodno = $data['no'];
    $lodging->start_date = $start_date;
    $lodging->stay = $stay;
    $lodging->adult_number = $adult_number;
    $lodging->child_number = $child_number;
    $lodging->baby_number  = $baby_number;
    $lodging->lodging_vehicle = $lodging_vehicle;
    $main_image = $lodging->lodging_main_image();
    $room_list = $lodging->room_list();

    $area = $lodging->lodging_code_name($data['lodging_area']);

    $price_date = $lodging->price_date();
    //echo $room_list[0]['no'];
    $lodging->roomno = $room_list[0]['no'];
    $lodging_price = $lodging->lodging_main_price();
    $lodging_basic_price = $lodging->lodging_basic_price();
    $basic_price = $lodging_price[5] ;
    if($package=="ACT"){
        $pack_name = "왕복항공+렌트카+".$room_list[0]['lodging_room_name'];
        $sale_price = $lodging_price[2];
    }else if($package=="AT"){
        $pack_name = "왕복항공+".$room_list[0]['lodging_room_name'];
        $sale_price = $lodging_price[1];
    }else if($package=="CT"){
        $pack_name = "렌트카+".$room_list[0]['lodging_room_name'];
        $sale_price = $lodging_price[1];
    }else{
        $pack_name = "";
        $sale_price = $lodging_price[0];
    }
    // echo $basic_price."===".$sale_price;

$percent = $sale_price / $basic_price * 100;
$add_percent =  round($percent, 0);
$total_percent =100 - $add_percent;
?>
    <style>
        .select-tel-list td.tel-img-area_<?=$i?> {
            width: 40%;
            height: 100%;
            margin : 10px;
            background : url('<?=$image_dir?>/<?=$main_image?>') no-repeat;
            background-size: cover;
        }
    </style>
<table>
    <tr>
        <td class="tel-img-area_<?=$i?>" rowspan="7">
        </td>

    </tr>
    <tr>
        <td class="tel-name"><?=$data['lodging_name']?></td>
    </tr>
    <tr>
        <td class="tel-place"><?=$area?> </td>
    </tr>
    <tr>
        <td class="tel-place"><?=$stay?>박<?=($stay+1)?>일 / 성인<?=$adult_number?>, 소아<?=$child_number?>, 유아<?=$baby_number?></td>
    </tr>
    <tr>
        <td class="tel-info">(요금적용일:  <?=$price_date?>까지)</td>
    </tr>
    <tr>
        <td class="tel-price"><?=set_comma($sale_price)?>원 <span class="tel-sale"><?=$total_percent?>%</span><span class="tel-stay"><?=$stay?></span><span class="tel-stay-text">박</span></td>
    </tr>
    <?if($case=="dan"){?>
        <tr>
            <td>
                <button id="pop_bt" class="select-button-left" onclick="window.location.href='../tel/tel_view.php?tel_no=<?=$data['no']?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&start_date=<?=$start_date?>&tel_stay=<?=$stay?>'" >선택</button>
            </td>
        </tr>
   <?}else{?>
        <tr>
            <td>
                <button id="pop_bt" class="select-button-left" onclick="room_layer(<?=$data['no']?>); " >선택</button>
            </td>
        </tr>
    <?}?>
</table>
    <?
    $i++;
}
}else{
 ?>
<?}?>