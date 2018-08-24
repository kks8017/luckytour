<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];

if($case=="insert"){
    $bustour_tour_name      = $_REQUEST["bustour_tour_name"];
    $bustour_tour_stay      = $_REQUEST["bustour_tour_stay"];


    $sql = "insert into bustour_tour(bustour_tour_name,bustour_tour_stay) VALUES('{$bustour_tour_name}','{$bustour_tour_stay}') "; // 거래처등록 쿼리

    $db->sql_query($sql);

}else if($case =="all_update"){
    // print_r($_REQUEST);
    $indate  = date("Y-m-d H:i",time());

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {

        $num               = $_REQUEST["sel"][$i];
        $no1               = $_REQUEST["no"][$num] ;
        $bustour_sort_no   = $_REQUEST["bustour_sort_no"][$num] ;
        $bustour_open      = $_REQUEST["bustour_open"][$num];

        $sql = "update bustour_tour set bustour_sort_no='{$bustour_sort_no}',bustour_open='{$bustour_open}' where no='{$no1}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case == "all_delete"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num              = $_REQUEST["sel"][$i];
        $no               = $_REQUEST["no"][$num] ;
        $main_old_image   = $_REQUEST["main_old_image"][$num] ;
        $detail_old_image = $_REQUEST["detail_old_image"][$num] ;

        $image_dir = "../../".KS_DATA_DIR."/".KS_BUSTOUR_DIR;
        unlink($image_dir."/thumbnail_".$main_old_image);
        unlink($image_dir."/".$main_old_image);

        unlink($image_dir."/thumbnail_".$detail_old_image);
        unlink($image_dir."/".$detail_old_image);

        $sql = "delete from bustour_tour where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case =="update"){
    $indate  = date("Y-m-d H:i",time());
    $no                           = $_REQUEST['no'];
    $bustour_tour_name            = $_REQUEST["bustour_tour_name"];
    $bustour_tour_stay            = $_REQUEST["bustour_tour_stay"];
    $bustour_tour_inclusion       = $_REQUEST["bustour_tour_inclusion"];
    $bustour_tour_not_inclusion   = $_REQUEST["bustour_tour_not_inclusion"];
    $bustour_tour_amount          = $_REQUEST["bustour_tour_amount"];
    $bustour_tour_amount_receive  = $_REQUEST["bustour_tour_amount_receive"];



    if($_FILES['bustour_tour_main_image']['error']==0) {
        if($_REQUEST['main_old_image']){
            $bustour_main_images = image_upload($_FILES['bustour_tour_main_image'],KS_DATA_DIR."/".KS_BUSTOUR_DIR,$_REQUEST['main_old_image'], "up");
        }else{
            $bustour_main_images = image_upload($_FILES['bustour_tour_main_image'],KS_DATA_DIR."/".KS_BUSTOUR_DIR);
        }
        $sql_main = ",bustour_tour_main_image ='{$bustour_main_images[1]}'";
    }else{
        $sql_main = "";
    }
    if($_FILES['bustour_tour_content_image']['error']==0) {
        if($_REQUEST['detail_old_image']){
            $bus_sub_images = image_upload($_FILES['bustour_tour_content_image'],KS_DATA_DIR."/".KS_BUSTOUR_DIR,$_REQUEST['detail_old_image'], "up");
        }else{
            $bus_sub_images = image_upload($_FILES['bustour_tour_content_image'],KS_DATA_DIR."/".KS_BUSTOUR_DIR);
        }
        $sql_sub = ",bustour_tour_content_image ='{$bus_sub_images[1]}'";
    }else{
        $sql_sub = "";
    }


    $sql = "update bustour_tour set bustour_tour_name='{$bustour_tour_name}',
                                              bustour_tour_stay ='{$bustour_tour_stay}',
                                              bustour_tour_inclusion ='{$bustour_tour_inclusion}',
                                              bustour_tour_not_inclusion ='{$bustour_tour_not_inclusion}',
                                              bustour_tour_amount ='{$bustour_tour_amount}',
                                              bustour_tour_amount_receive ='{$bustour_tour_amount_receive}'
                                              {$sql_main}
                                              {$sql_sub}
                                              where no='{$no}'";

    echo $sql;
    $db->sql_query($sql);

}
?>