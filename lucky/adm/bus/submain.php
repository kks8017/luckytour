<?php
if($_GET["subpage"]=="company"){
    $subpage = "bus_company.php";
}else if($_GET["subpage"]=="bus"){
    $subpage = "bus_list.php";
}else if($_GET["subpage"]=="amount"){
    $subpage = "bus_amount.php";
}else{
    $subpage = "bus_company.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=bus&subpage=company">업체관리</a></li>
        <li><a href="?linkpage=bus&subpage=bus">차량관리</a></li>
        <li><a href="?linkpage=bus&subpage=amount">요금관리</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>