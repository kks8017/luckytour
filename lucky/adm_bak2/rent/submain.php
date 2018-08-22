<?php
include_once("./_common.php");

if($_GET["subpage"]=="company"){
    $subpage = "rent_company.php";
}else if($_GET["subpage"]=="car"){
    $subpage = "rent_car_list.php";
}else if($_GET["subpage"]=="amount"){
    $subpage = "rent_amount.php";
}else if($_GET["subpage"]=="season"){
    $subpage = "rent_amount_season.php";
}else if($_GET["subpage"]=="code"){
    $subpage = "rent_config.php";
}else{
    $subpage = "rent_company.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=rent&subpage=code">렌트코드관리</a></li>
        <li><a href="?linkpage=rent&subpage=company">렌트업체관리</a></li>
        <li><a href="?linkpage=rent&subpage=car">차량관리</a></li>
        <li><a href="?linkpage=rent&subpage=amount">차량요금</a></li>
        <li><a href="?linkpage=rent&subpage=season">기간관리</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>