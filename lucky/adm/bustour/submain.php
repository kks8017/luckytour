<?php


if($_GET["subpage"]=="list"){
    $subpage = "bustour_list.php";
}else if($_GET["subpage"]=="detail"){
    $subpage = "bustour_detail.php";
}else{
    $subpage = "bustour_list.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=bustour&subpage=list">버스투어리스트</a></li>

    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>