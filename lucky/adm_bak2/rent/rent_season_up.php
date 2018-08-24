<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$sql = "select no,rent_com_no,rent_season_name,rent_season_start_date,rent_season_end_date from rent_season_list where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}

?>
<script>
    $( function() {
        $( ".rent_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            dateFormat : "yy-mm-dd",
            numberOfMonths : 2
        });

    });
</script>
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
            <td>기간명</td>
            <td><input type="text" name="rent_season_name_up" id="rent_season_name_up" value="<?=$row['rent_season_name']?>"></td>
        </tr>
        <tr>
            <td>기간일자</td>
            <td>시작일 : <input type="text" name="rent_season_start_date_up" value="<?=$row['rent_season_start_date']?>" class="rent_date"> <br>
                종료일 : <input type="text" name="rent_season_end_date_up" value="<?=$row['rent_season_end_date']?>" class="rent_date"></td>
        </tr>
    </table>
    <input type="hidden" name="s_no" value="<?=$row['no']?>">
    <input type="hidden" name="case" value="season_up">
    <p><input id="season_mod_btn" type="submit" value="기간수정"></p>
