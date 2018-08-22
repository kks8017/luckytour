<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_air_no = $_REQUEST['reserv_air_no'];

$sql_reserv = "select no,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);

$sql_air = "select no,
                    reserv_air_airno,
                    reserv_air_company_no,
                    reserv_air_departure_area,
                    reserv_air_arrival_area,
                    reserv_air_departure_airline,
                    reserv_air_arrival_airline,
                    reserv_air_departure_company,
                    reserv_air_arrival_company,
                    reserv_air_departure_date,
                    reserv_air_arrival_date,
                    reserv_air_adult_normal_price,
                    reserv_air_child_normal_price,
                    reserv_air_adult_sale,
                    reserv_air_child_sale,
                    reserv_air_adult_deposit_sale,
                    reserv_air_child_deposit_sale,
                    reserv_air_total_price,
                    reserv_air_total_deposit_price,
                    reserv_air_adult_number,
                    reserv_air_child_number,
                    reserv_air_baby_number
            from reservation_air where no='{$reserv_air_no}' and reserv_user_no='{$no}' ";
$rs_air  = $db->sql_query($sql_air);
$row_air = $db->fetch_array($rs_air);

$company = set_company();
$tour_air_area = explode(",",$company['tour_air_area']);

$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}
$sql_company = "select air_name from air_company  where air_type='S' and air_sch_ok='Y'  order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company['air_name'];
}
$start_date1 = explode(" ",$row_air['reserv_air_departure_date']);
$start_date = explode("-",$start_date1[0]);
$start_time = explode(":",$start_date1[1]);
$end_date1 = explode(" ",$row_air['reserv_air_arrival_date']);
$end_date = explode("-",$end_date1[0]);
$end_time = explode(":",$end_date1[1]);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 항공추가</title>
    <meta charset="utf-8">
    <link href="../css/popup.css" rel="stylesheet">
    <link href="../css/reset.css" rel="stylesheet">
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
        loadingImg += " <img src='../image/viewLoading.gif'/>";
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

    function air_update(no,com_no,num_ad,num_ch,num_yu){
        var url = "air_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&air_company_no="+com_no+"&adult_number="+num_ad+"&child_number="+num_ch+"&baby_number="+num_yu+"&reserv_user_no=<?=$no?>&reserv_air_no=<?=$reserv_air_no?>&case=update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:air();");
                window.close();
            }
        });
    }
</script>
<body>
<div id="wrapair">
    <div style="margin-bottom: 20px;">
        <header><p>할인항공변경 </p></header>
        <form id="air_sch_frm">
            <div id="air_reserv">

            </div>
            <table>
                <tr>
                    <th ><input type="button" id="air_update_btn" value="일정수정"><input type="button" id="air_delete_btn" value="일정삭제"></th>
                </tr>
            </table>
            <table>
                <tr>
                    <th  colspan="4">검색</th>
                </tr>
                <tr>
                    <th >시간대</th>
                    <td  colspan="3"><label><input type="radio" name="time" value="0" checked>전체</label>
                        <label><input type="radio" name="time" value="1">6:00~7 :59</label>
                        <label><input type="radio" name="time" value="2">8:00~9:59</label>
                        <label><input type="radio" name="time" value="3">10:00~11:59</label>
                        <label><input type="radio" name="time" value="4">12:00~13:59</label>
                        <label><input type="radio" name="time" value="5">14:00~15:59</label>
                        <label><input type="radio" name="time" value="6">16:00~18:59</label>
                        <label><input type="radio" name="time" value="7">19:00~21:59</label>
                    </td>
                </tr>
                <tr>
                    <th >할인율</th>
                    <td  colspan="3">
                        <label><input type="radio" name="sale" value="0" checked>전체</label>
                        <label><input type="radio" name="sale" value="1">50%이상</label>
                        <label><input type="radio" name="sale" value="2">30~40%</label>
                        <label><input type="radio" name="sale" value="3">20~29%</label>
                        <label><input type="radio" name="sale" value="4">10~19%</label>
                        <label><input type="radio" name="sale" value="5">0~9%</label>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="reserv_air_no" value="<?=$reserv_air_no?>" >
            <input type="hidden" name="reserv_user_no" value="<?=$no?>" >

        </form>
        <table>
            <tr>
                <th ><input type="button" id="air_sch_btn" value="검색"></th>
            </tr>
        </table>
    </div>
    <div class="inbody" id="air_schedule">

    </div>
</div>
<script>
    $(window).on('load', function() {
        air ();
    });
    function air () {
        var url = "sale_air_reserv.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no=<?=$no?>&reserv_air_no=<?=$reserv_air_no?>", // serializes the form's elements.
            success: function (data) {
                $("#air_reserv").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    $(document).ready(function () {

        $("#air_sch_btn").click(function () {

            var url = "sale_air_schedule.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#air_sch_frm").serialize()+"&type=update", // serializes the form's elements.
                success: function (data) {
                    $("#air_schedule").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                }
            });
        });
        $("#air_update_btn").click(function () {

            var url = "air_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#air_sch_frm").serialize()+"&case=stay_update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    $(opener.location).attr("href", "javascript:air();");
                    alert("항공수정을 하셨습니다.");
                }
            });
        });
        $("#air_delete_btn").click(function () {

            var url = "air_reserv_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#air_sch_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        console.log(data);
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        $(opener.location).attr("href", "javascript:air();");
                        alert("항공을 삭제 하셨습니다.");
                        window.close();
                    }
                });
            }
        });
    });
 
</script>

</body>
</html>