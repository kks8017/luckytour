<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$sql = "select no,golf_season_name,golf_season_start_date,golf_season_end_date from golf_season_list where golf_no='{$golf_no}'  order by no";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);
?>
<script>
    $( function() {
        $( ".rent_date" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
    });
</script>
<table class="tbl_com">
    <tr>
        <th>기간명</th>
        <td><input type="text" name="golf_season_name_up" value="<?=$row['golf_season_name']?>"></td>
    </tr>
    <tr>
        <th>기간일자</th>
        <td>시작일 : <input type="text" name="golf_season_start_date_up" class="rent_date" value="<?=$row['golf_season_start_date']?>"> <br>
            종료일 : <input type="text" name="golf_season_end_date_up" class="rent_date" value="<?=$row['golf_season_end_date']?>"></td>
    </tr>
</table>
<input type="hidden" name="s_no" value="<?=$row['no']?>">
<input type="hidden" name="case" value="season_up">
<p><input id="season_mod_btn" type="submit" value="기간수정"></p>
