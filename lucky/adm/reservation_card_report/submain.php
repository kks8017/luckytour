<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="card") {
    $sublink = "reservation_report_card.php";
}else if($_GET["subpage"]=="tax"){
    $sublink = "reservation_report_tax.php";
}else if($_GET["subpage"]=="refund"){
    $sublink = "reservation_report_refund.php";
}else if($_GET["subpage"]=="com"){
    $sublink = "reservation_report_refund_com.php";
}else{
    $sublink = "reservation_report_card.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=report_card&subpage=card">카드결제</a></li>
        <li><a href="?linkpage=report_tax&subpage=tax">세금계산서</a></li>
        <li><a href="?linkpage=report_refund&subpage=refund">고객환불</a></li>
        <li><a href="?linkpage=report_refund&subpage=com">거래처환불</a></li>
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