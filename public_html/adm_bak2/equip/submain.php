<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="list"){
    $sublink = "equip_list.php";
}else{
    $sublink = "equip_list.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=equip&subpage=list">전체현황</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$sublink}");?>
</div>