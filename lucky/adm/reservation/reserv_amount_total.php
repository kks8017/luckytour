<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['reserv_user_no'];

$sql_amount = "select * from reservation_amount where reserv_user_no='{$no}'";
$rs_amount  = $db->sql_query($sql_amount);
$row_amount = $db->fetch_array($rs_amount);
$res->res_no = $no;
$deposit_price = $res->reserv_deposit_price();
$profit = $row_amount['reserv_total_price'] - $deposit_price;
?>
<table class="conbox">
    <tr>
        <td height="50">총금액 : <input type="text" name="total_amount" id="total_amount" value="<?=set_comma($row_amount['reserv_total_price'])?>" >원<br>
           </td>
        <td>
            총수익  :  <?=set_comma($profit)?>원 = <?=set_comma($row_amount['reserv_total_price'])?>원 - <?=set_comma($deposit_price)?>원
        </td>
    </tr>
</table>
<table class="conbox">
    <tr>
        <td class="titbox" width="80">계약금</td>
        <td>
            <table class="conbox3" style="width: 370px;border: 0px;">
                <tr>
                    <td> 예약금 <input type="text" name="reserv_deposit_price" id="reserv_deposit_price" value="<?=set_comma($row_amount['reserv_deposit_price'])?>" size="18"></td>
                    <td>입금상태 <input type="checkbox" name="reserv_deposit_state"  value="Y"   <?if($row_amount['reserv_deposit_state']=="Y"){?>checked<?}?>></td>
                </tr>
                <tr>
                    <td>입금자 <input type="text" name="reserv_deposit_depositor" id="reserv_deposit_depositor" value="<?=$row_amount['reserv_deposit_depositor']?>" size="18"> </td>
                    <td>입금일 <input type="text" name="reserv_deposit_date" id="reserv_deposit_date" value="<?=$row_amount['reserv_deposit_date']?>" class="air_date" size="14"></td>
                </tr>
            </table>
            </td>
        <td class="titbox" width="80">잔&nbsp;금</td>
        <td>
            <table class="conbox3" style="width: 370px;border: 0px;">
                <tr>
                    <td> 잔 &nbsp; 금 <input type="text" name="reserv_balance_price" id="reserv_balance_price" value="<?=set_comma($row_amount['reserv_balance_price'])?>" size="18"></td>
                    <td>입금상태 <input type="checkbox" name="reserv_balance_state" value="Y"  <?if($row_amount['reserv_balance_state']=="Y"){?>checked<?}?>></td>
                </tr>
                <tr>
                    <td>입금자 <input type="text" name="reserv_balance_depositor" id="reserv_balance_depositor" value="<?=$row_amount['reserv_balance_depositor']?>" size="18"></td>
                    <td>입금일 <input type="text" name="reserv_balance_date" id="reserv_balance_date" value="<?=$row_amount['reserv_balance_date']?>" class="air_date"  size="18"></td>
                </tr>
            </table>

    </tr>
</table>
<table class="conbox">
    <tr>
        <td><input type="button" value="변경하기" onclick="update();"> <input type="button" value="닫기" onclick="window.close();"></td>
    </tr>
</table>
<script>
    $( function() {
         $("#reserv_deposit_price").keyup(function () {
            var total_price   = get_comma($("#total_amount").val());
            var deposit_price = get_comma($("#reserv_deposit_price").val());

            var balance_price = total_price - deposit_price ;
            if($("input:checkbox[name='reserv_balance_state']").is(':checked')){
            }else {
                $("#reserv_balance_price").val(set_comma(balance_price));
            }
        });
    });
    $( function() {
        $( ".air_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
        });
    });

</script>