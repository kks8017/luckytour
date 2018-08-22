<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];
//print_r($_REQUEST) ;
if($case == "com_insert"){

    $air_name      = $_REQUEST["air_name"];
    $air_type      = $_REQUEST["air_type"];

    $sql = "insert into air_company(air_name,air_type) VALUES('{$air_name}','{$air_type}') "; // 거래처등록 쿼리

    $db->sql_query($sql);
}else if($case =="com_up"){
   // print_r($_REQUEST);
    $indate  = date("Y-m-d H:i",time());
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $air_name1    = $_REQUEST["air_name"][$num] ;
        $air_type1    = $_REQUEST["air_type_".$num];
        $air_content1 = $_REQUEST["air_content"][$num];
        $air_manager1 = $_REQUEST["air_manager"][$num];
        $air_phone1   = $_REQUEST["air_phone"][$num];
        $air_fax1     = $_REQUEST["air_fax"][$num];
        $air_sch_ok1  = $_REQUEST["air_sch_ok_".$num];


        $sql = "update air_company set air_name='{$air_name1}',air_type='{$air_type1}',air_content='{$air_content1}',air_manager='{$air_manager1}', air_phone='{$air_phone1}',air_fax='{$air_fax1}',air_sch_ok='{$air_sch_ok1}',indate='{$indate}' where no='{$no1}'";
      //  echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "com_del"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from air_company where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case =="no_insert"){
    $indate  = date("Y-m-d H:i",time());
    $sch_departure_area       = $_REQUEST["sch_departure_area"];
    $sch_arrival_area         = $_REQUEST["sch_arrival_area"];
    $sch_departure_airline    = $_REQUEST["sch_departure_airline"];
    $sch_arrival_airline      = $_REQUEST["sch_arrival_airline"];
    $hour                     = $_REQUEST["hour"];
    $minute                   = $_REQUEST["minute"];
    $r_hour                   = $_REQUEST["r_hour"];
    $r_minute                 = $_REQUEST["r_minute"];
    $sch_adult_normal_price   = get_comma($_REQUEST["sch_adult_normal_price"]);
    $sch_child_normal_price   = get_comma($_REQUEST["sch_child_normal_price"]);
    $sch_adult_sale           = get_comma($_REQUEST["sch_adult_sale"]);
    $sch_child_sale           = get_comma($_REQUEST["sch_child_sale"]);
    $sch_adult_sale_price     = get_comma($_REQUEST["sch_adult_sale_price"]);
    $sch_child_sale_price     = get_comma($_REQUEST["sch_child_sale_price"]);
    $sch_bigo                 = $_REQUEST["sch_bigo"];
    $sch_departure_time       = $hour.":".$minute;
    $sch_arrival_time         = $r_hour.":".$r_minute;

    $sql = "insert into air_normal_schedule(sch_departure_area,
                                              sch_arrival_area,
                                              sch_departure_airline,
                                              sch_arrival_airline,
                                              sch_departure_time,
                                              sch_arrival_time,
                                              sch_adult_normal_price,
                                              sch_child_normal_price,
                                              sch_adult_sale,
                                              sch_child_sale,
                                              sch_adult_sale_price,
                                              sch_child_sale_price,
                                              sch_bigo,
                                              indate) 
            VALUES('{$sch_departure_area}',
                    '{$sch_arrival_area}',
                    '{$sch_departure_airline}',
                    '{$sch_arrival_airline}',
                    '{$sch_departure_time}',
                    '{$sch_arrival_time}',
                    '{$sch_adult_normal_price}',
                    '{$sch_child_normal_price}',
                    '{$sch_adult_sale}',
                    '{$sch_child_sale}',
                    '{$sch_adult_sale_price}',
                    '{$sch_child_sale_price}',
                    '{$sch_bigo}',
                    '{$indate}'
                    ) ";
    $db->sql_query($sql);

}else if($case == "no_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];

        $sql = "delete from air_normal_schedule where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="no_up"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num                       = $_REQUEST["sel"][$i];
        $no1                       = $_REQUEST["no"][$num] ;
        $sch_departure_area1       = $_REQUEST["sch_departure_area_".$i];
        $sch_arrival_area1         = $_REQUEST["sch_arrival_area_".$i];
        $sch_departure_airline1    = $_REQUEST["sch_departure_airline_".$i];
        $sch_arrival_airline1      = $_REQUEST["sch_arrival_airline_".$i];
        $hour1                     = $_REQUEST["hour"][$num];
        $minute1                   = $_REQUEST["minute"][$num];
        $r_hour1                   = $_REQUEST["r_hour"][$num];
        $r_minute1                 = $_REQUEST["r_minute"][$num];
        $sch_adult_normal_price1   = get_comma($_REQUEST["sch_adult_normal_price"][$num]);
        $sch_child_normal_price1   = get_comma($_REQUEST["sch_child_normal_price"][$num]);
        $sch_adult_sale1           = get_comma($_REQUEST["sch_adult_sale"][$num]);
        $sch_child_sale1           = get_comma($_REQUEST["sch_child_sale"][$num]);
        $sch_adult_sale_price1     = get_comma($_REQUEST["sch_adult_sale_price"][$num]);
        $sch_child_sale_price1     = get_comma($_REQUEST["sch_child_sale_price"][$num]);
        $sch_bigo1                 = $_REQUEST["sch_bigo"][$num];
        $sch_departure_time        = $hour1.":".$minute1;
        $sch_arrival_time          = $r_hour1.":".$r_minute1;


        $sql = "update air_normal_schedule 
                set 
                        sch_departure_area     ='{$sch_departure_area1}',
                        sch_arrival_area       ='{$sch_arrival_area1}',
                        sch_departure_airline  ='{$sch_departure_airline1}',
                        sch_arrival_airline    ='{$sch_arrival_airline1}', 
                        sch_departure_time     ='{$sch_departure_time}',
                        sch_arrival_time       ='{$sch_arrival_time}',
                        sch_adult_normal_price ='{$sch_adult_normal_price1}',
                        sch_child_normal_price ='{$sch_child_normal_price1}',
                        sch_adult_sale         ='{$sch_adult_sale1}',
                        sch_child_sale         ='{$sch_child_sale1}',
                        sch_adult_sale_price   ='{$sch_adult_sale_price1}', 
                        sch_child_sale_price   ='{$sch_child_sale_price1}', 
                        sch_bigo               ='{$sch_bigo1}'
                where no='{$no1}'";
          echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="oil_insert"){
    $indate  = date("Y-m-d H:i",time());
    $a_oil_name        = $_REQUEST["a_oil_name"];
    $a_oil_start_date  = $_REQUEST["a_oil_start_date"];
    $a_oil_end_date    = $_REQUEST["a_oil_end_date"];
    $a_oil_oil_price   = get_comma($_REQUEST["a_oil_oil_price"]);
    $a_oil_com_price   = get_comma($_REQUEST["a_oil_com_price"]);

    $sql = "insert into air_oil_comm(a_oil_name,
                                       a_oil_start_date,
                                       a_oil_end_date,
                                       a_oil_oil_price,
                                       a_oil_com_price,
                                       indate) 
            VALUES('{$a_oil_name}',
                    '{$a_oil_start_date}',
                    '{$a_oil_end_date}',
                    '{$a_oil_oil_price}',
                    '{$a_oil_com_price}',
                    '{$indate}'
                    ) ";
    echo $sql;
    $db->sql_query($sql);

}else if($case =="oil_up"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num                = $_REQUEST["sel"][$i];
        $no1                = $_REQUEST["no"][$num] ;
        $a_oil_name1        = $_REQUEST["a_oil_name"][$num];
        $a_oil_start_date1  = $_REQUEST["a_oil_start_date"][$num];
        $a_oil_end_date1    = $_REQUEST["a_oil_end_date"][$num];
        $a_oil_oil_price1   = get_comma($_REQUEST["a_oil_oil_price"][$num]);
        $a_oil_com_price1   = get_comma($_REQUEST["a_oil_com_price"][$num]);

        $sql = "update air_oil_comm 
                set 
                        a_oil_name         ='{$a_oil_name1}',
                        a_oil_start_date   ='{$a_oil_start_date1}',
                        a_oil_end_date     ='{$a_oil_end_date1}',
                        a_oil_oil_price    ='{$a_oil_oil_price1}', 
                        a_oil_com_price    ='{$a_oil_com_price1}'
                where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "oil_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];

        $sql = "delete from air_oil_comm where no='{$no1}'";
        $db->sql_query($sql);
    }
}
?>