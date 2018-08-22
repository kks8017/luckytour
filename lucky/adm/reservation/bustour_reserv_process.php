<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];
if($case=="insert"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bustour_no = $_REQUEST['no'];

    $reserv_bustour_date = $_REQUEST['start_date'];
    $reserv_bustour_number = $_REQUEST['number'];

    $reserv_type = $_REQUEST['reserv_type'];

    $bustour->bustour_no = $reserv_bustour_no;
    $bustour->number = $reserv_bustour_number;
    $bustour->start_date = $reserv_bustour_date;

    $bustour_row = $bustour->bustour_name();
    //print_r($bustour_row);

    $bustour_price = $bustour->bustour_price();

    $sql = "insert into reservation_bustour (reserv_user_no,
                                               reserv_bustour_no,
                                               reserv_bustour_name,
                                               reserv_bustour_date,
                                               reserv_bustour_number,
                                               reserv_bustour_stay,
                                               reserv_bustour_total_price,
                                               reserv_bustour_total_deposit_price,
                                               indate
                                               )VALUES(
                                               '{$reserv_user_no}',
                                               '{$reserv_bustour_no}',
                                               '{$bustour_row[0]['bustour_tour_name']}',
                                               '{$reserv_bustour_date}',
                                               '{$reserv_bustour_number}',
                                               '{$bustour_row[0]['bustour_tour_stay']}',
                                               '{$bustour_price[0]}',
                                               '{$bustour_price[1]}',
                                               '{$indate}'
                                               ) 
                                               ";
    echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$bustour_price[0],0);
    $res->start_date_change($reserv_user_no);

    $subject = "버스투어을 추가하셨습니다.";
    $content = "투어명 : {$bustour_row[0]['bustour_tour_name']}  <br>
                 투어일 :{$reserv_bustour_date}  <br>
                  인원 :{$reserv_bustour_number}  <br>
                 판매가 : {$bustour_price[0]}   <br>
                 입금가 : {$bustour_price[1]}  <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "update"){
    $indate = date("Y-m-d H:i");
    $no = $_REQUEST['no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bustour_name= $_REQUEST['reserv_bustour_name'];
    $reserv_bustour_date = $_REQUEST['start_date'];

    $bustour_number = $_REQUEST['bustour_number'];
    $reserv_type = $_REQUEST['reserv_type'];

    $reserv_bustour_total_price = get_comma($_REQUEST['reserv_bustour_total_price']);
    $reserv_bustour_total_deposit_price = get_comma($_REQUEST['reserv_bustour_deposit_price']);

    $sql_price = "select * from  reservation_bustour where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bustour_total_price'];

    $sql = "update reservation_bustour set   reserv_bustour_name='{$reserv_bustour_name}',
                                               reserv_bustour_date='{$reserv_bustour_date}',
                                               reserv_bustour_number='{$bustour_number}',
                                               reserv_bustour_total_price='{$reserv_bustour_total_price}',
                                               reserv_bustour_total_deposit_price='{$reserv_bustour_total_deposit_price}'
            where no='{$no}'    ";
    echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_bustour_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "버스투어을 변경하셨습니다.";
    $content = "투어명 : {$row_price['reserv_bustour_name']} ->  {$reserv_bustour_name} <br>
                 투어일 :{$row_price['reserv_bustour_date']} ->  {$reserv_bustour_date} <br>
                 인  원 :{$row_price['reserv_bustour_number']}  ->  {$bustour_number} <br>
                 판매가 : {$row_price['reserv_bustour_total_price']} ->  {$reserv_bustour_total_price}   <br>
                 입금가 : {$row_price['reserv_bustour_total_deposit_price']} ->  {$reserv_bustour_total_deposit_price}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "delete") {
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $no = $_REQUEST['no'];

    $sql_price = "select reserv_bustour_total_price from  reservation_bustour where no='{$no}'";


    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bustour_total_price'];

    $sql = "update reservation_bustour set reserv_del_mark='Y' where no='{$no}'";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "버스투어을 삭제하셨습니다.";
    $content = "투어명 : {$row_price['reserv_bustour_name']}  <br>
                 투어일 :{$row_price['reserv_bustour_date']}  <br>
                 인  원 :{$row_price['reserv_bustour_number']}   <br>
                 판매가 : {$row_price['reserv_bustour_total_price']}   <br>
                 입금가 : {$row_price['reserv_bustour_total_deposit_price']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case == "srh_update"){
    $indate = date("Y-m-d H:i");
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_bustour_no = $_REQUEST['reserv_bustour_no'];
    $no = $_REQUEST['no'];
    $reserv_bustour_date = $_REQUEST['start_date'];
    $reserv_bustour_number = $_REQUEST['number'];

    $reserv_type = $_REQUEST['reserv_type'];

    $bustour->bustour_no = $no;
    $bustour->number = $reserv_bustour_number;
    $bustour->start_date = $reserv_bustour_date;

    $bustour_row = $bustour->bustour_name();
    //print_r($bustour_row);

    $bustour_price = $bustour->bustour_price();

    $sql_price = "select * from  reservation_bustour where no='{$reserv_bustour_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bustour_total_price'];

    $sql = "update reservation_bustour set   reserv_bustour_no ='{$reserv_bus_no}',
                                               reserv_bustour_name ='{$bustour_row[0]['bustour_tour_name']}',
                                               reserv_bustour_date ='{$reserv_bustour_date}',
                                               reserv_bustour_number ='{$reserv_bustour_number}',
                                               reserv_bustour_total_price ='{$bustour_price[0]}',
                                               reserv_bustour_total_deposit_price ='{$bustour_price[1]}'
                                               
            where no='{$reserv_bustour_no}'                                  
                                               ";
    //echo $sql;
    //exit-1;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, $bustour_price[0], $old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "버스투어을 변경하셨습니다.";
    $content = "투어명 : {$row_price['reserv_bustour_name']} ->  {$bustour_row[0]['bustour_tour_name']} <br>
                 투어일 :{$row_price['reserv_bustour_date']} ->  {$reserv_bustour_date} <br>
                 인  원 :{$row_price['reserv_bustour_number']}  ->  {$reserv_bustour_number} <br>
                 판매가 : {$row_price['reserv_bustour_total_price']} ->  {$bustour_price[0]}   <br>
                 입금가 : {$row_price['reserv_bustour_total_deposit_price']} ->  {$bustour_price[1]}  <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update") {
    $i = $_REQUEST['i'];
    $reserv_bus_no = $_REQUEST['reserv_bustour_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];


    $reserv_bustour_deposit_price = get_comma($_REQUEST['reserv_bustour_deposit_price'][$i]);
    $reserv_bustour_deposit_date = $_REQUEST['reserv_bustour_deposit_date'][$i];
    $reserv_bustour_deposit_state = $_REQUEST['reserv_bustour_deposit_state_'.$i];
    $reserv_bustour_balance_price = get_comma($_REQUEST['reserv_bustour_balance_price'][$i]);
    $reserv_bustour_balance_date = $_REQUEST['reserv_bustour_balance_date'][$i];
    $reserv_bustour_balance_state = $_REQUEST['reserv_bustour_balance_state_'.$i];
    $reserv_bustour_bigo = $_REQUEST['reserv_bustour_bigo'];
    $sql_price = "select * from  reservation_bustour where no='{$reserv_bustour_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_bustour_total_price'];

    $sql = "update reservation_bustour set 
                                          reserv_bustour_deposit_price ='{$reserv_bustour_deposit_price}',
                                          reserv_bustour_deposit_date ='{$reserv_bustour_deposit_date}',
                                          reserv_bustour_deposit_state = '{$reserv_bustour_deposit_state}',
                                          reserv_bustour_balance_price = '{$reserv_bustour_balance_price}',
                                          reserv_bustour_balance_date = '{$reserv_bustour_balance_date}',                          
                                          reserv_bustour_balance_state = '{$reserv_bustour_balance_state}'
                                  
                where no='{$reserv_bus_no}'";
    // echo $sql;
    $db->sql_query($sql);
    $sql_bigo = "update reservation_user_content set reserv_bustour_bigo='{$reserv_bustour_bigo}' where no='{$reserv_user_no}' ";

    $db->sql_query($sql_bigo);
    if($row_price['reserv_bustour_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_bustour_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_bus_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_bustour_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "버스투어정보를 변경하셨습니다.";
    $content = " 선금 :{$row_price['reserv_bus_deposit_price']} -> {$reserv_bustour_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_bus_deposit_date']}  -> {$reserv_bustour_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금 :{$row_price['reserv_bus_balance_price']}  -> {$reserv_bustour_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_bus_balance_date']}  -> {$reserv_bustour_balance_state} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);


}
?>