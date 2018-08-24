<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case == "code_insert") {
    $indate  = date("Y-m-d H:i",time());

    $golf_config_type = $_REQUEST["golf_config_type"];
    $golf_config_sort_no = $_REQUEST["golf_config_sort_no"];
    $golf_config_name = $_REQUEST["golf_config_name"];

    $sql = "insert into golf_config(golf_config_type,golf_config_sort_no,golf_config_name,indate) VALUES('{$golf_config_type}','{$golf_config_sort_no}','{$golf_config_name}','{$indate}') "; // 거래처등록 쿼리
    $db->sql_query($sql);
}else if($case =="code_up"){

    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $golf_config_type    = $_REQUEST["golf_config_type"][$num] ;
        $golf_config_sort_no = $_REQUEST["golf_config_sort_no"][$num];
        $golf_config_name = $_REQUEST["golf_config_name"][$num];
        $golf_config_chk = $_REQUEST["golf_config_chk"][$num];

        $sql = "update golf_config set golf_config_type='{$golf_config_type}',golf_config_sort_no='{$golf_config_sort_no}',golf_config_name='{$golf_config_name}' ,golf_config_chk='{$golf_config_chk}' where no='{$no1}'";
        //    echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "code_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST["no"][$num];

        $sql = "delete from golf_config where no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case == "golf_insert") {
    $indate  = date("Y-m-d H:i",time());
    $golf_name = $_REQUEST['golf_name'];
    $golf_area = $_REQUEST['golf_area'];

    $sql = "insert into golf_list (golf_name,golf_area,indate) value('{$golf_name}','{$golf_area}','{$indate}')";
    $db->sql_query($sql);
}else if($case =="golf_all_update"){
    // print_r($_REQUEST);
    //exit-1;
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $golf_sort1    = $_REQUEST["golf_sort_no"][$num] ;
        $golf_open1    = $_REQUEST["golf_open_chk"][$num];


        $sql = "update golf_list set golf_sort_no='{$golf_sort1}',golf_open_chk='{$golf_open1}' where no='{$no1}'";
          echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="golf_image"){

    $dir = KS_DATA_DIR."/".KS_GOLF_DIR;
    //echo $dir;
    //exit-1;
    $indate = date("Y-m-d H:i",time());
    $golf_no = $_REQUEST['golf_no'];

    for($i=0; $i<$_POST['image_count']; $i++) {

        if($_FILES['image_'.$i]['tmp_name']!=""){
            $golf_images         = image_upload($_FILES['image_'.$i],$dir,"","");
        }

        $sql = "insert into golf_image (golf_no,golf_image_file_s,golf_image_file_m,indate) values('{$golf_no}','{$golf_images[0]}','{$golf_images[1]}','{$indate}')";
        $db->sql_query($sql);
    }

}else if($case == "golf_delete"){
    $image_dir = "../../".KS_DATA_DIR."/".KS_GOLF_DIR;


    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from golf_list where no='{$no}'";
        $db->sql_query($sql);

        $sql_sel = "select golf_image_file_s,golf_image_file_m from golf_image where golf_no='{$no}'";
        $rs_sel  = $db->sql_query($sql_sel);
        $row_sel = $db->fetch_array($rs_sel);

        unlink($image_dir."/".$row_sel['golf_image_file_s']);
        unlink($image_dir."/".$row_sel['golf_image_file_m']);

        $sql = "delete from golf_image where golf_no='{$no}'";
        $db->sql_query($sql);
        $sql = "delete from golf_hole_amount where golf_no='{$no}'";
        $db->sql_query($sql);
        $sql = "delete from golf_hole_season_amount where golf_no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case == "golf_image_del"){
    $no        = $_REQUEST["img_no"];

    $image_dir = "../../".KS_DATA_DIR."/".KS_GOLF_DIR;
    echo $image_dir;

    $sql_sel = "select golf_image_file_s,golf_image_file_m from golf_image where no='{$no}'";
    $rs_sel  = $db->sql_query($sql_sel);
    $row_sel = $db->fetch_array($rs_sel);

    $sql = "delete from golf_image where no='{$no}'";
    $db->sql_query($sql);

    unlink($image_dir."/".$row_sel['golf_image_file_s']);
    unlink($image_dir."/".$row_sel['golf_image_file_m']);
}else if($case =="golf_update") {
    // print_r($_REQUEST);
    // exit-1;
    $indate = date("Y-m-d H:i", time());


    $no1 = $_REQUEST["no"];
    $golf_name = $_REQUEST["golf_name"];
    $golf_area = $_REQUEST["golf_area"];
    $golf_phone = $_REQUEST["golf_phone"];
    $golf_fax = $_REQUEST["golf_fax"];
    $golf_email = $_REQUEST["golf_email"];
    $golf_address = $_REQUEST["golf_address"];
    $golf_content = $_REQUEST["golf_content"];
    $golf_note = $_REQUEST["golf_note"];
    $golf_timestamp = $_REQUEST["golf_timestamp"];
    $golf_key = $_REQUEST["golf_key"];


    $sql = "update golf_list set 
                                golf_name='{$golf_name}',
                                golf_area='{$golf_area}',
                                golf_phone='{$golf_phone}',
                                golf_fax='{$golf_fax}',
                                golf_email='{$golf_email}',
                                golf_address='{$golf_address}',
                                golf_content='{$golf_content}',
                                golf_note='{$golf_note}',
                                golf_timestamp='{$golf_timestamp}',
                                golf_key='{$golf_key}'
                               
            where no='{$no1}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case == "hole_insert"){

    $no = $_REQUEST["no"];
    $golf_no = $_REQUEST["golf_no"];
    $hole_name = $_REQUEST["hole_name"];

    $sql = "insert into golf_hole_list(golf_no,hole_name) values('{$golf_no}','{$hole_name}')";
    echo $sql;
    $db->sql_query($sql);
    $hole_no = $db->insert_id();
    $sql_amt = "insert into golf_hole_amount(golf_no,hole_no) values('{$golf_no}','{$hole_no}')";
    $db->sql_query($sql_amt);

    $sql_sea = "select no from golf_season_list where golf_no='{$golf_no}' ";
    $rs_sea  = $db->sql_query($sql_sea);
    while ($row_sea = $db->fetch_array($rs_sea)) {
        $sql_season = "insert into golf_season_amount (golf_no,hole_no,golf_season_no) values('{$golf_no}','{$hole_no}','{$row_sea['no']}')";
        //  echo $sql_amount;
        $db->sql_query($sql_season);
    }

}else if($case == "hole_update"){
    $no = $_REQUEST["no"];
    $golf_name = $_REQUEST["golf_name"];


    $sql = "update golf_hole_list set hole_name='{$golf_name}' where no='{$no}'";
    $db->sql_query($sql);

}else if($case == "hole_delete"){
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST["no"][$num];

        $sql = "delete from golf_hole_list where no='{$no}'";
        $db->sql_query($sql);

        $sql = "delete from golf_hole_amount where hole_no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case=="season_all_up"){
    //print_r($_REQUEST);

    $indate  = date("Y-m-d H:i",time());
    $mode  = $_REQUEST['mode'];
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];

        $golf_amount_basic = get_comma($_REQUEST['golf_amount_basic'][$num]);
        $golf_amount_basic_week = get_comma($_REQUEST['golf_amount_basic_week'][$num]);
        $golf_amount_amount = get_comma($_REQUEST['golf_amount_amount'][$num]);
        $golf_amount_amount_week = get_comma($_REQUEST['golf_amount_amount_week'][$num]);
        $golf_amount_deposit = get_comma($_REQUEST['golf_amount_deposit'][$num]);
        $golf_amount_deposit_week = get_comma($_REQUEST['golf_amount_deposit_week'][$num]);

        if($_REQUEST["week"][$i]!=""){
            $golf_amount_week = implode(",", $_REQUEST["week"][$i]);
        }

        if ($mode == "") {

            $sql = "update golf_hole_amount set 
                                              hole_amount_basic='{$golf_amount_basic}',
                                              hole_amount_basic_week='{$golf_amount_basic_week}',
                                              hole_amount='{$golf_amount_amount}',
                                              hole_amount_week='{$golf_amount_amount_week}',
                                              hole_amount_deposit='{$golf_amount_deposit}',
                                              hole_amount_deposit_week='{$golf_amount_deposit_week}',
                                              hole_week='{$golf_amount_week}'
                        where no='{$no1}'";
        }else{
            $golf_season_open = $_REQUEST['golf_season_open'][$num];
            $sql = "update golf_hole_amount_season set 
                                          hole_season_amount_basic='{$golf_amount_basic}',
                                          hole_season_amount_basic_week='{$golf_amount_basic_week}',
                                          hole_season_amount='{$golf_amount_amount}',
                                          hole_season_amount_week='{$golf_amount_amount_week}',
                                          hole_season_amount_deposit='{$golf_amount_deposit}',
                                          hole_season_amount_deposit_week='{$golf_amount_deposit_week}',
                                          hole_season_week='{$golf_amount_week}',
                                          hole_season_amount_open = '{$golf_season_open}'
                                         
                    where no='{$no1}'";

        }
        echo $sql;
        $db->sql_query($sql);
    }

}else if($case=="season_insert") {

    $indate = date("Y-m-d H:i", time());
    $golf_no = $_REQUEST["golf_no"];
    $golf_season_name = $_REQUEST["golf_season_name"];
    $golf_season_start_date = $_REQUEST["golf_season_start_date"];
    $golf_season_end_date = $_REQUEST["golf_season_end_date"];

    $sql_list = "insert into golf_season_list(golf_no,
                                               golf_season_name,
                                               golf_season_start_date,
                                               golf_season_end_date,
                                               indate) 
                    VALUES('{$golf_no}',
                            '{$golf_season_name}',
                            '{$golf_season_start_date}',
                            '{$golf_season_end_date}',
                            '{$indate}'
                            ) ";
    echo $sql_list;
    $db->sql_query($sql_list);
    $season_id = $db->insert_id();
    $sql_golf = "select no,golf_no from golf_hole_list where golf_no='{$golf_no}'  order by no asc";
    $rs_golf  = $db->sql_query($sql_golf);
    while($row_golf = $db->fetch_array($rs_golf)) {
        $sql = "insert into golf_hole_amount_season(golf_no,
                                               hole_no,
                                               golf_season_no,
                                               indate) 
                    VALUES('{$golf_no}',
                            '{$row_golf['no']}',
                            '{$season_id}',
                            '{$indate}'
                            ) ";
        echo $sql;
        $db->sql_query($sql);
    }


}else if($case=="season_del") {

    $no        = $_REQUEST["no"];
    $sql = "delete from golf_season_list where no='{$no}'";
    $db->sql_query($sql);

    $sql = "delete from golf_hole_amount_season where golf_season_no='{$no}'";
    $db->sql_query($sql);
}else if($case=="margin_insert") {


    $golf_no = $_REQUEST['golf_no'];
    $season_no = $_REQUEST['season_no'];
    $mode = $_REQUEST['mode'];
    $no = $_REQUEST['no'];
    $margin_basic = get_comma($_REQUEST['margin_basic']);
    $margin_amount = get_comma($_REQUEST['margin_amount']);


    if ($mode == "") {
        $sql_amount = "select no,hole_amount_deposit,hole_amount_deposit_week from golf_hole_amount where golf_no='{$golf_no}'";
        $rs_amount  = $db->sql_query($sql_amount);
        while($row_amount = $db->fetch_array($rs_amount)){
            $result_amount[] = $row_amount;
        }
        $sql_margin = "select count(no) as cnt from golf_hole_amount_margin where golf_no='{$golf_no}' and golf_margin_mode!='season' ";
        $rs_margin  = $db->sql_query($sql_margin);
        $row_margin = $db->fetch_array($rs_margin);

        if($row_margin['cnt'] > 0){
            $sql_margin_up = "update golf_hole_amount_margin set golf_amount_margin_basic='{$margin_basic}',golf_amount_margin_amount='{$margin_amount}' where no='{$no}'";
            $db->sql_query($sql_margin_up);
        }else{
            $sql_margin_in = "insert into golf_hole_amount_margin (golf_no,golf_amount_margin_basic,golf_amount_margin_amount) values('{$golf_no}','{$margin_basic}','{$margin_amount}')";
            $db->sql_query($sql_margin_in);

        }
        foreach ($result_amount as $amount){

            $golf_amount_basic = $amount['hole_amount_deposit'] + $margin_basic;
            $golf_amount_basic_week = $amount['hole_amount_deposit_week'] + $margin_basic;
            $golf_amount = $amount['hole_amount_deposit'] + $margin_amount;
            $golf_amount_week = $amount['hole_amount_deposit_week'] + $margin_amount;


            $sql = "update golf_hole_amount set 
                                              hole_amount_basic='{$golf_amount_basic}',
                                              hole_amount_basic_week='{$golf_amount_basic_week}',
                                              hole_amount='{$golf_amount}',
                                              hole_amount_week='{$golf_amount_week}'
                        where no='{$amount['no']}'";
            $db->sql_query($sql);

        }

    }else{
        $sql_amount = "select no,hole_season_amount_deposit,hole_season_amount_deposit_week from golf_hole_amount_season where golf_no='{$golf_no}' and golf_season_no='{$season_no}'";
      //  echo $sql_amount;
        $rs_amount  = $db->sql_query($sql_amount);
        while($row_amount = $db->fetch_array($rs_amount)){
            $result_amount[] = $row_amount;
        }
        // print_r($result_amount);
        $sql_margin = "select count(no) as cnt from golf_hole_amount_margin where golf_no='{$golf_no}' and season_no='{$season_no}' and golf_margin_mode='season'  ";
    //    echo $sql_margin;
        $rs_margin  = $db->sql_query($sql_margin);
        $row_margin = $db->fetch_array($rs_margin);

        if($row_margin['cnt'] > 0){
            $sql_margin_up = "update golf_hole_amount_margin set golf_amount_margin_basic='{$margin_basic}',golf_amount_margin_amount='{$margin_amount}' where no='{$no}'";
           // echo $sql_margin_up;
            $db->sql_query($sql_margin_up);
        }else{
            $sql_margin_in = "insert into golf_hole_amount_margin (golf_no,season_no,golf_margin_mode,golf_amount_margin_basic,golf_amount_margin_amount) values('{$golf_no}','{$season_no}','season','{$margin_basic}','{$margin_amount}')";
            $db->sql_query($sql_margin_in);

        }

        foreach ($result_amount as $amount) {

            //  echo $amount['lodging_season_deposit'];
            $hole_season_amount_basic = ((int)$amount['hole_season_amount_deposit'] + $margin_basic);
            $hole_season_amount_basic_week = ((int)$amount['hole_season_amount_deposit_week'] + $margin_basic);
            $hole_season_amount = ((int)$amount['hole_season_amount_deposit'] + $margin_amount);
            $hole_season_amount_week = ((int)$amount['hole_season_amount_deposit_week'] + $margin_amount);

            $sql = "update golf_hole_amount_season set 
                                          hole_season_amount_basic='{$hole_season_amount_basic}',
                                          hole_season_amount_basic_week='{$hole_season_amount_basic_week}',
                                          hole_season_amount='{$hole_season_amount}',
                                          hole_season_amount_week='{$hole_season_amount_week}'
                                          
                                          
                    where no='{$amount['no']}' and golf_season_no='{$season_no}'";
            echo $sql;
            $db->sql_query($sql);
        }
    }
}else if($case =="season_up") {


    $no = $_REQUEST["s_no"];
    $golf_season_name = $_REQUEST["golf_season_name_up"];
    $golf_season_start_date = $_REQUEST["golf_season_start_date_up"];
    $golf_season_end_date = $_REQUEST["golf_season_end_date_up"];


    $sql = "update golf_season_list 
                set 
                        
                        golf_season_name           ='{$golf_season_name}',
                        golf_season_start_date     ='{$golf_season_start_date}',
                        golf_season_end_date       ='{$golf_season_end_date}'
                where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}

?>