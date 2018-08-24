<?php
if($_GET["subpage"]=="list"){
    $subpage = "lodging_list.php";
}else if($_GET["subpage"]=="detail"){
    $subpage = "lodging_detail.php";
}else if($_GET["subpage"]=="room"){
    $subpage = "room_list.php";
}else if($_GET["subpage"]=="amount"){
    $subpage = "lodging_amount.php";
}else if($_GET["subpage"]=="code"){
    $subpage = "lodging_config.php";
}else{
    $subpage = "lodging_list.php";
}
?>
<div id="sub_menu">
    <ul>
        <li><a href="javascript:tel_link('?linkpage=tel&subpage=code');">숙소코드</a></li>
        <li><a href="javascript:tel_link('?linkpage=tel&subpage=list');">숙소리스트</a></li>
        <li><a href="javascript:tel_link('?linkpage=tel&subpage=room&lodging_no=');">객실관리</a></li>
        <li><a href="javascript:tel_link('?linkpage=tel&subpage=amount&lodging_no=');">요금관리</a></li>
    </ul>
</div>
<div class="sub_content">
<?php include_once("{$subpage}");?>
</div>
<script>
    function tel_link(url) {
        if($("#lodging_no").val()!=undefined){
          var lod_no =   $("#lodging_no").val()
        }else{
            var lod_no ="";
        }
        window.location.href = url+lod_no;
    }
</script>