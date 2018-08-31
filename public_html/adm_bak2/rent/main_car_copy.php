<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$com_no = $_REQUEST['com_no'];

$main_com_no = get_rentcar_company("","대표");

$sql = "select no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail where  rent_com_no='{$main_com_no[0]}'   order by rent_car_sort asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$rent = new rent();
?>
<script>
    $(document).ready(function () {
        $("#allsele").click(function () {
            $("input[name='sele[]']").prop("checked", function () {
                return !$(this).prop("checked");
            })
        });
    });
</script>
<table>
    <tr>
        <td><input type="checkbox" id="allsele"></td>
        <td>차량명</td>
        <td>차량종류</td>
        <td>연료</td>
    </tr>
<?
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $rent_type_name = $rent->rent_code_name($data['rent_car_type']);
        $rent_fuel_name = $rent->rent_code_name($data['rent_car_fuel']);
        ?>
        <tr>
            <td><input type="checkbox" name="sele[]" value="<?=$i?>"><input type="hidden" name="no_cp[]" value="<?=$data['no']?>"></td>
            <td><?=$data['rent_car_name']?></td>
            <td><?=$rent_type_name?></td>
            <td><?=$rent_fuel_name?></td>
        </tr>
        <?php
        $i++;
    }
}else{
    ?>
    <tr>
        <th colspan="8" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
    </tr>
<?}?>
 </table>
<p><input type="submit" value="복사하기"></p>
<input type="hidden" name="case" id="case" value="car_copy">
<input type="hidden" name="com_no" id="com_no" value="<?=$com_no?>">