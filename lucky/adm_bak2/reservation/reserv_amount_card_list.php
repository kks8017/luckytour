<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['reserv_amount_no'];

$sql = "select * from reservation_amount_card where reserv_amount_no='{$no}'";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)){
  $result[] = $row;
}
?>
<script>
    $( function() {
        $( ".air_date" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
        $('.NumbersOnly').keyup(function () {
            if( $(this).val() != null && $(this).val() != '' ) {
                var tmps = parseInt($(this).val().replace(/[^0-9]/g, '')) || 0;
                var tmps2 = tmps.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).val(tmps2);
            }
        });

    });
</script>
<table>
    <tr>
        <td>결제명</td>
        <td>결제인</td>
        <td>결제금액</td>
        <td>결제일</td>
        <td>결제상태</td>
        <td>비고</td>
        <td>관리</td>
    </tr>
    <?php
    $i=0;
    if(is_array($result)) {
    foreach ($result as $data){

    ?>
    <tr>
        <td><input type="text" name="card_subject" id="card_subject_<?=$i?>" value="<?=$data['reserv_amount_card_subject']?>" size="15"></td>
        <td><input type="text" name="card_name" id="card_name_<?=$i?>" value="<?=$data['reserv_amount_card_name']?>" size="10"></td>
        <td><input type="text" name="card_price" id="card_price_<?=$i?>" value="<?=set_comma($data['reserv_amount_card_price'])?>" size="10" class="NumbersOnly"><input type="hidden"  id="card_old_price_<?=$i?>" value="<?=set_comma($data['reserv_amount_card_price'])?>"></td>
        <td><input type="text" name="card_date"  id="card_date_<?=$i?>" value="<?=$data['reserv_amount_card_date']?>" size="12" class="air_date"></td>
        <td>
            <select name="reserv_amount_card_state" id="card_state_<?=$i?>">
                <option value="N" <?if($data['reserv_amount_card_state']=="N"){?>selected<?}?>>미결제</option>
                <option value="Y" <?if($data['reserv_amount_card_state']=="Y"){?>selected<?}?>>결제완료</option>
            </select>
        </td>
        <td><input type="text" name="card_bigo" id="card_bigo_<?=$i?>" value="<?=$data['reserv_amount_card_bigo']?>" size="18"></td>
        <td><input type="button"  value="변경" onclick="card_update(<?=$i?>);"> <input type="button" value="삭제" onclick="card_delete(<?=$i?>);"><input type="hidden" id="no_<?=$i?>" value="<?=$data['no']?>"></td>
    </tr>
        <?php
        $i++;
    }
    }else{
        ?>
        <tr>
            <th colspan="7" ><p>등록된 정보가 없습니다.</p></th>
        </tr>
    <?}?>

</table>