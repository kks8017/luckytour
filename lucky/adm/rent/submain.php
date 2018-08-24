<?php
include_once("./_common.php");

if($_GET["subpage"]=="company"){
    $subpage = "rent_company.php";
    $color2   = "class='sel'";
}else if($_GET["subpage"]=="car"){
    $subpage = "rent_car_list.php";
    $color3   = "class='sel'";
}else if($_GET["subpage"]=="amount"){
    $subpage = "rent_amount.php";
    $color4   = "class='sel'";
}else if($_GET["subpage"]=="season"){
    $subpage = "rent_amount_season.php";
    $color5   = "class='sel'";
}else if($_GET["subpage"]=="code"){
    $subpage = "rent_config.php";
    $color1   = "class='sel'";
}else{
    $subpage = "rent_company.php";
    $color2   = "class='sel'";
}
?>
<div id="sub_menu">
    <ul>
        <li <?=$color1?>><a href="?linkpage=rent&subpage=code">렌트코드관리</a></li>
        <li <?=$color2?>><a href="?linkpage=rent&subpage=company">렌트업체관리</a></li>
        <li <?=$color3?>><a href="?linkpage=rent&subpage=car">차량관리</a></li>
        <li <?=$color4?>><a href="?linkpage=rent&subpage=amount">차량요금</a></li>
        <li <?=$color5?>><a href="?linkpage=rent&subpage=season">기간관리</a></li>
    </ul>
</div>
<div class="sub_content">
    <?php include_once("{$subpage}");?>
</div>