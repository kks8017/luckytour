<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="sell"){
    $sublink = "reservation_report_sell.php";
    $color1   = "class='sel'";
}else if($_GET["subpage"] == "air"){
    $sublink = "reservation_report_sell_air.php";
    $color2   = "class='sel'";
}else if($_GET["subpage"] == "rent"){
    $sublink = "reservation_report_sell_rent.php";
    $color3   = "class='sel'";
}else if($_GET["subpage"] == "lod"){
    $sublink = "reservation_report_sell_lodging.php";
    $color4   = "class='sel'";
}else if($_GET["subpage"] == "bus"){
    $sublink = "reservation_report_sell_bus.php";
    $color5   = "class='sel'";
}else if($_GET["subpage"] == "bustour"){
    $sublink = "reservation_report_sell_bustour.php";
    $color6   = "class='sel'";
}else if($_GET["subpage"] == "golf"){
    $sublink = "reservation_report_sell_golf.php";
    $color7   = "class='sel'";
}else{
    $sublink = "reservation_report_sell.php";
    $color1   = "class='sel'";
}
?>
<div id="sub_menu">
    <ul>
        <li <?=$color1?>><a href="?linkpage=report_sell&subpage=sell">전체현황</a></li>
        <li <?=$color2?>><a href="?linkpage=report_sell&subpage=air">항공</a></li>
        <li <?=$color3?>><a href="?linkpage=report_sell&subpage=rent">렌트</a></li>
        <li <?=$color4?>><a href="?linkpage=report_sell&subpage=lod">숙박</a></li>
        <li <?=$color5?>><a href="?linkpage=report_sell&subpage=bus">버스/택시</a></li>
        <li <?=$color6?>><a href="?linkpage=report_sell&subpage=bustour">버스투어</a></li>
        <li <?=$color7?>><a href="?linkpage=report_sell&subpage=golf">골프</a></li>
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