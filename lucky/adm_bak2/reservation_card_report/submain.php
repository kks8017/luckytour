<?php
$subpage = $_GET["subpage"];
if($_GET["subpage"]=="card") {
    $sublink = "reservation_report_card.php";
}else if($_GET["subpage"]=="tax"){
    $sublink = "reservation_report_tax.php";
}else if($_GET["subpage"]=="refund"){
    $sublink = "reservation_report_refund.php";
}else{
    $sublink = "reservation_report_card.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="?linkpage=report_card&subpage=card">카드결제</a></li>
        <li><a href="?linkpage=report_tax&subpage=tax">세금계산서</a></li>
        <li><a href="?linkpage=report_refund&subpage=refund">환불</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$sublink}");?>
</div>