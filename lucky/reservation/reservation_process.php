<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$air  = new air();
$rent = new rent();
$tel  = new lodging();
$bus  = new bus();
$bustour = new bustour();
$golf = new golf();
$main = new main();


$ip = $main->user_ip();
$incom = "PC";
$indate = date("Y-m-d H:i");
$SQL = "insert into reservation_user_content(user_id,
                                                      reserv_name,
                                                      reserv_phone,
                                                      reserv_email,
                                                      reserv_real_name,
                                                      reserv_real_phone,
                                                      reserv_group_id,
                                                      reserv_tour_start_date,
                                                      reserv_tour_end_date,
                                                      reserv_adult_number,
                                                      reserv_child_number,
                                                      reserv_baby_number,
                                                      reserv_adult_list,
                                                      reserv_child_list,
                                                      reserv_baby_list,
                                                      reserv_inquiry,
                                                      reserv_real_inquiry,
                                                      reserv_ip,
                                                      reserv_type,
                                                      reserv_state,
                                                      reserv_incom_type,
                                                      indate
                                                      ) VALUES 
                                                      (
                                                      '{$_SESSION['user_id']}',
                                                      '{$_POST['name']}',
                                                      '{$_POST['phone']}',
                                                      '{$_POST['email']}',
                                                      '{$_POST['real_name']}',
                                                      '{$_POST['real_phone']}',
                                                      '',
                                                      '{$_POST['start_date']}',
                                                      '{$_POST['end_date']}',
                                                      '{$_POST['adult_number']}',
                                                      '{$_POST['child_number']}',
                                                      '{$_POST['baby_number']}',
                                                      '{$_POST['adult_name']}',
                                                      '{$_POST['child_name']}',
                                                      '{$_POST['baby_name']}',
                                                      '{$_POST['reserv_inquiry']}',
                                                      '{$_POST['reserv_real_inquiry']}',
                                                      '{$ip}',
                                                      '{$_POST['package']}',
                                                      'WT',
                                                      '{$incom}',
                                                      '{$indate}'
                                                      )
                                                      ";

$rs = $db->sql_query($SQL);
$reserv_no = $db->insert_id();
$SQL_basic = "insert into reservation_user_content_basic(user_id,
                                                      reserv_user_no,
                                                      reserv_name,
                                                      reserv_phone,
                                                      reserv_email,
                                                      reserv_real_name,
                                                      reserv_real_phone,
                                                      reserv_group_id,
                                                      reserv_tour_start_date,
                                                      reserv_tour_end_date,
                                                      reserv_adult_number,
                                                      reserv_child_number,
                                                      reserv_baby_number,
                                                      reserv_adult_list,
                                                      reserv_child_list,
                                                      reserv_baby_list,
                                                      reserv_inquiry,
                                                      reserv_real_inquiry,
                                                      reserv_ip,
                                                      reserv_type,
                                                      reserv_state,
                                                      reserv_incom_type,
                                                      indate
                                                      ) VALUES 
                                                      (
                                                      '{$_SESSION['user_id']}',
                                                      '{$reserv_no}',
                                                      '{$_POST['name']}',
                                                      '{$_POST['phone']}',
                                                      '{$_POST['email']}',
                                                      '{$_POST['real_name']}',
                                                      '{$_POST['real_phone']}',
                                                      '',
                                                      '{$_POST['start_date']}',
                                                      '{$_POST['end_date']}',
                                                      '{$_POST['adult_number']}',
                                                      '{$_POST['child_number']}',
                                                      '{$_POST['baby_number']}',
                                                      '{$_POST['adult_name']}',
                                                      '{$_POST['child_name']}',
                                                      '{$_POST['baby_name']}',
                                                      '{$_POST['reserv_inquiry']}',
                                                      '{$_POST['reserv_real_inquiry']}',
                                                      '{$ip}',
                                                      '{$_POST['package']}',
                                                      'WT',
                                                      '{$incom}',
                                                      '{$indate}'
                                                      )
                                                      ";
$db->sql_query($SQL_basic);
if(strpos($_POST["package"],"A")!== false){
    $air->air_no = $_POST['air_company_no'];
    $air_list = $air->air_selected();


    $air_oil = get_oil($air_list['a_sch_departure_date']);

    if($air_list['a_sch_adult_sale']==0){
        $air_com = get_comm($air_list['a_sch_departure_date']);
    }else{
        $air_com = 0;
    }
    $start_date = $air_list['a_sch_departure_date']." ".$air_list['a_sch_departure_time'];
    $return_date = $air_list['a_sch_arrival_date']." ".$air_list['a_sch_arrival_time'];

    $a_sch_normal_price = ($air_list['a_sch_adult_normal_price']  ) ;

    $a_sch_adult_sale_price = ($air_list['a_sch_adult_sale_price'] + $air_oil +$air_com) * $_POST['adult_number'];
    $a_sch_child_sale_price = ($air_list['a_sch_child_sale_price'] + $air_oil +$air_com) * $_POST['child_number'];
    $a_sch_adult_deposit_price = ($air_list['a_sch_adult_deposit_price'] + $air_oil +$air_com) * $_POST['adult_number'];
    $a_sch_child_deposit_price = ($air_list['a_sch_child_deposit_price'] + $air_oil +$air_com) * $_POST['child_number'];

    $total_air_price = $a_sch_adult_sale_price + $a_sch_child_sale_price;
    $total_air_deposit_price = $a_sch_adult_deposit_price + $a_sch_child_deposit_price;

    $air_sql = "insert into reservation_air(reserv_user_no,
                                              reserv_air_airno,
                                              reserv_air_company_no,
                                              reserv_air_departure_area,
                                              reserv_air_end_departure_area,
                                              reserv_air_arrival_area,
                                              reserv_air_start_arrival_area,
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
                                              reserv_air_normal_total_price,
                                              reserv_air_total_deposit_price,
                                              reserv_air_adult_number,
                                              reserv_air_child_number,
                                              reserv_air_baby_number,
                                              reserv_air_adult_list,
                                              reserv_air_child_list,
                                              reserv_air_baby_list,
                                              reserv_air_type,
                                              indate
                                              )VALUES (
                                              '{$reserv_no}',
                                              '{$_POST['air_no']}',
                                              '{$_POST['air_company_no']}',
                                              '{$air_list['a_sch_departure_area_name']}',
                                              '제주',
                                              '{$air_list['a_sch_arrival_area_name']}',
                                              '제주',
                                              '{$air_list['a_sch_departure_airline_name']}',
                                              '{$air_list['a_sch_arrival_airline_name']}',
                                              '{$air_list['a_sch_company']}',
                                              '{$air_list['a_sch_company']}',
                                              '{$start_date}',
                                              '{$return_date}',
                                              '{$air_list['a_sch_stay']}',
                                              '{$air_list['a_sch_adult_normal_price']}',
                                              '{$air_list['a_sch_child_normal_price']}',
                                              '{$air_list['a_sch_adult_sale']}',
                                              '{$air_list['a_sch_child_sale']}',
                                              '{$air_list['a_sch_adult_deposit_sale']}',
                                              '{$air_list['a_sch_child_deposit_sale']}',
                                              '{$total_air_price}',
                                              '{$a_sch_normal_price}',
                                              '{$total_air_deposit_price}',
                                              '{$_POST['adult_number']}',
                                              '{$_POST['child_number']}',
                                              '{$_POST['baby_number']}',
                                              '{$_POST['adult_name']}',
                                              '{$_POST['child_name']}',
                                              '{$_POST['baby_name']}',
                                              '{$_POST['air_type']}',
                                              '{$indate}'
                                              )";

    $db->sql_query($air_sql);
    $air_sql_basic = "insert into reservation_air_basic(reserv_user_no,
                                              reserv_air_airno,
                                              reserv_air_company_no,
                                              reserv_air_departure_area,
                                              reserv_air_end_departure_area,
                                              reserv_air_arrival_area,
                                              reserv_air_start_arrival_area,
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
                                              reserv_air_normal_total_price,
                                              reserv_air_total_deposit_price,
                                              reserv_air_adult_number,
                                              reserv_air_child_number,
                                              reserv_air_baby_number,
                                              reserv_air_adult_list,
                                              reserv_air_child_list,
                                              reserv_air_baby_list,
                                              reserv_air_type,
                                              indate
                                              )VALUES (
                                              '{$reserv_no}',
                                              '{$_POST['air_no']}',
                                              '{$_POST['air_company_no']}',
                                              '{$air_list['a_sch_departure_area_name']}',
                                              '제주',
                                              '{$air_list['a_sch_arrival_area_name']}',
                                              '제주',
                                              '{$air_list['a_sch_departure_airline_name']}',
                                              '{$air_list['a_sch_arrival_airline_name']}',
                                              '{$air_list['a_sch_company']}',
                                              '{$air_list['a_sch_company']}',
                                              '{$start_date}',
                                              '{$return_date}',
                                              '{$air_list['a_sch_stay']}',
                                              '{$air_list['a_sch_adult_normal_price']}',
                                              '{$air_list['a_sch_child_normal_price']}',
                                              '{$air_list['a_sch_adult_sale']}',
                                              '{$air_list['a_sch_child_sale']}',
                                              '{$air_list['a_sch_adult_deposit_sale']}',
                                              '{$air_list['a_sch_child_deposit_sale']}',
                                              '{$total_air_price}',
                                              '{$a_sch_normal_price}',
                                              '{$total_air_deposit_price}',
                                              '{$_POST['adult_number']}',
                                              '{$_POST['child_number']}',
                                              '{$_POST['baby_number']}',
                                               '{$_POST['adult_name']}',
                                              '{$_POST['child_name']}',
                                              '{$_POST['baby_name']}',
                                              '{$_POST['air_type']}',
                                              '{$indate}'
                                              )";
//    echo $air_sql_basic;
    $db->sql_query($air_sql_basic);
}
if(strpos($_POST["package"],"C")!== false) {
    $sql_com = "select no,rent_com_name from rent_company where rent_com_type='대표'";
    $rs_com  = $db->sql_query($sql_com);
    $row_com = $db->fetch_array($rs_com);
    $rent->carno = $_POST['car_no'];
    $rent->comno = $row_com['no'];
    $rent_list = $rent->car_list();
    $rent->start_date =$_POST['car_sdate'];
    $rent->end_date = $_POST['car_edate'];
    $rent_time = $rent->rent_time();
    $fuel = $rent->rent_code_name($rent_list['rent_car_fuel']);
    $car_option = $_POST['navi'].",".$_POST['insu'];

    $rent_price = $rent->rent_price_main();
    if(strlen($_POST['package'])  == 1 and $_POST['package'] !="C" ){
        $total_rent_price = $rent_price[1] * $_POST['car_vehicle'];

        $car_sale = $rent_price[5];
    }else if(strlen($_POST['package']) > 1 and $_POST['package'] !="C" ){
        $total_rent_price = $rent_price[2] * $_POST['car_vehicle'];
        $car_sale = $rent_price[6];
    }else{
        $total_rent_price = $rent_price[0] * $_POST['car_vehicle'];
        $car_sale = $rent_price[4];
    }
    $car_sale_daposit = $rent_price[7];
    $total_rent_price_deposit = $rent_price[3] * $_POST['car_vehicle'];


    $rent_sql = "insert into reservation_rent(
                                                reserv_user_no,
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
                                                reserv_rent_departure_place,
                                                reserv_rent_arrival_place,
                                                reserv_rent_option,
                                                indate    
                                              ) VALUES (
                                                '{$reserv_no}',
                                                '{$row_com['no']}',
                                                '{$row_com['rent_com_name']}',
                                                '{$_POST['car_no']}',
                                                '{$rent_list['rent_car_name']}',
                                                '{$rent_list['rent_car_fuel']}',
                                                '{$rent_list['rent_car_type']}',
                                                '{$_POST['car_sdate']}',
                                                '{$_POST['car_edate']}',
                                                '{$rent_time[0]}',
                                                '{$_POST['car_vehicle']}',
                                                '{$car_sale}',
                                                '{$car_sale_daposit}',
                                                '{$total_rent_price}',
                                                '{$total_rent_price_deposit}',
                                                '본사',
                                                '본사',
                                                '{$car_option}',
                                                '{$indate}'
                                              )";
    //echo $rent_sql;
    $rent_sql_basic = "insert into reservation_rent_basic(
                                                reserv_user_no,
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
                                                reserv_rent_departure_place,
                                                reserv_rent_arrival_place,
                                                reserv_rent_option,
                                                indate    
                                              ) VALUES (
                                                '{$reserv_no}',
                                                '{$row_com['no']}',
                                                '{$row_com['rent_com_name']}',
                                                '{$_POST['car_no']}',
                                                '{$rent_list['rent_car_name']}',
                                                '{$rent_list['rent_car_fuel']}',
                                                '{$rent_list['rent_car_type']}',
                                                '{$_POST['car_sdate']}',
                                                '{$_POST['car_edate']}',
                                                '{$rent_time[0]}',
                                                '{$_POST['car_vehicle']}',
                                                '{$car_sale}',
                                                '{$car_sale_daposit}',
                                                '{$total_rent_price}',
                                                '{$total_rent_price_deposit}',
                                                '본사',
                                                '본사',
                                                '{$car_option}',
                                                '{$indate}'
                                              )";
    $db->sql_query($rent_sql);
    $db->sql_query($rent_sql_basic);

}
if(strpos($_POST["package"],"T")!== false) {

    if ($_POST['tel_t'] == "D") {
        $total_tel_price = 0;
        $total_tel_price_dan = 0;
        for ($i = 0; $i < count($_POST['tel_no']); $i++) {
            $tel->lodno = $_REQUEST['tel_no'][$i];
            $tel->roomno = $_REQUEST['room_no'][$i];
            $tel->start_date = $_REQUEST['tel_start_date'][$i];
            $tel->lodging_vehicle = $_REQUEST['tel_vehicle'][$i];
            $tel->adult_number = $_REQUEST['adult_number'];
            $tel->child_number = $_REQUEST['child_number'];
            $tel->baby_number = $_REQUEST['baby_number'];
            $tel->stay = $_REQUEST['tel_stay'][$i];
            $tel_list = $tel->lodging_room_name();

            $lodging_price = $tel->lodging_main_price();


            if (strlen($_REQUEST['package']) == 1 and $_REQUEST['package'] != "T") {
                $total_tel_price_dan = (($lodging_price[0] * $_REQUEST['tel_vehicle'][$i]) );
                $total_tel_price += (($lodging_price[1] * $_REQUEST['tel_vehicle'][$i]) );
            } else if (strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] != "T") {
                $total_tel_price_dan = (($lodging_price[0] * $_REQUEST['tel_vehicle'][$i]) );
                $total_tel_price += (($lodging_price[2] * $_REQUEST['tel_vehicle'][$i]));
            } else {
                $total_tel_price_dan = (($lodging_price[0] * $_REQUEST['tel_vehicle'][$i]) );
                $total_tel_price += (($lodging_price[0] * $_REQUEST['tel_vehicle'][$i]) );
            }
            $total_tel_price_deposit = (($lodging_price[4] * $_POST['tel_vehicle'][$i]));
            $tel_sql = "insert into reservation_lodging(
                                                      reserv_user_no,
                                                      reserv_tel_lodno,
                                                      reserv_tel_roomno,
                                                      reserv_tel_name,
                                                      reserv_tel_room_name,
                                                      reserv_tel_date,
                                                      reserv_tel_stay,
                                                      reserv_tel_few, 
                                                      reserv_tel_adult_number,
                                                      reserv_tel_child_number,
                                                      reserv_tel_baby_number,
                                                      reserv_tel_total_price,
                                                      reserv_tel_total_dposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$_POST['tel_no'][$i]}',
                                                        '{$_POST['room_no'][$i]}',
                                                        '{$tel_list[0]}',
                                                        '{$tel_list[1]}',
                                                        '{$_POST['tel_start_date'][$i]}',
                                                        '{$_POST['tel_stay'][$i]}',
                                                        '{$_POST['tel_vehicle'][$i]}',
                                                        '{$_POST['adult_number']}',
                                                        '{$_POST['child_number']}',
                                                        '{$_POST['baby_number']}',
                                                        '{$total_tel_price_dan}',
                                                        '{$total_tel_price_deposit}', 
                                                        '{$indate}' 
                                                      )
                         ";
            $tel_sql_basic = "insert into reservation_lodging_basic(
                                                      reserv_user_no,
                                                      reserv_tel_lodno,
                                                      reserv_tel_roomno,
                                                      reserv_tel_name,
                                                      reserv_tel_room_name,
                                                      reserv_tel_date,
                                                      reserv_tel_stay,
                                                      reserv_tel_few,
                                                       reserv_tel_adult_number,
                                                      reserv_tel_child_number,
                                                      reserv_tel_baby_number, 
                                                      reserv_tel_total_price,
                                                      reserv_tel_total_dposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$_POST['tel_no'][$i]}',
                                                        '{$_POST['room_no'][$i]}',
                                                        '{$tel_list[0]}',
                                                        '{$tel_list[1]}',
                                                        '{$_POST['tel_start_date'][$i]}',
                                                        '{$_POST['tel_stay'][$i]}',
                                                        '{$_POST['tel_vehicle'][$i]}',
                                                        '{$_POST['adult_number']}',
                                                        '{$_POST['child_number']}',
                                                        '{$_POST['baby_number']}',
                                                        '{$total_tel_price_dan}',
                                                        '{$total_tel_price_deposit}', 
                                                        '{$indate}' 
                                                      )
                         ";
            $db->sql_query($tel_sql);
            $db->sql_query($tel_sql_basic);

        }
    }else {
        $tel->lodno = $_POST['tel_no'];
        $tel->roomno = $_POST['room_no'];
        $tel->start_date = $_POST['tel_start_date'];
        $tel->lodging_vehicle = $_POST['tel_vehicle'];
        $tel->adult_number = $_POST['adult_number'];
        $tel->child_number = $_POST['child_number'];
        $tel->baby_number = $_POST['baby_number'];
        $tel->stay = $_POST['tel_stay'];
        $tel_list = $tel->lodging_room_name();

        $lodging_price = $tel->lodging_main_price();

        if (strlen($_POST['package']) == 1 and $_POST['package'] != "T") {
            $total_tel_price = (($lodging_price[1] * $_POST['tel_vehicle']));
        } else if (strlen($_POST['package']) > 1 and $_POST['package'] != "T") {
            $total_tel_price = (($lodging_price[2] * $_POST['tel_vehicle']));
        } else {
            $total_tel_price = (($lodging_price[0] * $_POST['tel_vehicle']));
        }
        $total_tel_price_deposit = (($lodging_price[4] * $_POST['tel_vehicle']));
        $tel_sql = "insert into reservation_lodging(
                                                      reserv_user_no,
                                                      reserv_tel_lodno,
                                                      reserv_tel_roomno,
                                                      reserv_tel_name,
                                                      reserv_tel_room_name,
                                                      reserv_tel_date,
                                                      reserv_tel_stay,
                                                      reserv_tel_few, 
                                                      reserv_tel_adult_number,
                                                      reserv_tel_child_number,
                                                      reserv_tel_baby_number,
                                                      reserv_tel_total_price,
                                                      reserv_tel_total_dposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$_POST['tel_no']}',
                                                        '{$_POST['room_no']}',
                                                        '{$tel_list[0]}',
                                                        '{$tel_list[1]}',
                                                        '{$_POST['tel_start_date']}',
                                                        '{$_POST['tel_stay']}',
                                                        '{$_POST['tel_vehicle']}',
                                                        '{$_POST['adult_number']}',
                                                        '{$_POST['child_number']}',
                                                        '{$_POST['baby_number']}',
                                                        '{$total_tel_price}',
                                                        '{$total_tel_price_deposit}', 
                                                        '{$indate}' 
                                                      )
                         ";
        $tel_sql_basic = "insert into reservation_lodging_basic(
                                                      reserv_user_no,
                                                      reserv_tel_lodno,
                                                      reserv_tel_roomno,
                                                      reserv_tel_name,
                                                      reserv_tel_room_name,
                                                      reserv_tel_date,
                                                      reserv_tel_stay,
                                                      reserv_tel_few,
                                                       reserv_tel_adult_number,
                                                      reserv_tel_child_number,
                                                      reserv_tel_baby_number, 
                                                      reserv_tel_total_price,
                                                      reserv_tel_total_dposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$_POST['tel_no']}',
                                                        '{$_POST['room_no']}',
                                                        '{$tel_list[0]}',
                                                        '{$tel_list[1]}',
                                                        '{$_POST['tel_start_date']}',
                                                        '{$_POST['tel_stay']}',
                                                        '{$_POST['tel_vehicle']}',
                                                        '{$_POST['adult_number']}',
                                                        '{$_POST['child_number']}',
                                                        '{$_POST['baby_number']}',
                                                        '{$total_tel_price}',
                                                        '{$total_tel_price_deposit}', 
                                                        '{$indate}' 
                                                      )
                         ";
       // echo $tel_sql_basic;
        $db->sql_query($tel_sql);
        $db->sql_query($tel_sql_basic);
    }
}
if(strpos($_POST["package"],"B")!== false) {
   // print_r($_POST);
    $bus->bus_no = $_POST['bus_no'];
    $bus->start_date = $_POST['bus_date'];
    $bus->stay = $_POST['bus_stay'];
    $bus->bus_vehicle = $_POST['bus_vehicle'];
    $bus_list = $bus->bus_name();
    $bus_type = $bus->bus_list();
    $bus_stay = $_POST['bus_stay']-1;
   // echo $bus_stay."===";
    $bus_edate = date("Y-m-d", strtotime($_POST['bus_date'] . " +{$bus_stay} days"));

    $bus_price = $bus->bus_price();
    $total_bus_price = $bus_price[0];
    $total_bus_price_deposit = $bus_price[1];

    $bus_sql = "insert into reservation_bus(
                                                reserv_user_no,
                                                reserv_bus_no,
                                                reserv_bus_name,
                                                reserv_bus_date,
                                                reserv_bus_stay,
                                                reserv_bus_type,
                                                reserv_bus_vehicle,
                                                reserv_bus_total_price,
                                                reserv_bus_total_deposit_price,
                                                indate
                                                ) VALUES (
                                                  '{$reserv_no}',
                                                  '{$_POST['bus_no']}',
                                                  '{$bus_list}',
                                                  '{$_POST['bus_date']}',
                                                  '{$_POST['bus_stay']}',
                                                  '{$bus_type['bus_type']}',
                                                  '{$_POST['bus_vehicle']}',
                                                  '{$total_bus_price}',
                                                  '{$total_bus_price_deposit}',
                                                  '{$indate}'
                                                )";
    $bus_sql_basic = "insert into reservation_bus_basic(
                                                reserv_user_no,
                                                reserv_bus_no,
                                                reserv_bus_name,
                                                reserv_bus_date,
                                                reserv_bus_stay,
                                                reserv_bus_type,
                                                reserv_bus_vehicle,
                                                reserv_bus_total_price,
                                                reserv_bus_total_deposit_price,
                                                indate
                                                ) VALUES (
                                                  '{$reserv_no}',
                                                  '{$_POST['bus_no']}',
                                                  '{$bus_list}',
                                                  '{$_POST['bus_date']}',
                                                  '{$_POST['bus_stay']}',
                                                  '{$bus_type['bus_type']}',
                                                  '{$_POST['bus_vehicle']}',
                                                  '{$total_bus_price}',
                                                  '{$total_bus_price_deposit}',
                                                  '{$indate}'
                                                )";
   // echo $bus_sql_basic;
    $db->sql_query($bus_sql);
    $db->sql_query($bus_sql_basic);
}
if(strpos($_POST["package"],"P")!== false) {
    $bustour->bustour_no = $_POST['bustour_no'];
    $bustour_list = $bustour->bustour_name();
    $bustour->start_date = $_POST['bustour_date'];
    $bustour->number = ($_POST['adult_number'] + $_POST['child_number']);
    $bustour_price = $bustour->bustour_price();
    $total_bustour_price = $bustour_price[0];
    $total_bustour_price_deposit = $bustour_price[1];
    $number = ($_POST['adult_number'] + $_POST['child_number']);
    $bustour_sql = "insert into reservation_bustour(
                                                      reserv_user_no,
                                                      reserv_bustour_name,
                                                      reserv_bustour_no,
                                                      reserv_bustour_date,
                                                      reserv_bustour_number,
                                                      reserv_bustour_total_price,
                                                      reserv_bustour_total_deposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$bustour_list['bustour_tour_name']}',
                                                        '{$_POST['bustour_no']}',
                                                        '{$_POST['bustour_date']}',
                                                        '{$number}',
                                                        '{$total_bustour_price}',
                                                        '{$total_bustour_price_deposit}',
                                                        '{$indate}'
                                                      )";
    $bustour_sql_basic = "insert into reservation_bustour_basic(
                                                      reserv_user_no,
                                                      reserv_bustour_name,
                                                      reserv_bustour_no,
                                                      reserv_bustour_date,
                                                      reserv_bustour_number,
                                                      reserv_bustour_total_price,
                                                      reserv_bustour_total_deposit_price,
                                                      indate
                                                      ) VALUES (
                                                        '{$reserv_no}',
                                                        '{$bustour_list['bustour_tour_name']}',
                                                        '{$_POST['bustour_no']}',
                                                        '{$_POST['bustour_date']}',
                                                        '{$number}',
                                                        '{$total_bustour_price}',
                                                        '{$total_bustour_price_deposit}',
                                                        '{$indate}'
                                                      )";
    $db->sql_query($bustour_sql);
    $db->sql_query($bustour_sql_basic);
}
if(strpos($_POST["package"],"G")!== false) {
    $total_golf_price =0;
    $total_golf_price_deposit=0;
    for ($i = 0; $i < count($_POST['golf_no']); $i++) {
        $golf->golf_no = $_POST['golf_no'][$i];
        $golf->hole_no = $_POST['hole_no'][$i];
        $golf_name = $golf->golf_name();
        $golf->adult_number = $_POST['golf_number'][$i];
        $golf->start_date = $_POST['golf_date'][$i];
        $golf->stay = 1;
        $golf_price = $golf->golf_main_price();
        $total_golf_price += $golf_price[1];
        $total_golf_price_deposit += $golf_price[2];

        $golf_sql = "insert into reservation_golf(
                                                    reserv_user_no,
                                                    reserv_golf_golf_no,
                                                    reserv_golf_hole_no,
                                                    reserv_golf_name,
                                                    reserv_golf_hole_name,
                                                    reserv_golf_date,
                                                    reserv_golf_stay,
                                                    reserv_golf_time,
                                                    reserv_golf_total_price,
                                                    reserv_golf_total_dposit_price,
                                                    indate
                                                    ) VALUES (
                                                      '{$reserv_no}',
                                                      '{$_POST['golf_no'][$i]}',
                                                      '{$_POST['hole_no'][$i]}',
                                                      '{$golf_name['golf_name']}',
                                                      '{$golf_name['hole_name']}',
                                                      '{$_POST['golf_date'][$i]}',
                                                      '1',
                                                      '{$_POST['golf_time'][$i]}',
                                                      '{$total_golf_price}',
                                                      '{$total_golf_price_deposit}',
                                                      '{$indate}'
                                                    )";
        $golf_sql_basic = "insert into reservation_golf_basic(
                                                    reserv_user_no,
                                                    reserv_golf_golf_no,
                                                    reserv_golf_hole_no,
                                                    reserv_golf_name,
                                                    reserv_golf_hole_name,
                                                    reserv_golf_date,
                                                    reserv_golf_stay,
                                                    reserv_golf_time,
                                                    reserv_golf_total_price,
                                                    reserv_golf_total_dposit_price,
                                                    indate
                                                    ) VALUES (
                                                      '{$reserv_no}',
                                                      '{$_POST['golf_no'][$i]}',
                                                      '{$_POST['hole_no'][$i]}',
                                                      '{$golf_name['golf_name']}',
                                                      '{$golf_name['hole_name']}',
                                                      '{$_POST['golf_date'][$i]}',
                                                      '1',
                                                      '{$_POST['golf_time'][$i]}',
                                                      '{$total_golf_price}',
                                                      '{$total_golf_price_deposit}',
                                                      '{$indate}'
                                                    )";
        $db->sql_query($golf_sql);
        $db->sql_query($golf_sql_basic);
    }
}

$total_price = $total_air_price + $total_rent_price + $total_tel_price + $total_bus_price + $total_bustour_price + $total_golf_price;
$reserv_price =  $total_price * 0.3;
$reserv_start_date  = date("Y-m-d",time());
$balance_price = $total_price - $reserv_price;
$reserv_end_date  = date("Y-m-d", strtotime(time()." +7 days"));


$sql_amount = "insert into reservation_amount(reserv_user_no,reserv_deposit_price,reserv_deposit_date,reserv_balance_price,reserv_balance_date,reserv_total_price,indate) 
                                        values('{$reserv_no}','{$reserv_price}','{$reserv_start_date}','{$balance_price}','{$reserv_start_date}','{$total_price}','{$indate}')";
$db->sql_query($sql_amount);
$sql_amount_basic = "insert into reservation_amount_basic(reserv_user_no,reserv_deposit_price,reserv_deposit_date,reserv_balance_price,reserv_balance_date,reserv_total_price,indate) 
                                        values('{$reserv_no}','{$reserv_price}','{$reserv_start_date}','{$balance_price}','{$reserv_start_date}','{$total_price}','{$indate}')";
$db->sql_query($sql_amount_basic);
//echo $sql_amount;
echo "<script>
            window.location.href = 'reservation_end.php?reserv_no={$reserv_no}'
       </script>
      ";
?>