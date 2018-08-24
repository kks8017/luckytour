<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="insert"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_golf_golfno = $_REQUEST['golfno'];
    $reserv_golf_holeno = $_REQUEST['holeno'];
    $reserv_golf_date = $_REQUEST['start_date'];
    $reserv_golf_stay = $_REQUEST['stay'];
    $reserv_golf_adult_number = $_REQUEST['adult_number'];
    $reserv_golf_time = $_REQUEST['golf_time'];
    $reserv_type = $_REQUEST['reserv_type'];

    $golf = new golf();

    $golf->golf_no = $reserv_golf_golfno;
    $golf->hole_no = $reserv_golf_holeno;
    $golf->start_date = $reserv_golf_date;
    $golf->stay = $reserv_golf_stay;
    $golf->adult_number = $reserv_golf_adult_number;


    $reserv_golf_name = $golf->golf_name();
    $golf_price = $golf->golf_main_price();

    $reserv_golf_total_price = $golf_price[1];
    $reserv_golf_total_price_deposit = $golf_price[2];

    $sql = "insert into reservation_golf (reserv_user_no,
                                               reserv_golf_golf_no,
                                               reserv_golf_hole_no,
                                               reserv_golf_name,
                                               reserv_golf_hole_name,
                                               reserv_golf_date,
                                               reserv_golf_stay,
                                               reserv_golf_time,
                                               reserv_golf_total_price,
                                               reserv_golf_total_dposit_price,
                                               reserv_golf_adult_number,
                                               indate
                                               )VALUES(
                                               '{$reserv_user_no}',
                                               '{$reserv_golf_golfno}',
                                               '{$reserv_golf_holeno}',
                                               '{$reserv_golf_name[0]}',
                                               '{$reserv_golf_name[1]}',
                                               '{$reserv_golf_date}',
                                               '{$reserv_golf_stay}',
                                               '{$reserv_golf_time}',
                                               '{$reserv_golf_total_price}',
                                               '{$reserv_golf_total_price_deposit}',
                                               '{$reserv_golf_adult_number}',
                                               '{$indate}'
                                               ) 
                                               ";
    echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_golf_total_price,0);
    $res->start_date_change($reserv_user_no);

    $subject = "골프를 추가하셨습니다.";
    $content = "골프장명 : {$reserv_golf_name[0]}  <br>
                 홀   명 :{$reserv_golf_name[1]}  <br>
                 부킹일짜 :{$reserv_golf_date}  <br>
                 일수 :{$reserv_golf_stay}  <br>
                 부킹시간 :{$reserv_golf_time}   <br>
                 인   원:{$reserv_golf_adult_number} <br>
                 판매가 : {$reserv_golf_total_price}   <br>
                 입금가 : {$reserv_golf_total_price_deposit}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_golf_name = $_REQUEST['reserv_golf_name'];
    $reserv_golf_hole_name = $_REQUEST['reserv_golf_hole_name'];
    $reserv_golf_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
    $reserv_golf_stay = $_REQUEST['golf_stay'];
    $reserv_golf_time = $_REQUEST['reserv_golf_time'];
    $reserv_golf_adult_number = $_REQUEST['adult_number'];
    $reserv_type = $_REQUEST['reserv_type'];

    $reserv_golf_total_price = get_comma($_REQUEST['reserv_golf_total_price']);
    $reserv_golf_total_dposit_price = get_comma($_REQUEST['reserv_golf_total_dposit_price']);

    $sql_price = "select * from  reservation_golf where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_golf_total_price'];

    $sql = "update reservation_golf set reserv_golf_name='{$reserv_golf_name}' ,
                                               reserv_golf_hole_name='{$reserv_golf_hole_name}',
                                               reserv_golf_date='{$reserv_golf_date}',
                                               reserv_golf_stay='{$reserv_golf_stay}',
                                               reserv_golf_time='{$reserv_golf_time}',
                                               reserv_golf_total_price='{$reserv_golf_total_price}',
                                               reserv_golf_total_dposit_price='{$reserv_golf_total_dposit_price}',
                                               reserv_golf_adult_number='{$reserv_golf_adult_number}'                                     
            where no='{$no}'                                    ";
    // echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_golf_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "골프를 변경하셨습니다.";
    $content = "골프장명 : {$row_price['reserv_golf_name']} ->  {$reserv_golf_name} <br>
                 홀명 :{$row_price['reserv_golf_hole_name']} ->  {$reserv_golf_hole_name} <br>
                 부킹일 :{$row_price['reserv_golf_date']} ->  {$reserv_golf_date} <br>
                 일수 :{$row_price['reserv_golf_stay']} ->  {$reserv_golf_stay} <br>
                 부킹시간 :{$row_price['reserv_golf_time']} ->  {$reserv_golf_time} <br>
                 인  원 :{$row_price['reserv_golf_adult_number']}  ->  {$reserv_golf_adult_number} <br>
                 판매가 : {$row_price['reserv_golf_total_price']} ->  {$reserv_golf_total_price}   <br>
                 입금가 : {$row_price['reserv_golf_total_dposit_price']} ->  {$reserv_golf_total_dposit_price} <br>
                
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "delete"){

    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $no = $_REQUEST['no'];

    $sql_price = "select * from  reservation_golf where no='{$no}'";

    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_golf_total_price'];

    $sql = "update reservation_golf set reserv_del_mark='Y' where no='{$no}'";
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);
    $subject = "골프를 삭제 하셨습니다.";
    $content = "골프장명 : {$row_price['reserv_golf_name']}  <br>
                 홀명 :{$row_price['reserv_golf_hole_name']}  <br>
                 부킹일 :{$row_price['reserv_golf_date']} <br>
                 일수 :{$row_price['reserv_golf_stay']}  <br>
                 부킹시간 :{$row_price['reserv_golf_time']} <br>
                 인  원 :{$row_price['reserv_tel_adult_number']}  <br>
                 판매가 : {$row_price['reserv_golf_total_price']}   <br>
                 입금가 : {$row_price['reserv_golf_total_dposit_price']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="srh_update") {
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_golf_golf_no = $_REQUEST['golfno'];
    $reserv_golf_hole_no = $_REQUEST['holeno'];
    $reserv_golf_date = $_REQUEST['start_date'];
    $reserv_golf_stay = $_REQUEST['stay'];
    $reserv_golf_time = $_REQUEST['golf_time'];
    $reserv_golf_adult_number = $_REQUEST['adult_number'];
    $reserv_type = $_REQUEST['reserv_type'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];

    $golf = new golf();

    $golf->golf_no = $reserv_golf_golf_no;
    $golf->hole_no = $reserv_golf_hole_no;
    $golf->start_date = $reserv_golf_date;
    $golf->stay = $reserv_golf_stay;
    $golf->adult_number = $reserv_golf_adult_number;


    $sql_price = "select * from  reservation_golf  where no='{$no}' and reserv_del_mark!='Y'";
    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_golf_total_price'];

    $reserv_golf_name = $golf->golf_name();
    $golf_price = $golf->golf_main_price();

    $reserv_golf_total_price = $golf_price[1];
    $reserv_golf_total_price_deposit = $golf_price[2];

    $sql = "update reservation_golf set   reserv_golf_golf_no ='{$reserv_golf_hole_no}',
                                               reserv_golf_hole_no ='{$reserv_golf_hole_no}',
                                               reserv_golf_name ='{$reserv_golf_name[0]}',
                                               reserv_golf_hole_name ='{$reserv_golf_name[1]}',
                                               reserv_golf_date ='{$reserv_golf_date}',
                                               reserv_golf_stay ='{$reserv_golf_stay}',
                                               reserv_golf_time ='{$reserv_golf_time}',
                                               reserv_golf_total_price ='{$reserv_golf_total_price}',
                                               reserv_golf_total_dposit_price ='{$reserv_golf_total_price_deposit}',
                                               reserv_golf_adult_number ='{$reserv_golf_adult_number}'
                                        
            where no='{$no}'                                  
                                               ";
    //echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, $reserv_golf_total_price, $old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "골프를 변경하셨습니다.";
    $content = " 골프장명 : {$row_price['reserv_golf_name']} ->  {$reserv_golf_name[0]} <br>
                 홀명 :{$row_price['reserv_golf_hole_name']} ->  {$reserv_golf_name[1]} <br>
                 부킹일 :{$row_price['reserv_golf_date']} ->  {$reserv_golf_date} <br>
                 일수 :{$row_price['reserv_tel_stay']} ->  {$reserv_golf_stay} <br>
                 부킹시간 :{$row_price['reserv_golf_time']} ->  {$reserv_golf_time} <br>
                 인  원 :{$row_price['reserv_golf_adult_number']}  ->  {$reserv_golf_adult_number} <br>
                 판매가 : {$row_price['reserv_golf_total_price']} ->  {$reserv_golf_total_price}   <br>
                 입금가 : {$row_price['reserv_golf_total_dposit_price']} ->  {$reserv_golf_total_price_deposit} <br>
                
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update") {
    $i = $_REQUEST['i'];
    $reserv_golf_no = $_REQUEST['reserv_golf_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_golf_reconfirm_date = $_REQUEST['reserv_golf_reconfirm_date'][$i];
    $reserv_golf_reconfirm_name = $_REQUEST['reserv_golf_reconfirm_name'][$i];
    $reserv_golf_reconfirm_state = $_REQUEST['reserv_golf_reconfirm_state'][$i];

    $reserv_golf_deposit_price = get_comma($_REQUEST['reserv_golf_deposit_price'][$i]);
    $reserv_golf_deposit_date = $_REQUEST['reserv_golf_deposit_date'][$i];
    $reserv_golf_deposit_state = $_REQUEST['reserv_golf_deposit_state'][$i];
    $reserv_golf_balance_price = get_comma($_REQUEST['reserv_golf_balance_price'][$i]);
    $reserv_golf_balance_date = $_REQUEST['reserv_golf_balance_date'][$i];
    $reserv_golf_balance_state = $_REQUEST['reserv_golf_balance_state'][$i];

    $sql_price = "select * from  reservation_golf  where no='{$no}' and reserv_del_mark!='Y'";
    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_golf_total_price'];

    $sql = "update reservation_golf set  reserv_golf_reconfirm_date = '{$reserv_golf_reconfirm_date}',
                                          reserv_golf_reconfirm_name = '{$reserv_golf_reconfirm_name}',
                                          reserv_golf_reconfirm_state = '{$reserv_golf_reconfirm_state}',
                                          reserv_golf_deposit_price ='{$reserv_golf_deposit_price}',
                                          reserv_golf_deposit_date ='{$reserv_golf_deposit_date}',
                                          reserv_golf_deposit_state = '{$reserv_golf_deposit_state}',
                                          reserv_golf_balance_price = '{$reserv_golf_balance_price}',
                                          reserv_golf_balance_date = '{$reserv_golf_balance_date}',                          
                                          reserv_golf_balance_state = '{$reserv_golf_balance_state}'
                                  
                                       
                where no='{$reserv_golf_no}'";
    echo $sql;
    $db->sql_query($sql);

    if($row_price['reserv_golf_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_golf_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_golf_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_golf_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "골프정보를 변경하셨습니다.";
    $content = "재확인날짜 : {$row_price['reserv_golf_reconfirm_date']}  -> {$reserv_golf_reconfirm_date} 변경 <br>
                 담당자 :{$row_price['reserv_golf_reconfirm_name']} -> {$reserv_golf_reconfirm_name} 변경 <br>
                 재확인상태 :{$row_price['reserv_golf_reconfirm_state']} -> {$reserv_golf_reconfirm_state} 변경 <br>
                 선금 :{$row_price['reserv_golf_deposit_price']} -> {$reserv_golf_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_golf_deposit_date']}  -> {$reserv_golf_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금{$row_price['reserv_golf_balance_price']}  -> {$reserv_golf_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_golf_balance_date']}  -> {$reserv_golf_balance_date} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}
?>