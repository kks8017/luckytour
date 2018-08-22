<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];
$indate    = date("Y-m-d H:i",time());
if($case=="insert"){
    print_r($_POST);
    $best_sort  = $_POST['best_sort'];
    $lodging_no = $_POST['lodging_no'];
    $room_no    = $_POST['room_no'];
    $rent_no    = $_POST['rent_no'];
    $best_title  = $_POST['best_title'];
    $best_event  = $_POST['best_event'];
    $best_link  = $_POST['best_link'];
    $best_sale           = $_POST['best_sale'];
    $best_sale_amount    = $_POST['best_sale_amount'];
    $best_normal_amount  = $_POST['best_normal_amount'];
    $air  = $_POST['air'];
 //   echo KS_DATA_DIR."/".KS_BEST_DIR;

    if($_FILES['photo']['tmp_name']!=""){
        $best_images         = image_upload($_FILES['photo'],KS_DATA_DIR."/".KS_BEST_DIR,"","","../");
    }

    $sql = "insert into best_list(best_sort,rent_no,tel_no,room_no,air,best_title,best_event,best_link,best_sales,best_sale_amount,best_normal_amount,best_img)
            values('{$best_sort}','{$rent_no}','{$lodging_no}','{$room_no}','{$air}','{$best_title}','{$best_event}','{$best_link}','{$best_sale}','{$best_sale_amount}','{$best_normal_amount}','{$best_images[0]}')
           ";
    echo $sql;
    $db->sql_query($sql);
}else if($case == "update"){

    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num       = $_REQUEST["sel"][$i];
        $no  =$_POST['no'][$num];
        $best_sort = $_POST['best_sort'][$num];
        $lodging_no = $_POST['tel_no_'.$num];
        $room_no = $_POST['room_no_'.$num];
        $rent_no = $_POST['rent_no_'.$num];
        $best_title = $_POST['best_title'][$num];
        $best_event = $_POST['best_event'][$num];
        $best_link = $_POST['best_link'][$num];
        $best_sale = $_POST['best_sale'][$num];
        $best_sale_amount = $_POST['best_sale_amount'][$num];
        $best_normal_amount = $_POST['best_normal_amount'][$num];
        $air = $_POST['air_'.$num];
      //  print_r($_FILES['photo'][$num]);
        $photo = array("name"=>$_FILES['photo']['name'][$num],"type"=>$_FILES['photo']['type'][$num],"tmp_name"=>$_FILES['photo']['tmp_name'][$num],"error"=>$_FILES['photo']['error'][$num],"size"=>$_FILES['photo']['size'][$num]);

        if ($_FILES['photo']['name'][$num] != "") {
            if ($_REQUEST['old_photo'][$num]) {
                $best_images = image_upload($photo, KS_DATA_DIR . "/" . KS_BEST_DIR, $_REQUEST['old_photo'][$num], "up", "../");
            } else {
                $best_images = image_upload($photo, KS_DATA_DIR . "/" . KS_BEST_DIR);
            }
            $image_sql = " ,best_img='{$best_images[1]}'";

        } else {

            $image_sql = "";
        }
        $sql = "update best_list set
                                  best_sort='{$best_sort}',
                                  rent_no='{$rent_no}',
                                  tel_no='{$lodging_no}',
                                  room_no='{$room_no}',
                                  air='{$air}',
                                  best_title='{$best_title}',
                                  best_link='{$best_link}',
                                  best_event='{$best_event}',
                                  best_sales='{$best_sale}',
                                  best_sale_amount='{$best_sale_amount}',
                                  best_normal_amount='{$best_normal_amount}' 
                                  {$image_sql}
                  where no='{$no}' ";
        echo $sql;
        $db->sql_query($sql);
    }

}else if($case=="delete"){
    for($i=0; $i < count($_REQUEST["sel"]);$i++) {
        $num = $_REQUEST["sel"][$i];
        $no  = $_REQUEST["no"][$num];
        $sql = "delete from best_list where no='{$no}'";
        $db->sql_query($sql);
        if ($_REQUEST['old_photo'][$num] != "") {
            unlink(KS_DATA_DIR."/".KS_BEST_DIR."/".$_REQUEST['old_photo']);
        }

    }
}
?>