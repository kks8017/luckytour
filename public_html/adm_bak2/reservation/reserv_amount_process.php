<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="card_insert"){
    $indate = date("Y-m-d H:i:s",time());
    $reserv_amount_no         = $_REQUEST['reserv_amount_no'];
    $reserv_user_no         = $_REQUEST['reserv_user_no'];
    $card_subject             = $_REQUEST['card_subject'];
    $reserv_amount_card_price = get_comma($_REQUEST['reserv_amount_card_price']);

    $sql = "insert into reservation_amount_card set reserv_amount_no='{$reserv_amount_no}',reserv_amount_card_subject='{$card_subject}',reserv_amount_card_price='{$reserv_amount_card_price}', indate='{$indate}'";
    $db->sql_query($sql);
    if($card_subject=="계약금"){
        $res->deposit_price($reserv_user_no,0,$reserv_amount_card_price);
    }else if($card_subject=="중도금"){
        $res->payment_price($reserv_user_no,0,$reserv_amount_card_price);
    }else if($card_subject=="잔금"){
        $res->balance_price($reserv_user_no,0,$reserv_amount_card_price);
    }
    $subject = "카드결제를 추가하셨습니다.";
    $content = "결제명 : {$card_subject}  <br>
                 결제금액 :{$reserv_amount_card_price}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="card_update"){
    $no = $_REQUEST['no'];
    $card_subject  = $_REQUEST['card_subject'];
    $card_price    = get_comma($_REQUEST['card_price']);
    $card_old_price    = get_comma($_REQUEST['card_old_price']);
    $card_name    = $_REQUEST['card_name'];
    $card_date    = $_REQUEST['card_date'];
    $card_state    = $_REQUEST['card_state'];
    $card_bigo    = $_REQUEST['card_bigo'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];

    $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
    $rs_price  = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);

    if($card_subject=="계약금"){
        $res->deposit_price($reserv_user_no,$card_old_price,$card_price);
    }else if($card_subject=="중도금"){
        $res->payment_price($reserv_user_no,$card_old_price,$card_price);
    }else if($card_subject=="잔금"){
        $res->balance_price($reserv_user_no,$card_old_price,$card_price);
    }

    $sql = "update reservation_amount_card set reserv_amount_card_subject='{$card_subject}',
                                                 reserv_amount_card_price='{$card_price}',
                                                 reserv_amount_card_name='{$card_name}' ,
                                                 reserv_amount_card_date='{$card_date}' , 
                                                 reserv_amount_card_state='{$card_state}',
                                                 reserv_amount_card_bigo='{$card_bigo}' 
                                            where  no='{$no}'";
    echo $sql;
    $db->sql_query($sql);

    $subject = "카드결제를 변경하셨습니다.";
    $content = "결제명 : {$row_price['reserv_amount_card_subject']} ->  {$card_subject} <br>
                 결금액 :{$row_price['reserv_amount_card_price']} ->  {$card_price} <br>
                 결제자 :{$row_price['reserv_amount_card_name']}  ->  {$card_name} <br>
                 결제일: {$row_price['reserv_amount_card_date']} ->  {$card_date}   <br>
                 결제상태 : {$row_price['reserv_amount_card_state']} ->  {$card_state}  <br>
                 비고 : {$row_price['reserv_amount_card_bigo']} ->  {$card_bigo}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="card_delete") {
    $no = $_REQUEST['no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $card_subject  = $_REQUEST['card_subject'];
    $card_price    = get_comma($_REQUEST['card_price']);

    $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
    $rs_price  = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);

    $sql = "delete from reservation_amount_card where no='{$no}'";
    $db->sql_query($sql);

    if($card_subject=="계약금"){
        $total = $row_price['reserv_deposit_price'] +$card_price;
        $res->deposit_price($reserv_user_no,$total,$row_price['reserv_deposit_price']);
    }else if($card_subject=="중도금"){
        $total = $row_price['reserv_payment_price'] +$card_price;
        $res->payment_price($reserv_user_no,$total,$row_price['reserv_payment_price']);
    }else if($card_subject=="잔금"){
        $total = $row_price['reserv_balance_price'] +$card_price;
        $res->balance_price($reserv_user_no,$total,$row_price['reserv_balance_price']);
    }
    $subject = "카드결제를 삭제하셨습니다.";
    $content = "결제명 : {$row_price['reserv_amount_card_subject']}  <br>
                 결금액 :{$row_price['reserv_amount_card_price']}  <br>
                 결제자 :{$row_price['reserv_amount_card_name']} <br>
                 결제일: {$row_price['reserv_amount_card_date']}    <br>
                 결제상태 : {$row_price['reserv_amount_card_state']}  <br>
                 비고 : {$row_price['reserv_amount_card_bigo']} <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="etc_insert"){
        $indate = date("Y-m-d H:i:s",time());
        $reserv_amount_no         = $_REQUEST['reserv_amount_no'];
        $reserv_user_no           = $_REQUEST['reserv_user_no'];
        $etc_subject              = $_REQUEST['etc_subject'];
        $etc_price                = get_comma($_REQUEST['etc_price']);

        $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
        $rs_price  = $db->sql_query($sql_price);
        $row_price = $db->fetch_array($rs_price);

        $sql = "insert into reservation_amount_etc set reserv_amount_no='{$reserv_amount_no}',reserv_etc_type='{$etc_subject}',reserv_etc_price='{$etc_price}', indate='{$indate}'";
        $db->sql_query($sql);
        if($etc_subject =="할인") {
            $res->reserv_price_change($reserv_user_no, 0, $etc_price);
        }else if($etc_subject =="중도금"){
           if($row_price['reserv_balance_state']=="Y") {
               $res->payment_price($reserv_user_no, 0, $etc_price);
           }else{
               if ($row_price['reserv_payment_price'] > 0) {
                   $res->payment_price($reserv_user_no, 0, $etc_price);
               } else {
                   $res->balance_price($reserv_user_no, 0, $etc_price);
               }
           }
        }
    $subject = "{$etc_subject}를 추가하셨습니다.";
    $content = "결제명 : {$etc_subject}  <br>
                 결제금액 :{$etc_price}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="etc_update"){
        $no = $_REQUEST['no'];
        $reserv_user_no           = $_REQUEST['reserv_user_no'];
        $etc_subject  = $_REQUEST['etc_subject'];
        $etc_price    = get_comma($_REQUEST['etc_price']);
        $etc_old_price    = get_comma($_REQUEST['etc_old_price']);
        $etc_name    = $_REQUEST['etc_name'];
        $etc_date    = $_REQUEST['etc_date'];
        $etc_state    = $_REQUEST['etc_state'];
        $etc_bigo    = $_REQUEST['etc_bigo'];

        $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
        $rs_price  = $db->sql_query($sql_price);
        $row_price = $db->fetch_array($rs_price);

    $sql_etc = "select * from reservation_amount_etc where reserv_user_no='{$reserv_user_no}'";
    $rs_etc  = $db->sql_query($sql_etc);
    $row_etc = $db->fetch_array($rs_etc);

        if($etc_subject =="할인") {
            $res->reserv_price_change($reserv_user_no, $etc_old_price, $etc_price);
        }else if($etc_subject =="중도금"){
            if($row_price['reserv_balance_state']=="Y") {
                $res->payment_price($reserv_user_no, $etc_old_price, $etc_price);
            }else{
                if ($row_price['reserv_payment_price'] > 0) {
                    $total_price = $row_price['reserv_payment_price']+
                    $res->payment_price($reserv_user_no, $etc_old_price, $etc_price);
                } else {
                    $res->balance_price($reserv_user_no, $etc_old_price, $etc_price);
                }
            }
        }

        $sql = "update reservation_amount_etc set reserv_etc_type='{$etc_subject}',
                                                 reserv_etc_depositor='{$etc_name}',
                                                 reserv_etc_date='{$etc_date}' ,
                                                 reserv_etc_price='{$etc_price}' , 
                                                 reserv_etc_state='{$etc_state}',
                                                 reserv_etc_bigo='{$etc_bigo}' 
                                            where  no='{$no}'";
        echo $sql;
        $db->sql_query($sql);

        $subject = "{$row_etc['reserv_etc_type']}를 변경하셨습니다.";
        $content = "결제명 : {$row_etc['reserv_etc_type']} ->  {$etc_subject} <br>
                     결금액 :{$row_etc['reserv_etc_price']} ->  {$etc_name} <br>
                     결제자 :{$row_etc['reserv_etc_date']}  ->  {$etc_date} <br>
                     결제일: {$row_etc['reserv_etc_depositor']} ->  {$etc_name}   <br>
                     결제상태 : {$row_etc['reserv_etc_state']} ->  {$etc_state}  <br>
                     비고 : {$row_etc['reserv_etc_bigo']} ->  {$etc_bigo}  <br>
                     변경하셨습니다.
                   ";
        $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="etc_delete"){
    $no = $_REQUEST['no'];
    $etc_subject        = $_REQUEST['etc_subject'];
    $etc_price          = get_comma($_REQUEST['etc_price']);
    $reserv_user_no     = $_REQUEST['reserv_user_no'];

    $sql = "delete from reservation_amount_etc where no='{$no}'";
    $db->sql_query($sql);

    $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
    $rs_price  = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);

    $sql_etc = "select * from reservation_amount_etc where reserv_user_no='{$reserv_user_no}'";
    $rs_etc  = $db->sql_query($sql_etc);
    $row_etc = $db->fetch_array($rs_etc);

    if($etc_subject =="할인"){
        $res->reserv_price_change($reserv_user_no, $etc_price,0);
    }else if($etc_subject =="중도금") {
        $total = $row_price['reserv_balance_price'] +$etc_price;
        $res->payment_price($reserv_user_no, $total, $row_price['reserv_balance_price']);
    }
    $subject = "{$row_etc['reserv_etc_type']}를 변경하셨습니다.";
    $content = "결제명 : {$row_etc['reserv_etc_type']}<br>
                     결금액 :{$row_etc['reserv_etc_price']}<br>
                     결제자 :{$row_etc['reserv_etc_date']}  <br>
                     결제일: {$row_etc['reserv_etc_depositor']}    <br>
                     결제상태 : {$row_etc['reserv_etc_state']} <br>
                     비고 : {$row_etc['reserv_etc_bigo']} <br>
                     변경하셨습니다.
                   ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="update"){

    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_deposit_depositor = $_REQUEST['reserv_deposit_depositor'];
    $reserv_deposit_price = get_comma($_REQUEST['reserv_deposit_price']);
    $reserv_deposit_date = $_REQUEST['reserv_deposit_date'];
    if( $_REQUEST['reserv_deposit_state']=="undefined") {
        $reserv_deposit_state = "N";
    }else{
        $reserv_deposit_state = $_REQUEST['reserv_deposit_state'];
    }
    $reserv_payment_depositor = $_REQUEST['reserv_payment_depositor'];
    $reserv_payment_price = get_comma($_REQUEST['reserv_payment_price']);
    $reserv_payment_date = $_REQUEST['reserv_payment_date'];
   if( $_REQUEST['reserv_payment_state']=="undefined") {
        $reserv_payment_state = "N";
    }else{
        $reserv_payment_state = $_REQUEST['reserv_payment_state'];
    }
    $reserv_balance_depositor = $_REQUEST['reserv_balance_depositor'];
    $reserv_balance_price = get_comma($_REQUEST['reserv_balance_price']);
    $reserv_balance_state = $_REQUEST['reserv_balance_state'];
    $reserv_balance_date = $_REQUEST['reserv_balance_date'];
    if( $_REQUEST['reserv_balance_state']=="undefined") {
        $reserv_balance_state = "N";
    }else{
        $reserv_balance_state = $_REQUEST['reserv_balance_state'];
    }
    $reserv_total_price = get_comma($_REQUEST['total_amount']);

    $sql_price = "select * from reservation_amount where reserv_user_no='{$reserv_user_no}'";
    $rs_price  = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);


    $sql = "update reservation_amount set reserv_deposit_depositor='{$reserv_deposit_depositor}',
                                            reserv_deposit_price='{$reserv_deposit_price}',
                                            reserv_deposit_date='{$reserv_deposit_date}',
                                            reserv_deposit_state='{$reserv_deposit_state}',
                                            reserv_payment_depositor='{$reserv_payment_depositor}',
                                            reserv_payment_price='{$reserv_payment_price}',
                                            reserv_payment_date='{$reserv_payment_date}',
                                            reserv_payment_state='{$reserv_payment_state}',
                                            reserv_balance_depositor='{$reserv_balance_depositor}',
                                            reserv_balance_price='{$reserv_balance_price}',
                                            reserv_balance_date='{$reserv_balance_date}',
                                            reserv_balance_state='{$reserv_balance_state}',
                                            reserv_total_price='{$reserv_total_price}'
            where  reserv_user_no='{$reserv_user_no}'";
    echo $sql;
    $db->sql_query($sql);

    $subject = "입금정보를 변경하셨습니다.";
    $content = "     예약금 :{$row_price['reserv_deposit_price']} -> {$reserv_deposit_price} <br>
                     입금자 :{$row_price['reserv_deposit_depositor']} -> {$reserv_deposit_depositor}  <br>
                     입금일: {$row_price['reserv_deposit_date']} -> {$reserv_deposit_date}    <br>
                     입금상태 : {$row_price['reserv_deposit_state']} -> {$reserv_deposit_state} <br>
                     중도금 :{$row_price['reserv_payment_price']} -> {$reserv_payment_price}<br>
                     입금자 :{$row_price['reserv_payment_depositor']} -> {$reserv_payment_depositor}  <br>
                     입금일: {$row_price['reserv_payment_date']} -> {$reserv_payment_date}    <br>
                     입금상태 : {$row_price['reserv_payment_state']} -> {$reserv_payment_state} <br>
                     잔금 :{$row_price['reserv_balance_price']} -> {$reserv_balance_price}<br>
                     입금자 :{$row_price['reserv_balance_depositor']} -> {$reserv_balance_depositor}  <br>
                     입금일: {$row_price['reserv_balance_date']}  -> {$reserv_balance_date}  <br>
                     입금상태 : {$row_price['reserv_balance_state']} -> {$reserv_balance_state} <br>
                     변경하셨습니다.
                   ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}

?>