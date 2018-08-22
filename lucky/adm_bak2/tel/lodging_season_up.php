<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$sql = "select no,lodging_no,lodging_season_name,lodging_season_start_date,lodging_season_end_date from lodging_season_list where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

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
            dateFormat: 'yy-mm-dd',
            numberOfMonths : 2
        });
    });
</script>
<table>
    <tr>
        <td>기간명</td>
        <td><input type="text" name="lodging_season_name_up" value="<?=$row['lodging_season_name']?>"></td>
    </tr>
    <tr>
        <td>기간일자</td>
        <td>시작일 : <input type="text" name="lodging_season_start_date_up" class="rent_date" value="<?=$row['lodging_season_start_date']?>"> <br>
            종료일 : <input type="text" name="lodging_season_end_date_up" class="rent_date" value="<?=$row['lodging_season_end_date']?>"></td>
    </tr>
</table>
<input type="hidden" name="s_no" value="<?=$row['no']?>">
<input type="hidden" name="case" value="season_up">
<p><input id="season_mod_btn" type="submit" value="기간수정"></p>
