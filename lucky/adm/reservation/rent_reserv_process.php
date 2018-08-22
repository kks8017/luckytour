<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="insert"){

    $no = $_REQUEST['no'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $rent_vehicle = $_REQUEST['rent_vehicle'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $rent_option = $_REQUEST['rent_option'];
    $rent_com_no = $_REQUEST['rent_com_no'];
    $reserv_type = $_REQUEST['reserv_type'];

    $rent = new rent();

    $sql_car = "select no,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel  from rent_car_detail where   no='{$no}'";
    $rs_car  = $db->sql_query($sql_car);
    $row_car = $db->fetch_array($rs_car);

    $rent->carno = $no;
    $rent->start_date =$start_date;
    $rent->end_date = $end_date;
    $rent->comno = $rent_com_no;
    $use_time = $rent->rent_time();
    $rent_com_name = $rent->company_name();
    //0판매가,1에어카가,2에어카텔가,3입금가,4판매할인율,5에어카할인율,6에어카텔할인율,7입금할인율
    $rent_deposit_price = $rent->rent_price_main();
   // echo $rent_deposit_price[3]."<br>";
    $rent->carno = $no;
    $rent->start_date =$start_date;
    $rent->end_date = $end_date;
    $rent->comno = $row_car['rent_com_no'];

    $rent_price = $rent->rent_price_main();
    $rent_fuel = $rent->rent_code_name($row_car['rent_car_fuel']);
    $rent_type = $rent->rent_code_name($row_car['rent_car_type']);

    echo $rent_price[3]."<br>";




    if(strlen($reserv_type)  == 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[1] * $rent_vehicle;
        $sale_car = $rent_price[5];
    }else if(strlen($reserv_type) > 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
        $sale_car = $rent_price[6];
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
        $sale_car = $rent_price[4];
    }
    $sale_car_price_deposit = $rent_price[3] * $rent_vehicle;
    $sale_car_deposit = $rent_deposit_price[7];

    $sql = "insert into reservation_rent(reserv_user_no,
                                           reserv_rent_com_no,
                                           reserv_rent_com_name,
                                           reserv_rent_carno,
                                           reserv_rent_car_name,
                                           reserv_rent_car_fuel,
                                           reserv_rent_car_type,
                                           reserv_rent_start_date,
                                           reserv_rent_end_date,
                                           reserv_rent_time,
                                           reserv_rent_vehicle,
                                           reserv_rent_sale,
                                           reserv_rent_deposit_sale,
                                           reserv_rent_total_price,
                                           reserv_rent_total_deposit_price,
                                           reserv_rent_option
                                           ) values(
                                           '{$reserv_user_no}',
                                           '{$rent_com_no}',
                                           '{$rent_com_name}',
                                           '{$no}',
                                           '{$row_car['rent_car_name']}',
                                           '{$row_car['rent_car_fuel']}',
                                           '{$row_car['rent_car_type']}',
                                           '{$start_date}',
                                           '{$end_date}',
                                           '{$use_time[0]}',
                                           '{$rent_vehicle}',
                                           '{$sale_car}',
                                           '{$sale_car_deposit}',
                                           '{$sale_car_price}',
                                           '{$sale_car_price_deposit}',
                                           '{$rent_option}'
                                           )";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$sale_car_price,0);
    $res->start_date_change($reserv_user_no);

    $subject = "렌트카을 추가하셨습니다.";
    $content = "차랑명 : {$row_car['rent_car_name']}  <br>
                 연료 :{$rent_fuel}  <br>
                 차량타입 :{$rent_type}  <br>
                 출고일자 :{$start_date}  <br>
                 입고일자 :{$end_date}   <br>
                 사용시간 :{$use_time[0]} <br>
                 사용대수 :{$rent_vehicle}  <br>
                 판매할인율 : {$sale_car}   <br>
                 입금할인율 : {$sale_car_deposit}  <br>
                 판매가 : {$sale_car_price}   <br>
                 입금가 : {$sale_car_price_deposit}  <br>
                 부가서비스 : {$rent_option} <br>
                 추가하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="update"){

    $no = $_REQUEST['reserv_rent_no'];
    $start_date = $_REQUEST['start_date']." ".$_REQUEST['start_hour'].":".$_REQUEST['start_minute'];
    $end_date = $_REQUEST['end_date']." ".$_REQUEST['end_hour'].":".$_REQUEST['end_minute'];

    $reserv_rent_car_name = $_REQUEST['reserv_rent_car_name'];
    $rent_vehicle = $_REQUEST['reserv_rent_vehicle'];
    $reserv_type = $_REQUEST['reserv_type'];
    $reserv_fuel = $_REQUEST['reserv_fuel'];
    $reserv_rent_time = $_REQUEST['reserv_rent_time'];
    $reserv_rent_sale = $_REQUEST['reserv_rent_sale'];
    $reserv_rent_deposit_sale = $_REQUEST['reserv_rent_deposit_sale'];
    $reserv_rent_total_price = get_comma($_REQUEST['reserv_rent_total_price']);
    $reserv_rent_total_deposit_price = get_comma($_REQUEST['reserv_rent_total_deposit_price']);
    $reserv_rent_departure_place = $_REQUEST['reserv_rent_departure_place'];
    $reserv_rent_arrival_place = $_REQUEST['reserv_rent_arrival_place'];
    $reserv_rent_option = $_REQUEST['reserv_option'];
    $reserv_rent_option  = implode(",",$reserv_rent_option);
    $reserv_user_no = $_REQUEST['reserv_user_no'];

    $rent->comno = $_REQUEST['company_list'];
    $rent_com_no = $_REQUEST['company_list'];
    $rent_com_name = $rent->company_name();

    $sql_price = "select * from  reservation_rent where no='{$no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_rent_total_price'];

    $sql ="update reservation_rent set 
            reserv_rent_car_name ='{$reserv_rent_car_name}',
            reserv_rent_com_no = '{$rent_com_no}',
            reserv_rent_com_name = '{$rent_com_name}',
            reserv_rent_car_fuel ='{$reserv_fuel}',
            reserv_rent_car_type ='{$reserv_type}',
            reserv_rent_start_date ='{$start_date}',
            reserv_rent_end_date ='{$end_date}',
            reserv_rent_time ='{$reserv_rent_time}',
            reserv_rent_vehicle ='{$rent_vehicle}',
            reserv_rent_sale ='{$reserv_rent_sale}',
            reserv_rent_deposit_sale ='{$reserv_rent_deposit_sale}',
            reserv_rent_option ='{$reserv_rent_option}',
            reserv_rent_departure_place ='{$reserv_rent_departure_place}',
            reserv_rent_arrival_place ='{$reserv_rent_arrival_place}',
            reserv_rent_total_price ='{$reserv_rent_total_price}',
            reserv_rent_total_deposit_price ='{$reserv_rent_total_deposit_price}'
          where no='{$no}'   
          ";

    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$reserv_rent_total_price,$old_total_price);
    $res->start_date_change($reserv_user_no);
    $subject = "렌트카을 변경하셨습니다.";
    $content = "차랑명 : {$row_price['reserv_rent_car_name']} ->  {$reserv_rent_car_name} <br>
                 업체 :{$row_price['reserv_rent_com_name']} ->  {$rent_com_name} <br>
                 연료 :{$row_price['reserv_rent_car_fuel']} ->  {$reserv_fuel} <br>
                 차량타입 :{$row_price['reserv_rent_car_type']} ->  {$reserv_type} <br>
                 출고일자 :{$row_price['reserv_rent_start_date']} ->  {$start_date} <br>
                 입고일자 :{$row_price['reserv_rent_end_date']}  ->  {$end_date} <br>
                 사용시간 :{$row_price['reserv_rent_time']}  ->  {$reserv_rent_time} <br>
                 사용대수 :{$row_price['reserv_rent_vehicle']} ->  {$rent_vehicle}  <br>
                 판매할인율 : {$row_price['reserv_rent_sale']} ->  {$reserv_rent_sale}   <br>
                 입금할인율 : {$row_price['reserv_rent_deposit_sale']} ->  {$reserv_rent_deposit_sale} <br>
                 판매가 : {$row_price['reserv_rent_total_price']} ->  {$reserv_rent_total_price}   <br>
                 입금가 : {$row_price['reserv_rent_total_deposit_price']} ->  {$reserv_rent_total_deposit_price}  <br>
                 부가서비스 : {$row_price['reserv_rent_option']} ->  {$reserv_rent_option} <br>
                 출고장소 : {$row_price['reserv_rent_departure_place']} ->  {$reserv_rent_departure_place} <br>
                 입고장소 : {$row_price['reserv_rent_arrival_place']} ->  {$reserv_rent_arrival_place} <br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="delete") {
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_rent_no = $_REQUEST['reserv_rent_no'];

    $sql_price = "select * from  reservation_rent where no='{$reserv_rent_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price = $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_rent_total_price'];

    $sql = "update reservation_rent set reserv_del_mark='Y' where no='{$reserv_rent_no}'";
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no, 0, $old_total_price);
    $res->start_date_change($reserv_user_no);
    $subject = "렌트카을 삭제 되었습니다.";
    $content = "차랑명 : {$row_price['reserv_rent_car_name']}  <br>
                 업체 :{$row_price['reserv_rent_com_name']}  <br>
                 연료 :{$row_price['reserv_rent_car_fuel']}  <br>
                 차량타입 :{$row_price['reserv_rent_car_type']}  <br>
                 출고일자 :{$row_price['reserv_rent_start_date']}  <br>
                 입고일자 :{$row_price['reserv_rent_end_date']}   <br>
                 사용시간 :{$row_price['reserv_rent_time']}   <br>
                 사용대수 :{$row_price['reserv_rent_vehicle']}   <br>
                 판매할인율 : {$row_price['reserv_rent_sale']}    <br>
                 입금할인율 : {$row_price['reserv_rent_deposit_sale']}  <br>
                 판매가 : {$row_price['reserv_rent_total_price']}    <br>
                 입금가 : {$row_price['reserv_rent_total_deposit_price']}   <br>
                 부가서비스 : {$row_price['reserv_rent_option']}  <br>
                 출고장소 : {$row_price['reserv_rent_departure_place']}  <br>
                 입고장소 : {$row_price['reserv_rent_arrival_place']}  <br>
                 삭제하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="sch_update"){
    $no = $_REQUEST['no'];
    $reserv_rent_no = $_REQUEST['reserv_rent_no'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $rent_vehicle = $_REQUEST['rent_vehicle'];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $rent_option = $_REQUEST['rent_option'];
    $rent_com_no = $_REQUEST['rent_com_no'];
    $reserv_type = $_REQUEST['reserv_type'];

    $rent = new rent();

    $sql_car = "select no,rent_com_no,rent_car_name,rent_car_type,rent_car_fuel  from rent_car_detail where   no='{$no}'";
    $rs_car  = $db->sql_query($sql_car);
    $row_car = $db->fetch_array($rs_car);

    $rent->carno = $no;
    $rent->start_date =$start_date;
    $rent->end_date = $end_date;
    $rent->comno = $rent_com_no;
    $use_time = $rent->rent_time();
    $rent_com_name = $rent->company_name();
    //0판매가,1에어카가,2에어카텔가,3입금가,4판매할인율,5에어카할인율,6에어카텔할인율,7입금할인율
    $rent_deposit_price = $rent->rent_price_main();
     echo $rent_deposit_price[3]."<br>";
    $rent->carno = $no;
    $rent->start_date =$start_date;
    $rent->end_date = $end_date;
    $rent->comno = $row_car['rent_com_no'];

    $rent_price = $rent->rent_price_main();
    $rent_fuel = $rent->rent_code_name($row_car['rent_car_fuel']);
    $rent_type = $rent->rent_code_name($row_car['rent_car_type']);

    //echo $rent_price[3]."<br>";




    if(strlen($reserv_type)  == 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[1] * $rent_vehicle;
        $sale_car = $rent_price[5];
    }else if(strlen($reserv_type) > 1 and $reserv_type !="C" ){
        $sale_car_price = $rent_price[2] * $rent_vehicle;
        $sale_car = $rent_price[6];
    }else{
        $sale_car_price = $rent_price[0] * $rent_vehicle;
        $sale_car = $rent_price[4];
    }
    $sale_car_price_deposit = $rent_deposit_price[3] * $rent_vehicle;
  //  echo $sale_car_price_deposit;
    $sale_car_deposit = $rent_deposit_price[7];

    $sql_price = "select * from  reservation_rent where no='{$reserv_rent_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_rent_total_price'];

    $sql = "update  reservation_rent set reserv_rent_com_no= '{$rent_com_no}',
                                           reserv_rent_com_name = '{$rent_com_name}',
                                           reserv_rent_carno = '{$no}',
                                           reserv_rent_car_name = '{$row_car['rent_car_name']}',
                                           reserv_rent_car_fuel = '{$row_car['rent_car_fuel']}',
                                           reserv_rent_car_type = '{$row_car['rent_car_type']}',
                                           reserv_rent_start_date = '{$start_date}',
                                           reserv_rent_end_date ='{$end_date}',
                                           reserv_rent_time = '{$use_time[0]}',
                                           reserv_rent_vehicle = '{$rent_vehicle}',
                                           reserv_rent_sale = '{$sale_car}',
                                           reserv_rent_deposit_sale = '{$sale_car_deposit}' ,
                                           reserv_rent_total_price = '{$sale_car_price}',
                                           reserv_rent_total_deposit_price = '{$sale_car_price_deposit}',
                                           reserv_rent_departure_place ='지점',
                                           reserv_rent_arrival_place ='지점',
                                           reserv_rent_option = '{$rent_option}'
             where no='{$reserv_rent_no}'                              ";
    echo $sql;
    $db->sql_query($sql);
    $res->reserv_type_change($reserv_user_no);
    $res->reserv_price_change($reserv_user_no,$sale_car_price,$old_total_price);
    $res->start_date_change($reserv_user_no);

    $subject = "렌트카을 변경하셨습니다.";
    $content = "차랑명 : {$row_price['reserv_rent_car_name']} ->  {$row_car['rent_car_name']} <br>
                 업체 :{$row_price['reserv_rent_com_name']} ->  {$rent_com_name} <br>
                 연료 :{$row_price['reserv_rent_car_fuel']} ->  {$rent_fuel} <br>
                 차량타입 :{$row_price['reserv_rent_car_type']} ->  {$rent_type} <br>
                 출고일자 :{$row_price['reserv_rent_start_date']} ->  {$start_date} <br>
                 입고일자 :{$row_price['reserv_rent_end_date']}  ->  {$end_date} <br>
                 사용시간 :{$row_price['reserv_rent_time']}  ->  {$use_time[0]} <br>
                 사용대수 :{$row_price['reserv_rent_vehicle']} ->  {$rent_vehicle}  <br>
                 판매할인율 : {$row_price['reserv_rent_sale']} ->  {$sale_car}   <br>
                 입금할인율 : {$row_price['reserv_rent_deposit_sale']} ->  {$sale_car_deposit} <br>
                 판매가 : {$row_price['reserv_rent_total_price']} ->  {$sale_car_price}   <br>
                 입금가 : {$row_price['reserv_rent_total_deposit_price']} ->  {$sale_car_price_deposit}  <br>
                 부가서비스 : {$row_price['reserv_rent_option']} ->  {$reserv_rent_option} <br>
                 출고장소 : {$row_price['reserv_rent_departure_place']} -> 지점 <br>
                 입고장소 : {$row_price['reserv_rent_arrival_place']} -> 지점<br>
                 변경하셨습니다.
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}else if($case=="ledger_update") {
    print_r($_REQUEST);
    $i = $_REQUEST['i'];
    $reserv_rent_no = $_REQUEST['reserv_rent_no'][$i];
    $reserv_user_no = $_REQUEST['reserv_user_no'];
    $reserv_rent_reconfirm_date = $_REQUEST['reserv_rent_reconfirm_date'][$i];
    $reserv_rent_reconfirm_name = $_REQUEST['reserv_rent_reconfirm_name'][$i];
    $reserv_rent_reconfirm_state = $_REQUEST['reserv_rent_reconfirm_state_'.$i];

    $reserv_rent_deposit_price = get_comma($_REQUEST['reserv_rent_deposit_price'][$i]);
    $reserv_rent_deposit_date = $_REQUEST['reserv_rent_deposit_date'][$i];
    $reserv_rent_deposit_state = $_REQUEST['reserv_rent_deposit_state_'.$i];
    $reserv_rent_balance_price = get_comma($_REQUEST['reserv_rent_balance_price'][$i]);
    $reserv_rent_balance_date = $_REQUEST['reserv_rent_balance_date'][$i];
    $reserv_rent_balance_state = $_REQUEST['reserv_rent_balance_state_'.$i];
    $reserv_rent_block     = $_REQUEST['rent_block'][$i];
    $reserv_rent_wait      = $_REQUEST['rent_wait'][$i];
    $reserv_rent_bigo      = $_REQUEST['reserv_rent_bigo'];

    $sql_price = "select * from  reservation_rent where no='{$reserv_rent_no}'";
    $rs_price = $db->sql_query($sql_price);
    $row_price =  $db->fetch_array($rs_price);
    $old_total_price = $row_price['reserv_rent_total_price'];


    $sql = "update reservation_rent set  reserv_rent_reconfirm_date = '{$reserv_rent_reconfirm_date}',
                                          reserv_rent_reconfirm_name = '{$reserv_rent_reconfirm_name}',
                                          reserv_rent_reconfirm_state = '{$reserv_rent_reconfirm_state}',
                                          reserv_rent_deposit_price ='{$reserv_rent_deposit_price}',
                                          reserv_rent_deposit_date ='{$reserv_rent_deposit_date}',
                                          reserv_rent_deposit_state = '{$reserv_rent_deposit_state}',
                                          reserv_rent_balance_price = '{$reserv_rent_balance_price}',
                                          reserv_rent_balance_date = '{$reserv_rent_balance_date}',
                                          reserv_rent_balance_state = '{$reserv_rent_balance_state}',                          
                                          reserv_rent_block = '{$reserv_rent_block}',
                                          reserv_rent_wait = '{$reserv_rent_wait}'
                where no='{$reserv_rent_no}'";
    echo $sql;
    $db->sql_query($sql);
    $sql_bigo = "update reservation_user_content set reserv_rent_bigo='{$reserv_rent_bigo}' where no='{$reserv_user_no}' ";

    $db->sql_query($sql_bigo);

    if($row_price['reserv_rent_deposit_state']=="Y"){
        $deposit_state_old = "입금";
    }else{
        $deposit_state_old = "미입금";
    }
    if($reserv_rent_deposit_state=="Y"){
        $deposit_state = "입금";
    }else{
        $deposit_state = "미입금";
    }
    if($row_price['reserv_rent_balance_state']=="Y"){
        $balance_state_old = "입금";
    }else{
        $balance_state_old = "미입금";
    }
    if($reserv_rent_balance_state=="Y"){
        $balance_state = "입금";
    }else{
        $balance_state = "미입금";
    }

    $subject = "렌트카정보를 변경하셨습니다.";
    $content = "재확인날짜 : {$row_price['reserv_rent_reconfirm_date']}  -> {$reserv_rent_reconfirm_date} 변경 <br>
                 담당자 :{$row_price['reserv_rent_reconfirm_name']} -> {$reserv_rent_reconfirm_name} 변경 <br>
                 재확인상태 :{$row_price['reserv_rent_reconfirm_state']} -> {$reserv_rent_reconfirm_state} 변경 <br>
                 선금 :{$row_price['reserv_rent_deposit_price']} -> {$reserv_rent_deposit_price} 변경 <br>
                 선금일짜 :{$row_price['reserv_rent_deposit_date']}  -> {$reserv_rent_deposit_date} 변경 <br>
                 선금상태 :{$deposit_state_old}  -> {$deposit_state} 변경 <br>
                 잔금{$row_price['reserv_rent_balance_price']}  -> {$reserv_rent_balance_price} 변경 <br>
                 잔금일자 :{$row_price['reserv_rent_balance_date']}  -> {$reserv_rent_balance_date} 변경 <br>
                 잔금상태 :{$balance_state_old} -> {$balance_state_old} 변경 <br>
               ";
    $res->reserv_content($reserv_user_no,$subject,$content,$_SESSION["member_name"]);
}
?>