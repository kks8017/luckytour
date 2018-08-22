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
    $sql_amount = "insert into reservation_amount(reserv_user_no) values('{$reserv_no}')";
    $db->sql_query($sql_amount);
    echo "<script>
                window.location.href = 'reservation_ledger.php?no={$reserv_no}'
          </script>";
}

$no = $_REQUEST['no'];

$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

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
    <link href="../css/admin.css" rel="stylesheet">
    <link href="../css/normalize.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        window.open("sale_air_update.php?no=<?=$no?>&reserv_air_no="+no,"sale_air_update","width=1000,height=500")
    }
    function air_update_normal(no) {
        window.open("normal_air_update.php?no=<?=$no?>&reserv_air_no="+no,"normal_air_update","width=1000,height=500")
    }
    function rent_update(no) {
        window.open("rentcar_update.php?no=<?=$no?>&reserv_rent_no="+no,"rent_update","width=1000,height=500")
    }
    function lodging_update(no) {
        window.open("lodging_update.php?no=<?=$no?>&reserv_lodging_no="+no,"lodging_update","width=1000,height=500")
    }
    function bus_update(no) {
        window.open("bus_update.php?no=<?=$no?>&reserv_bus_no="+no,"bus_update","width=1000,height=500")
    }
    function bustour_update(no) {
        window.open("bustour_update.php?no=<?=$no?>&reserv_bustour_no="+no,"bustour_update","width=1000,height=500")
    }
    function golf_update(no) {
        window.open("golf_update.php?no=<?=$no?>&reserv_golf_no="+no,"golf_update","width=1000,height=500")
    }
    function equip_update(no) {
        window.open("equip_update.php?no=<?=$no?>&reserv_equip_no="+no,"equip_update","width=1000,height=300")
    }
    function amount_update(no) {
        window.open("reserv_amount_update.php?reserv_user_no=<?=$no?>","amount_update","width=1000,height=500")
    }
    function reserv_content() {
        window.open("reserv_content.php?no=<?=$no?>","content_update","width=1000,height=500")
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

    function air_ledger_update_normal(no){
        var url = "air_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#normal_air_frm").serialize()+"&reserv_user_no=<?=$no?>&reserv_air_no="+no+"&case=ledger_update", // serializes the form's elements.
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
            data: $("#user_frm").serialize()+"&no=<?=$no?>&reserv_summarize="+$("#reserv_summarize").val()+"&case=update", // serializes the form's elements.
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
</script>
<body>
<div class="reservation_ledger">
        <div class="reservation_ledger_top">
            <table>
                <tr>
                    <td class="title"><span class="font_realbule"><?=$row['reserv_name']?></span>님예약현황</td>
                    <td class="indate"> 접수상태 :
                        <select name="reserv_state">
                            <option value="WT" <?if($row['reserv_state']=="WT"){?>selected<?}?>>접수</option>
                            <option value="BL" <?if($row['reserv_state']=="BL"){?>selected<?}?>>보류</option>
                            <option value="OK" <?if($row['reserv_state']=="OK"){?>selected<?}?>>완료</option>
                            <option value="CL" <?if($row['reserv_state']=="CL"){?>selected<?}?>>취소</option>
                            <option value="GL" <?if($row['reserv_state']=="GL"){?>selected<?}?>>결항</option>
                            <option value="BJ" <?if($row['reserv_state']=="BJ"){?>selected<?}?>>부재</option>
                        </select>
                        <input type="button" id="state_btn" value="변경">
                    </td>
                    <td class="indate"> 담당자 :
                        <select name="reserv_person">
                            <?php
                            foreach ($result_staff as $staff) {
                            ?>
                                <option value="<?=$staff['no']?>" <?if($row==$staff['no']){?>selected<?}?>><?=$staff['ad_name']?></option>
                            <?
                            }
                            ?>
                        </select>
                        <input type="button" value="변경">
                    </td>
                    <td class="cont"><input type="button" onclick="reserv_content();" value="변경내역" > <input type="button" value="문자내역" ></td>
                    <td class="indate"> 접수일 : <?=$row['indate']?></td>
                </tr>
            </table>
        </div>
        <div class="reservation_ledger_left">
            <form id="user_frm">
            <div id="reserv_user">
            </div>
            </form>
            <form id="amt_frm">
            <div id="reserv_amount">
            </div>
            </form>
            <table>
                <tr>
                    <td >진행사항</td>
                    <td > <textarea name="reserv_summarize" id="reserv_summarize" rows="9" cols="60"></textarea></td>
                </tr>
            </table>
        </div>
        <div class="reservation_ledger_right">
           <div>
               <form id="sale_air_frm">
                <div id="sale_air"></div>
               </form>
               <form id="normal_air_frm">
                <div id="normal_air"></div>
               </form>
               <form id="rent_frm">
                   <div id="rentcar"></div>
               </form>
               <form id="lodging_frm">
                   <div id="lodging"></div>
               </form>
               <form id="bus_frm">
                   <div id="bus"></div>
               </form>
               <form id="bustour_frm">
                   <div id="bustour"></div>
               </form>
               <form id="golf_frm">
                   <div id="golf"></div>
               </form>
               <form id="equip_frm">
                   <div id="equip"></div>
               </form>
           </div>
        </div>
        <div>

                <div><input type="button" id="sale_air_btn" value="할인항공추가"></div>
                <div><input type="button" id="normal_air_btn" value="일반항공추가"></div>
                <div><input type="button" id="rentcar_btn" value="렌트카추가"></div>
                <div><input type="button" id="lodging_btn" value="숙박추가"></div>
                <div><input type="button" id="bus_btn" value="버스/택시추가"></div>
                <div><input type="button" id="bustour_btn" value="버스투어추가"></div>
                <div><input type="button" id="golf_btn" value="골프추가"></div>
                <div><input type="button" id="equip_btn" value="편의장비추가"></div>
        </div>

</div>
<script>
    $(window).on('load', function() {
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
    $(document).ready(function () {
        $("#sale_air_btn").click(function () {
           window.open("sale_air_add.php?no=<?=$no?>","sale_air_add","width=1000,height=500")
        });
        $("#normal_air_btn").click(function () {
            window.open("normal_air_add.php?no=<?=$no?>","normal_air_add","width=1000,height=500")
        });
        $("#rentcar_btn").click(function () {
            window.open("rentcar_add.php?no=<?=$no?>","rent_add","width=1000,height=500")
        });
        $("#lodging_btn").click(function () {
            window.open("lodging_add.php?no=<?=$no?>","lodging_add","width=1000,height=500")
        });
        $("#bus_btn").click(function () {
            window.open("bus_add.php?no=<?=$no?>","bus_add","width=1000,height=500")
        });
        $("#bustour_btn").click(function () {
            window.open("bustour_add.php?no=<?=$no?>","bustour_add","width=1000,height=500")
        });
        $("#golf_btn").click(function () {
            window.open("golf_add.php?no=<?=$no?>","golf_add","width=1000,height=500")
        });
        $("#equip_btn").click(function () {
            window.open("equip_add.php?no=<?=$no?>","equip_add","width=1000,height=220")
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
    });
</script>
</body>
</html>
