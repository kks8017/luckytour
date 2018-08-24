<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$board = new board();
$board_table = $_REQUEST['board_table'];
$adm = $_REQUEST['adm'];
//print_r($_REQUEST);
$case        = $_REQUEST["case"];
if($_SESSION['scode']==$_POST['s_code'] && !empty($_SESSION['scode']) or $adm=="admin" or $case=="delete" or $case=="reply_delete" ){
    unset($_SESSION['scode']);

   // echo $case;
    if($case=="insert") {

        $sql_num = "select count(no) as cnt from {$board_table}";
        $rs_num = $db->sql_query($sql_num);
        $row_num = $db->fetch_array($rs_num);
        if ($row_num['cnt'] == 0) {
            $row_num['cnt'] = 1;
        }
        if ($_SESSION["member_id"]) {
            $id = $_SESSION["member_id"];
        } else if ($_SESSION["user_id"]) {
            $id = $_SESSION["user_id"];
        }
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($_REQUEST['notice'] == "undefined") {
            $notice = "";
        } else {
            $notice = $_REQUEST['notice'];
        }
        if ($_REQUEST['secret'] == "undefined") {
            $secret = "";
        } else {
            $secret = $_REQUEST['secret'];
        }

        $author = $_REQUEST['author'];
        $subject = $_REQUEST['subject'];
        $content = $_REQUEST['content'];
        $files = $board->file_uplod($_FILES['files']);
        if($files[1]!=""){
            echo $files[1];
        }
        $passwd = $_REQUEST['passwd'];
        $indate = date("Y-m-d H:i", time());

        $sql = "insert into {$board_table}(num,id,notice,secret,author,subject,content,files,passwd,ip,indate) values('{$row_num['cnt']}','{$id}','{$notice}','{$secret}','{$author}','{$subject}','{$content}','{$files[0]}','{$passwd}','{$ip}','{$indate}')";
        $db->sql_query($sql);
    }else if($case=="update") {

        $no = $_REQUEST['no'];
        $old_file = $_REQUEST['old_file'];
        if ($_REQUEST['notice'] == "undefined") {
            $notice = "";
        } else {
            $notice = $_REQUEST['notice'];
        }
        if ($_REQUEST['secret'] == "undefined") {
            $secret = "";
        } else {
            $secret = $_REQUEST['secret'];
        }

        $author = $_REQUEST['author'];
        $subject = $_REQUEST['subject'];
        $content = $_REQUEST['content'];
        if ($_FILES['files'] != "") {
            unlink("../data/board_file/" . $old_file);
            $files = $board->file_uplod($_FILES['files']);
            if($files[1]!=""){
                echo $files[1];
            }
            $file_sql = ",files='{$files[0]}'";
        } else {
            $file_sql = "";
        }
        $sql_pass = "select passwd from {$board_table} where no='{$no}' ";
   //     echo $sql_pass;
        $rs_pass  = $db->sql_query($sql_pass);
        $row_pass = $db->fetch_array($rs_pass);
        $passwd = $_REQUEST['passwd'];
        echo $passwd."===".$row_pass['passwd'];
        if($passwd == $row_pass['passwd']) {
            $sql = "update {$board_table} set notice='{$notice}',secret='{$secret}',author='{$author}',content='{$content}' {$file_sql} where no='{$no}'";
            $db->sql_query($sql);
            echo "<input type='hidden' id='pwd' value='OK'>";
        }else{
            echo "<input type='hidden' id='pwd' value='NO'>";
        }
    }else if($case=="delete") {
        $no = $_REQUEST['no'];
        $old_file = $_REQUEST['old_file'];
        if ($old_file != "") {
            unlink("../data/board_file/" . $old_file);
        }

        $sql = "delete from {$board_table} where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);

    }else if($case=="all_delete"){
        $board_table = $_REQUEST['table'];
        $table = explode("_",$_REQUEST['table']);
        for($i=0; $i < count($_REQUEST["sel"]);$i++) {
            $num = $_REQUEST['sel'][$i];
            $no = $_REQUEST['no'][$num];
            $old_file = $_REQUEST['old_file'][$num];
            if ($old_file != "") {
                unlink("../data/board_file/" . $old_file);
            }

            $sql = "delete from {$board_table} where no='{$no}'";
            echo $sql;
            $db->sql_query($sql);
        }

        echo "<script>window.location.href ='../adm/index.php?linkpage=board_list&bd_no=&board_table=$table[1]'; </script>";

    }else if($case == "reply_insert"){
        $indate = date("Y-m-d H:i",time());

        $bd_no = $_REQUEST['bd_no'];
        $sub_no = $_REQUEST['sub_no'];
        $re_name = $_REQUEST['re_name'];
        $passwd = $_REQUEST['passwd'];
        $re_content = $_REQUEST['re_content'];

        $sql = "insert into board_reply(bd_no,sub_no,name,passwd,content,indate) values('{$bd_no}','{$sub_no}','{$re_name}','{$passwd}','{$re_content}','{$indate}')";
        echo $sql;
        $db->sql_query($sql);

    }else if($case == "reply_delete"){
        $no = $_REQUEST['no'];

        $sql = "delete from board_reply where no='{$no}'";
        echo $sql;
        $db->sql_query($sql);
    }





}else{
    echo "<input type='hidden' id='er_code' value='wrong'>";
}
?>