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
<table>
    <tr>
        <td>총금액 : <input type="text" name="total_amount" id="total_amount" value="<?=set_comma($row_amount['reserv_total_price'])?>">원<br>
            총수익  :  <?=set_comma($profit)?>원 = <?=set_comma($row_amount['reserv_total_price'])?>원 - <?=set_comma($deposit_price)?>원
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>계약금</td>
        <td>입금자 <input type="text" name="reserv_deposit_depositor" id="reserv_deposit_depositor" value="<?=$row_amount['reserv_deposit_depositor']?>" size="13">
            <br>예약금 <input type="text" name="reserv_deposit_price" id="reserv_deposit_price" value="<?=set_comma($row_amount['reserv_deposit_price'])?>" size="13">
            <br>입금일 <input type="text" name="reserv_deposit_date" id="reserv_deposit_date" value="<?=$row_amount['reserv_deposit_date']?>" class="air_date" size="13">
            <br>입금상태<input type="checkbox" name="reserv_deposit_state"  value="Y"   <?if($row_amount['reserv_deposit_state']=="Y"){?>checked<?}?>></td>
        <td>중도금</td>
        <td>입금자 <input type="text" name="reserv_payment_depositor" id="reserv_payment_depositor" value="<?=$row_amount['reserv_payment_depositor']?>" size="13">
            <br>중도금 <input type="text" name="reserv_payment_price" id="reserv_payment_price" value="<?=set_comma($row_amount['reserv_payment_price'])?>" size="13">
            <br>입금일 <input type="text" name="reserv_payment_date" id="reserv_payment_date" value="<?=$row_amount['reserv_payment_date']?>" class="air_date" size="13">
            <br>입금상태<input type="checkbox" name="reserv_payment_state"  value="Y"  <?if($row_amount['reserv_payment_state']=="Y"){?>checked<?}?>></td>
        <td>잔&nbsp;금</td>
        <td>입금자 <input type="text" name="reserv_balance_depositor" id="reserv_balance_depositor" value="<?=$row_amount['reserv_balance_depositor']?>" size="13">
            <br>잔 &nbsp; 금 <input type="text" name="reserv_balance_price" id="reserv_balance_price" value="<?=set_comma($row_amount['reserv_balance_price'])?>" size="13">
            <br>입금일 <input type="text" name="reserv_balance_date" id="reserv_balance_date" value="<?=$row_amount['reserv_balance_date']?>" class="air_date"  size="13">
            <br>입금상태<input type="checkbox" name="reserv_balance_state" value="Y"  <?if($row_amount['reserv_balance_state']=="Y"){?>checked<?}?>></td>
    </tr>
</table>
<table>
    <tr>
        <td><input type="button" value="변경하기" onclick="update();"> <input type="button" value="닫기"></td>
    </tr>
</table>
<script>
    $( function() {
        $("#reserv_payment_price").keyup(function () {
            var total_price   = get_comma($("#total_amount").val());
            var deposit_price = get_comma($("#reserv_deposit_price").val());
            var payment_price = get_comma($("#reserv_payment_price").val());

            var balance_price = total_price - deposit_price -  payment_price;
            if($("input:checkbox[name='reserv_balance_state']").is(':checked')){
            }else {
                $("#reserv_balance_price").val(set_comma(balance_price));
            }
        });
        $("#reserv_deposit_price").keyup(function () {
            var total_price   = get_comma($("#total_amount").val());
            var deposit_price = get_comma($("#reserv_deposit_price").val());
            var payment_price = get_comma($("#reserv_payment_price").val());

            var balance_price = total_price - deposit_price -  payment_price;
            if($("input:checkbox[name='reserv_balance_state']").is(':checked')){
            }else {
                $("#reserv_balance_price").val(set_comma(balance_price));
            }
        });
    });


</script>