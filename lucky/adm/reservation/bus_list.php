<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가


$reserv_user_no = $_REQUEST['reserv_user_no'];
$start_date = $_REQUEST['start_date'];
$stay = $_REQUEST['bus_stay'];
$type = $_REQUEST['type'];

$bus_vehicle = $_REQUEST['bus_vehicle'];
$reserv_type = $_REQUEST['reserv_type'];
$bus_type = $_REQUEST['bus_type'];
$sql = "select * from bus_taxi_car where  bus_open='Y' and bus_type='{$bus_type}' order by bus_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_BUS_DIR;
?>

    <table class="conbox3">
        <th>사진</th>
        <th>차량명</th>
        <th>사용일</th>
        <th>판매가</th>
        <th>입금가</th>
        <th>추가</th>
        <?php
        $i=0;
        if(is_array($result_list)) {
            foreach ($result_list as $data){

                $bus->bus_no = $data['no'];
                $bus->stay   = $stay;
                $bus->bus_vehicle = $bus_vehicle;

                $bus_price = $bus->bus_price();
                switch ($data['bus_type']){
                    case 'B' :
                        $bus_type = "버스";
                        break;
                    case 'X' :
                        $bus_type = "택시";
                        break;
                }
                ?>


                <tr>
                    <td  align="center">
                        <div ><img src="<?=$image_dir."/".$data['bus_image']?>" width="150" height="100"></div>
                    </td>
                    <td  align="center">
                        <?=$data['bus_name']?>
                    </td>
                    <td  align="center">
                        사용일 : <?=$stay?> 일
                    </td>
                    <td  align="center">
                        판매가 : <?=set_comma($bus_price[0])?>원
                    </td>
                    <td  align="center">
                        입금가 : <?=set_comma($bus_price[1])?>원
                    </td>
                    <td  align="center">
                       <?if($type=="add"){?><input type="button" value="추가" onclick="bus_add( '<?=$data['no']?>','<?=$start_date?>','<?=$stay?>','<?=$bus_vehicle?>','<?=$data['bus_type']?>')"><?}else{?><input type="button" value="변경" onclick="bus_update( '<?=$data['no']?>','<?=$start_date?>','<?=$stay?>','<?=$bus_vehicle?>','<?=$data['bus_type']?>')"><?}?>
                    </td>
                </tr>

                <?php
                $i++;
            }
        }else{
            ?>
            <tr>
                <td class="cont" align="center" colspan="7">등록된 정보가 없습니다.</td>
            </tr>
        <?}?>
    </table>
