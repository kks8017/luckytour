<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];
$start_date = $_REQUEST['start_date'];
$num = $_REQUEST['bustour_number'];
$type = $_REQUEST['type'];

$bus_vehicle = $_REQUEST['bus_vehicle'];
$reserv_type = $_REQUEST['reserv_type'];
$bus_type = $_REQUEST['bus_type'];
$sql = "select * from bustour_tour where  bustour_open='Y' order by bustour_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_BUSTOUR_DIR;
?>

    <table class="conbox3">
        <th>사진</th>
        <th>투어명</th>
        <th>일정</th>
        <th>판매가</th>
        <th>입금가</th>
        <th>추가</th>
        <?php
        $i=0;
        if(is_array($result_list)) {
            foreach ($result_list as $data){

                $bustour->bustour_no = $data['no'];
                $bustour->number = $num;

                $bustour_price  = $bustour->bustour_price();

                ?>


                <tr>
                    <td align="center">
                      <img src="<?=$image_dir."/".$data['bustour_tour_main_image']?>" width="150" height="100">
                    </td>
                    <td  align="center">
                        <?=$data['bustour_tour_name']?>
                    </td>
                    <td  align="center">
                        일정 : <?=$data['bustour_tour_stay']?>박 <?=$data['bustour_tour_stay']+1?>일
                    </td>
                    <td  align="center">
                        판매가 : <?=$bustour_price[0]?>원
                    </td>
                    <td  align="center">
                        입금가 : <?=$bustour_price[1]?>원
                    </td>
                    <td  align="center">
                        <?if($type=="add"){?><input type="button" value="추가" onclick="bustour_add( '<?=$data['no']?>','<?=$start_date?>','<?=$num?>')"><?}else{?><input type="button" value="변경" onclick="bustour_update( '<?=$data['no']?>','<?=$start_date?>','<?=$num?>')"><?}?>
                    </td>
                </tr>

                <?php
                $i++;
            }
        }else{
            ?>
            <tr>
                <td colspan="6">등록된 정보가 없습니다.</td>
            </tr>
        <?}?>
    </table>

