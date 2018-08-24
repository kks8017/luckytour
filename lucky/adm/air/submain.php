<?php
if($_GET["subpage"]=="company"){
    $subpage = "air_company.php";
}else if($_GET["subpage"] == "normal"){
    $subpage = "air_normal_schedule.php";
}else if($_GET["subpage"] == "oil"){
    $subpage = "air_com_oil.php";
}else{
    $subpage = "air_company.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=air&subpage=company">항공업체관리</a></li>
        <li><a href="?linkpage=air&subpage=normal">항공일반스케줄</a></li>
        <li><a href="?linkpage=air&subpage=oil">유류할증및수수료</a></li>
        <li><a>스케줄불러오기</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>