<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];
if($case=="insert"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bus_no = $_REQUEST['busno'];

    $reserv_bus_date = $_REQUEST['start_date'];
    $reserv_bus_stay = $_REQUEST['stay'];
    $reserv_bus_few= $_REQUEST['few'];
    $reserv_bus_type= $_REQUEST['bus_type'];
    $reserv_type = $_REQUEST['reserv_type'];

    $bus->bus_no = $reserv_bus_no;
    $bus->stay = $reserv_bus_stay;
    $bus->bus_vehicle = $reserv_bus_few;
    $bus_price = $bus->bus_price();
    $bus_name = $bus->bus_name();

    $sql = "insert into reservation_bus (reserv_user_no,
                                               reserv_bus_no,
                                               reserv_bus_name,
                                               reserv_bus_date,
                                               reserv_bus_stay,
                                               reserv_bus_type,
                                               reserv_bus_total_price,
                                               reserv_bus_total_deposit_price,
                                               reserv_bus_vehicle,
                                               indate
                                               )VALUES(
                                               '{$reserv_user_no}',
                                               '{$reserv_bus_no}',
                                               '{$bus_name}',
                                               '{$reserv_bus_date}',
                                               '{$reserv_bus_stay}',
                                               '{$reserv_bus_type}',
                                               '{$bus_price[0]}',
                                               '{$bus_price[1]}',
                                               '{$reserv_bus_few}',
                                               '{$indate}'
                                               ) 
                                               ";
    echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$bus_price[0],0);
    $res->start_date_change($reserv_user_no);

    if($reserv_bus_type=="B"){
        $bus_type= "버스";
    }else{
        $bus_type= "택시";
    }

    $subject = "{$bus_type}을 추가하셨습니다.";
    $content = "차랑명 : {$bus_name}  <br>
                 출고일자 :{$reserv_bus_date}  <br>
                 사용일 :{$reserv_bus_stay}   <br>
                 사용대수 :{$reserv_bus_few}  <br>
                 판매가 : {$bus_price[0]}   <br>
                 입금가 : {$bus_price[1]}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bus_name = $_REQUEST['bus_name'];
    $reserv_bus_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];

    $reserv_bus_stay = $_REQUEST['bus_stay'];
    $reserv_bus_few = $_REQUEST['bus_vehicle'];
    $reserv_type = $_REQUEST['reserv_type'];
    $reserv_bus_type = $_REQUEST['reserv_bus_type'];

    $reserv_bus_total_price = get_comma($_REQUEST['reserv_bus_total_price']);
    $reserv_bus_total_dposit_price = get_comma($_REQUEST['reserv_bus_deposit_price']);

    $sql_price = "select * from  reservation_bus where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bus_total_price'];

    $sql = "update reservation_bus set       reserv_bus_name='{$reserv_bus_name}',
                                               reserv_bus_date='{$reserv_bus_date}',
                                               reserv_bus_stay='{$reserv_bus_stay}',
                                               reserv_bus_vehicle='{$reserv_bus_few}',
                                               reserv_bus_total_price='{$reserv_bus_total_price}',
                                               reserv_bus_total_deposit_price='{$reserv_bus_total_dposit_price}'
            where no='{$no}'    ";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_bus_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    if($reserv_bus_type=="B"){
        $bus_type= "버스";
    }else{
        $bus_type= "택시";
    }

    $subject = "{$bus_type}을 변경하셨습니다.";
    $content = "차랑명 : {$row_price['reserv_bus_name']} ->  {$reserv_bus_name} <br>
                 출고일자 :{$row_price['reserv_bus_date']} ->  {$reserv_bus_date} <br>
                 사용일 :{$row_price['reserv_bus_stay']}  ->  {$reserv_bus_stay} <br>
                 사용대수 :{$row_price['reserv_bus_vehicle']} ->  {$reserv_bus_few}  <br>
                 판매가 : {$row_price['reserv_bus_total_price']} ->  {$reserv_bus_total_price}   <br>
                 입금가 : {$row_price['reserv_bus_total_deposit_price']} ->  {$reserv_bus_total_dposit_price}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case == "delete") {
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bus_type = $_REQUEST['reserv_bus_type'];
    $no = $_REQUEST['no'];

    $sql_price = "select * from  reservation_bus where no='{$no}'";

    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bus_total_price'];

    $sql = "update reservation_bus set reserv_del_mark='Y' where no='{$no}'";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);

    if($reserv_bus_type=="B"){
        $bus_type= "버스";
    }else{
        $bus_type= "택시";
    }
    
    $subject = "{$bus_type}을 삭제하셨습니다.";
    $content = "차랑명 : {$row_price['reserv_bus_name']} <br>
                 출고일자 :{$row_price['reserv_bus_date']} <br>
                 사용일 :{$row_price['reserv_bus_stay']} <br>
                 사용대수 :{$row_price['reserv_bus_vehicle']}   <br>
                 판매가 : {$row_price['reserv_bus_total_price']}   <br>
                 입금가 : {$row_price['reserv_bus_total_deposit_price']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "srh_update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_bus_no = $_REQUEST['busno'];
    $reserv_bus_date = $_REQUEST['start_date'];
    $reserv_bus_stay = $_REQUEST['stay'];
    $reserv_bus_few= $_REQUEST['few'];
    $reserv_type = $_REQUEST['reserv_type'];
    $reserv_bus_type = $_REQUEST['bus_type'];
    $bus->bus_no = $reserv_bus_no;
    $bus->stay = $reserv_bus_stay;
    $bus->bus_vehicle = $reserv_bus_few;
    $bus_price = $bus->bus_price();
    $bus_name = $bus->bus_name();

    $sql_price = "select * from  reservation_bus where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bus_total_price'];

    $sql = "update reservation_bus set   reserv_bus_no ='{$reserv_bus_no}',
                                               reserv_bus_name ='{$bus_name}',
                                               reserv_bus_date ='{$reserv_bus_date}',
                                               reserv_bus_stay ='{$reserv_bus_stay}',
                                               reserv_bus_total_price ='{$bus_price[0]}',
                                               reserv_bus_total_deposit_price ='{$bus_price[1]}',
                                               reserv_bus_vehicle ='{$reserv_bus_few}'
                                           
            where no='{$no}'                                  
                                               ";
    //echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, $bus_price[0], $old_total_price);
    $res->start_date_change($reserv_user_no);

    if($reserv_bus_type=="B"){
        $bus_type= "버스";
    }else{
        $bus_type= "택시";
    }

    $subject = "{$bus_type}을 변경하셨습니다.";
    $content = "차랑명 : {$row_price['reserv_bus_name']} ->  {$bus_name} <br>
                 출고일자 :{$row_price['reserv_bus_date']} ->  {$reserv_bus_date} <br>
                 사용일 :{$row_price['reserv_bus_stay']}  ->  {$reserv_bus_stay} <br>
                 사용대수 :{$row_price['reserv_bus_vehicle']} ->  {$reserv_bus_few}  <br>
                 판매가 : {$row_price['reserv_bus_total_price']} ->  {$bus_price[0]}   <br>
                 입금가 : {$row_price['reserv_bus_total_deposit_price']} ->  {$bus_price[1]}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update") {
    $i = $_REQUEST['i'];
    $reserv_bus_no = $_REQUEST['reserv_bus_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bus_reconfirm_phone = $_REQUEST['reserv_bus_reconfirm_phone'][$i];
    $reserv_bus_reconfirm_name = $_REQUEST['reserv_bus_reconfirm_name'][$i];
    $reserv_bus_reconfirm_state = $_REQUEST['reserv_bus_reconfirm_state'][$i];

    $reserv_bus_deposit_price = get_comma($_REQUEST['reserv_bus_deposit_price'][$i]);
    $reserv_bus_deposit_date = $_REQUEST['reserv_bus_deposit_date'][$i];
    $reserv_bus_deposit_state = $_REQUEST['reserv_bus_deposit_state'][$i];
    $reserv_bus_balance_price = get_comma($_REQUEST['reserv_bus_balance_price'][$i]);
    $reserv_bus_balance_date = $_REQUEST['reserv_bus_balance_date'][$i];
    $reserv_bus_balance_state = $_REQUEST['reserv_bus_balance_state'][$i];

    $sql_price = "select * from  reservation_bus where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bus_total_price'];



    $sql = "update reservation_bus set  reserv_bus_reconfirm_phone = '{$reserv_bus_reconfirm_phone}',
                                          reserv_bus_reconfirm_person = '{$reserv_bus_reconfirm_name}',
                                          reserv_bus_reconfirm_state = '{$reserv_bus_reconfirm_state}',
                                          reserv_bus_deposit_price ='{$reserv_bus_deposit_price}',
                                          reserv_bus_deposit_date ='{$reserv_bus_deposit_date}',
                                          reserv_bus_deposit_state = '{$reserv_bus_deposit_state}',
                                          reserv_bus_balance_price = '{$reserv_bus_balance_price}',
                                          reserv_bus_balance_date = '{$reserv_bus_balance_date}',                          
                                          reserv_bus_balance_state = '{$reserv_bus_balance_state}'
                                  
                                       
                where no='{$reserv_bus_no}'";
   // echo $sql;
    $db->sql_query($sql);
    if($row_price['reserv_bus_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_bus_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_bus_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_bus_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "버스/택시정보를 변경하셨습니다.";
    $content = "재확인날짜 : {$row_price['reserv_bus_reconfirm_phone']}  -> {$reserv_bus_reconfirm_phone} 변경 <br>
                 담당자 :{$row_price['reserv_bus_reconfirm_person']} -> {$reserv_bus_reconfirm_name} 변경 <br>
                 재확인상태 :{$row_price['reserv_bus_reconfirm_state']} -> {$reserv_bus_reconfirm_state} 변경 <br>
                 선금 :{$row_price['reserv_bus_deposit_price']} -> {$reserv_bus_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_bus_deposit_date']}  -> {$reserv_bus_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금{$row_price['reserv_bus_balance_price']}  -> {$reserv_bus_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_bus_balance_date']}  -> {$reserv_bus_balance_date} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}
?>