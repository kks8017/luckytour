<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$linkpage = $_GET["linkpage"];
$reserv_name = $_REQUEST["reserv_name"];
$lodge_search = $_REQUEST["lodge_search"];

$SQL = "select * from tour_company where tour_main='Y'";
$rs  = $db->sql_query($SQL);
$row = $db->fetch_array($rs);

$SQL_config = "select tour_air_area,tour_rent_code,tour_rent_fuel_code,tour_rent_option,tour_tel_code,tour_tel_type_code from tour_config where tour_com_no='{$row['no']}'";
$rs_config  = $db->sql_query($SQL_config);
$row_config = $db->fetch_array($rs_config);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row['tour_name']?>관리자</title>
    <meta charset="utf-8">

    <link href="css/common.css" rel="stylesheet">
   
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/gnb.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
    <script type="text/javascript" src="/lib/common.lib.js" ></script>
</head>
<script>

    function wrapWindowByMask() {

        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();
//      var maskWidth = $(document).width();
        var maskWidth = window.document.body.clientWidth;
        var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";

        var loadingImg = '';
        loadingImg += "<div id='loadingImg' style='position:absolute; left:50%; top:40%; display:none; z-index:10000;'>";
        loadingImg += " <img src='/com/img/viewLoading.gif'/>";
        loadingImg += "</div>";
        //화면에 레이어 추가
        $('body')
            .append(mask)
            .append(loadingImg)
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $('#mask').css({
            'width' : maskWidth
            , 'height': maskHeight
            , 'opacity' : '0.3'
        });

        //마스크 표시
        $('#mask').show();
        //로딩중 이미지 표시
        $('#loadingImg').show();
    }
    function closeWindowByMask() {
        $('#mask, #loadingImg').hide();
        $('#mask, #loadingImg').remove();
    }
    function ledger(no) {
        window.open("reservation/reservation_ledger.php?no="+no,"ledger_pop_"+no,"width=1450,height=900");
    }
</script>

<body>
<?php

if($_SESSION["member_id"]!=""){


    if($_GET["linkpage"] == "reservation" ) {
        $page = "reservation/submain.php";
    }else if($_GET["linkpage"] == "res_basic"){
        $page = "reservation/reservation_basic.php";
    }else if($_GET["linkpage"] == "air"){
        $page = "air/submain.php";
    }else if($_GET["linkpage"] == "rent"){
        $page = "rent/submain.php";
    }else if($_GET["linkpage"] == "tel"){
        $page = "tel/submain.php";
    }else if($_GET["linkpage"] == "bus"){
        $page = "bus/submain.php";
    }else if($_GET["linkpage"] == "bustour"){
        $page = "bustour/submain.php";
    }else if($_GET["linkpage"] == "golf"){
        $page = "golf/submain.php";
    }else if($_GET["linkpage"] == "equip"){
        $page = "equip/submain.php";
    }else if($_GET["linkpage"] == "person_list"){
        $page = "person_list.php";
    }else if($_GET["linkpage"] == "company"){
        $page = "company_list.php";
    }else if($_GET["linkpage"] == "company_mod"){
        $page = "company.php";
    }else if($_GET["linkpage"] == "basic"){
        $page = "basic_config.php";
    }else if($_GET["linkpage"] == "board"){
        $page = "board_list.php";
    }else if($_GET["linkpage"] == "bd_config"){
        $page = "board_config.php";
    }else if($_GET["linkpage"] == "board_list"){
        $page = "../board/board.php";
    }else if($_GET["linkpage"] == "cash"){
        $page = "cash_list.php";
    }else if($_GET["linkpage"] == "report"){
        $page = "reservation_report/submain.php";
    }else if($_GET["linkpage"] == "report_sell"){
        $page = "reservation_sell_report/submain.php";
    }else if($_GET["linkpage"] == "report_remit"){
        $page = "reservation_remit_report/submain.php";
    }else if($_GET["linkpage"] == "report_collect"){
        $page = "reservation_collect_report/submain.php";
    }else if($_GET["linkpage"] == "report_card"){
        $page = "reservation_card_report/submain.php";
    }else if($_GET["linkpage"] == "report_tax"){
        $page = "reservation_card_report/submain.php";
    }else if($_GET["linkpage"] == "report_refund"){
        $page = "reservation_card_report/submain.php";
    }else if($_GET["linkpage"] == "best"){
        $page = "best_list.php";
    }else{
        $page = "reservation/submain.php";
    }

?>
<div id="wrap">
    <div id="head_wrap" >
        <header id="header">
            <div class="lmenu">
                <div class="logo">
                    <p>(주)제주럭키투어 관리자</p>
                </div>
                <div class="btn">
                    <p> <a href="logout.php"><img src="./image/logout.png"/></a></p>
                    <p><a href="#none"><img src="./image/upd.png" /></a></p>
                </div>
            </div>
            <div id="nav">
                <?php include_once ("./top_menu2.php");?>
            </div>
        </header>

    </div>
</div>

<div id="content">
    <div class="lmenu">
        <div class="wr">
            <div class="search_section" >
                <form id="main_srh_frm"  method="post" action="?linkpage=reservation&subpage=res_list">
                    <h3>예약자 검색</h3>
                    <input type="text" name="reserv_name" value="<?=$reserv_name?>" /><input type="image" src="./image/search_btn.png" id="main_sch_btn" />
                </form>
            </div>
            <div class="search_section" >
                <form id="main_srh_frm"  method="post" action="?linkpage=tel&subpage=list">
                    <h3>숙소 검색</h3>
                    <input type="text" name="lodge_search"  value="<?=$lodge_search?>"/>
                    <input type="image" src="./image/search_btn.png" />
                </form>
            </div>
        </div>
    </div>
    <div class="rmenu">
    <?php include_once($page);?>
    </div>

</div>
<div style="height: 50px;">

</div>
<?}else{
    goto_url("/adm/login.php");
}?>
<script>
    $(document).ready(function () {

        $("#main_sch_btn").click(function () {
            $("#main_srh_frm").submit();
        });

    });
    $( function() {
        $( ".air_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "../sub_img/calender2.png",
            buttonImageOnly : true
        });
    });
</script>
</body>
</html>
