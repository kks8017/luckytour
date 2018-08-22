<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="remit"){
    $sublink = "reservation_report_remit.php";
}else if($_GET["subpage"] == "air"){
    $sublink = "reservation_report_remit_air.php";
}else if($_GET["subpage"] == "rent"){
    $sublink = "reservation_report_remit_rent.php";
}else if($_GET["subpage"] == "lod"){
    $sublink = "reservation_report_remit_lodging.php";
}else if($_GET["subpage"] == "bus"){
    $sublink = "reservation_report_remit_bus.php";
}else if($_GET["subpage"] == "bustour"){
    $sublink = "reservation_report_remit_bustour.php";
}else if($_GET["subpage"] == "golf"){
    $sublink = "reservation_report_remit_golf.php";
}else{
    $sublink = "reservation_report_remit.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=report_remit&subpage=remit">전체현황</a></li>
        <li><a href="?linkpage=report_remit&subpage=air">항공</a></li>
        <li><a href="?linkpage=report_remit&subpage=rent">렌트</a></li>
        <li><a href="?linkpage=report_remit&subpage=lod">숙박</a></li>
        <li><a href="?linkpage=report_remit&subpage=bus">버스/택시</a></li>
        <li><a href="?linkpage=report_remit&subpage=bustour">버스투어</a></li>
        <li><a href="?linkpage=report_remit&subpage=golf">골프</a></li>
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