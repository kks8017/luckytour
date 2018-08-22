<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case=="com_insert"){
    $bus_taxi_name      = $_REQUEST["bus_taxi_name"];


    $sql = "insert into bus_taxi_company(bus_taxi_name) VALUES('{$bus_taxi_name}') "; // 거래처등록 쿼리

    $db->sql_query($sql);

}else if($case =="com_up"){
    // print_r($_REQUEST);
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num               = $_REQUEST["sel"][$i];
        $no1               = $_REQUEST["no"][$num] ;
        $bus_taxi_name1    = $_REQUEST["bus_taxi_name"][$num] ;
        $bus_taxi_phone1   = $_REQUEST["bus_taxi_phone"][$num];
        $bus_taxi_fax1     = $_REQUEST["bus_taxi_fax"][$num];
        $bus_taxi_email1   = $_REQUEST["bus_taxi_email"][$num];
        $bus_taxi_content1 = $_REQUEST["bus_taxi_content"][$num];

        $sql = "update bus_taxi_company set bus_taxi_name='{$bus_taxi_name1}',bus_taxi_phone='{$bus_taxi_phone1}',bus_taxi_fax='{$bus_taxi_fax1}',bus_taxi_email='{$bus_taxi_email1}', bus_taxi_content='{$bus_taxi_content1}' where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "com_del"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from bus_taxi_company where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case =="car_insert"){
    $indate  = date("Y-m-d H:i",time());

    $bus_name       = $_REQUEST["bus_name"];
    $bus_type       = $_REQUEST["bus_type"];

    if($_FILES['car_image']['tmp_name']!=""){
        $bus_images         = image_upload($_FILES['car_image'],KS_DATA_DIR."/".KS_BUS_DIR);
    }


    $sql = "insert into bus_taxi_car(bus_name,
                                              bus_type,
                                              bus_image,
                                              indate) 
            VALUES('{$bus_name}',
                    '{$bus_type}',
                    '{$bus_images[1]}',
                    '{$indate}'
                    ) ";
    echo $sql;
    $db->sql_query($sql);
    $car_no = $db->insert_id();
    $sql = "insert into bus_taxi_amount(bus_taxi_no,indate) 
            VALUES('{$car_no}',
                    '{$indate}'
                    ) ";
    // echo $sql;
    $db->sql_query($sql);
}else if($case =="bus_up"){


    $no                       = $_REQUEST["no"];
    $bus_name                 = $_REQUEST["bus_name_up"];
    $bus_type                 = $_REQUEST["bus_type_up"];



    if($_FILES['car_image_up']['error']==0) {
        if($_REQUEST['old_image']){
            $bus_images = image_upload($_FILES['car_image_up'],KS_DATA_DIR."/".KS_BUS_DIR,$_REQUEST['old_image'], "up");
        }else{
            $bus_images = image_upload($_FILES['car_image_up'],KS_DATA_DIR."/".KS_BUS_DIR);
        }
        $img_sql = ",bus_image       ='{$bus_images[1]}'";
    }else{
        $img_sql = "";
    }


    $sql = "update bus_taxi_car 
                set 
                        bus_name     ='{$bus_name}',
                        bus_type       ='{$bus_type}'
                       {$img_sql}
                where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case == "car_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];
        $old_image = $_REQUEST["old_image"][$num];

        $sql_amount = "delete from bus_taxi_amount where bus_taxi_no='{$no1}' ";
        echo $sql_amount;
        $db->sql_query($sql_amount);
        $image_dir = "../../".KS_DATA_DIR."/".KS_BUS_DIR;
        unlink($image_dir."/thumbnail_".$old_image);
        unlink($image_dir."/".$old_image);

        $sql = "delete from bus_taxi_car where no='{$no1}'";
        $db->sql_query($sql);
    }
}else if($case =="car_all_up"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num                       = $_REQUEST["sel"][$i];
        $no1                       = $_REQUEST["no"][$num] ;
        $sort_no1                  = $_REQUEST["bus_sort_no"][$num];
        $bus_open                  = $_REQUEST["bus_open"][$num];



        $sql = "update bus_taxi_car 
                set 
                        bus_sort_no     ='{$sort_no1}',
                        bus_open       ='{$bus_open}'
                where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="all_amount"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num                       = $_REQUEST["sel"][$i];
        $no1                       = $_REQUEST["no"][$num] ;
        $bus_taxi_amount_1                  = get_comma($_REQUEST["bus_taxi_amount_1"][$num]);
        $bus_taxi_amount_2                  = get_comma($_REQUEST["bus_taxi_amount_2"][$num]);
        $bus_taxi_amount_3                  = get_comma($_REQUEST["bus_taxi_amount_3"][$num]);
        $bus_taxi_amount_4                  = get_comma($_REQUEST["bus_taxi_amount_4"][$num]);
        $bus_taxi_amount_5                  = get_comma($_REQUEST["bus_taxi_amount_5"][$num]);
        $bus_taxi_amount_6                  = get_comma($_REQUEST["bus_taxi_amount_6"][$num]);
        $bus_taxi_amount_7                  = get_comma($_REQUEST["bus_taxi_amount_7"][$num]);
        $bus_taxi_amount_8                  = get_comma($_REQUEST["bus_taxi_amount_8"][$num]);
        $bus_taxi_amount_9                  = get_comma($_REQUEST["bus_taxi_amount_9"][$num]);
        $bus_taxi_amount_10                 = get_comma($_REQUEST["bus_taxi_amount_10"][$num]);
        $bus_taxi_amount_deposit            = get_comma($_REQUEST["bus_taxi_amount_deposit"][$num]);



        $sql = "update bus_taxi_amount 
                set 
                        bus_taxi_amount_1     ='{$bus_taxi_amount_1}',
                        bus_taxi_amount_2     ='{$bus_taxi_amount_2}',
                        bus_taxi_amount_3     ='{$bus_taxi_amount_3}',
                        bus_taxi_amount_4     ='{$bus_taxi_amount_4}',
                        bus_taxi_amount_5     ='{$bus_taxi_amount_5}',
                        bus_taxi_amount_6     ='{$bus_taxi_amount_6}',
                        bus_taxi_amount_7     ='{$bus_taxi_amount_7}',
                        bus_taxi_amount_8     ='{$bus_taxi_amount_8}',
                        bus_taxi_amount_9     ='{$bus_taxi_amount_9}',
                        bus_taxi_amount_10     ='{$bus_taxi_amount_10}',
                        bus_taxi_amount_deposit     ='{$bus_taxi_amount_deposit}'
                where no='{$no1}'";
        //echo $sql;
        $db->sql_query($sql);
    }
}
?>