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
    $deposit_class = "payment";
}else{
    $deposit_state = "미결제";
    $deposit_class = "no_payment";
}
if($row_amount['reserv_payment_state']=="Y"){
    $payment_state = "결제완료";
    $payment_class = "payment";
}else{
    $payment_state = "미결제";
    $payment_class = "no_payment";
}
if($row_amount['reserv_balance_state']=="Y"){
    $balance_state = "결제완료";
    $balance_class = "payment";
}else{
    $balance_state = "미결제";
    $balance_class = "no_payment";
}

?>
<script>
    function sms_send(type) {
        window.open("../SMS/mms.php?reserv_no=<?=$no?>&c="+type,"sms","width=254,height=460");
    }
    function deposit_board() {
        window.open("deposit_board.php?reserv_no=<?=$no?>","board","width=450,height=100");
    }
    function reserv_email() {
        window.open("email.php?no=<?=$no?>","email","width=800,height=500,scrollbars=yes")
    }
    function reserv_email_est() {
        window.open("est_email.php?no=<?=$no?>","email","width=800,height=500,scrollbars=yes")
    }
</script>
<header><p style="padding-left: 10px;">입금정보 <img type="button" src="../image/deposit_upd_btn.png" style="cursor: pointer;vertical-align: middle;" onclick="amount_update();" /> <img type="button" src="../image/ok_mail.gif" style="cursor: pointer;vertical-align: middle;" onclick="reserv_email();" /> <img type="button" src="../image/est_mail.gif" style="cursor: pointer;vertical-align: middle;" onclick="reserv_email_est();" /> <img type="button" src="../image/board_add.gif" style="cursor: pointer;vertical-align: middle;" onclick="deposit_board();" /></p> </header>
<table width="100%">
     <tr>
        <th class="title"><span>계약금</span></th>
        <td ><span class="price"><?=set_comma($row_amount['reserv_deposit_price'])?>원</span><span class="bracket">[</span><span class="<?=$deposit_class?>"><?=$deposit_state?></span><span class="bracket">]</span>[<a href="javascript:sms_send('deposit_send');">요청</a>]</td>
        <th><span>계약금 입금일</span></th>
        <td > <span class="date"><?=$row_amount['reserv_deposit_date']?></span> [<a href="javascript:sms_send('deposit_ok');">완료</a>]</td>

    </tr>
    <tr>
        <th class="title"><span>잔금</span</th>
        <td><span class="price"><?=set_comma($row_amount['reserv_balance_price'])?>원</span><span class="bracket">[<span class="<?=$balance_class?>"><?=$balance_state?></span><span class="bracket">]</span>[<a href="javascript:sms_send('balance_send');">요청</a>]</td>
        <th><span>잔금입금일</span></th>
        <td ><span class="date"><?=$row_amount['reserv_balance_date']?></span> [<a href="javascript:sms_send('balance_ok');">완료</a>]</td>

    </tr>
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
                <th class="title"><span>카드결제금</span></th>
                <td ><span class="price"><?=set_comma($data['reserv_amount_card_price'])?>원</span><span class="bracket">[<span class="<?=$deposit_class?>"><?=$state?></span><span class="bracket">]</span></td>
                <th><span>결제일</span></th>
                <td > <span class="date"><?=$data['reserv_amount_card_date']?></span></td>
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
                <th class="title"><span><?=$data['reserv_etc_type']?></span></th>
                <td><span class="price"><?=set_comma($data['reserv_etc_price'])?>원</span><span class="bracket">[<span class="<?=$deposit_class?>"><?=$state?></span><span class="bracket">]</span></td>
                <th><span>처리일</span></th>
                <td ><span class="date"><?=$data['reserv_etc_date']?> </span></td>
            </tr>
            <?php
            $i++;
        }
    }else{
        ?>

    <?}?>


    <tr>
        <th class="title"><span>총 입금액</span></th>
        <td><span class="price"><?=set_comma($deposit_price)?>원</span>  </td>
        <th><span>총 수익</span></th>
        <td colspan="2"> <span class="price"><?=set_comma($profit)?>원</span></td>

    </tr>
    <tr>
        <th class="title"><span>총 금액</span></th>
        <td colspan="3"><span class="price"><?=set_comma($row_amount['reserv_total_price'])?>원</span></td>
    </tr>
</table>
