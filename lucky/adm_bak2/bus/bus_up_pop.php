<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가


$no = $_REQUEST['no'];


$sql = "select no,bus_name,bus_type,bus_open,bus_image,bus_sort_no from bus_taxi_car where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$image_dir = "/".KS_DATA_DIR."/".KS_BUS_DIR;
$year = explode("~",$row['rent_car_year_type']);
?>

<table>
    <tr>
        <td>차량명</td>
        <td><input type="text" name="bus_name_up" id="bus_name_up" value="<?=$row['bus_name']?>"></td>
    </tr>
    <tr>
        <td>차량이미지</td>
        <td><img src="<?=$image_dir."/thumbnail_".$row['bus_image']?>" class="photo"><br><input type="file" name="car_image_up"><input type="hidden" name="old_image" value="<?="thumbnail_".$row['bus_image']?>"</td>
    </tr>
    <tr>
        <td>차량종류</td>
        <td>
            <select name="bus_type_up">
                <option value="B" <? if($row['bus_type']=="B"){?>selected<?}?>>버스</option>
                <option value="T" <? if($row['bus_type']=="T"){?>selected<?}?>>택시</option>
            </select>
        </td>
    </tr>
</table>
<p><input id="up_btn" type="submit" value="차량수정"></p>
<input type="hidden" name="case" value="bus_up">
<input type="hidden" name="no" value="<?=$row['no']?>">

