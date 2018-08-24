<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['reserv_user_no'];

$sql_amount = "select * from reservation_amount where reserv_user_no='{$no}'";
$rs_amount  = $db->sql_query($sql_amount);
$row_amount = $db->fetch_array($rs_amount);

$sql_card = "select * from reservation_amount_card where reserv_amount_no='{$row_amount['no']}'";
$rs_card  = $db->sql_query($sql_card);
while($row_card = $db->fetch_array($rs_card)){
    $result_card[] = $row_card;
}

$sql_etc = "select * from reservation_amount_etc where reserv_amount_no='{$row_amount['no']}'";
$rs_etc  = $db->sql_query($sql_etc);
while ($row_etc = $db->fetch_array($rs_etc)){
    $result_etc[] = $row_etc;
}

$res->res_no = $no;
$deposit_price = $res->reserv_deposit_price();
$profit = $row_amount['reserv_total_price'] - $deposit_price;

if($row_amount['reserv_deposit_state']=="Y"){
    $deposit_state = "결제완료";
    $deposit_class = "font_bule";
}else{
    $deposit_state = "미결제";
    $deposit_class = "font_red";
}
if($row_amount['reserv_payment_state']=="Y"){
    $payment_state = "결제완료";
    $payment_class = "font_bule";
}else{
    $payment_state = "미결제";
    $payment_class = "font_red";
}
if($row_amount['reserv_balance_state']=="Y"){
    $balance_state = "결제완료";
    $balance_class = "font_bule";
}else{
    $balance_state = "미결제";
    $balance_class = "font_red";
}
?>
<table>
    <tr>
        <td colspan="4">입금 정보 <input type="button" value="입금정보변경" onclick="amount_update();"></td>
    </tr>
    <tr>
        <td class="title">계약금</td>
        <td><?=set_comma($row_amount['reserv_deposit_price'])?> 원[<span class="<?=$deposit_class?>"><?=$deposit_state?></span>]</td>
        <td class="title">계약금입금일</td>
        <td><?=$row_amount['reserv_deposit_date']?> </td>
    </tr>
    <?if($row_amount['reserv_payment_price'] > 0){?>
        <tr>
            <td class="title">중도금</td>
            <td><?=set_comma($row_amount['reserv_payment_price'])?> 원 [<span class="<?=$payment_class?>"><?=$payment_state?></span>]</td>
            <td class="title">중도금입금일</td>
            <td><?=$row_amount['reserv_payment_date']?> </td>
        </tr>
    <?}?>
    <?php
    $i=0;
    if(is_array($result_card)) {
        foreach ($result_card as $data){
            if($data['reserv_amount_card_state']=="Y"){
                $state = "결제완료";
                $class = "font_bule";
            }else{
                $state = "미결제";
                $class = "font_red";
            }
            ?>
            <tr>
                <td class="title">카드결제금</td>
                <td><?=set_comma($data['reserv_amount_card_price'])?> 원[<span class="<?=$class?>"><?=$state?></span>]</td>
                <td class="title">결제일</td>
                <td><?=$data['reserv_amount_card_date']?> </td>
            </tr>
            <?php
            $i++;
        }
    }else{
        ?>

    <?}?>
    <?php
    $i=0;
    if(is_array($result_etc)) {
        foreach ($result_etc as $data){
            if($data['reserv_etc_state']=="Y"){
                $state = "결제완료";
                $class = "font_bule";
            }else{
                $state = "미결제";
                $class = "font_red";
            }
            ?>
            <tr>
                <td class="title"><?=$data['reserv_etc_type']?></td>
                <td><?=set_comma($data['reserv_etc_price'])?> 원[<span class="<?=$class?>"><?=$state?></span>]</td>
                <td class="title">처리일</td>
                <td><?=$data['reserv_etc_date']?> </td>
            </tr>
            <?php
            $i++;
        }
    }else{
        ?>

    <?}?>

    <tr>
        <td class="title">잔금</td>
        <td><?=set_comma($row_amount['reserv_balance_price'])?>원 [<span class="<?=$balance_class?>"><?=$balance_state?></span>]</td>
        <td class="title">잔금입금일</td>
        <td> <?=$row_amount['reserv_balance_date']?></td>
    </tr>
    <tr>
        <td class="title">총 입금액</td>
        <td><?=set_comma($deposit_price)?>  </td>
        <td class="title">총 수익</td>
        <td><?=set_comma($profit)?> </td>
    </tr>
    <tr>
        <td class="title">총 금액</td>
        <td colspan="3"><?=set_comma($row_amount['reserv_total_price'])?>원</td>
    </tr>
</table>
