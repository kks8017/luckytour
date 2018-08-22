<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];
if($case=="insert"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_equip_no = $_REQUEST['equip_no'];

    $reserv_equip_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
    $reserv_equip_stay = $_REQUEST['reserv_equip_stay'];
    $reserv_equip_number = $_REQUEST['reserv_equip_number'];
    $reserv_equip_content = $_REQUEST['reserv_equip_content'];
    $reserv_equip_vehicle = $_REQUEST['reserv_equip_vehicle'];


    $res->equip_no =  $reserv_equip_no;
    $res->equip_stay = $reserv_equip_stay;
    $res->equip_number = $reserv_equip_number;
    $res->equip_vehicle = $reserv_equip_vehicle;

    $equip = $res->equip_price();

    $equip_name = $equip[2];
    $equip_price = $equip[0];
    $equip_deposit_price = $equip[1];


    $sql = "insert into reservation_equip (reserv_user_no,
                                               reserv_equip_no,
                                               reserv_equip_name,
                                               reserv_equip_content,
                                               reserv_equip_date,
                                               reserv_equip_number,
                                               reserv_equip_stay,
                                               reserv_equip_vehicle,
                                               reserv_equip_total_price,
                                               reserv_equip_total_deposit_price,
                                               indate
                                               )VALUES(
                                               '{$reserv_user_no}',
                                               '{$reserv_equip_no}',
                                               '{$equip_name}',
                                               '{$reserv_equip_content}',
                                               '{$reserv_equip_date}',
                                               '{$reserv_equip_number}',
                                               '{$reserv_equip_stay}',
                                               '{$reserv_equip_vehicle}',
                                               '{$equip_price}',
                                               '{$equip_deposit_price}',
                                               '{$indate}'
                                               ) 
                                               ";
    echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$equip_price,0);
    $res->start_date_change($reserv_user_no);

    $subject = "편의장비을 추가하셨습니다.";
    $content = "편의장비명 : {$equip_name}  <br>
                 사용일 :{$reserv_equip_date}({$reserv_equip_stay}일)  <br>
                  인원 :{$reserv_equip_number}  <br>
                 판매가 : {$equip_price}   <br>
                 입금가 : {$equip_deposit_price}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case == "update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $equip_no = $_REQUEST['equip_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_equip_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
    $reserv_equip_stay = $_REQUEST['reserv_equip_stay'];
    $reserv_equip_number = $_REQUEST['reserv_equip_number'];
    $reserv_equip_content = $_REQUEST['reserv_equip_content'];
    $reserv_equip_vehicle = $_REQUEST['reserv_equip_vehicle'];

    $res->equip_no =  $equip_no;
    $res->equip_stay = $reserv_equip_stay;
    $res->equip_number = $reserv_equip_number;
    $res->equip_vehicle = $reserv_equip_vehicle;

    $equip = $res->equip_price();

    $sql_price = "select * from  reservation_equip where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_equip_total_price'];

    if($row_price['reserv_equip_no'] == $equip_no){
        $reserv_equip_total_price = get_comma($_REQUEST['reserv_equip_total_price']);
        $reserv_equip_total_deposit_price = get_comma($_REQUEST['reserv_equip_total_deposit_price']);
    }else{
        $reserv_equip_total_price = $equip[0];
        $reserv_equip_total_deposit_price = $equip[1];
    }
    $equip_name = $equip[2];

    $sql = "update reservation_equip set     reserv_equip_no = '{$equip_no}',
                                               reserv_equip_name='{$equip_name}',
                                               reserv_equip_content='{$reserv_equip_content}',
                                               reserv_equip_date='{$reserv_equip_date}',
                                               reserv_equip_stay='{$reserv_equip_stay}',
                                               reserv_equip_number='{$reserv_equip_number}',
                                               reserv_equip_vehicle='{$reserv_equip_vehicle}',
                                               reserv_equip_total_price='{$reserv_equip_total_price}',
                                               reserv_equip_total_deposit_price='{$reserv_equip_total_deposit_price}'
            where no='{$no}'    ";
    echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_equip_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "편의장비을 변경하셨습니다.";
    $content = "편의장비명 : {$row_price['reserv_equip_name']} ->  {$equip_name} <br>
                 사용일 :{$row_price['reserv_equip_date']} ->  {$reserv_equip_date} <br>
                 인  원 :{$row_price['reserv_equip_number']}  ->  {$reserv_equip_number} <br>
                 판매가 : {$row_price['reserv_equip_total_price']} ->  {$reserv_equip_total_price}   <br>
                 입금가 : {$row_price['reserv_equip_total_deposit_price']} ->  {$reserv_equip_total_deposit_price}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "delete") {
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $no = $_REQUEST['no'];

    $sql_price = "select * from  reservation_equip where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_equip_total_price'];

    $sql = "update reservation_equip set reserv_del_mark='Y' where no='{$no}'";
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "편의장비을 삭제하셨습니다.";
    $content = "투어명 : {$row_price['reserv_equip_name']}  <br>
                 투어일 :{$row_price['reserv_equip_date']}  <br>
                 인  원 :{$row_price['reserv_equip_number']}   <br>
                 판매가 : {$row_price['reserv_equip_total_price']}   <br>
                 입금가 : {$row_price['reserv_equip_total_deposit_price']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update") {
    $i = $_REQUEST['i'];
    $reserv_equip_no = $_REQUEST['reserv_equip_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];

    if($_REQUEST['reserv_equip_state'][$i]){
        $reserv_equip_state = $_REQUEST['reserv_equip_state'][$i];
        $sql_state = " reserv_equip_state ='{$reserv_equip_state}',";
    }

    $reserv_equip_deposit_price = get_comma($_REQUEST['reserv_equip_deposit_price'][$i]);
    $reserv_equip_deposit_date = $_REQUEST['reserv_equip_deposit_date'][$i];
    $reserv_equip_deposit_state = $_REQUEST['reserv_equip_deposit_state_'.$i];
    $reserv_equip_balance_price = get_comma($_REQUEST['reserv_equip_balance_price'][$i]);
    $reserv_equip_balance_date = $_REQUEST['reserv_equip_balance_date'][$i];
    $reserv_equip_balance_state = $_REQUEST['reserv_equip_balance_state_'.$i];
    $reserv_equip_bigo = $_REQUEST['reserv_equip_bigo'];

    $sql_price = "select * from  reservation_equip where no='{$reserv_equip_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_equip_total_price'];

    $sql = "update reservation_equip set 
                                          {$sql_state}
                                          reserv_equip_deposit_price ='{$reserv_equip_deposit_price}',
                                          reserv_equip_deposit_date ='{$reserv_equip_deposit_date}',
                                          reserv_equip_deposit_state = '{$reserv_equip_deposit_state}',
                                          reserv_equip_balance_price = '{$reserv_equip_balance_price}',
                                          reserv_equip_balance_date = '{$reserv_equip_balance_date}',                          
                                          reserv_equip_balance_state = '{$reserv_equip_balance_state}'
                                  
                where no='{$reserv_equip_no}'";
    // echo $sql;
    $db->sql_query($sql);
    $sql_bigo = "update reservation_user_content set reserv_equip_bigo='{$reserv_equip_bigo}' where no='{$reserv_user_no}' ";

    $db->sql_query($sql_bigo);

    if($row_price['reserv_bustour_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_equip_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_bus_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_equip_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "버스투어정보를 변경하셨습니다.";
    $content = " 선금 :{$row_price['reserv_equip_deposit_price']} -> {$reserv_equip_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_equip_deposit_state']}  -> {$reserv_equip_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금 :{$row_price['reserv_equip_balance_price']}  -> {$reserv_equip_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_equip_balance_date']}  -> {$reserv_equip_balance_state} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);


}
?>