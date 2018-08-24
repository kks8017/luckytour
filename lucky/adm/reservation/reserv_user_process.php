<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case = $_REQUEST['case'];

if($case=="update") {
    $no = $_REQUEST['no'];
    $reserv_name = $_REQUEST['reserv_name'];
    $reserv_phone = $_REQUEST['reserv_phone'];
    $reserv_email = $_REQUEST['reserv_email'];
    $reserv_real_name = $_REQUEST['reserv_real_name'];
    $reserv_real_phone = $_REQUEST['reserv_real_phone'];
    $reserv_adult_number = $_REQUEST['reserv_adult_number'];
    $reserv_child_number = $_REQUEST['reserv_child_number'];
    $reserv_baby_number = $_REQUEST['reserv_baby_number'];
    $reserv_adult_list = $_REQUEST['reserv_adult_list'];
    $reserv_child_list = $_REQUEST['reserv_child_list'];
    $reserv_baby_list = $_REQUEST['reserv_baby_list'];
    $reserv_summarize = $_REQUEST['reserv_summarize'];

    $sql = "update reservation_user_content set 
                                                reserv_name='{$reserv_name}',
                                                reserv_phone='{$reserv_phone}',
                                                reserv_email='{$reserv_email}',
                                                reserv_real_name='{$reserv_real_name}',
                                                reserv_real_phone='{$reserv_real_phone}',
                                                reserv_adult_number='{$reserv_adult_number}',
                                                reserv_child_number='{$reserv_child_number}',
                                                reserv_baby_number='{$reserv_baby_number}',
                                                reserv_adult_list='{$reserv_adult_list}',
                                                reserv_child_list='{$reserv_child_list}',
                                                reserv_baby_list='{$reserv_baby_list}',
                                                reserv_summarize='{$reserv_summarize}'
             where no='{$no}'                                   
                                   ";
    echo $sql;
    $db->sql_query($sql);
}else if($case=="sum_update"){
    $no = $_REQUEST['no'];
    $reserv_summarize = $_REQUEST['reserv_summarize'];
    $sql = "update reservation_user_content set  reserv_summarize='{$reserv_summarize}' where no='{$no}'";
    $db->sql_query($sql);
}else if ($case=="list_delete") {

    for ($i = 0; $i < count($_REQUEST["sel"]); $i++) {
        $num = $_REQUEST["sel"][$i];
        $no = $_REQUEST['no'][$num];

        $sql = "update reservation_user_content set reserv_del_mark='Y' where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);
    }
}else if($case=="state_update"){
    $no = $_REQUEST['reserv_user_no'];
    $state = $_REQUEST['state'];

    $sql = "update reservation_user_content set reserv_state='{$state}' where no='{$no}'";
    $db->sql_query($sql);
}else if($case=="person_update"){
    $no = $_REQUEST['reserv_user_no'];
    $person = $_REQUEST['person'];

    $sql = "update reservation_user_content set reserv_person='{$person}' where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case=="ok_date_update") {
    $no = $_REQUEST['reserv_user_no'];
    if ($_REQUEST['ok_date'] == "미확정") {
        $ok_date = date("Y-m-d", time());
    } else {
        $ok_date = date("Y-m-d", time());
    }


    $sql = "update reservation_user_content set reserv_ok_date='{$ok_date}' where no='{$no}'";
    echo $sql;
    $db->sql_query($sql);
}else if($case=="deposit_board"){
 $main = new main();
 $indate = date("Y-m-d H:i");
 $company = $main->tour_config();
 $res->res_no = $_POST['reserv_no'];
 $user = $res->reserve_view();
 $type = $res->package_type($user['reserv_type']);
 $name = $_POST['name'];
 $title = $_POST['subject'];
 $price = $_POST['price'];
 $name =  mb_substr($name,0,2);
 $name = $name."*";
 $passwd = explode($user['reserv_phone'],"-");
 $author = $company['tour_name'];
 $subject = $name."님~ 고맙습니다.";
 $content = $name."고객님<br>".substr($user['reserv_tour_start_date'],5,5)."~".substr($user['reserv_tour_end_date'],5,5)."일 예약하신".$type."대 
                   {$title} <br> 일금 {$price}원 입금 되었습니다.<br>
                   고맙습니다. 만족스런 제주여행이 되시도록 최선의 노력을 다하겠습니다.";



 $sql  = "insert into board_deposit(author,subject,content,secret,notice,passwd,indate) value('{$author}','{$subject}','{$content}','Y','','{$passwd[2]}','{$indate}')";

 $db->sql_query($sql);

 echo "<script>
        alert('입금게시판에 입력완료했습니다.');
        window.close();
        </script>";
}
?>