<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];
$start_date = $_REQUEST['start_date'];
$stay = $_REQUEST['tel_stay'];
$end_date = date("Y-m-d",strtotime($start_date."+{$stay} days"));
$type = $_REQUEST['type'];
$lodging_vehicle = $_REQUEST['lodging_vehicle'];
$reserv_type = $_REQUEST['reserv_type'];
$reserv_lodging_area = $_REQUEST['reserv_lodging_area'];
$reserv_lodging_type = $_REQUEST['reserv_lodging_type'];
$search_name         = $_REQUEST['search_name'];
$adult_number        = $_REQUEST['adult_number'];
$child_number        = $_REQUEST['child_number'];
$baby_number         = $_REQUEST['baby_number'];

if($reserv_lodging_area){
    $sql_area = "and lodging_area='{$reserv_lodging_area}' ";
}else{
    $sql_area = "";
}
if($reserv_lodging_type){
    $sql_type = "and lodging_type='{$reserv_lodging_type}' ";
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
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_LOD_DIR;
?>

    <table class="conbox3" style="width: 100%">
    <?php
    $i=0;
    if(is_array($result_list)) {
        foreach ($result_list as $data){
            $lodging_area = $lodging->lodging_code_name($data['lodging_area']);
            $lodging_type = $lodging->lodging_code_name($data['lodging_type']);

            $lodging->lodno = $data['no'];
            $lodging->start_date = $start_date;
            $lodging->stay = $stay;
            $lodging->adult_number = $adult_number;
            $lodging->child_number = $child_number;
            $lodging->baby_number  = $baby_number;
            $lodging->lodging_vehicle = $lodging_vehicle;
            $main_image = $lodging->lodging_main_image();
            ?>


                    <tr>
                        <td class="photo" >
                            <div ><img src="<?=$image_dir."/".$main_image?>" class="photo"><p><?=$data['lodging_name']?><br> 지역 : <?=$lodging_area?><br> 타입 : <?=$lodging_type?></p></div>
                        </td>
                        <td style="vertical-align: top;" >

                                <div>
                                    <table style="width: 100%; margin-top: 5px;  ">
                                        <tr>
                                            <th >객실명</th>
                                            <th >기준/최대</th>
                                            <th >입금가격</th>
                                            <th >판매가격</th>
                                            <th >변경/추가</th>
                                        </tr>
                                        <?php
                                       $room_list = $lodging->room_list();

                                        foreach ($room_list as $room){
                                            $lodging->roomno = $room['no'];
                                            $lodging_price = $lodging->lodging_main_price();

                                            if(strlen($reserv_type)  == 1 and $reserv_type !="T" ){
                                                $sale_lod_price = (($lodging_price[1] * $lodging_vehicle) + $lodging_price[3]);
                                            }else if(strlen($reserv_type) > 1 and $reserv_type !="T" ){
                                                $sale_lod_price = (($lodging_price[2] * $lodging_vehicle) + $lodging_price[3]);
                                            }else{
                                                $sale_lod_price = (($lodging_price[0] * $lodging_vehicle) + $lodging_price[3]);
                                            }
                                            $lod_price_deposit = (($lodging_price[4] * $lodging_vehicle) + $lodging_price[3]);
                                            ?>
                                            <tr>
                                                <td  ><?=$room['lodging_room_name']?></td>
                                                <td  ><?=$room['lodging_room_min']?> / <?=$room['lodging_room_max']?></td>
                                                <td ><?=set_comma($lod_price_deposit)?></td>
                                                <td ><?=set_comma($sale_lod_price)?></td>
                                                <td >
                                                    <?if($type=="add"){?>
                                                    <input type="button" value="추가" onclick="lodging_add('<?=$data['no']?>','<?=$room['no']?>','<?=$start_date?>','<?=$stay?>','<?=$lodging_vehicle?>','<?=$adult_number?>','<?=$child_number?>','<?=$baby_number?>','<?=$reserv_type?>','<?=$reserv_type?>')">
                                                    <?}else{?>
                                                    <input type="button" value="변경" onclick="lodging_update('<?=$data['no']?>','<?=$room['no']?>','<?=$start_date?>','<?=$stay?>','<?=$lodging_vehicle?>','<?=$adult_number?>','<?=$child_number?>','<?=$baby_number?>','<?=$reserv_type?>','<?=$reserv_type?>')">
                                                    <?}?>
                                                </td>
                                            </tr>
                                        <?}?>
                                    </table>
                            </div>
                        </td>
                    </tr>

            <?php
            $i++;
        }
    }else{
        ?>
        <tr><td></td></tr>
    <?}?>
         </table>

