<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="month"){
    $sublink = "reservation_report_month.php";
}else if($_GET["subpage"] == "day"){
    $sublink = "reservation_report_day.php";
}else if($_GET["subpage"] == "deposit"){
    $sublink = "reservation_report_deposit.php";
}else if($_GET["subpage"] == "payment"){
    $sublink = "reservation_report_payment.php";
}else if($_GET["subpage"] == "balance"){
    $sublink = "reservation_report_balance.php";
}else if($_GET["subpage"] == "card"){
    $sublink = "reservation_report_card.php";
}else if($_GET["subpage"] == "golf"){
    $sublink = "reservation_report_remit_golf.php";
}else{
    $sublink = "reservation_report_month.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=report_collect&subpage=month">월별수금현황</a></li>
        <li><a href="?linkpage=report_collect&subpage=day">일별수금현황</a></li>
        <li><a href="?linkpage=report_collect&subpage=deposit">예약금예정/수금</a></li>
        <li><a href="?linkpage=report_collect&subpage=payment">중도금예정/수금</a></li>
        <li><a href="?linkpage=report_collect&subpage=balance">잔금예정/수금</a></li>
        <li><a href="?linkpage=report_collect&subpage=card">카드예정/수금</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$sublink}");?>
</div>
<script>
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