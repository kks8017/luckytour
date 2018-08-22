<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$ledger = $_REQUEST['ledger'];


if($ledger=="adm"){
    $start_date = date("Y-m-d",time());
    $end_date = date("Y-m-d",time()+86400);
    $indate = date("Y-m-d H:i:s",time());
    $sql = "insert into reservation_user_content(reserv_name,reserv_phone,reserv_email,reserv_tour_start_date,reserv_tour_end_date,reserv_ledger,reserv_incom_type,reserv_person,reserv_adult_number,reserv_child_number,reserv_baby_number,reserv_state,indate) 
            values('테스트','010-0000-0000','test@test.com','{$start_date}','{$end_date}','Y','MANAGER','{$_SESSION['member_name']}','2','0','0','WT','{$indate}')";

    $rs = $db->sql_query($sql);
    $reserv_no = $db->insert_id();
    $sql_amount = "insert into reservation_amount(reserv_user_no,reserv_deposit_date,reserv_balance_date) values('{$reserv_no}','{$start_date}','{$start_date}')";
    $db->sql_query($sql_amount);
    echo "<script>
                window.location.href = 'reservation_ledger.php?no={$reserv_no}'
          </script>";
}
if($ledger=="ledger"){
    $reserv_no =$_REQUEST['reserv_no'];
    $sql = "update reservation_user_content set reserv_ledger='Y' , reserv_person='{$_SESSION['member_name']}' where no='{$reserv_no}'";
    $db->sql_query($sql);
    echo "<script>
                window.location.href = 'reservation_ledger.php?no={$reserv_no}'
          </script>";
}
$no = $_REQUEST['no'];

$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

if($row['reserv_ok_date']=="" or $row['reserv_ok_date']=="0000-00-00"){
    $ok_date = "미확정";
}else{
    $ok_date = $row['reserv_ok_date'];
}

$sql_amount = "select * from reservation_amount where reserv_user_no='{$no}'";
$rs_amount  = $db->sql_query($sql_amount);
$row_amount = $db->fetch_array($rs_amount);

$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row['tour_name']?>관리자</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reserve_ledger.css" />
    <link href="../css/normalize.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
    <script type="text/javascript" src="/lib/common.lib.js" ></script>
</head>
<script>

    function wrapWindowByMask() {

        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();
//      var maskWidth = $(document).width();
        var maskWidth = window.document.body.clientWidth;
        var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";

        var loadingImg = '';
        loadingImg += "<div id='loadingImg' style='position:absolute; left:50%; top:40%; display:none; z-index:10000;'>";
        loadingImg += " <img src='../images/viewLoading.gif'/>";
        loadingImg += "</div>";
        //화면에 레이어 추가
        $('body')
            .append(mask)
            .append(loadingImg)
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $('#mask').css({
            'width' : maskWidth
            , 'height': maskHeight
            , 'opacity' : '0.3'
        });

        //마스크 표시
        $('#mask').show();
        //로딩중 이미지 표시
        $('#loadingImg').show();
    }
    function closeWindowByMask() {
        $('#mask, #loadingImg').hide();
        $('#mask, #loadingImg').remove();
    }
    function air_update(no) {
        window.open("sale_air_update.php?no=<?=$no?>&reserv_air_no="+no,"sale_air_update","width=1000,height=500,scrollbars=yes")
    }
    function air_update_normal(no) {
        window.open("normal_air_update.php?no=<?=$no?>&reserv_air_no="+no,"normal_air_update","width=1000,height=500 ,scrollbars=yes")
    }
    function rent_update(no) {
        window.open("rentcar_update.php?no=<?=$no?>&reserv_rent_no="+no,"rent_update","width=1000,height=500,scrollbars=yes")
    }
    function lodging_update(no) {
        window.open("lodging_update.php?no=<?=$no?>&reserv_lodging_no="+no,"lodging_update","width=1000,height=500,scrollbars=yes")
    }
    function bus_update(no) {
        window.open("bus_update.php?no=<?=$no?>&reserv_bus_no="+no,"bus_update","width=1000,height=500,scrollbars=yes")
    }
    function bustour_update(no) {
        window.open("bustour_update.php?no=<?=$no?>&reserv_bustour_no="+no,"bustour_update","width=1000,height=500,scrollbars=yes")
    }
    function golf_update(no) {
        window.open("golf_update.php?no=<?=$no?>&reserv_golf_no="+no,"golf_update","width=1000,height=500,scrollbars=yes")
    }
    function equip_update(no) {
        window.open("equip_update.php?no=<?=$no?>&reserv_equip_no="+no,"equip_update","width=1000,height=300,scrollbars=yes")
    }
    function amount_update(no) {
        window.open("reserv_amount_update.php?reserv_user_no=<?=$no?>","amount_update","width=1000,height=500,scrollbars=yes")
    }
    function reserv_content() {
        window.open("reserv_content.php?no=<?=$no?>","content_update","width=640,height=300,scrollbars=yes")
    }
    function reserv_sms() {
        window.open("sms_list.php?no=<?=$no?>","content_update","width=640,height=300,scrollbars=yes")
    }
    function air_ledger_update(i){

        var url = "air_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#sale_air_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask()
            },
            complete: function () {
                closeWindowByMask();
                alert("항공정보를 수정하셨습니다.");
                air();
            }
        });
    }

    function air_ledger_update_normal(i){
        var url = "air_reserv_process.php"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $("#no_air_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask()
            },
            complete: function () {
                closeWindowByMask();
                alert("항공정보를 수정하셨습니다.");
               normal_air();
            }
        });
    }
    function rent_ledger_update(i){
        var url = "rent_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#rent_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("렌트정보를 수정하셨습니다.");
                rent();
            }
        });
    }
    function lodging_ledger_update(i){
        var url = "lodging_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#lodging_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("숙소정보를 수정하셨습니다.");
                lodging();
            }
        });
    }
    function bus_ledger_update(i){
        var url = "bus_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#bus_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("버스/택시정보를 수정하셨습니다.");
                bus();
            }
        });
    }
    function bustour_ledger_update(i){
        var url = "bustour_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#bustour_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("버스투어정보를 수정하셨습니다.");
                bustour();
            }
        });
    }
    function golf_ledger_update(i){
        var url = "golf_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#golf_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("골프정보를 수정하셨습니다.");
                golf();
            }
        });
    }
    function equip_ledger_update(i){
        var url = "equip_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#equip_frm").serialize()+"&reserv_user_no=<?=$no?>&i="+i+"&case=ledger_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("편의장비를 수정하셨습니다.");
                equip();
            }
        });
    }
    function user_update(){
        var url = "reserv_user_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#user_frm").serialize()+"&no=<?=$no?>&case=update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("고객정보를 수정하셨습니다.");
                user_content();
            }
        });
    }
    function sum_update(){
        var url = "reserv_user_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#user_frm").serialize()+"&no=<?=$no?>&reserv_summarize="+$("#reserv_summarize").val()+"&case=sum_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                alert("진행사항를 수정하셨습니다.");
                user_content();
            }
        });
    }
</script>
<body>
<div id="wrap">
    <div class="mheader">
        <p><span><?=$row['reserv_name']?></span>님 예약현황&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>접수상태 :</span>
            <select name="reserv_state">
                <option value="WT" <?if($row['reserv_state']=="WT"){?>selected<?}?>>접수</option>
                <option value="BL" <?if($row['reserv_state']=="BL"){?>selected<?}?>>보류</option>
                <option value="OK" <?if($row['reserv_state']=="OK"){?>selected<?}?>>완료</option>
                <option value="CL" <?if($row['reserv_state']=="CL"){?>selected<?}?>>취소</option>
                <option value="GL" <?if($row['reserv_state']=="GL"){?>selected<?}?>>결항</option>
                <option value="BJ" <?if($row['reserv_state']=="BJ"){?>selected<?}?>>부재</option>
                <option value="BC" <?if($row['reserv_state']=="BC"){?>selected<?}?>>블럭</option>
                <option value="BW" <?if($row['reserv_state']=="BW"){?>selected<?}?>>입금대기</option>
            </select>
            <img type="button" src="../image/modify.gif" id="state_btn" value="변경" style="cursor: pointer;">
            <span >담당자 :</span>
            <select name="reserv_person">
                <?php
                foreach ($result_staff as $staff) {
                    ?>
                    <option value="<?=$staff['ad_name']?>" <?if($row['reserv_person']==$staff['ad_name']){?>selected<?}?>><?=$staff['ad_name']?></option>
                    <?
                }
                ?>
            </select>
            <img type="button" src="../image/modify.gif" id="person_btn" value="변경" style="cursor: pointer;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <img src="../image/change_list_btn.png" onclick="reserv_content();" style="cursor: pointer;" /></a>
            <img src="../image/character_list_btn.png" onclick="reserv_sms();" style="cursor: pointer;"  /> <span class="date">확정일 <input type="text" id="ok_date" name="ok_date" value="<?=$ok_date?>" size="15"> <img type="button" src="../image/modify.gif" id="ok_date_btn" value="변경" style="cursor: pointer;"> </span> &nbsp;&nbsp; &nbsp;<span class="date"> [접수일 : <?=substr($row['indate'],0,16)?>]</span> <a href="javascript:window.close();" class="close"><img src="../image/close_btn.png" /></a></p>
    </div>
    <div class="lcontent">
        <form id="user_frm">
            <div id="reserv_user" class="member_info">
            </div>
        </form>
        <form id="amt_frm">
            <div class="deposit_info">

                <div id="reserv_amount">
                </div>

                <table style="width: 100%">
                    <tr>
                        <th ><span>진행사항</span><img type="button" src="../image/upd_btn.png" onclick="sum_update();" style="cursor: pointer;vertical-align: middle;"/></th>
                        <td ><textarea name="reserv_summarize" id="reserv_summarize" class="summarize"><?=$row['reserv_summarize']?></textarea></td>
                    </tr>
                </table>
            </div>
        </form><!-- deposit_info 끝 -->
    </div> <!-- lcontent 끝 -->
    <div class="rcontent">

        <form name="sale_air_frm" id="sale_air_frm">
            <div style="margin-bottom: 10px;" id="sale_air"></div>
        </form>

        <form id="no_air_frm">
            <div style="margin-bottom: 10px;" id="normal_air"></div>
        </form>


        <form id="rent_frm">
            <div style="margin-bottom: 10px;" id="rentcar"></div>
        </form>


        <form id="lodging_frm">
            <div style="margin-bottom: 5px;" id="lodging"></div>
        </form>



        <form id="bustour_frm">
            <div style="margin-bottom: 5px;" id="bustour"></div>
        </form>


        <form id="golf_frm">
            <div style="margin-bottom: 5px;" id="golf"></div>
        </form>


            <form id="bus_frm">
                <div style="margin-bottom: 5px;" id="bus"></div>
            </form>

        <form id="equip_frm">
            <div style="margin-bottom: 5px;" id="equip"></div>
        </form>

    </div> <!-- rcontent 끝 -->
    <div>

        <div><img src="../image/sale_add_btn.png" type="button" id="sale_air_btn" style="cursor: pointer;"></div>
        <div><img src="../image/normal_add_btn.png"  type="button" id="normal_air_btn" style="cursor: pointer;"></div>
        <div><img src="../image/rent_add_btn.png"  type="button" id="rentcar_btn" style="cursor: pointer;"></div>
        <div><img src="../image/lod_add_btn.png"  type="button" id="lodging_btn" style="cursor: pointer;"></div>
        <div><img src="../image/bus_add_btn.png"  type="button" id="bus_btn" style="cursor: pointer;"></div>
        <div><img src="../image/bustour_add_btn.png"  type="button" id="bustour_btn" style="cursor: pointer;"></div>
        <div><img src="../image/golf_add_btn.png"  type="button" id="golf_btn" style="cursor: pointer;"></div>
        <div><img src="../image/equip_add_btn.png"  type="button" id="equip_btn" style="cursor: pointer;"></div>
        <br>
        <br>
        <div><input type="button" value="예약완료문자" onclick="sms_all();"> </div>
    </div>

</div>
<div id="type_view"></div>
<script>
    $(window).on('load', function() {
        type_load();
        user_content();
        user_amount();
        air();
        normal_air();
        rent();
        lodging();
        bus();
        bustour();
        golf();
        equip();
    });
    function type_load() {
        var url = "type_view.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#type_view").html(data); // show response from the php script.
                 console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
               if($("#air_type").val()==undefined){
                    $("#sale_air").hide();
               }
                if($("#n_air_type").val()==undefined){
                    $("#normal_air").hide();
                }
                if($("#rent_type").val()==undefined){
                    $("#rentcar").hide();
                }
                if($("#tel_type").val()==undefined){
                    $("#lodging").hide();
                }
                if($("#bus_type").val()==undefined){
                    $("#bus").hide();
                }
                if($("#bustour_type").val()==undefined){
                    $("#bustour").hide();
                }
                if($("#golf_type").val()==undefined){
                    $("#golf").hide();
                }
            }
        });
    }
    function air() {
        var url = "sale_air.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#sale_air").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function normal_air() {
        var url = "normal_air.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#normal_air").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function rent() {
        var url = "rentcar.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#rentcar").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function lodging() {
        var url = "lodging.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#lodging").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function bus() {
        var url = "bus.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#bus").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function bustour() {
        var url = "bustour.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#bustour").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function golf() {
        var url = "golf.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#golf").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function equip() {
        var url = "equip.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#equip").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                type_load();
                user_amount();
            }
        });
    }
    function user_content() {
        var url = "reserv_user.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#reserv_user").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function user_amount() {
        var url = "reserv_amount.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#reserv_amount").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function sms_all() {
        window.open("../SMS/mms.php?reserv_no=<?=$no?>&c=res_all","sms","width=254,height=460");
    }
    $(document).ready(function () {
        $("#sale_air_btn").click(function () {
            window.open("sale_air_add.php?no=<?=$no?>","sale_air_add","width=1000,height=500,scrollbars=yes")
        });
        $("#normal_air_btn").click(function () {
            window.open("normal_air_add.php?no=<?=$no?>","normal_air_add","width=1000,height=500,scrollbars=yes")
        });
        $("#rentcar_btn").click(function () {
            window.open("rentcar_add.php?no=<?=$no?>","rent_add","width=1000,height=500,scrollbars=yes")
        });
        $("#lodging_btn").click(function () {
            window.open("lodging_add.php?no=<?=$no?>","lodging_add","width=1000,height=500,scrollbars=yes")
        });
        $("#bus_btn").click(function () {
            window.open("bus_add.php?no=<?=$no?>","bus_add","width=1000,height=500,scrollbars=yes")
        });
        $("#bustour_btn").click(function () {
            window.open("bustour_add.php?no=<?=$no?>","bustour_add","width=1000,height=500,scrollbars=yes")
        });
        $("#golf_btn").click(function () {
            window.open("golf_add.php?no=<?=$no?>","golf_add","width=1000,height=500,scrollbars=yes")
        });
        $("#equip_btn").click(function () {
            window.open("equip_add.php?no=<?=$no?>","equip_add","width=1000,height=220,scrollbars=yes")
        });
        $("#state_btn").click(function () {
            var url = "reserv_user_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "reserv_user_no=<?=$no?>&state="+$("select[name='reserv_state']").val()+"&case=state_update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask()
                },
                complete: function () {
                    closeWindowByMask();
                }
            });

        });
        $("#ok_date_btn").click(function () {
            var url = "reserv_user_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "reserv_user_no=<?=$no?>&ok_date="+$("#ok_date").val()+"&case=ok_date_update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask()
                },
                complete: function () {
                    closeWindowByMask();
                    window.location.reload();
                }
            });

        });
        $("#person_btn").click(function () {
            var url = "reserv_user_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "reserv_user_no=<?=$no?>&person="+$("select[name='reserv_person']").val()+"&case=person_update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask()
                },
                complete: function () {
                   window.location.reload();
                }
            });

        });
        $(".price_sum1").keyup(function () {
           var sum1 = $(".price_sum1").val();
           var sum2 = $(".price_sum2").val();

           var total = Number(sum1)
        })
    });
</script>
</body>
</html>
