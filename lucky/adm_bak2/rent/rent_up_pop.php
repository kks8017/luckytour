<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$company = set_company();
$no = $_REQUEST['no'];
$rent = new rent();

$rent_list_type = $rent->rent_code('T');
$rent_list_fuel = $rent->rent_code('F');
$rent_list_option = $rent->rent_code('O');

$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}

$sql = "select no,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$image_dir = "/".KS_DATA_DIR."/".KS_RENT_DIR;
$year = explode("~",$row['rent_car_year_type']);
?>

    <table>
        <tr>
            <td>업체명</td>
            <td>

                <select name="rent_company_up" id="rent_company_up">
                    <?php
                    foreach ($result_com as $com){  ?>
                        <option value="<?=$com['no']?>" <?if($row['rent_com_no'] == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
                    <?}?>
                </select>
            </td>
        </tr>
        <tr>
            <td>차량명</td>
            <td><input type="text" name="rent_name_up" id="rent_name_up" value="<?=$row['rent_car_name']?>"></td>
        </tr>
        <tr>
            <td>차량이미지</td>
            <td><img src="<?=$image_dir."/thumbnail_".$row['rent_car_image']?>" class="photo"><br><input type="file" name="car_image_up"><input type="hidden" name="old_image" value="<?="thumbnail_".$row['rent_car_image']?>"</td>
        </tr>
        <tr>
            <td>차량종류</td>
            <td>
                <select name="rent_car_type_up">
                    <?
                    foreach ($rent_list_type as $rent_type){
                        if($rent_type['no']==$row['rent_car_type']){$sel="selected";}else{$sel ="";}
                        echo "<option value='{$rent_type['no']}' $sel>{$rent_type['rent_config_name']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>연료</td>
            <td>
                <select name="rent_car_fuel_up">
                    <?
                    foreach ($rent_list_fuel as $rent_fuel){
                        if($rent_fuel['no']==$row['rent_car_fuel']){$sel="selected";}else{$sel ="";}
                        echo "<option value='{$rent_fuel['no']}' {$sel}>{$rent_fuel['rent_config_name']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>차량년식</td>
            <td><input type="text" name="rent_car_year_start_up" size="5" value="<?=$year[0]?>"> ~ <input type="text" name="rent_car_year_end_up" size="5" value="<?=$year[1]?>"> </td>
        </tr>
        <tr>
            <td>옵션</td>
            <td>
                <?
                $k=0;

                foreach ($rent_list_option as $rent_option){
                    if($row['rent_car_option']==$rent_option['no']){$chk="checked";}else{$chk="";}
                    echo "<input type='checkbox' name='rent_option_up[]' value='{$rent_option['no']}' {$chk}>{$rent_option['rent_config_name']} ";
                    $k++;
                }
                ?>

            </td>
        </tr>

    </table>
    <p><input id="up_btn" type="submit" value="차량수정"></p>
    <input type="hidden" name="case" value="car_up">
    <input type="hidden" name="no" value="<?=$row['no']?>">

