<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case == "com_insert"){

    $rent_com_name      = $_REQUEST["rent_com_name"];
    $rent_com_type      = $_REQUEST["rent_com_type"];

    $sql = "insert into rent_company(rent_com_name,rent_com_type) VALUES('{$rent_com_name}','{$rent_com_type}') "; // 거래처등록 쿼리

    $db->sql_query($sql);
}else if($case =="com_up"){
    // print_r($_REQUEST);
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $rent_name1    = $_REQUEST["rent_com_name"][$num] ;
        $rent_type1    = $_REQUEST["rent_com_type_".$num];
        $rent_manager1 = $_REQUEST["rent_com_manager"][$num];
        $rent_phone1 = $_REQUEST["rent_com_phone"][$num];
        $rent_fax1   = $_REQUEST["rent_com_fax"][$num];
        $rent_content1     = $_REQUEST["rent_com_content"][$num];

        $sql = "update rent_company set rent_com_name='{$rent_name1}',rent_com_type='{$rent_type1}',rent_com_manager='{$rent_manager1}',rent_com_phone='{$rent_phone1}', rent_com_fax='{$rent_fax1}',rent_com_content='{$rent_content1}' where no='{$no1}'";
        //  echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "com_del"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from rent_company where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case =="car_insert"){
    $indate  = date("Y-m-d H:i",time());
    $rent_com_no         = $_REQUEST["rent_company"];
    $rent_car_name       = $_REQUEST["rent_name"];
    $rent_car_type       = $_REQUEST["rent_car_type"];
    $rent_car_fuel       = $_REQUEST["rent_car_fuel"];
    $rent_car_year       = $_REQUEST["rent_car_year_start"]."~".$_REQUEST["rent_car_year_end"];
    $rent_option         = implode(",",$_REQUEST["rent_option"]);

    if($_FILES['car_image']['tmp_name']!=""){
        $rent_images         = image_upload($_FILES['car_image'],KS_DATA_DIR."/".KS_RENT_DIR);
    }


    $sql = "insert into rent_car_detail(rent_com_no,
                                              rent_car_name,
                                              rent_car_type,
                                              rent_car_fuel,
                                              rent_car_year_type,
                                              rent_car_option,
                                              rent_car_image,
                                              indate) 
            VALUES('{$rent_com_no}',
                    '{$rent_car_name}',
                    '{$rent_car_type}',
                    '{$rent_car_fuel}',
                    '{$rent_car_year}',
                    '{$rent_option}',
                    '{$rent_images[1]}',
                    '{$indate}'
                    ) ";
     echo $sql;
    $db->sql_query($sql);
    $car_no = $db->insert_id();
    $sql = "insert into rent_amount(rent_com_no,rent_car_no,indate) 
            VALUES('{$rent_com_no}',
                    '{$car_no}',
                    '{$indate}'
                    ) ";
    // echo $sql;
    $db->sql_query($sql);

}else if($case == "car_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];
        $com_no1 = $_REQUEST["com_no"][$num];
        $old_image = $_REQUEST["old_image"][$num];

        $sql_amount = "delete from rent_amount where rent_car_no='{$no1}' and  rent_com_no='{$com_no1}'";

        $db->sql_query($sql_amount);
        $image_dir = "../../".KS_DATA_DIR."/".KS_RENT_DIR;
        unlink($image_dir."/thumbnail_".$old_image);
        unlink($image_dir."/".$old_image);

        $sql = "delete from rent_car_detail where no='{$no1}'";
        $db->sql_query($sql);


    }
}else if($case =="car_all_up"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num                       = $_REQUEST["sel"][$i];
        $no1                       = $_REQUEST["no"][$num] ;
        $sort_no1                  = $_REQUEST["rent_car_sort"][$num];
        $rent_car_open1            = $_REQUEST["rent_car_open_".$i];



        $sql = "update rent_car_detail 
                set 
                        rent_car_sort     ='{$sort_no1}',
                        rent_car_open       ='{$rent_car_open1}'
                where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="car_up"){


        $no                       = $_REQUEST["no"];
        $rent_com_no              = $_REQUEST["rent_company_up"];
        $rent_name                = $_REQUEST["rent_name_up"];
        $car_type                 = $_REQUEST["rent_car_type_up"];
        $car_fuel                 = $_REQUEST["rent_car_fuel_up"];
        $rent_car_year            = $_REQUEST["rent_car_year_start_up"]."~".$_REQUEST["rent_car_year_end_up"];
        if(is_array($_REQUEST['rent_option_up'])) {
            $rent_option = implode(",", $_REQUEST["rent_option_up"]);
        }

        if($_FILES['car_image_up']['error']==0) {
            if($_REQUEST['old_image']){
                $rent_images = image_upload($_FILES['car_image_up'],KS_DATA_DIR."/".KS_RENT_DIR,$_REQUEST['old_image'], "up");
            }else{
                $rent_images = image_upload($_FILES['car_image_up'],KS_DATA_DIR."/".KS_RENT_DIR);
            }
            $image_sql =" ,rent_car_image='{$rent_images[1]}'";

        }else{

            $image_sql ="";
        }



        $sql = "update rent_car_detail 
                set 
                        rent_com_no     ='{$rent_com_no}',
                        rent_car_name       ='{$rent_name}',
                        rent_car_type       ='{$car_type}',
                        rent_car_fuel       ='{$car_fuel}',
                        rent_car_year_type       ='{$rent_car_year}',
                        rent_car_option       ='{$rent_option}'
                        {$image_sql}
                  where no='{$no}'  ";
        echo $sql;
        $db->sql_query($sql);



}else if($case =="car_amt_up"){


    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num                       = $_REQUEST["sel"][$i];
        $no1                       = $_REQUEST["no"][$num] ;
        $rent_amount_6hour         = get_comma($_REQUEST["rent_amount_6hour"][$num]);
        $rent_amount_12hour        = get_comma($_REQUEST["rent_amount_12hour"][$num]);
        $rent_amount_24hour        = get_comma($_REQUEST["rent_amount_24hour"][$num]);
        $rent_sale_car             = $_REQUEST["rent_sale_car"][$num] ;
        $rent_sale_aircar          = $_REQUEST["rent_sale_aircar"][$num] ;
        $rent_sale_aircartel       = $_REQUEST["rent_sale_aircartel"][$num] ;
        $rent_sale_car_week        = $_REQUEST["rent_sale_car_week"][$num] ;
        $rent_sale_aircar_week     = $_REQUEST["rent_sale_aircar_week"][$num] ;
        $rent_sale_aircartel_week  = $_REQUEST["rent_sale_aircartel_week"][$num] ;
        $rent_sale_deposit         = $_REQUEST["rent_sale_deposit"][$num] ;
        $rent_sale_deposit_week    = $_REQUEST["rent_sale_deposit_week"][$num] ;
        $rent_sale_additional      = get_comma($_REQUEST["rent_sale_additional"][$num]) ;
        $rent_sale_week            = implode(",",$_REQUEST["rent_sale_week"][$i]);


        $sql = "update rent_amount 
                set 
                        rent_amount_6hour         ='{$rent_amount_6hour}',
                        rent_amount_12hour        ='{$rent_amount_12hour}',
                        rent_amount_24hour        ='{$rent_amount_24hour}',
                        rent_sale_car             ='{$rent_sale_car}',
                        rent_sale_aircar          ='{$rent_sale_aircar}',
                        rent_sale_aircartel       ='{$rent_sale_aircartel}',
                        rent_sale_car_week        ='{$rent_sale_car_week}',
                        rent_sale_aircar_week     ='{$rent_sale_aircar_week}',
                        rent_sale_aircartel_week  ='{$rent_sale_aircartel_week}',
                        rent_sale_deposit         ='{$rent_sale_deposit}',
                        rent_sale_deposit_week    ='{$rent_sale_deposit_week}',
                        rent_sale_additional      ='{$rent_sale_additional}',
                        rent_sale_week            ='{$rent_sale_week}'
                where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }

}else if($case=="season_insert") {

    $indate = date("Y-m-d H:i", time());
    $rent_com_no = $_REQUEST["rent_com_no"];
    $rent_season_name = $_REQUEST["rent_season_name"];
    $rent_season_start_date = $_REQUEST["rent_season_start_date"];
    $rent_season_end_date = $_REQUEST["rent_season_end_date"];
    $sql_com = "select rent_com_no,rent_car_no,rent_amount_6hour,rent_amount_12hour,rent_amount_24hour from rent_amount where rent_com_no='{$rent_com_no}'";
    $rs_com = $db->sql_query($sql_com);

    $sql_list = "insert into rent_season_list(rent_com_no,
                                               rent_season_name,
                                               rent_season_start_date,
                                               rent_season_end_date,
                                               indate) 
                    VALUES('{$rent_com_no}',
                            '{$rent_season_name}',
                            '{$rent_season_start_date}',
                            '{$rent_season_end_date}',
                            '{$indate}'
                            ) ";
    echo $sql_list;
    $db->sql_query($sql_list);
    $season_id = $db->insert_id();
    while ($row_com = $db->fetch_array($rs_com)) {

        $sql = "insert into rent_season_amount(rent_season_no,
                                               rent_car_no,
                                               rent_season_amount_6hour,
                                               rent_season_amount_12hour,
                                               rent_season_amount_24hour,
                                               indate) 
                    VALUES('$season_id',
                            '{$row_com['rent_car_no']}',
                            '{$row_com['rent_amount_6hour']}',
                            '{$row_com['rent_amount_12hour']}',
                            '{$row_com['rent_amount_24hour']}',
                            '{$indate}'
                            ) ";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="season_all_up") {


    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {

        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];
        $rent_amount_6hour = get_comma($_REQUEST["rent_season_amount_6hour"][$num]);
        $rent_amount_12hour = get_comma($_REQUEST["rent_season_amount_12hour"][$num]);
        $rent_amount_24hour = get_comma($_REQUEST["rent_season_amount_24hour"][$num]);
        $rent_sale_car = $_REQUEST["rent_season_sale_car"][$num];
        $rent_sale_aircar = $_REQUEST["rent_season_sale_aircar"][$num];
        $rent_sale_aircartel = $_REQUEST["rent_season_sale_aircartel"][$num];
        $rent_sale_car_week = $_REQUEST["rent_season_sale_car_week"][$num];
        $rent_sale_aircar_week = $_REQUEST["rent_season_sale_aircar_week"][$num];
        $rent_sale_aircartel_week = $_REQUEST["rent_season_sale_aircartel_week"][$num];
        $rent_sale_deposit = $_REQUEST["rent_season_sale_deposit"][$num];
        $rent_sale_deposit_week = $_REQUEST["rent_season_sale_deposit_week"][$num];
        $rent_sale_additional = get_comma($_REQUEST["rent_season_sale_additional"][$num]);
        if($_REQUEST["rent_season_sale_week"][$i]!=""){
            $rent_sale_week = implode(",", $_REQUEST["rent_season_sale_week"][$i]);
        }



        $sql = "update rent_season_amount 
                set 
                        rent_season_amount_6hour         ='{$rent_amount_6hour}',
                        rent_season_amount_12hour        ='{$rent_amount_12hour}',
                        rent_season_amount_24hour        ='{$rent_amount_24hour}',
                        rent_season_sale_car             ='{$rent_sale_car}',
                        rent_season_sale_aircar          ='{$rent_sale_aircar}',
                        rent_season_sale_aircartel       ='{$rent_sale_aircartel}',
                        rent_season_sale_car_week        ='{$rent_sale_car_week}',
                        rent_season_sale_aircar_week     ='{$rent_sale_aircar_week}',
                        rent_season_sale_aircartel_week  ='{$rent_sale_aircartel_week}',
                        rent_season_sale_deposit         ='{$rent_sale_deposit}',
                        rent_season_sale_deposit_week    ='{$rent_sale_deposit_week}',
                        rent_season_sale_additional      ='{$rent_sale_additional}',
                        rent_season_week                 ='{$rent_sale_week}'
                where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "season_all_del"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from rent_season_amount where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case =="season_up"){


    $no                       = $_REQUEST["s_no"];
    $rent_season_name         = $_REQUEST["rent_season_name_up"];
    $rent_season_start_date   = $_REQUEST["rent_season_start_date_up"];
    $rent_season_end_date     = $_REQUEST["rent_season_end_date_up"];


    $sql = "update rent_season_list 
                set 
                        
                        rent_season_name           ='{$rent_season_name}',
                        rent_season_start_date     ='{$rent_season_start_date}',
                        rent_season_end_date       ='{$rent_season_end_date}'
                where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case == "season_del"){


        $no        = $_REQUEST["no"];
        $sql = "delete from rent_season_list where no='{$no}'";
        $db->sql_query($sql);

        $sql = "delete from rent_season_amount where rent_season_no='{$no}'";
        $db->sql_query($sql);

}else if($case =="car_copy"){

    $indate  = date("Y-m-d H:i",time());
    $rent_com_no = $_REQUEST["com_no"];
    for ($i = 0; $i < count($_REQUEST["sele"]); $i++) {

        $num = $_REQUEST["sele"][$i];
        $no1 = $_REQUEST["no_cp"][$num];




        $sql_car = "select * from rent_car_detail where no='{$no1}'";
      //  echo $sql_car."<br>";
        $rs_car = $db->sql_query($sql_car);
        $row_car = $db->fetch_array($rs_car);


        $sql = "insert into rent_car_detail(rent_com_no,
                                                  rent_car_no,
                                                  rent_car_name,
                                                  rent_car_type,
                                                  rent_car_fuel,
                                                  rent_car_year_type,
                                                  rent_car_option,
                                                  indate) 
                VALUES('{$rent_com_no}',
                        '{$no1}',
                        '{$row_car['rent_car_name']}',
                        '{$row_car['rent_car_type']}',
                        '{$row_car['rent_car_fuel']}',
                        '{$row_car['rent_car_year_type']}',
                        '{$row_car['rent_car_option']}',
                        '{$indate}'
                        ) ";
         echo $sql;
        $db->sql_query($sql);
        $sql = "insert into rent_amount(rent_com_no,rent_car_no,indate) 
                VALUES('{$rent_com_no}',
                        '{$no1}',
                        '{$indate}'
                        ) ";
      //   echo $sql;
        $db->sql_query($sql);

    }

}else if($case == "code_insert") {
    $indate  = date("Y-m-d H:i",time());

    $rent_config_type = $_REQUEST["rent_config_type"];
    $rent_config_sort_no = $_REQUEST["rent_config_sort_no"];
    $rent_config_name = $_REQUEST["rent_config_name"];

    $sql = "insert into rent_config(rent_config_type,rent_config_sort_no,rent_config_name,indate) VALUES('{$rent_config_type}','{$rent_config_sort_no}','{$rent_config_name}','{$indate}') "; // 거래처등록 쿼리
    $db->sql_query($sql);
}else if($case =="code_up"){

    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $rent_config_type1    = $_REQUEST["rent_config_type"][$num] ;
        $rent_config_sort_no1 = $_REQUEST["rent_config_sort_no"][$num];
        $rent_config_name1 = $_REQUEST["rent_config_name"][$num];
        $rent_config_chk1 = $_REQUEST["rent_config_chk"][$num];

        $sql = "update rent_config set rent_config_type='{$rent_config_type1}',rent_config_sort_no='{$rent_config_sort_no1}',rent_config_name='{$rent_config_name1}' ,rent_config_chk='{$rent_config_chk1}' where no='{$no1}'";
      //    echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "code_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST["no"][$num];

        $sql = "delete from rent_config where no='{$no}'";
        $db->sql_query($sql);
    }
}
?>