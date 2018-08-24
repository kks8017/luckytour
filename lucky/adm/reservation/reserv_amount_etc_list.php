<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['reserv_amount_no'];

$sql = "select * from reservation_amount_etc where reserv_amount_no='{$no}'";

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
<table class="conbox">
    <tr>
        <td class="titbox">결제명</td>
        <td class="titbox">결제인</td>
        <td class="titbox">결제금액</td>
        <td class="titbox">결제일</td>
        <td class="titbox">결제상태</td>
        <td class="titbox">비고</td>
        <td class="titbox">관리</td>
    </tr>
    <?php
    $i=0;
    if(is_array($result)) {
        foreach ($result as $data){

            ?>
            <tr>
                <td>
                    <select name="etc_subject" id="etc_subject_<?=$i?>">
                        <option value="중도금" <?if($data['reserv_etc_type']=="중도금"){?>selected<?}?>>중도금</option>
                        <option value="현금영수증" <?if($data['reserv_etc_type']=="현금영수증"){?>selected<?}?>>현금영수증</option>
                        <option value="현지입금" <?if($data['reserv_etc_type']=="현지입금"){?>selected<?}?>>현지입금</option>
                        <option value="할인" <?if($data['reserv_etc_type']=="할인"){?>selected<?}?>>할인</option>
                        <option value="부분환불" <?if($data['reserv_etc_type']=="부분환불"){?>selected<?}?>>부분환불</option>
                        <option value="전액환불" <?if($data['reserv_etc_type']=="전액환불"){?>selected<?}?>>전액환불</option>
                        <option value="환불요청금" <?if($data['reserv_etc_type']=="환불요청금"){?>selected<?}?>>환불요청금</option>
                        <option value="거래처보관금" <?if($data['reserv_etc_type']=="거래처보관금"){?>selected<?}?>>거래처보관금</option>
                        <option value="추가금액" <?if($data['reserv_etc_type']=="추가금액"){?>selected<?}?>>추가금액</option>
                        <option value="기타" <?if($data['reserv_etc_type']=="기타"){?>selected<?}?>>기타</option>
                    </select>

                </td>
                <td><input type="text" name="etc_name" id="etc_name_<?=$i?>" value="<?=$data['reserv_etc_depositor']?>" size="10"></td>
                <td><input type="text" name="etc_price" id="etc_price_<?=$i?>" value="<?=set_comma($data['reserv_etc_price'])?>" size="10" class="NumbersOnly"><input type="hidden" id="etc_old_price_<?=$i?>" value="<?=set_comma($data['reserv_etc_price'])?>"> </td>
                <td><input type="text" name="etc_date"  id="etc_date_<?=$i?>" value="<?=$data['reserv_etc_date']?>" size="12" class="air_date"></td>
                <td>
                    <select name="reserv_amount_etc_state" id="etc_state_<?=$i?>">
                        <option value="N" <?if($data['reserv_etc_state']=="N"){?>selected<?}?>>미결제</option>
                        <option value="Y" <?if($data['reserv_etc_state']=="Y"){?>selected<?}?>>결제완료</option>
                    </select>
                </td>
                <td><input type="text" name="etc_bigo" id="etc_bigo_<?=$i?>" value="<?=$data['reserv_etc_bigo']?>" size="18"></td>
                <td><input type="button"  value="변경" onclick="etc_update(<?=$i?>);"> <input type="button" value="삭제" onclick="etc_delete(<?=$i?>);"><input type="hidden" id="etc_no_<?=$i?>" value="<?=$data['no']?>"></td>
            </tr>
            <?php
            $i++;
        }
    }else{
        ?>
        <tr>
            <td align="center" colspan="7" ><p>등록된 정보가 없습니다.</p></td>
        </tr>
    <?}?>

</table>