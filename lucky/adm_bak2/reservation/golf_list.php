<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];
$start_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
$stay = $_REQUEST['golf_stay'];
$end_date = date("Y-m-d",strtotime($start_date."+{$stay} days"));
$type = $_REQUEST['type'];

$reserv_type = $_REQUEST['reserv_type'];
$reserv_golf_area = $_REQUEST['reserv_golf_area'];
$search_name         = $_REQUEST['search_name'];
$adult_number        = $_REQUEST['adult_number'];
$golf_time        = $_REQUEST['reserv_golf_time'];

if($reserv_golf_area){
    $sql_area = "and lodging_area='{$reserv_golf_area}' ";
}else{
    $sql_area = "";
}

if($search_name){
    $sql_name = "and golf_name like '%{$search_name}%' ";
}else{
    $sql_name = "";
}

$sql = "select no,golf_name,golf_area,golf_phone,golf_fax 
        from golf_list where  golf_open_chk='Y'   {$sql_area}  {$sql_name}  order by golf_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_GOLF_DIR;
?>
<div class="rentcar_list">
    <table>
        <?php
        $i=0;
        if(is_array($result_list)) {
            foreach ($result_list as $data){
                $golf_area = $golf->golf_code_name($data['golf_area']);
                $golf->golf_no = $data['no'];
                $golf->start_date = $start_date;
                $golf->stay = $stay;
                $golf->adult_number = $adult_number;
                $main_image = $golf->golf_main_image();
                ?>
                <tr>
                    <td align="center">
                        <div ><img src="<?=$image_dir."/".$main_image?>" class="photo"><p><?=$data['golf_name']?><br> 지역 : <?=$golf_area?></p></div>
                    </td>
                    <td>

                        <div>
                            <table>
                                <?php
                                $hole_list = $golf->hole_list();

                                foreach ($hole_list as $hole){
                                    $golf->hole_no = $hole['no'];
                                    $golf_price = $golf->golf_main_price();

                                    $sale_golf_price = $golf_price[1];
                                    $golf_price_deposit = $golf_price[2];
                                    ?>
                                    <tr>
                                        <td><?=$hole['hole_name']?></td>
                                        <td>부킹시간 : <?=$golf_time?> </td>
                                        <td>입금가격 :<?=$golf_price_deposit?></td>
                                        <td>판매가격 :<?=$sale_golf_price?></td>
                                        <td>
                                            <?if($type=="add"){?>
                                                <input type="button" value="추가" onclick="golf_add('<?=$data['no']?>','<?=$hole['no']?>','<?=$start_date?>','<?=$stay?>','<?=$adult_number?>')">
                                            <?}else{?>
                                                <input type="button" value="변경" onclick="lodging_update('<?=$data['no']?>','<?=$hole['no']?>','<?=$start_date?>','<?=$stay?>','<?=$lodging_vehicle?>','<?=$adult_number?>','<?=$child_number?>','<?=$baby_number?>','<?=$reserv_type?>','<?=$reserv_type?>')">
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

</div>