<?php
include_once('./_common.php');

if($_SESSION["member_id"]==""){
    include_once('board_header.php');
}
$page_set = 10; // 한페이지 줄수
$block_set = 10; // 한페이지 블럭수

$sql_bd = "select no from board_list where bd_id='{$_REQUEST['board_table']}'";
$rs_bd  = $db->sql_query($sql_bd);
$row_bd = $db->fetch_array($rs_bd);

$bd_no = $row_bd['no'];
$bd_id = $_REQUEST['board_table'];
$table = "board_".$_REQUEST['board_table'];
$board = $_REQUEST['board'];
$page = $_REQUEST['page'];

if($board=="list") {
    $sublink = 'list.php';
    $class = "notice";

}else if($board=="write"){
    $sublink ='write.php';
    $class = "writer";
}else if($board=="view"){
    $sublink = 'view.php';
    $class = "notice";
    $subclass  = "_detail";
}else if($board=="modify"){
    $sublink = 'modify.php';
    $class = "notice";
}else if($board=="confirm"){
    $sublink = 'reserv_confirm.php';
    $class = "res_confirm";
}else if($board=="reserv_list"){
    $sublink = 'reserv_list.php';
    $class = "faq";
}else if($board=="cash"){
    $sublink = 'cash_list.php';
    $class = "notice";
}else if($board=="cash_write"){
    $sublink = 'cash_write.php';
    $class = "notice";
}else if($board=="reserv_view"){
    $sublink = 'reserv_view.php';
    $class = "faq";

}else{
    $sublink = 'list.php' ;
    $class = "notice";
}
if($_SESSION["member_id"]!=""){
    $adm_link = "/adm/?linkpage=board_list&";
}else{
    $adm_link = "/board/board.php?";
}
?>
<link rel="stylesheet" href="../css/customer.css" />
<script type="text/javascript" src="../smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar mar"></span>
            <h3>고객센터</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
    </div>
    <div class="<?=$class?><?=$subclass?>">

        <div class="lmenu">
            <ul>

                <li><a href="<?=$adm_link?>board_table=inquire"/>여행상담문의<img src="../sub_img/off_left_arrow.png" /></a></li>
               <?if($_SESSION["member_id"]==""){?>
                <li><a href="./refund.html" />환불규정<img src="../sub_img/off_left_arrow.png" /></a></li>
                <li><a href="/board/board.php?board=cash" />현금영수증신청<img src="../sub_img/off_left_arrow.png" /></a></li>
                <?}?>
                <li><a href="<?=$adm_link?>board_table=deposit" />입금확인<img src="../sub_img/off_left_arrow.png" /></a></li>
                <?if($_SESSION["member_id"]==""){?>
                <li><a href="/board/board.php?board=confirm"/>예약확인<img src="../sub_img/off_left_arrow.png" /></a></li>
                <?}?>
                <li><a href="<?=$adm_link?>board_table=latter"/>여행후기<img src="../sub_img/off_left_arrow.png" /></a></li>
                <li><a href="<?=$adm_link?>board_table=notice"  class="last"/>공지사항<img src="../sub_img/on_left_arrow.png" /></a></li>
            </ul>
        </div>

        <?include_once ($sublink);?>
    </div> <!-- faq 끝 -->
</div><!-- content 끝 -->
<?
if($_SESSION["member_id"]==""){
    include_once('board_footer.php');
}
?>