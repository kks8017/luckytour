<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="res_list"){
    $sublink = "reservation_list.php";
}else if($_GET["subpage"] == "res_ok_list"){
    $sublink = "reservation_ok_list.php";
}else if($_GET["subpage"] == "oil"){
    $sublink = "air_com_oil.php";
}else{
    $sublink = "reservation_list.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=reservation&subpage=res_list">예약현황</a></li>
        <li><a href="?linkpage=reservation&subpage=res_ok_list">예약장부현황</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$sublink}");?>
</div>