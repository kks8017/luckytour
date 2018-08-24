<?php
include_once("./_common.php");

if($_GET["subpage"]=="code"){
    $subpage = "golf_config.php";
}else if($_GET["subpage"]=="list"){
    $subpage = "golf_list.php";
}else if($_GET["subpage"]=="detail"){
    $subpage = "golf_detail.php";
}else if($_GET["subpage"]=="hole"){
    $subpage = "hole_list.php";
}else if($_GET["subpage"]=="amount"){
    $subpage = "golf_amount.php";
}else if($_GET["subpage"]=="season"){
    $subpage = "rent_amount_season.php";
}else if($_GET["subpage"]=="code"){
    $subpage = "rent_config.php";
}else{
    $subpage = "golf_list.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=golf&subpage=code">골프코드</a></li>
        <li><a href="?linkpage=golf&subpage=list">골프장</a></li>
        <li><a href="?linkpage=golf&subpage=hole">홀관리</a></li>
        <li><a href="?linkpage=golf&subpage=amount">요금관리</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>