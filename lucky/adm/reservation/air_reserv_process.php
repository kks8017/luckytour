<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];



if($case=="insert"){
    $air_no = $_REQUEST['air_company_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_adult_number = $_REQUEST['air_adult_number'];
    $reserv_air_child_number = $_REQUEST['air_child_number'];
    $reserv_air_baby_number = $_REQUEST['air_baby_number'];

    $sql_sch = "select * from air_schedule where a_sch_company_no='{$air_no}'";
    // echo $sql_sch;
    $rs_sch  = $db->sql_query($sql_sch);
    $row_sch = $db->fetch_array($rs_sch);

    $a_sch_departure_date = $row_sch['a_sch_departure_date']." ".$row_sch['a_sch_departure_time'];
    $a_sch_arrival_date   = $row_sch['a_sch_arrival_date']." ".$row_sch['a_sch_arrival_time'];

    $a_sch_adult_normal_price = ($row_sch['a_sch_adult_normal_price'] - 8000) ;
    $a_sch_child_normal_price = ($row_sch['a_sch_child_normal_price'] - 4000) ;
    $air_oil = get_oil($row_sch['a_sch_departure_date']);
    if($row_sch['a_sch_adult_sale']==0){
        $air_com = get_comm($row_sch['a_sch_departure_date']);
    }else{
        $air_com = 0;
    }
    $reserv_air_normal_total_price = ((($a_sch_adult_normal_price * $reserv_air_adult_number)+($air_oil+$air_com)) + (($a_sch_child_normal_price * $reserv_air_child_number)+($air_oil+$air_com)));
    $total_price = ((($row_sch['a_sch_adult_sale_price'] * $reserv_air_adult_number)+($air_oil+$air_com)) + (($row_sch['a_sch_child_sale_price'] * $reserv_air_child_number)+($air_oil+$air_com)));
    $total_deposit_price = ((($row_sch['a_sch_adult_deposit_price']* $reserv_air_adult_number) +($air_oil+$air_com)) + (($row_sch['a_sch_child_deposit_price'] * $reserv_air_child_number)+($air_oil+$air_com)));
    //  echo "$total_deposit_price = (({$row_sch['a_sch_adult_deposit_price']}* {$reserv_air_adult_number}) + ({$row_sch['a_sch_child_deposit_price']} + {$reserv_air_child_number}))";
    $sql = "insert into reservation_air(reserv_user_no,
                                          reserv_air_airno,
                                          reserv_air_company_no,
                                          reserv_air_departure_area,
                                          reserv_air_arrival_area,
                                          reserv_air_departure_airline,
                                          reserv_air_arrival_airline,
                                          reserv_air_departure_company,
                                          reserv_air_arrival_company,
                                          reserv_air_departure_date,
                                          reserv_air_arrival_date,                          
                                          reserv_air_stay,
                                          reserv_air_adult_normal_price,
                                          reserv_air_child_normal_price,
                                          reserv_air_adult_sale,                     
                                          reserv_air_child_sale,
                                          reserv_air_adult_deposit_sale,
                                          reserv_air_child_deposit_sale,
                                          reserv_air_normal_total_price,
                                          reserv_air_total_price,
                                          reserv_air_total_deposit_price,
                                          reserv_air_adult_number,
                                          reserv_air_child_number,
                                          reserv_air_baby_number,
                                          reserv_air_type
                                        )
                                        VALUES 
                                        ('{$reserv_user_no}',
                                         '{$row_sch['no']}',
                                         '{$air_no}',
                                         '{$row_sch['a_sch_departure_area_name']}',
                                         '{$row_sch['a_sch_arrival_area_name']}',
                                         '{$row_sch['a_sch_departure_airline_name']}',
                                         '{$row_sch['a_sch_arrival_airline_name']}',
                                         '{$row_sch['a_sch_company']}',
                                         '{$row_sch['a_sch_company']}',
                                         '{$a_sch_departure_date}',
                                         '{$a_sch_arrival_date}',
                                         '{$row_sch['a_sch_stay']}',
                                         '{$a_sch_adult_normal_price}',
                                         '{$a_sch_child_normal_price}',
                                         '{$row_sch['a_sch_adult_sale']}',
                                         '{$row_sch['a_sch_child_sale']}',
                                         '{$row_sch['a_sch_adult_deposit_sale']}',
                                         '{$row_sch['a_sch_child_deposit_sale']}',
                                         '{$reserv_air_normal_total_price}',
                                         '{$total_price}',
                                         '{$total_deposit_price}',
                                         '{$reserv_air_adult_number}',
                                         '{$reserv_air_child_number}',
                                         '{$reserv_air_baby_number}',
                                         'S'
                                        )";
     echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$total_price,0);
    $res->start_date_change($reserv_user_no);
    $subject = "{$row_sch['a_sch_departure_area_name']}출발 항공을 추가하셨습니다.";
    $content = "{$row_sch['a_sch_departure_area_name']}출발 -> 제주 {$row_sch['a_sch_departure_airline_name']}<br> 
                제주 -> {$row_sch['a_sch_departure_area_name']}출발 {$row_sch['a_sch_arrival_airline_name']}<br>
                출발 : {$a_sch_departure_date}   리턴 : {$a_sch_arrival_date} {$row_sch['a_sch_stay']} <br>
                성인할인율 : {$row_sch['a_sch_adult_sale']} 소아할인율 : {$row_sch['a_sch_child_sale']}<br>
                성인입금할인율 : {$row_sch['a_sch_adult_deposit_sale']} 소아입금할인율 : {$row_sch['a_sch_child_deposit_sale']}<br>
                성인: {$reserv_air_adult_number} 소아 : {$reserv_air_child_number} 유아 : {$reserv_air_baby_number}<br>
                총금액  : $total_price <br>
                항공을 추가하셨습니다.
                ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="stay_update"){
    $reserv_air_no = $_REQUEST['reserv_air_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_adult_number = $_REQUEST['adult_number'];
    $reserv_air_child_number = $_REQUEST['child_number'];
    $reserv_air_baby_number = $_REQUEST['baby_number'];
    $start_date    = $_REQUEST['start_date'];
    $start_hour    = $_REQUEST['start_hour'];
    $start_minute  = $_REQUEST['start_minute'];
    $end_date    = $_REQUEST['end_date'];
    $end_hour    = $_REQUEST['end_hour'];
    $end_minute  = $_REQUEST['end_minute'];

    $sql_price = "select * from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);

    $reserv_air_departure_date = $start_date." ".$start_hour.":".$start_minute;
    $reserv_air_arrival_date   = $end_date." ".$end_hour.":".$end_minute;

    $ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;
    $stay = $ddy."박".($ddy+1)."일";

    $sch_departure_area  = $_REQUEST['sch_departure_area'];
    $sch_end_departure_area  = $_REQUEST['sch_end_departure_area'];
    $sch_start_arrival_area  = $_REQUEST['sch_start_arrival_area'];
    $sch_arrival_area  = $_REQUEST['sch_arrival_area'];
    $start_airline  = $_REQUEST['start_airline'];
    $end_airline  = $_REQUEST['end_airline'];
    $start_company  = $_REQUEST['start_company'];
    $end_company  = $_REQUEST['end_company'];
    $reserv_air_adult_sale  = $_REQUEST['reserv_air_adult_sale'];
    $reserv_air_child_sale  = $_REQUEST['reserv_air_child_sale'];
    $reserv_air_adult_deposit_sale  = $_REQUEST['reserv_air_adult_deposit_sale'];
    $reserv_air_child_deposit_sale  = $_REQUEST['reserv_air_child_deposit_sale'];
    $reserv_total_price  = get_comma($_REQUEST['reserv_total_price']);
    $reserv_air_total_deposit_price  = get_comma($_REQUEST['reserv_total_deposit_price']);


    $sql = "update reservation_air set  reserv_air_departure_area = '{$sch_departure_area}',
                                          reserv_air_end_departure_area = '{$sch_end_departure_area}',
                                          reserv_air_start_arrival_area = '{$sch_start_arrival_area}',
                                          reserv_air_arrival_area = '{$sch_arrival_area}',
                                          reserv_air_departure_airline = '{$start_airline}',
                                          reserv_air_arrival_airline = '{$end_airline}',
                                          reserv_air_departure_company = '{$start_company}',
                                          reserv_air_arrival_company = '{$end_company}',
                                          reserv_air_departure_date = '{$reserv_air_departure_date}',
                                          reserv_air_arrival_date = '{$reserv_air_arrival_date}',                          
                                          reserv_air_stay = '{$stay}',
                                          reserv_air_adult_sale = '{$reserv_air_adult_sale}',                     
                                          reserv_air_child_sale = '{$reserv_air_child_sale}',
                                          reserv_air_adult_deposit_sale = '{$reserv_air_adult_deposit_sale}',
                                          reserv_air_child_deposit_sale = '{$reserv_air_child_deposit_sale}',
                                          reserv_air_total_price = '{$reserv_total_price}',
                                          reserv_air_total_deposit_price = '{$reserv_air_total_deposit_price}',
                                          reserv_air_adult_number = '{$reserv_air_adult_number}',
                                          reserv_air_child_number = '{$reserv_air_child_number}',
                                          reserv_air_baby_number = '{$reserv_air_baby_number}'
              where no='{$reserv_air_no}'";
    echo $sql;
    $db->sql_query($sql);
    $res->reserv_price_change($reserv_user_no,$reserv_total_price,$row_price['reserv_air_total_price']);
    $res->start_date_change($reserv_user_no);

    $subject = "항공내용을 변경하셨습니다.";
    $content = "출발지역 : {$row_price['reserv_air_departure_area']}  -> {$sch_departure_area} 변경 <br>
                 리턴지역 :{$row_price['reserv_air_arrival_area']} -> {$sch_arrival_area} 변경 <br>
                 출발항공사 :{$row_price['reserv_air_departure_airline']} -> {$start_airline} 변경 <br>
                 리턴항공사 :{$row_price['reserv_air_arrival_airline']} -> {$end_airline} 변경 <br>
                 출발에이전시 :{$row_price['reserv_air_departure_company']}  -> {$start_company} 변경 <br>
                 리턴에이전시 :{$row_price['reserv_air_arrival_company']} -> {$end_company} 변경 <br>
                 출발일자 :{$row_price['reserv_air_departure_date']} -> {$reserv_air_departure_date} 변경 <br>
                 리턴일자 :{$row_price['reserv_air_departure_date']}  -> {$reserv_air_arrival_date} 변경 <br>
                 성인판매할인율 : {$row_price['reserv_air_adult_sale']}  -> {$reserv_air_adult_sale} 변경 <br>
                 소아판매할인율 : {$row_price['reserv_air_child_sale']}  -> {$reserv_air_child_sale} 변경 <br>
                 성인입금할인율 : {$row_price['reserv_air_adult_deposit_sale']}  -> {$reserv_air_adult_deposit_sale} 변경 <br>
                 소아입금할인율 : {$row_price['reserv_air_child_deposit_sale']}  -> {$reserv_air_child_deposit_sale} 변경 <br>
                 총요금 : {$row_price['reserv_air_total_price']}  -> {$reserv_total_price} 변경 <br>
                 총입금요금 : {$row_price['reserv_air_total_deposit_price']}  -> {$reserv_air_total_deposit_price} 변경 <br>
                 성인인원 : {$row_price['reserv_air_adult_number']}  -> {$reserv_air_adult_number} 변경 <br>
                 소아인원 : {$row_price['reserv_air_child_number']}  -> {$reserv_air_child_number} 변경 <br>
                 유아인원 : {$row_price['reserv_air_baby_number']}  -> {$reserv_air_baby_number} 변경 
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="update"){
    $air_no = $_REQUEST['no'];
    $air_company_no = $_REQUEST['air_company_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_no = $_REQUEST['reserv_air_no'];
    $reserv_air_adult_number = $_REQUEST['adult_number'];
    $reserv_air_child_number = $_REQUEST['child_number'];
    $reserv_air_baby_number = $_REQUEST['baby_number'];

    $sql_sch = "select * from air_schedule where a_sch_company_no='{$air_company_no}'";
    // echo $sql_sch;
    $rs_sch  = $db->sql_query($sql_sch);
    $row_sch = $db->fetch_array($rs_sch);

    $a_sch_departure_date = $row_sch['a_sch_departure_date']." ".$row_sch['a_sch_departure_time'];
    $a_sch_arrival_date   = $row_sch['a_sch_arrival_date']." ".$row_sch['a_sch_arrival_time'];

    $a_sch_adult_normal_price = ($row_sch['a_sch_adult_normal_price'] - 8000) ;
    $a_sch_child_normal_price = ($row_sch['a_sch_child_normal_price'] - 4000) ;

    $air_oil = get_oil($row_sch['a_sch_departure_date']);
    if($row_sch['a_sch_adult_sale']==0){
        $air_com = get_comm($row_sch['a_sch_departure_date']);
    }else{
        $air_com = 0;
    }
    $reserv_air_normal_total_price = ((($a_sch_adult_normal_price * $reserv_air_adult_number)+($air_oil+$air_com)) + (($a_sch_child_normal_price * $reserv_air_child_number)+($air_oil+$air_com)));
    $total_price = ((($row_sch['a_sch_adult_sale_price'] * $reserv_air_adult_number)+($air_oil+$air_com)) + (($row_sch['a_sch_child_sale_price'] * $reserv_air_child_number)+($air_oil+$air_com)));
    $total_deposit_price = ((($row_sch['a_sch_adult_deposit_price']* $reserv_air_adult_number) +($air_oil+$air_com)) + (($row_sch['a_sch_child_deposit_price'] * $reserv_air_child_number)+($air_oil+$air_com)));

    $sql_price = "select * from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_air_total_price'];


    $sql = "update reservation_air set reserv_air_airno='{$air_no}',
                                          reserv_air_comapany_no='{$air_company_no}',
                                          reserv_air_departure_area = '{$row_sch['a_sch_departure_area_name']}',
                                          reserv_air_arrival_area = '{$row_sch['a_sch_arrival_area_name']}',
                                          reserv_air_departure_airline = '{$row_sch['a_sch_departure_airline_name']}',
                                          reserv_air_arrival_airline ='{$row_sch['a_sch_arrival_airline_name']}',
                                          reserv_air_departure_company ='{$row_sch['a_sch_company']}',
                                          reserv_air_arrival_company = '{$row_sch['a_sch_company']}',
                                          reserv_air_departure_date = '{$a_sch_departure_date}',
                                          reserv_air_arrival_date = '{$a_sch_arrival_date}',                          
                                          reserv_air_stay = '{$row_sch['a_sch_stay']}',
                                          reserv_air_adult_normal_price = '{$a_sch_adult_normal_price}',
                                          reserv_air_child_normal_price = '{$a_sch_child_normal_price}',
                                          reserv_air_adult_sale = '{$row_sch['a_sch_adult_sale']}',                     
                                          reserv_air_child_sale = '{$row_sch['a_sch_child_sale']}',
                                          reserv_air_adult_deposit_sale = '{$row_sch['a_sch_adult_deposit_sale']}',
                                          reserv_air_child_deposit_sale = '{$row_sch['a_sch_child_deposit_sale']}',
                                          reserv_air_normal_total_price = '{$reserv_air_normal_total_price}',
                                          reserv_air_total_price = '{$total_price}',
                                          reserv_air_total_deposit_price ='{$total_deposit_price}',
                                          reserv_air_adult_number = '{$reserv_air_adult_number}',
                                          reserv_air_child_number = '{$reserv_air_child_number}',
                                          reserv_air_baby_number  = '{$reserv_air_baby_number}'
                where no='{$reserv_air_no}'";
     echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "{$row_price['reserv_air_departure_area']}출발에서  {$row_sch['a_sch_departure_area_name']}출발 항공으로 변경하셨습니다.";
    $content = "{$row_price['reserv_air_departure_area']}출발 -> 제주 {$row_price['reserv_air_departure_airline']}<br> 
                제주 -> {$row_price['reserv_air_arrival_area']}출발 {$row_price['reserv_air_arrival_airline']}<br>
                출발 : {$row_price['reserv_air_departure_date']}   리턴 : {$row_price['reserv_air_arrival_date']} {$row_price['reserv_air_stay']} <br>
                성인할인율 : {$row_price['reserv_air_adult_sale']} 소아할인율 : {$row_price['reserv_air_child_sale']}<br>
                성인입금할인율 : {$row_price['reserv_air_adult_deposit_sale']} 소아입금할인율 : {$row_price['reserv_air_child_deposit_sale']}<br>
                성인: {$row_price['reserv_air_adult_number']} 소아 : {$row_price['reserv_air_child_number']} 유아 : {$row_price['reserv_air_baby_number']}<br>
                총금액  : {$row_price['reserv_air_total_price']} <br>
                변경 ->  {$row_sch['a_sch_departure_area_name']}출발 -> 제주 {$row_sch['a_sch_departure_airline_name']}<br> 
                제주 -> {$row_sch['a_sch_departure_area_name']}출발 {$row_sch['a_sch_arrival_airline_name']}<br>
                출발 : {$a_sch_departure_date}   리턴 : {$a_sch_arrival_date} {$row_sch['a_sch_stay']} <br>
                성인할인율 : {$row_sch['a_sch_adult_sale']} 소아할인율 : {$row_sch['a_sch_child_sale']}<br>
                성인입금할인율 : {$row_sch['a_sch_adult_deposit_sale']} 소아입금할인율 : {$row_sch['a_sch_child_deposit_sale']}<br>
                성인: {$reserv_air_adult_number} 소아 : {$reserv_air_child_number} 유아 : {$reserv_air_baby_number}<br>
                총금액  : $total_price <br> 으로 변경하셨습니다.
                ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="delete"){
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_no = $_REQUEST['reserv_air_no'];

    $sql_price = "select * from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_air_total_price'];

    $sql = "update reservation_air set reserv_del_mark='Y' where no='{$reserv_air_no}'";
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,0,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "{$row_price['reserv_air_departure_area']}출발 항공 을 삭제하셨습니다.";
    $content = "{$row_price['reserv_air_departure_area']}출발 -> 제주 {$row_price['reserv_air_departure_airline']}<br> 
                제주 -> {$row_price['reserv_air_arrival_area']}출발 {$row_price['reserv_air_arrival_airline']}<br>
                출발 : {$row_price['reserv_air_departure_date']}   리턴 : {$row_price['reserv_air_arrival_date']} {$row_price['reserv_air_stay']} <br>
                성인할인율 : {$row_price['reserv_air_adult_sale']} 소아할인율 : {$row_price['reserv_air_child_sale']}<br>
                성인입금할인율 : {$row_price['reserv_air_adult_deposit_sale']} 소아입금할인율 : {$row_price['reserv_air_child_deposit_sale']}<br>
                성인: {$row_price['reserv_air_adult_number']} 소아 : {$row_price['reserv_air_child_number']} 유아 : {$row_price['reserv_air_baby_number']}<br>
                총금액  : {$row_price['reserv_air_total_price']} <br>
                항공을 삭제하셨습니다.
                ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="ledger_update"){
    print_r($_REQUEST);
    $i = $_REQUEST['i'];
    $reserv_air_no = $_REQUEST['reserv_air_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_booking_date = $_REQUEST['reserv_air_booking_date'][$i];
    $reserv_air_booking_number = $_REQUEST['reserv_air_booking_number'][$i];
    $reserv_air_adult_list = $_REQUEST['reserv_air_adult_list'][$i];
    $reserv_air_child_list    = $_REQUEST['reserv_air_child_list'][$i];
    $reserv_air_baby_list   = $_REQUEST['reserv_air_baby_list'][$i];
    $reserv_air_deposit_price     = get_comma($_REQUEST['reserv_air_deposit_price'][$i]);
    $reserv_air_deposit_date    = $_REQUEST['reserv_air_deposit_date'][$i];
    $reserv_air_deposit_state  = $_REQUEST['reserv_air_deposit_state_'.$i];
    $reserv_air_balance_price    = get_comma($_REQUEST['reserv_air_balance_price'][$i]);
    $reserv_air_balance_date   = $_REQUEST['reserv_air_balance_date'][$i];
    $reserv_air_balance_state     = $_REQUEST['reserv_air_balance_state_'.$i];
    $reserv_air_block     = $_REQUEST['air_block_'.$i];
    $reserv_air_wait     = $_REQUEST['air_wait_'.$i];
    $reserv_air_bigo = $_REQUEST['reserv_air_bigo'];
    $reserv_no_air_bigo = $_REQUEST['reserv_no_air_bigo'];

    $sql_price = "select * from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);


    $sql = "update reservation_air set  reserv_air_booking_date = '{$reserv_air_booking_date}',
                                          reserv_air_booking_number = '{$reserv_air_booking_number}',
                                          reserv_air_adult_list = '{$reserv_air_adult_list}',
                                          reserv_air_child_list ='{$reserv_air_child_list}',
                                          reserv_air_baby_list ='{$reserv_air_baby_list}',
                                          reserv_air_deposit_price = '{$reserv_air_deposit_price}',
                                          reserv_air_deposit_date = '{$reserv_air_deposit_date}',
                                          reserv_air_deposit_state = '{$reserv_air_deposit_state}',                          
                                          reserv_air_balance_price = '{$reserv_air_balance_price}',
                                          reserv_air_balance_date = '{$reserv_air_balance_date}',
                                          reserv_air_balance_state = '{$reserv_air_balance_state}',
                                          reserv_air_block = '{$reserv_air_block}',
                                          reserv_air_wait = '{$reserv_air_wait}'
                where no='{$reserv_air_no}'";

    $db->sql_query($sql);
    if($reserv_no_air_bigo == "undefined") {
        $sql_bigo = "update reservation_user_content set reserv_air_bigo='{$reserv_air_bigo}' where no='{$reserv_user_no}' ";
    }else{
        $sql_bigo = "update reservation_user_content set reserv_no_air_bigo='{$reserv_no_air_bigo}' where no='{$reserv_user_no}' ";
    }

    $db->sql_query($sql_bigo);
    if($row_price['reserv_air_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_air_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_air_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_air_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }
    $subject = " 항공 정보를 수정하셨습니다.";
    $content = "발권일 : {$row_price['reserv_air_booking_date']}  -> {$reserv_air_booking_date} 변경 <br>
                 예약번호 :{$row_price['reserv_air_booking_number']} -> {$reserv_air_booking_number} 변경 <br>
                 성인명단 :{$row_price['reserv_air_adult_list']} -> {$reserv_air_adult_list} 변경 <br>
                 소아명단 :{$row_price['reserv_air_child_list']} -> {$reserv_air_child_list} 변경 <br>
                 유아명단 :{$row_price['reserv_air_baby_list']}  -> {$reserv_air_baby_list} 변경 <br>
                 선금 :{$row_price['reserv_air_deposit_price']} -> {$reserv_air_deposit_price} 변경 <br>
                 선금일자 :{$row_price['reserv_air_deposit_date']} -> {$reserv_air_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금{$row_price['reserv_air_balance_price']}  -> {$reserv_air_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_air_balance_date']}  -> {$reserv_air_balance_date} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case=="no_insert"){

    $reserv_air_no = $_REQUEST['reserv_air_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_adult_number = $_REQUEST['adult_number'];
    $reserv_air_child_number = $_REQUEST['child_number'];
    $reserv_air_baby_number = $_REQUEST['baby_number'];
    $start_date    = $_REQUEST['start_date'];
    $start_hour    = $_REQUEST['start_hour'];
    $start_minute  = $_REQUEST['start_minute'];
    $end_date    = $_REQUEST['end_date'];
    $end_hour    = $_REQUEST['end_hour'];
    $end_minute  = $_REQUEST['end_minute'];

    $reserv_air_departure_date = $start_date." ".$start_hour.":".$start_minute;
    $reserv_air_arrival_date   = $end_date." ".$end_hour.":".$end_minute;

    $ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;
    $stay = $ddy."박".($ddy+1)."일";

    $sch_departure_area  = $_REQUEST['sch_departure_area'];
    $sch_end_departure_area  = $_REQUEST['sch_end_departure_area'];
    $sch_start_arrival_area  = $_REQUEST['sch_start_arrival_area'];
    $sch_arrival_area  = $_REQUEST['sch_arrival_area'];
    $start_airline  = $_REQUEST['start_airline'];
    $end_airline  = $_REQUEST['end_airline'];
    $start_company  = $_REQUEST['start_company'];
    $end_company  = $_REQUEST['end_company'];
    $reserv_air_adult_sale  = $_REQUEST['reserv_air_adult_sale'];
    $reserv_air_child_sale  = $_REQUEST['reserv_air_child_sale'];
    $reserv_air_adult_deposit_sale  = $_REQUEST['reserv_air_adult_deposit_sale'];
    $reserv_air_child_deposit_sale  = $_REQUEST['reserv_air_child_deposit_sale'];
    $reserv_normal_adult_price  = get_comma($_REQUEST['reserv_normal_adult_price']);
    $reserv_normal_child_price  = get_comma($_REQUEST['reserv_normal_child_price']);
    $reserv_total_price  = get_comma($_REQUEST['reserv_total_price']);
    $reserv_air_total_deposit_price  = get_comma($_REQUEST['reserv_total_deposit_price']);


    $sql = "insert into reservation_air(reserv_user_no,
                                          reserv_air_departure_area,
                                          reserv_air_end_departure_area,
                                          reserv_air_start_arrival_area,
                                          reserv_air_arrival_area,
                                          reserv_air_departure_airline,
                                          reserv_air_arrival_airline,
                                          reserv_air_departure_company,
                                          reserv_air_arrival_company,
                                          reserv_air_departure_date,
                                          reserv_air_arrival_date,                          
                                          reserv_air_stay,
                                          reserv_air_adult_normal_price,
                                          reserv_air_child_normal_price,
                                          reserv_air_adult_sale,                     
                                          reserv_air_child_sale,
                                          reserv_air_adult_deposit_sale,
                                          reserv_air_child_deposit_sale,
                                          reserv_air_total_price,
                                          reserv_air_total_deposit_price,
                                          reserv_air_adult_number,
                                          reserv_air_child_number,
                                          reserv_air_baby_number,
                                          reserv_air_type
                                        )
                                        VALUES 
                                        ('{$reserv_user_no}',
                                         '{$sch_departure_area}',
                                         '{$sch_end_departure_area}',
                                         '{$sch_start_arrival_area}',
                                         '{$sch_arrival_area}',
                                         '{$start_airline}',
                                         '{$end_airline}',
                                         '{$start_company}',
                                         '{$end_company}',
                                         '{$reserv_air_departure_date}',
                                         '{$reserv_air_arrival_date}',
                                         '{$stay}',
                                         '{$reserv_normal_adult_price}',
                                         '{$reserv_normal_child_price}',
                                         '{$reserv_air_adult_sale}',
                                         '{$reserv_air_child_sale}',
                                         '{$reserv_air_adult_deposit_sale}',
                                         '{$reserv_air_child_deposit_sale}',
                                         '{$reserv_total_price}',
                                         '{$reserv_air_total_deposit_price}',
                                         '{$reserv_air_adult_number}',
                                         '{$reserv_air_child_number}',
                                         '{$reserv_air_baby_number}',
                                         'N'
                                        )";
    //  echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_total_price,0);
    $res->start_date_change($reserv_user_no);

    $subject = "일반항공을 추가하셨습니다.";
    $content = "출발지역 : {$sch_departure_area}  <br>
                 리턴지역 :{$sch_arrival_area}  <br>
                 출발항공사 :{$start_airline}  <br>
                 리턴항공사 :{$end_airline}  <br>
                 출발에이전시 :{$start_company}   <br>
                 리턴에이전시 :{$end_company}  <br>
                 출발일자 :{$reserv_air_departure_date} <br>
                 리턴일자 :{$reserv_air_arrival_date}  <br>
                 성인판매할인율 : {$reserv_air_adult_sale}   <br>
                 소아판매할인율 : {$reserv_air_child_sale}  <br>
                 성인입금할인율 : {$reserv_air_adult_deposit_sale}   <br>
                 소아입금할인율 : {$reserv_air_child_deposit_sale}  <br>
                 총요금 : {$reserv_total_price}  <br>
                 총입금요금 : {$reserv_air_total_deposit_price}   <br>
                 성인인원 : {$reserv_air_adult_number}   <br>
                 소아인원 : {$reserv_air_child_number}   <br>
                 유아인원 : {$reserv_air_baby_number} <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}else if($case == "no_update"){
    $reserv_air_no = $_REQUEST['reserv_air_no'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_adult_number = $_REQUEST['adult_number'];
    $reserv_air_child_number = $_REQUEST['child_number'];
    $reserv_air_baby_number = $_REQUEST['baby_number'];
    $start_date    = $_REQUEST['start_date'];
    $start_hour    = $_REQUEST['start_hour'];
    $start_minute  = $_REQUEST['start_minute'];
    $end_date    = $_REQUEST['end_date'];
    $end_hour    = $_REQUEST['end_hour'];
    $end_minute  = $_REQUEST['end_minute'];



    $sql_price = "select * from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);

    $reserv_air_departure_date = $start_date." ".$start_hour.":".$start_minute;
    $reserv_air_arrival_date   = $end_date." ".$end_hour.":".$end_minute;

    $ddy = ( strtotime($end_date) - strtotime($start_date) ) / 86400;
    $stay = $ddy."박".($ddy+1)."일";

    $sch_departure_area  = $_REQUEST['sch_departure_area'];
    $sch_end_departure_area  = $_REQUEST['sch_end_departure_area'];
    $sch_start_arrival_area  = $_REQUEST['sch_start_arrival_area'];
    $sch_arrival_area  = $_REQUEST['sch_arrival_area'];
    $start_airline  = $_REQUEST['start_airline'];
    $end_airline  = $_REQUEST['end_airline'];
    $start_company  = $_REQUEST['start_company'];
    $end_company  = $_REQUEST['end_company'];
    $reserv_air_adult_sale  = $_REQUEST['reserv_air_adult_sale'];
    $reserv_air_child_sale  = $_REQUEST['reserv_air_child_sale'];
    $reserv_air_adult_deposit_sale  = $_REQUEST['reserv_air_adult_deposit_sale'];
    $reserv_air_child_deposit_sale  = $_REQUEST['reserv_air_child_deposit_sale'];
    $reserv_air_adult_normal_price  = $_REQUEST['reserv_normal_adult_price'];
    $reserv_air_child_normal_price  = $_REQUEST['reserv_normal_child_price'];
    $reserv_total_price  = get_comma($_REQUEST['reserv_total_price']);
    $reserv_air_total_deposit_price  = get_comma($_REQUEST['reserv_total_deposit_price']);


    $sql = "update reservation_air set  reserv_air_departure_area = '{$sch_departure_area}',
                                          reserv_air_end_departure_area = '{$sch_end_departure_area}',
                                          reserv_air_start_arrival_area = '{$sch_start_arrival_area}',
                                          reserv_air_arrival_area = '{$sch_arrival_area}',
                                          reserv_air_departure_airline = '{$start_airline}',
                                          reserv_air_arrival_airline = '{$end_airline}',
                                          reserv_air_departure_company = '{$start_company}',
                                          reserv_air_arrival_company = '{$end_company}',
                                          reserv_air_departure_date = '{$reserv_air_departure_date}',
                                          reserv_air_arrival_date = '{$reserv_air_arrival_date}',                          
                                          reserv_air_stay = '{$stay}',
                                          reserv_air_adult_sale = '{$reserv_air_adult_sale}',                     
                                          reserv_air_child_sale = '{$reserv_air_child_sale}',
                                          reserv_air_adult_deposit_sale = '{$reserv_air_adult_deposit_sale}',
                                          reserv_air_child_deposit_sale = '{$reserv_air_child_deposit_sale}',
                                          reserv_air_adult_normal_price ='{$reserv_air_adult_normal_price}',
                                          reserv_air_child_normal_price ='{$reserv_air_child_normal_price}',
                                          reserv_air_total_price = '{$reserv_total_price}',
                                          reserv_air_total_deposit_price = '{$reserv_air_total_deposit_price}',
                                          reserv_air_adult_number = '{$reserv_air_adult_number}',
                                          reserv_air_child_number = '{$reserv_air_child_number}',
                                          reserv_air_baby_number = '{$reserv_air_baby_number}'
              where no='{$reserv_air_no}'";
    echo $sql;
    $db->sql_query($sql);
    $res->reserv_price_change($reserv_user_no,$reserv_total_price,$row_price['reserv_air_total_price']);
    $res->start_date_change($reserv_user_no);

    $subject = "일반항공내용을 변경하셨습니다.";
    $content = "출발지역 : {$row_price['reserv_air_departure_area']}  -> {$sch_departure_area} 변경 <br>
                 리턴지역 :{$row_price['reserv_air_arrival_area']} -> {$sch_arrival_area} 변경 <br>
                 출발항공사 :{$row_price['reserv_air_departure_airline']} -> {$start_airline} 변경 <br>
                 리턴항공사 :{$row_price['reserv_air_arrival_airline']} -> {$end_airline} 변경 <br>
                 출발에이전시 :{$row_price['reserv_air_departure_company']}  -> {$start_company} 변경 <br>
                 리턴에이전시 :{$row_price['reserv_air_arrival_company']} -> {$end_company} 변경 <br>
                 출발일자 :{$row_price['reserv_air_departure_date']} -> {$reserv_air_departure_date} 변경 <br>
                 리턴일자 :{$row_price['reserv_air_departure_date']}  -> {$reserv_air_arrival_date} 변경 <br>
                 성인판매할인율 : {$row_price['reserv_air_adult_sale']}  -> {$reserv_air_adult_sale} 변경 <br>
                 소아판매할인율 : {$row_price['reserv_air_child_sale']}  -> {$reserv_air_child_sale} 변경 <br>
                 성인입금할인율 : {$row_price['reserv_air_adult_deposit_sale']}  -> {$reserv_air_adult_deposit_sale} 변경 <br>
                 소아입금할인율 : {$row_price['reserv_air_child_deposit_sale']}  -> {$reserv_air_child_deposit_sale} 변경 <br>
                 총요금 : {$row_price['reserv_air_total_price']}  -> {$reserv_total_price} 변경 <br>
                 총입금요금 : {$row_price['reserv_air_total_deposit_price']}  -> {$reserv_air_total_deposit_price} 변경 <br>
                 성인인원 : {$row_price['reserv_air_adult_number']}  -> {$reserv_air_adult_number} 변경 <br>
                 소아인원 : {$row_price['reserv_air_child_number']}  -> {$reserv_air_child_number} 변경 <br>
                 유아인원 : {$row_price['reserv_air_baby_number']}  -> {$reserv_air_baby_number} 변경 
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);


}else if($case=="no_delete"){
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_air_no = $_REQUEST['reserv_air_no'];

    $sql_price = "select *  from  reservation_air where no='{$reserv_air_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_air_total_price'];

    $sql = "update reservation_air set reserv_del_mark='Y' where no='{$reserv_air_no}'";
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,0,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "일반항공 을 삭제하셨습니다.";
    $content = "{$row_price['reserv_air_departure_area']}출발 -> 제주 {$row_price['reserv_air_departure_airline']}<br> 
                제주 -> {$row_price['reserv_air_arrival_area']}출발 {$row_price['reserv_air_arrival_airline']}<br>
                출발 : {$row_price['reserv_air_departure_date']}   리턴 : {$row_price['reserv_air_arrival_date']} {$row_price['reserv_air_stay']} <br>
                성인할인율 : {$row_price['reserv_air_adult_sale']} 소아할인율 : {$row_price['reserv_air_child_sale']}<br>
                성인입금할인율 : {$row_price['reserv_air_adult_deposit_sale']} 소아입금할인율 : {$row_price['reserv_air_child_deposit_sale']}<br>
                성인: {$row_price['reserv_air_adult_number']} 소아 : {$row_price['reserv_air_child_number']} 유아 : {$row_price['reserv_air_baby_number']}<br>
                총금액  : {$row_price['reserv_air_total_price']} <br>
                항공을 삭제하셨습니다.
                ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);

}

?>