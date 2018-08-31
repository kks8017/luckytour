<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$case      = $_REQUEST["case"];
$indate    = date("Y-m-d H:i",time());
if($case=="insert"){
    $board_id     = $_REQUEST["board_id"];
    $board_name   = addslashes($_REQUEST["board_name"]);

    $sql =  "select * from board_list where bd_id='{$board_id}'"; // 아이디 중복 쿼리
    $rs  = $db->sql_query($sql);
    $num = $db->num_rows($rs);
    if($num==0) {
        $sql = "insert into board_list(bd_id,bd_name,indate) VALUES('{$board_id}','{$board_name}','{$indate}') "; // 사이트등록 쿼리
        $db->sql_query($sql);
        $bd_no = $db->insert_id();

        $sql_con = "insert into board_config(bd_no) VALUES('{$bd_no}')"; //사이트등록 과 동시에 기본설정 등록 하는 쿼리
        $db->sql_query($sql_con);

        $sql_table = "
        CREATE TABLE board_{$board_id} (
                  no INT(11) AUTO_INCREMENT NOT NULL,
                  num INT(11) NOT NULL,
                  id VARCHAR(25) NOT NULL,
                  dep VARCHAR (25) NOT NULL DEFAULT 'A',
                  notice CHAR(2) NULL,
                  secret CHAR(2) NULL,
                  author VARCHAR(25) NOT NULL,
                  subject VARCHAR(255) NOT NULL,
                  content TEXT NOT NULL,
                  files VARCHAR(255) NULL,
                  passwd CHAR(4) NULL,
                  hits int(11) NULL DEFAULT '0',
                  ip VARCHAR(25) NOT NULL,
                  indate DATETIME NULL,
                  PRIMARY KEY (no)
                );
        ";

        $db->sql_query($sql_table);
    }else{
        echo "NO"; // 아이디가 중복되었슬때 0을 표시해준다
    }
}else if($case == "update"){
    $no = $_REQUEST['no'];
    $bd_type = $_REQUEST['bd_type'];
    $bd_notice = $_REQUEST['bd_notice'];
    $bd_write = $_REQUEST['bd_write'];
    $bd_file = $_REQUEST['bd_file'];
    $bd_secret = $_REQUEST['bd_secret'];

    $sql = "update  board_config set bd_type='{$bd_type}',bd_notice='{$bd_notice}',bd_file='{$bd_file}',bd_secret='{$bd_secret}',bd_write='{$bd_write}' where no='{$no}'";
    $db->sql_query($sql);

}else if($case=="delete"){
    $no     = $_REQUEST["no"];
    $sql =  "select * from board_list where no='{$no}'"; // 아이디 중복 쿼리
    $rs  = $db->sql_query($sql);
    $row = $db->fetch_array($rs);

    $sql =  "delete from board_list where no='{$no}'";
    $db->sql_query($sql);
    $sql_con =  "delete from board_config where bd_no='{$no}'";
    $db->sql_query($sql_con);
    $table = "board_".$row['bd_id'];
    $sql_table = "Drop table {$table} ";
    $db->sql_query($sql_table);
}
?>