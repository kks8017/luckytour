<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$reserv_user_no = $_REQUEST['reserv_no'];
$main = new main();
$main_company = $main->tour_config();
$res->res_no = $reserv_user_no;
$reser_user = $res->reserve_view();
$amount = $res->reserve_amount();
if($amount['reserv_deposit_state']=="Y" and $amount['reserv_balance_state']=="N"){
     $price = $amount['reserv_deposit_price'];
     $sel1 = "selected";
}else if($amount['reserv_deposit_state']=="Y" and $amount['reserv_balance_state']=="Y"){
    if($amount['reserv_balance_price']==0){
        $price = $amount['reserv_deposit_price'];
        $sel1 = "selected";
    }else {
        $price = $amount['reserv_balance_price'];
        $sel2 = "selected";
    }
}

?>


<form name="form2" method="post" action="reserv_user_process.php">
    <table width="430" border='1' cellpadding='3' cellspacing='0' bordercolor='#006600'>
        <tr>
            <td><select name="subject">
                    <option <?=$sel1?> value="예약금">예약금</option>
                    <option value="중도금">중도금</option>
                    <option value="전액">전액</option>
                    <option <?=$sel2?> value="잔금">잔금</option>
                    <option value="카드결제">카드결제</option>
                </select>
                입금자:
                <input name="name" type="text" size="10" value='<?=$reser_user['reserv_name']?>'>
                |입금액 :
                <input name="price" type="text" size="10" value='<?=set_comma($price)?>'>

        </tr>
    </table>
    <table width="430" border=0 cellpadding=3 cellspacing=0 bordercolor=#006600>
        <tr>
            <td align="center"><input type="hidden" name="reserv_no" value="<?=$reserv_user_no?>">
                <input type="hidden" name="package_type" value="<?=$reser_user['reserv_type']?>">
                <input type="hidden" name="case" value="deposit_board">
                <input type="submit" name="Submit" value="입금확인">
            </td>
        </tr>
    </table>
</form>