<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="insert"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_tel_lodno = $_REQUEST['lodno'];
    $reserv_tel_roomno = $_REQUEST['roomno'];
    $reserv_tel_date = $_REQUEST['start_date'];
    $reserv_tel_stay = $_REQUEST['stay'];
    $reserv_tel_few= $_REQUEST['few'];
    $reserv_tel_adult_number = $_REQUEST['adult_number'];
    $reserv_tel_child_number = $_REQUEST['child_number'];
    $reserv_tel_baby_number = $_REQUEST['baby_number'];
    $reserv_type = $_REQUEST['reserv_type'];

    $lodging = new lodging();

    $lodging->lodno = $reserv_tel_lodno;
    $lodging->roomno = $reserv_tel_roomno;
    $lodging->start_date = $reserv_tel_date;
    $lodging->stay = $reserv_tel_stay;
    $lodging->lodging_vehicle = $reserv_tel_few;
    $lodging->adult_number = $reserv_tel_adult_number;
    $lodging->child_number = $reserv_tel_child_number;
    $lodging->baby_number  = $reserv_tel_baby_number;

    $reserv_tel_name = $lodging->lodging_room_name();
    $lodging_price = $lodging->lodging_main_price();

    if(strlen($reserv_type)  == 1 and $reserv_type !="T" ){
        $reserv_tel_total_price = (($lodging_price[1] * $reserv_tel_few) + $lodging_price[3]);
    }else if(strlen($reserv_type) > 1 and $reserv_type !="T" ){
        $reserv_tel_total_price = (($lodging_price[2] * $reserv_tel_few) + $lodging_price[3]);
    }else{
        $reserv_tel_total_price = (($lodging_price[0] * $reserv_tel_few) + $lodging_price[3]);
    }
    $reserv_tel_total_dposit_price = (($lodging_price[4] * $reserv_tel_few) + $lodging_price[3]);

    $sql = "insert into reservation_lodging (reserv_user_no,
                                               reserv_tel_lodno,
                                               reserv_tel_roomno,
                                               reserv_tel_name,
                                               reserv_tel_room_name,
                                               reserv_tel_date,
                                               reserv_tel_stay,
                                               reserv_tel_few,
                                               reserv_tel_total_price,
                                               reserv_tel_total_dposit_price,
                                               reserv_tel_adult_number,
                                               reserv_tel_child_number,
                                               reserv_tel_baby_number,
                                               indate
                                               )VALUES(
                                               '{$reserv_user_no}',
                                               '{$reserv_tel_lodno}',
                                               '{$reserv_tel_roomno}',
                                               '{$reserv_tel_name[0]}',
                                               '{$reserv_tel_name[1]}',
                                               '{$reserv_tel_date}',
                                               '{$reserv_tel_stay}',
                                               '{$reserv_tel_few}',
                                               '{$reserv_tel_total_price}',
                                               '{$reserv_tel_total_dposit_price}',
                                               '{$reserv_tel_adult_number}',
                                               '{$reserv_tel_child_number}',
                                               '{$reserv_tel_baby_number}',
                                               '{$indate}'
                                               ) 
                                               ";
    echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_tel_total_price,0);
    $res->start_date_change($reserv_user_no);

    $subject = "숙소를 추가하셨습니다.";
    $content = "숙소명 : {$reserv_tel_name[0]}  <br>
                 객실명 :{$reserv_tel_name[1]}  <br>
                 입실일 :{$reserv_tel_date}  <br>
                 숙박일 :{$reserv_tel_stay}  <br>
                 객실수 :{$reserv_tel_few}   <br>
                 성  인 :{$reserv_tel_adult_number} <br>
                 소  아 :{$reserv_tel_child_number}  <br>
                 유  아 : {$reserv_tel_baby_number}   <br>
                 판매가 : {$reserv_tel_total_price}   <br>
                 입금가 : {$reserv_tel_total_dposit_price}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_tel_name = $_REQUEST['reserv_tel_name'];
    $reserv_tel_room_name = $_REQUEST['reserv_tel_room_name'];
    $reserv_tel_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
    $reserv_tel_stay = $_REQUEST['tel_stay'];
    $reserv_tel_few = $_REQUEST['lodging_vehicle'];
    $reserv_tel_adult_number = $_REQUEST['adult_number'];
    $reserv_tel_child_number = $_REQUEST['child_number'];
    $reserv_tel_baby_number = $_REQUEST['baby_number'];
    $reserv_type = $_REQUEST['reserv_type'];

    $reserv_tel_total_price = get_comma($_REQUEST['reserv_tel_total_price']);
    $reserv_tel_total_dposit_price = get_comma($_REQUEST['reserv_tel_total_dposit_price']);

    $sql_price = "select * from  reservation_lodging where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_tel_total_price'];

    $sql = "update reservation_lodging set reserv_tel_name='{$reserv_tel_name}' ,
                                               reserv_tel_room_name='{$reserv_tel_room_name}',
                                               reserv_tel_date='{$reserv_tel_date}',
                                               reserv_tel_stay='{$reserv_tel_stay}',
                                               reserv_tel_few='{$reserv_tel_few}',
                                               reserv_tel_total_price='{$reserv_tel_total_price}',
                                               reserv_tel_total_dposit_price='{$reserv_tel_total_dposit_price}',
                                               reserv_tel_adult_number='{$reserv_tel_adult_number}',
                                               reserv_tel_child_number='{$reserv_tel_child_number}',
                                               reserv_tel_baby_number='{$reserv_tel_baby_number}'
            where no='{$no}'                                    ";
    // echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_tel_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "숙소를 변경하셨습니다.";
    $content = "숙소명 : {$row_price['reserv_tel_name']} ->  {$reserv_tel_name} <br>
                 객실명 :{$row_price['reserv_tel_room_name']} ->  {$reserv_tel_room_name} <br>
                 입실일 :{$row_price['reserv_tel_date']} ->  {$reserv_tel_date} <br>
                 숙박일 :{$row_price['reserv_tel_stay']} ->  {$reserv_tel_stay} <br>
                 객실수 :{$row_price['reserv_tel_few']} ->  {$reserv_tel_few} <br>
                 성  인 :{$row_price['reserv_tel_adult_number']}  ->  {$reserv_tel_adult_number} <br>
                 소  아 :{$row_price['reserv_tel_child_number']}  ->  {$reserv_tel_child_number} <br>
                 유  아 :{$row_price['reserv_tel_baby_number']} ->  {$reserv_tel_baby_number}  <br>
                 판매가 : {$row_price['reserv_tel_total_price']} ->  {$reserv_tel_total_price}   <br>
                 입금가 : {$row_price['reserv_tel_total_dposit_price']} ->  {$reserv_tel_total_dposit_price} <br>
                
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "delete"){

    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $no = $_REQUEST['no'];

    $sql_price = "select * from  reservation_lodging where no='{$no}'";

    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_tel_total_price'];

    $sql = "update reservation_lodging set reserv_del_mark='Y' where no='{$no}'";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);
    $subject = "숙소를 삭제 하셨습니다.";
    $content = "숙소명 : {$row_price['reserv_tel_name']}  <br>
                 객실명 :{$row_price['reserv_tel_room_name']}  <br>
                 입실일 :{$row_price['reserv_tel_date']} <br>
                 숙박일 :{$row_price['reserv_tel_stay']}  <br>
                 객실수 :{$row_price['reserv_tel_few']} <br>
                 성  인 :{$row_price['reserv_tel_adult_number']}  <br>
                 소  아 :{$row_price['reserv_tel_child_number']}  <br>
                 유  아 :{$row_price['reserv_tel_baby_number']} <br>
                 판매가 : {$row_price['reserv_tel_total_price']}   <br>
                 입금가 : {$row_price['reserv_tel_total_dposit_price']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="srh_update") {
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_tel_lodno = $_REQUEST['lodno'];
    $reserv_tel_roomno = $_REQUEST['roomno'];
    $reserv_tel_date = $_REQUEST['start_date'];
    $reserv_tel_stay = $_REQUEST['stay'];
    $reserv_tel_few = $_REQUEST['few'];
    $reserv_tel_adult_number = $_REQUEST['adult_number'];
    $reserv_tel_child_number = $_REQUEST['child_number'];
    $reserv_tel_baby_number = $_REQUEST['baby_number'];
    $reserv_type = $_REQUEST['reserv_type'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];

    $lodging = new lodging();

    $lodging->lodno = $reserv_tel_lodno;
    $lodging->roomno = $reserv_tel_roomno;
    $lodging->start_date = $reserv_tel_date;
    $lodging->stay = $reserv_tel_stay;
    $lodging->lodging_vehicle = $reserv_tel_few;
    $lodging->adult_number = $reserv_tel_adult_number;
    $lodging->child_number = $reserv_tel_child_number;
    $lodging->baby_number = $reserv_tel_baby_number;

    $reserv_tel_name = $lodging->lodging_room_name();
    $lodging_price = $lodging->lodging_main_price();

    $sql_price = "select * from  reservation_lodging  where no='{$no}' and reserv_del_mark!='Y'";
    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_tel_total_price'];

    if (strlen($reserv_type) == 1 and $reserv_type != "T") {
        $reserv_tel_total_price = (($lodging_price[1] * $reserv_tel_few) + $lodging_price[3]);
    } else if (strlen($reserv_type) > 1 and $reserv_type != "T") {
        $reserv_tel_total_price = (($lodging_price[2] * $reserv_tel_few) + $lodging_price[3]);
    } else {
        $reserv_tel_total_price = (($lodging_price[0] * $reserv_tel_few) + $lodging_price[3]);
    }
    $reserv_tel_total_dposit_price = (($lodging_price[4] * $reserv_tel_few) + $lodging_price[3]);

    $sql = "update reservation_lodging set   reserv_tel_lodno ='{$reserv_tel_lodno}',
                                               reserv_tel_roomno ='{$reserv_tel_roomno}',
                                               reserv_tel_name ='{$reserv_tel_name[0]}',
                                               reserv_tel_room_name ='{$reserv_tel_name[1]}',
                                               reserv_tel_date ='{$reserv_tel_date}',
                                               reserv_tel_stay ='{$reserv_tel_stay}',
                                               reserv_tel_few ='{$reserv_tel_few}',
                                               reserv_tel_total_price ='{$reserv_tel_total_price}',
                                               reserv_tel_total_dposit_price ='{$reserv_tel_total_dposit_price}',
                                               reserv_tel_adult_number ='{$reserv_tel_adult_number}',
                                               reserv_tel_child_number ='{$reserv_tel_child_number}',
                                               reserv_tel_baby_number ='{$reserv_tel_baby_number}'
            where no='{$no}'                                  
                                               ";
     //echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, $reserv_tel_total_price, $old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "숙소를 변경하셨습니다.";
    $content = "숙소명 : {$row_price['reserv_tel_name']} ->  {$reserv_tel_name[0]} <br>
                 객실명 :{$row_price['reserv_tel_room_name']} ->  {$reserv_tel_name[1]} <br>
                 입실일 :{$row_price['reserv_tel_date']} ->  {$reserv_tel_date} <br>
                 숙박일 :{$row_price['reserv_tel_stay']} ->  {$reserv_tel_stay} <br>
                 객실수 :{$row_price['reserv_tel_few']} ->  {$reserv_tel_few} <br>
                 성  인 :{$row_price['reserv_tel_adult_number']}  ->  {$reserv_tel_adult_number} <br>
                 소  아 :{$row_price['reserv_tel_child_number']}  ->  {$reserv_tel_child_number} <br>
                 유  아 :{$row_price['reserv_tel_baby_number']} ->  {$reserv_tel_baby_number}  <br>
                 판매가 : {$row_price['reserv_tel_total_price']} ->  {$reserv_tel_total_price}   <br>
                 입금가 : {$row_price['reserv_tel_total_dposit_price']} ->  {$reserv_tel_total_dposit_price} <br>
                
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update") {
    $i = $_REQUEST['i'];
    $reserv_tel_no = $_REQUEST['reserv_tel_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_tel_reconfirm_date = $_REQUEST['reserv_lodging_reconfirm_date'][$i];
    $reserv_tel_reconfirm_name = $_REQUEST['reserv_lodging_reconfirm_name'][$i];
    $reserv_tel_reconfirm_state = $_REQUEST['reserv_lodging_reconfirm_state'][$i];

    $reserv_tel_deposit_price = get_comma($_REQUEST['reserv_tel_deposit_price'][$i]);
    $reserv_tel_deposit_date = $_REQUEST['reserv_tel_deposit_date'][$i];
    $reserv_tel_deposit_state = $_REQUEST['reserv_tel_deposit_state'][$i];
    $reserv_tel_balance_price = get_comma($_REQUEST['reserv_tel_balance_price'][$i]);
    $reserv_tel_balance_date = $_REQUEST['reserv_tel_balance_date'][$i];
    $reserv_tel_balance_state = $_REQUEST['reserv_tel_balance_state'][$i];

    $sql_price = "select * from  reservation_lodging  where no='{$no}' and reserv_del_mark!='Y'";
    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_tel_total_price'];

    $sql = "update reservation_lodging set  reserv_lodging_reconfirm_date = '{$reserv_tel_reconfirm_date}',
                                          reserv_lodging_reconfirm_name = '{$reserv_tel_reconfirm_name}',
                                          reserv_lodging_reconfirm_state = '{$reserv_tel_reconfirm_state}',
                                          reserv_tel_deposit_price ='{$reserv_tel_deposit_price}',
                                          reserv_tel_deposit_date ='{$reserv_tel_deposit_date}',
                                          reserv_tel_deposit_state = '{$reserv_tel_deposit_state}',
                                          reserv_tel_balance_price = '{$reserv_tel_balance_price}',
                                          reserv_tel_balance_date = '{$reserv_tel_balance_date}',                          
                                          reserv_tel_balance_state = '{$reserv_tel_balance_state}'
                                  
                                       
                where no='{$reserv_tel_no}'";
    echo $sql;
    $db->sql_query($sql);

    if($row_price['reserv_tel_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_tel_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_tel_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_tel_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "숙소정보를 변경하셨습니다.";
    $content = "재확인날짜 : {$row_price['reserv_lodging_reconfirm_date']}  -> {$reserv_tel_reconfirm_date} 변경 <br>
                 담당자 :{$row_price['reserv_lodging_reconfirm_name']} -> {$reserv_tel_reconfirm_name} 변경 <br>
                 재확인상태 :{$row_price['reserv_lodging_reconfirm_state']} -> {$reserv_tel_reconfirm_state} 변경 <br>
                 선금 :{$row_price['reserv_tel_deposit_price']} -> {$reserv_tel_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_tel_deposit_date']}  -> {$reserv_tel_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금{$row_price['reserv_tel_balance_price']}  -> {$reserv_tel_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_tel_balance_date']}  -> {$reserv_tel_balance_date} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}
?>