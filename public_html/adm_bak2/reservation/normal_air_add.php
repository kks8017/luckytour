<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_air_no = $_REQUEST['reserv_air_no'];

$sql_reserv = "select no,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


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
        loadingImg += " <img src='/com/img/viewLoading.gif'/>";
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

</script>
<body>
<div class="reserv_air_add">
    <div>
        <table>
            <tr>
                <td>항공변경</td>
            </tr>
        </table>
        <form id="air_sch_frm">
            <div id="air_reserv">

            </div>
            <table>
                <tr>
                    <td align="center"><input type="button" id="air_update_btn" value="일정추가"></td>
                </tr>
            </table>

            <input type="hidden" name="reserv_user_no" value="<?=$no?>" >

        </form>

    </div>

</div>
<script>
    $(window).on('load', function() {
        normal_air ();
    });
    function normal_air () {
        var url = "normal_air_reserv.php"; // the script where you handle the form input.
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


        $("#air_update_btn").click(function () {

            var url = "air_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#air_sch_frm").serialize()+"&case=no_insert", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    alert("일반항공추가 하셨습니다.");
                   // window.close();
                }
            });
        });

    });
</script>

</body>
</html>