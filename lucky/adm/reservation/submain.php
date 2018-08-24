<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="res_list"){
    $sublink = "reservation_list.php";
    $color1   = "class='sel'";
}else if($_GET["subpage"] == "res_ok_list"){
    $sublink = "reservation_ok_list.php";
    $color2   = "class='sel'";
}else if($_GET["subpage"] == "air_block"){
    $sublink = "reserv_air_block_list.php";
    $color3   = "class='sel'";
}else if($_GET["subpage"] == "rent_block"){
    $sublink = "reserv_rent_block_list.php";
    $color4   = "class='sel'";
}else if($_GET["subpage"] == "lod_block"){
    $sublink = "reserv_lod_block_list.php";
    $color5   = "class='sel'";
}else if($_GET["subpage"] == "oil"){
    $sublink = "air_com_oil.php";

}else{
    $sublink = "reservation_list.php";
    $color1   = "class='sel'";
}
?>
<div id="sub_menu">
    <ul>
        <li <?=$color1?>><a href="?linkpage=reservation&subpage=res_list">예약현황</a></li>
        <li <?=$color3?>><a href="?linkpage=reservation&subpage=air_block">항공블럭/대기</a></li>
        <li <?=$color4?>><a href="?linkpage=reservation&subpage=rent_block">렌트블럭/대기</a></li>
        <li <?=$color5?>><a href="?linkpage=reservation&subpage=lod_block">숙소블럭/대기</a></li>
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