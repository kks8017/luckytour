<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$case = $_REQUEST['case'];

if($case =="tel_insert"){

    $lodging_name = $_REQUEST['lodging_name'];
    $lodging_type = $_REQUEST['lodging_type'];
    $lodging_area = $_REQUEST['lodging_area'];

    $sql = "insert into lodging_list (lodging_name,lodging_type,lodging_area) value('{$lodging_name}','{$lodging_type}','{$lodging_area}')";
    $db->sql_query($sql);
    $insert_id = $db->insert_id();
    $sql_amount = "insert into lodging_amount_margin (lodging_no) values('{$insert_id}')";
    $db->sql_query($sql_amount);

}else if($case =="tel_all_update"){
     print_r($_REQUEST);
    //exit-1;
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $lodging_sort1    = $_REQUEST["lodging_sort"][$num] ;
        $lodging_open1    = $_REQUEST["lodging_open_".$num];
        $lodging_recomm1 = $_REQUEST["lodging_recomm_".$num];
        $lodging_event1 = $_REQUEST["lodging_event"][$num];

        $sql = "update lodging_list set lodging_sort='{$lodging_sort1}',lodging_open='{$lodging_open1}',lodging_recomm='{$lodging_recomm1}',lodging_event='{$lodging_event1}' where no='{$no1}'";
          echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="tel_update") {
    //   echo "aaaaa";
      print_r($_POST);
    // exit-1;
    $indate = date("Y-m-d H:i", time());


    $no1 = $_REQUEST["no"];
    $lodging_name = $_REQUEST["lodging_name"];
    $lodging_type = $_REQUEST["lodging_type"];
    $lodging_area = $_REQUEST["lodging_area"];
    $lodging_address = $_REQUEST["lodging_address"];
    $lodging_manager_phone = $_REQUEST["lodging_manager_phone"];
    $lodging_real_phone = $_REQUEST["lodging_real_phone"];
    $lodging_manager_fax = $_REQUEST["lodging_manager_fax"];
    $lodging_real_fax = $_REQUEST["lodging_real_fax"];
    $lodging_manager_email = $_REQUEST["lodging_manager_email"];
    $lodging_real_email = $_REQUEST["lodging_real_email"];
    $lodging_account = $_REQUEST["lodging_account"];
    $lodging_theme = $_REQUEST["lodging_thema"];

    $lodging_content = $_REQUEST["lodging_content"];
    // echo htmlspecialchars($_POST["lodging_content"]);
    $lodging_additional = $_REQUEST["lodging_additional"];
    $lodging_facility = $_REQUEST["lodging_facility"];
    $lodging_timestamp = $_REQUEST["lodging_timestamp"];
    $lodging_key = $_REQUEST["lodging_key"];


    $sql = "update lodging_list set 
                                lodging_name='{$lodging_name}',
                                lodging_type='{$lodging_type}',
                                lodging_area='{$lodging_area}',
                                lodging_address='{$lodging_address}',
                                lodging_manager_phone='{$lodging_manager_phone}',
                                lodging_real_phone='{$lodging_real_phone}',
                                lodging_manager_fax='{$lodging_manager_fax}',
                                lodging_real_fax='{$lodging_real_fax}',
                                lodging_manager_email='{$lodging_manager_email}',
                                lodging_real_email='{$lodging_real_email}',
                                lodging_account='{$lodging_account}',
                                lodging_theme='{$lodging_theme}',
                                lodging_content='{$lodging_content}',
                                lodging_additional='{$lodging_additional}',
                                lodging_facility='{$lodging_facility}',
                                lodging_timestamp='{$lodging_timestamp}',
                                lodging_key='{$lodging_key}'
            where no='{$no1}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case =="tel_image"){
    print_r( $_FILES);
    $dir = KS_DATA_DIR."/".KS_LOD_DIR;
    //echo $dir;
    //exit-1;
    $indate = date("Y-m-d H:i",time());
    $lodging_no = $_REQUEST['lodging_no'];

    for($i=0; $i<$_POST['image_count']; $i++) {
        // echo $_FILES['image_'.$i]['name'];
        if($_FILES['image_'.$i]['tmp_name']!=""){
            $lod_images         = image_upload($_FILES['image_'.$i],$dir,"","");
        }

        $sql = "insert into lodging_image (lodging_no,lodging_image_file_s,lodging_image_file_m,indate) values('{$lodging_no}','{$lod_images[0]}','{$lod_images[1]}','{$indate}')";
        echo $sql;
        $db->sql_query($sql);
    }

}else if($case == "tel_delete"){
    $image_dir = "../../".KS_DATA_DIR."/".KS_LOD_DIR;
    $image_room_dir = "../../".KS_DATA_DIR."/".KS_ROOM_DIR;

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no        = $_REQUEST["no"][$num] ;

        $sql = "delete from lodging_list where no='{$no}'";
        $db->sql_query($sql);

        $sql_sel = "select lodging_image_file_s,lodging_image_file_m from lodging_image where lodging_no='{$no}'";
        $rs_sel  = $db->sql_query($sql_sel);
        $row_sel = $db->fetch_array($rs_sel);

        unlink($image_dir."/".$row_sel['lodging_image_file_s']);
        unlink($image_dir."/".$row_sel['lodging_image_file_m']);

        $sql = "delete from lodging_image where lodging_no='{$no}'";
        $db->sql_query($sql);



        $sql_room = "select lodging_room_no,lodging_room_image_file_s,lodging_room_image_file_m  from lodging_room,lodging_room_image where lodging_room_image.lodging_room_no=lodging_room.no and lodging_no='{$no}'";
        $rs_room  = $db->sql_query($sql_room);
        while($row_room = $db->fetch_array($rs_room)) {

            unlink($image_room_dir . "/" . $row_room['lodging_room_image_file_s']);
            unlink($image_room_dir . "/" . $row_room['lodging_room_image_file_m']);
            $sql = "delete from lodging_room_image where lodging_room_no='{$row_room['lodging_room_no']}'";
            $db->sql_query($sql);
        }

        $sql = "delete from lodging_room where lodging_no='{$no}'";
        $db->sql_query($sql);


        $sql = "delete from lodging_amount where lodging_no='{$no}'";
        $db->sql_query($sql);

        $sql = "delete from lodging_season_amount where lodging_no='{$no}'";
        $db->sql_query($sql);
    }
}else if($case == "tel_image_del"){
    $no        = $_REQUEST["img_no"];

    $image_dir = "../../".KS_DATA_DIR."/".KS_LOD_DIR;
    echo $image_dir;

    $sql_sel = "select lodging_image_file_s,lodging_image_file_m from lodging_image where no='{$no}'";
    $rs_sel  = $db->sql_query($sql_sel);
    $row_sel = $db->fetch_array($rs_sel);

    $sql = "delete from lodging_image where no='{$no}'";
    $db->sql_query($sql);

    unlink($image_dir."/".$row_sel['lodging_image_file_s']);
    unlink($image_dir."/".$row_sel['lodging_image_file_m']);
}else if($case =="room_insert"){

    $dir = KS_DATA_DIR."/".KS_ROOM_DIR;
    //echo $dir;
    //exit-1;
    $indate = date("Y-m-d H:i",time());
    $lodging_no = $_REQUEST['lodging_no'];
    $lodging_room_name = $_REQUEST['lodging_room_name'];
    $lodging_room_min = $_REQUEST['lodging_room_min'];
    $lodging_room_max = $_REQUEST['lodging_room_max'];
    $lodging_room_structure = $_REQUEST['lodging_room_structure'];
    $lodging_room_satisfy = $_REQUEST['lodging_room_satisfy'];
    $lodging_room_view = $_REQUEST['lodging_room_view'];

    $sql = "insert into lodging_room (lodging_no,lodging_room_name,lodging_room_min,lodging_room_max,lodging_room_structure,lodging_room_satisfy,lodging_room_view,indate) 
            values('{$lodging_no}','{$lodging_room_name}','{$lodging_room_min}','{$lodging_room_max}','{$lodging_room_structure}','{$lodging_room_satisfy}','{$lodging_room_view}','{$indate}')";
    //echo $sql;
    $db->sql_query($sql);
    $lodging_room_no  = $db->insert_id();
    $sql_amount = "insert into lodging_amount (lodging_no,lodging_room_no) values('{$lodging_no}','{$lodging_room_no}')";
    //  echo $sql_amount;
    $db->sql_query($sql_amount);
    $sql_sea = "select no from lodging_season_list where lodging_no='{$lodging_no}' ";
    $rs_sea  = $db->sql_query($sql_sea);
    while ($row_sea = $db->fetch_array($rs_sea)) {
        $sql_season = "insert into lodging_season_amount (lodging_no,lodging_room_no,lodging_season_no) values('{$lodging_no}','{$lodging_room_no}','{$row_sea['no']}')";
        //  echo $sql_amount;
        $db->sql_query($sql_season);
    }
    for($i=0; $i<$_POST['image_count']; $i++) {

        if($_FILES['image_'.$i]['tmp_name']!=""){
            $lod_images         = image_upload($_FILES['image_'.$i],$dir,"","");
        }

        $sql_img = "insert into lodging_room_image (lodging_room_no,lodging_room_image_file_s,lodging_room_image_file_m,indate) values('{$lodging_room_no}','{$lod_images[0]}','{$lod_images[1]}','{$indate}')";
        echo $sql_img;
        $db->sql_query($sql_img);
    }


}else if($case == "room_image_del"){
    $no        = $_REQUEST["no"];

    $image_dir = "../../".KS_DATA_DIR."/".KS_ROOM_DIR;

    $sql_sel = "select lodging_room_image_file_s,lodging_room_image_file_m from lodging_room_image where no='{$no}'";

    $rs_sel  = $db->sql_query($sql_sel);
    $row_sel = $db->fetch_array($rs_sel);
    unlink($image_dir."/".$row_sel['lodging_room_image_file_s']);
    unlink($image_dir."/".$row_sel['lodging_room_image_file_m']);

    $sql = "delete from lodging_room_image where no='{$no}'";
    $db->sql_query($sql);

}else if($case =="room_up"){

    $dir = KS_DATA_DIR."/".KS_ROOM_DIR;
    //echo $dir;
    //exit-1;
    //print_r($_REQUEST);
    //exit-1;
    $indate = date("Y-m-d H:i",time());
    $no = $_REQUEST['no'];
    $lodging_room_name = $_REQUEST['lodging_room_name'];
    $lodging_room_min = $_REQUEST['lodging_room_min'];
    $lodging_room_max = $_REQUEST['lodging_room_max'];
    $lodging_room_structure = $_REQUEST['lodging_room_structure'];
    $lodging_room_satisfy = $_REQUEST['lodging_room_satisfy'];
    $lodging_room_view = $_REQUEST['lodging_room_view'];

    $sql = "update lodging_room set lodging_room_name='{$lodging_room_name}',
                                      lodging_room_min='{$lodging_room_min}',
                                      lodging_room_max='{$lodging_room_max}',
                                      lodging_room_structure='{$lodging_room_structure}',
                                      lodging_room_satisfy='{$lodging_room_satisfy}',
                                      lodging_room_view='{$lodging_room_view}' 
            where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
    for($i=0; $i<$_POST['image_count']; $i++) {

        if($_FILES['image_'.$i]['tmp_name']!=""){
            $lod_images         = image_upload($_FILES['image_'.$i],$dir,"","");
            $sql_img = "insert into lodging_room_image (lodging_room_no,lodging_room_image_file_s,lodging_room_image_file_m,indate) values('{$no}','{$lod_images[0]}','{$lod_images[1]}','{$indate}')";
            echo $sql_img;
            $db->sql_query($sql_img);
        }

    }
}else if($case =="room_all_update"){
    // print_r($_REQUEST);
    //exit-1;
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $lodging_sort1    = $_REQUEST["lodging_room_sort"][$num] ;
        $lodging_open1    = $_REQUEST["lodging_room_open"][$num];


        $sql = "update lodging_room set lodging_room_sort='{$lodging_sort1}',lodging_room_open='{$lodging_open1}' where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "room_delete") {
    $image_dir = "../../" . KS_DATA_DIR . "/" . KS_ROOM_DIR;
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST["no"][$num];

        $sql = "delete from lodging_room where no='{$no}'";
        $db->sql_query($sql);
    }
    $sql_sel = "select lodging_room_image_file_s,lodging_room_image_file_m from lodging_room_image where no='{$no}'";

    $rs_sel = $db->sql_query($sql_sel);
    while ($row_sel = $db->fetch_array($rs_sel)) {
        unlink($image_dir . "/" . $row_sel['lodging_room_image_file_s']);
        unlink($image_dir . "/" . $row_sel['lodging_room_image_file_m']);
    }

    $sql_img = "delete from lodging_room_image where lodging_room_no='{$no}'";
    $db->sql_query($sql_img);

    $sql_amount = "delete from lodging_amount where lodging_room_no='{$no}'";
    $db->sql_query($sql_amount);
    $sql_season = "delete from lodging_season_amount where lodging_room_no='{$no}'";
    $db->sql_query($sql_season);
}else if($case=="season_all_up"){
    //print_r($_REQUEST);

    $indate  = date("Y-m-d H:i",time());
    $mode  = $_REQUEST['mode'];
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num = $_REQUEST["sel"][$i];
        $no1 = $_REQUEST["no"][$num];

        $lodging_amount_basic = get_comma($_REQUEST['lodging_amount_basic'][$num]);
        $lodging_amount_basic_week = get_comma($_REQUEST['lodging_amount_basic_week'][$num]);
        $lodging_amount_tel = get_comma($_REQUEST['lodging_amount_tel'][$num]);
        $lodging_amount_tel_week = get_comma($_REQUEST['lodging_amount_tel_week'][$num]);
        $lodging_amount_airtel = get_comma($_REQUEST['lodging_amount_airtel'][$num]);
        $lodging_amount_airtel_week = get_comma($_REQUEST['lodging_amount_airtel_week'][$num]);
        $lodging_amount_aircartel = get_comma($_REQUEST['lodging_amount_aircartel'][$num]);
        $lodging_amount_aircartel_week = get_comma($_REQUEST['lodging_amount_aircartel_week'][$num]);
        $lodging_amount_deposit = get_comma($_REQUEST['lodging_amount_deposit'][$num]);
        $lodging_amount_deposit_week = get_comma($_REQUEST['lodging_amount_deposit_week'][$num]);
        $lodging_amount_adult_add = get_comma($_REQUEST['lodging_amount_adult_add'][$num]);
        $lodging_amount_child_add = get_comma($_REQUEST['lodging_amount_child_add'][$num]);

        if($_REQUEST["week"][$i]!=""){
            $lodging_amount_week = implode(",", $_REQUEST["week"][$i]);
        }

        if ($mode == "") {

            $sql = "update lodging_amount set 
                                              lodging_amount_basic='{$lodging_amount_basic}',
                                              lodging_amount_basic_week='{$lodging_amount_basic_week}',
                                              lodging_amount_tel='{$lodging_amount_tel}',
                                              lodging_amount_tel_week='{$lodging_amount_tel_week}',
                                              lodging_amount_airtel='{$lodging_amount_airtel}',
                                              lodging_amount_airtel_week='{$lodging_amount_airtel_week}',
                                              lodging_amount_aircartel='{$lodging_amount_aircartel}',
                                              lodging_amount_aircartel_week='{$lodging_amount_aircartel_week}',
                                              lodging_amount_deposit='{$lodging_amount_deposit}',
                                              lodging_amount_deposit_week='{$lodging_amount_deposit_week}',
                                              lodging_amount_adult_add='{$lodging_amount_adult_add}',
                                              lodging_amount_child_add='{$lodging_amount_child_add}',
                                              lodging_week='{$lodging_amount_week}'
                        where no='{$no1}'";
        }else{
            $lodging_amount_open = $_REQUEST['lodging_season_open'][$num];
            $sql = "update lodging_season_amount set
                                          lodging_season_basic='{$lodging_amount_basic}',
                                          lodging_season_basic_week='{$lodging_amount_basic_week}', 
                                          lodging_season_tel='{$lodging_amount_tel}',
                                          lodging_season_tel_week='{$lodging_amount_tel_week}',
                                          lodging_season_airtel='{$lodging_amount_airtel}',
                                          lodging_season_airtel_week='{$lodging_amount_airtel_week}',
                                          lodging_season_aircartel='{$lodging_amount_aircartel}',
                                          lodging_season_aircartel_week='{$lodging_amount_aircartel_week}',
                                          lodging_season_deposit='{$lodging_amount_deposit}',
                                          lodging_season_deposit_week='{$lodging_amount_deposit_week}',
                                          lodging_season_adult_add='{$lodging_amount_adult_add}',
                                          lodging_season_child_add='{$lodging_amount_child_add}',
                                          lodging_season_open='{$lodging_amount_open}',
                                          lodging_season_week='{$lodging_amount_week}'
                    where no='{$no1}'";

        }
        echo $sql;
        $db->sql_query($sql);
    }

}else if($case=="season_insert") {

    $indate = date("Y-m-d H:i", time());
    $lodging_no = $_REQUEST["lodging_no"];
    $season_no = $_REQUEST["lodging_season_no"];
    $lodging_season_name = $_REQUEST["lodging_season_name"];
    $lodging_season_start_date = $_REQUEST["lodging_season_start_date"];
    $lodging_season_end_date = $_REQUEST["lodging_season_end_date"];

    $sql_list = "insert into lodging_season_list(lodging_no,
                                               lodging_season_name,
                                               lodging_season_start_date,
                                               lodging_season_end_date,
                                               indate) 
                    VALUES('{$lodging_no}',
                            '{$lodging_season_name}',
                            '{$lodging_season_start_date}',
                            '{$lodging_season_end_date}',
                            '{$indate}'
                            ) ";
    echo $sql_list;
    $db->sql_query($sql_list);
    $season_id = $db->insert_id();
    $sql_room = "select no,lodging_no from lodging_room where lodging_no='{$lodging_no}'  order by no asc";
    $rs_room  = $db->sql_query($sql_room);
    while($row_room = $db->fetch_array($rs_room)) {
        if($season_no!=""){
            $sql_copy = "select * from lodging_season_amount where lodging_no='{$lodging_no}' and  lodging_room_no='{$row_room['no']}' and lodging_season_no='{$season_no}'  order by no asc";
            $rs_copy  = $db->sql_query($sql_copy);
            $row_copy  = $db->fetch_array($rs_copy);
            $sql = "insert into lodging_season_amount(lodging_no,
                                               lodging_room_no,
                                               lodging_season_no,
                                               lodging_season_basic,
                                               lodging_season_basic_week,
                                               lodging_season_tel,
                                               lodging_season_airtel,
                                               lodging_season_aircartel,
                                               lodging_season_tel_week,
                                               lodging_season_airtel_week,
                                               lodging_season_aircartel_week,
                                               lodging_season_deposit,
                                               lodging_season_deposit_week,
                                               lodging_season_adult_add,
                                               lodging_season_child_add,
                                               lodging_season_week,
                                               indate) 
                    VALUES('{$lodging_no}',
                            '{$row_room['no']}',
                            '{$season_id}',
                            '{$row_copy['lodging_season_basic']}',
                            '{$row_copy['lodging_season_basic_week']}',
                            '{$row_copy['lodging_season_tel']}',
                            '{$row_copy['lodging_season_airtel']}',
                            '{$row_copy['lodging_season_aircartel']}',
                            '{$row_copy['lodging_season_tel_week']}',
                            '{$row_copy['lodging_season_airtel_week']}',
                            '{$row_copy['lodging_season_aircartel_week']}',
                            '{$row_copy['lodging_season_deposit']}',
                            '{$row_copy['lodging_season_deposit_week']}',
                            '{$row_copy['lodging_season_adult_add']}',
                            '{$row_copy['lodging_season_child_add']}',
                            '{$row_copy['lodging_season_week']}',
                            '{$indate}'
                            ) ";
            echo $sql;
            $db->sql_query($sql);

        }else{
            $sql_copy = "select * from lodging_amount where lodging_no='{$lodging_no}' and  lodging_room_no='{$row_room['no']}'   order by no asc";
            echo $sql_copy;
            $rs_copy  = $db->sql_query($sql_copy);
            $row_copy  = $db->fetch_array($rs_copy);
            $sql = "insert into lodging_season_amount(lodging_no,
                                               lodging_room_no,
                                               lodging_season_no,
                                               lodging_season_basic,
                                               lodging_season_basic_week,
                                               lodging_season_tel,
                                               lodging_season_airtel,
                                               lodging_season_aircartel,
                                               lodging_season_tel_week,
                                               lodging_season_airtel_week,
                                               lodging_season_aircartel_week,
                                               lodging_season_deposit,
                                               lodging_season_deposit_week,
                                               lodging_season_adult_add,
                                               lodging_season_child_add,
                                               lodging_season_week,
                                               indate) 
                    VALUES('{$lodging_no}',
                            '{$row_room['no']}',
                            '{$season_id}',
                            '{$row_copy['lodging_amount_basic']}',
                            '{$row_copy['lodging_amount_basic_week']}',
                            '{$row_copy['lodging_amount_tel']}',
                            '{$row_copy['lodging_amount_airtel']}',
                            '{$row_copy['lodging_amount_aircartel']}',
                            '{$row_copy['lodging_amount_tel_week']}',
                            '{$row_copy['lodging_amount_airtel_week']}',
                            '{$row_copy['lodging_amount_aircartel_week']}',
                            '{$row_copy['lodging_amount_deposit']}',
                            '{$row_copy['lodging_amount_deposit_week']}',
                            '{$row_copy['lodging_amount_adult_add']}',
                            '{$row_copy['lodging_amount_child_add']}',
                            '{$row_copy['lodging_week']}',
                            '{$indate}'
                            ) ";
            echo $sql;
            $db->sql_query($sql);


        }


    }


}else if($case=="season_del") {

    $no        = $_REQUEST["no"];
    $sql = "delete from lodging_season_list where no='{$no}'";
    $db->sql_query($sql);

    $sql = "delete from lodging_season_amount where lodging_season_no='{$no}'";
    $db->sql_query($sql);
}else if($case=="margin_insert") {
    print_r($_POST);

    $lodging_no = $_REQUEST['lodging_no'];
    $season_no = $_REQUEST['season_no'];
    $mode = $_REQUEST['mode'];
    $no = $_REQUEST['no'];
    $margin_basic = get_comma($_REQUEST['margin_basic']);
    $margin_tel = get_comma($_REQUEST['margin_tel']);
    $margin_airtel = get_comma($_REQUEST['margin_airtel']);
    $margin_aircartel = get_comma($_REQUEST['margin_aircartel']);
    $margin_adult = get_comma($_REQUEST['margin_amount_adult_add']);
    $margin_child = get_comma($_REQUEST['margin_amount_child_add']);
    $lodging_amount_week = implode(",", $_REQUEST["margin_week"]);

    if ($mode == "") {
        $sql_amount = "select no,lodging_amount_deposit,lodging_amount_deposit_week from lodging_amount where lodging_no='{$lodging_no}'";
        $rs_amount  = $db->sql_query($sql_amount);
        while($row_amount = $db->fetch_array($rs_amount)){
            $result_amount[] = $row_amount;
        }
        $sql_margin = "select count(no) as cnt from lodging_amount_margin where lodging_no='{$lodging_no}' and lodging_margin_mode!='season' ";
        //   echo $sql_margin;
        $rs_margin  = $db->sql_query($sql_margin);
        $row_margin = $db->fetch_array($rs_margin);

        if($row_margin['cnt'] > 0){
            $sql_margin_up = "update lodging_amount_margin set lodging_amount_margin_basic='{$margin_basic}',lodging_amount_margin_tel='{$margin_tel}',lodging_amount_margin_airtel='{$margin_airtel}',lodging_amount_margin_aircartel='{$margin_aircartel}',lodging_amount_margin_adult='{$margin_adult}',lodging_amount_margin_child='{$margin_child}',lodging_amount_margin_week='{$lodging_amount_week}' where no='{$no}'";
            //  echo $sql_margin_up;
            $db->sql_query($sql_margin_up);
        }else{
            $sql_margin_in = "insert into lodging_amount_margin (lodging_no,lodging_amount_margin_basic,lodging_amount_margin_tel,lodging_amount_margin_airtel,lodging_amount_margin_aircartel,lodging_amount_margin_adult,lodging_amount_margin_child,lodging_amount_margin_week) values('{$lodging_no}','{$margin_basic}','{$margin_tel}','{$margin_airtel}','{$margin_aircartel}','{$margin_adult}','{$margin_child}','{$lodging_amount_week}')";
            // echo $sql_margin_in;
            $db->sql_query($sql_margin_in);

        }
        foreach ($result_amount as $amount){
            $lodging_amount_basic = $amount['lodging_amount_deposit'] + $margin_basic;
            $lodging_amount_basic_week = $amount['lodging_amount_deposit_week'] + $margin_basic;
            $lodging_amount_tel = $amount['lodging_amount_deposit'] + $margin_tel;
            $lodging_amount_tel_week = $amount['lodging_amount_deposit_week'] + $margin_tel;
            $lodging_amount_airtel = $amount['lodging_amount_deposit'] + $margin_airtel;
            $lodging_amount_airtel_week = $amount['lodging_amount_deposit_week'] + $margin_airtel;
            $lodging_amount_aircartel = $amount['lodging_amount_deposit'] + $margin_aircartel;
            $lodging_amount_aircartel_week = $amount['lodging_amount_deposit_week'] + $margin_aircartel;

            $sql = "update lodging_amount set 
                                              lodging_amount_basic='{$lodging_amount_basic}',
                                              lodging_amount_basic_week='{$lodging_amount_basic_week}',
                                              lodging_amount_tel='{$lodging_amount_tel}',
                                              lodging_amount_tel_week='{$lodging_amount_tel_week}',
                                              lodging_amount_airtel='{$lodging_amount_airtel}',
                                              lodging_amount_airtel_week='{$lodging_amount_airtel_week}',
                                              lodging_amount_aircartel='{$lodging_amount_aircartel}',
                                              lodging_amount_aircartel_week='{$lodging_amount_aircartel_week}',
                                              lodging_amount_adult_add='{$margin_adult}',
                                              lodging_amount_child_add='{$margin_child}',
                                              lodging_week='{$lodging_amount_week}'
                              
                        where no='{$amount['no']}'";
            $db->sql_query($sql);

        }





    }else{
        $sql_amount = "select no,lodging_season_deposit,lodging_season_deposit_week from lodging_season_amount where lodging_no='{$lodging_no}' and lodging_season_no='{$season_no}'";
        echo $sql_amount;
        $rs_amount  = $db->sql_query($sql_amount);
        while($row_amount = $db->fetch_array($rs_amount)){
            $result_amount[] = $row_amount;
        }
        // print_r($result_amount);
        $sql_margin = "select count(no) as cnt from lodging_amount_margin where lodging_no='{$lodging_no}' and lodging_season_no='{$season_no}' and lodging_margin_mode='season'  ";

        $rs_margin  = $db->sql_query($sql_margin);
        $row_margin = $db->fetch_array($rs_margin);

        if($row_margin['cnt'] > 0){
            $sql_margin_up = "update lodging_amount_margin set lodging_amount_margin_basic='{$margin_basic}',lodging_amount_margin_tel='{$margin_tel}',lodging_amount_margin_airtel='{$margin_airtel}',lodging_amount_margin_aircartel='{$margin_aircartel}',lodging_amount_margin_adult='{$margin_adult}',lodging_amount_margin_child='{$margin_child}',lodging_amount_margin_week='{$lodging_amount_week}' where no='{$no}'";
            echo $sql_margin_up;
            $db->sql_query($sql_margin_up);
        }else{
            $sql_margin_in = "insert into lodging_amount_margin (lodging_no,lodging_amount_margin_basic,lodging_amount_margin_tel,lodging_amount_margin_airtel,lodging_amount_margin_aircartel,lodging_margin_mode,lodging_season_no,lodging_amount_margin_adult,lodging_amount_margin_child,lodging_amount_margin_week) values('{$lodging_no}','{$margin_basic}','{$margin_tel}','{$margin_airtel}','{$margin_aircartel}','season','{$season_no}','{$margin_adult}','{$margin_child}','{$lodging_amount_week}')";
            $db->sql_query($sql_margin_in);

        }

        foreach ($result_amount as $amount) {

            //  echo $amount['lodging_season_deposit'];
            $lodging_amount_basic = ((int)$amount['lodging_season_deposit'] + $margin_basic);
            $lodging_amount_basic_week = ((int)$amount['lodging_season_deposit_week'] + $margin_basic);
            $lodging_amount_tel = ((int)$amount['lodging_season_deposit'] + $margin_tel);
            $lodging_amount_tel_week = ((int)$amount['lodging_season_deposit_week'] + $margin_tel);
            $lodging_amount_airtel = ((int)$amount['lodging_season_deposit'] + $margin_airtel);
            $lodging_amount_airtel_week = ((int)$amount['lodging_season_deposit_week'] + $margin_airtel);
            $lodging_amount_aircartel = ((int)$amount['lodging_season_deposit'] + $margin_aircartel);
            $lodging_amount_aircartel_week = ((int)$amount['lodging_season_deposit_week'] + $margin_aircartel);

            $sql = "update lodging_season_amount set
                                          lodging_season_basic='{$lodging_amount_basic}',
                                          lodging_season_basic_week='{$lodging_amount_basic_week}', 
                                          lodging_season_tel='{$lodging_amount_tel}',
                                          lodging_season_tel_week='{$lodging_amount_tel_week}',
                                          lodging_season_airtel='{$lodging_amount_airtel}',
                                          lodging_season_airtel_week='{$lodging_amount_airtel_week}',
                                          lodging_season_aircartel='{$lodging_amount_aircartel}',
                                          lodging_season_aircartel_week='{$lodging_amount_aircartel_week}',
                                          lodging_season_adult_add='{$margin_adult}',
                                          lodging_season_child_add='{$margin_child}',
                                          lodging_season_week='{$lodging_amount_week}'
                                          
                    where no='{$amount['no']}' and lodging_season_no='{$season_no}'";
            echo $sql;
            $db->sql_query($sql);
        }
    }
}else if($case =="season_up"){


    $no                       = $_REQUEST["s_no"];
    $lodging_season_name         = $_REQUEST["lodging_season_name_up"];
    $lodging_season_start_date   = $_REQUEST["lodging_season_start_date_up"];
    $lodging_season_end_date     = $_REQUEST["lodging_season_end_date_up"];


    $sql = "update lodging_season_list 
                set 
                        
                        lodging_season_name           ='{$lodging_season_name}',
                        lodging_season_start_date     ='{$lodging_season_start_date}',
                        lodging_season_end_date       ='{$lodging_season_end_date}'
                where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case == "code_insert") {
    $indate  = date("Y-m-d H:i",time());

    $lodging_config_type = $_REQUEST["lodging_config_type"];
    $lodging_config_sort_no = $_REQUEST["lodging_config_sort_no"];
    $lodging_config_name = $_REQUEST["lodging_config_name"];

    $sql = "insert into lodging_config(lodging_config_type,lodging_config_sort_no,lodging_config_name,indate) VALUES('{$lodging_config_type}','{$lodging_config_sort_no}','{$lodging_config_name}','{$indate}') "; // 거래처등록 쿼리
    $db->sql_query($sql);
}else if($case =="code_up"){

    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num          = $_REQUEST["sel"][$i];
        $no1          = $_REQUEST["no"][$num] ;
        $lodging_config_type    = $_REQUEST["lodging_config_type"][$num] ;
        $lodging_config_sort_no = $_REQUEST["lodging_config_sort_no"][$num];
        $lodging_config_name = $_REQUEST["lodging_config_name"][$num];
        $lodging_config_chk = $_REQUEST["lodging_config_chk"][$num];

        $sql = "update lodging_config set lodging_config_type='{$lodging_config_type}',lodging_config_sort_no='{$lodging_config_sort_no}',lodging_config_name='{$lodging_config_name}' ,lodging_config_chk='{$lodging_config_chk}' where no='{$no1}'";
        //    echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "code_del") {
    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST["no"][$num];

        $sql = "delete from lodging_config where no='{$no}'";
        $db->sql_query($sql);
    }
}

?>