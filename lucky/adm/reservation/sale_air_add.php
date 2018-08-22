<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

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
$sql_company = "select air_name from air_company  where air_type='S' and air_sch_ok='Y' order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company['air_name'];
}
$start_date = explode("-",$row_reserv['reserv_tour_start_date']);
$end_date = explode("-",$row_reserv['reserv_tour_end_date']);
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

    function air_add(no,com_no,num_ad,num_ch,num_yu){
        var url = "air_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&air_company_no="+com_no+"&air_adult_number="+num_ad+"&air_child_number="+num_ch+"&air_baby_number="+num_yu+"&reserv_user_no=<?=$no?>&case=insert", // serializes the form's elements.
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
<div id="wrapair" >
    <div>
        <header><p>할인항공추가 </p></header>
        <form id="air_sch_frm">
            <table>
                <tr>
                    <th >출발일자</th>
                    <td ><input type="text" name="start_date" id="start_date" size="20" value="<?=$row_reserv['reserv_tour_start_date']?>"></td>
                    <th >리턴일자</th>
                    <td ><input type="text" name="end_date" id="end_date" size="20" value="<?=$row_reserv['reserv_tour_end_date']?>"></td>
                </tr>
                <tr>
                    <th >출발지역</th>
                    <td >
                        <select name="sch_departure_area">
                            <?php
                            foreach ($tour_air_area as $area){
                                $area_name = explode("|",$area);
                                echo "<option value='{$area_name[0]}'>{$area_name[0]}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <th >인원</th>
                    <td >성인<input type="text" name="adult_number" id="adult_number" size="3" value="<?=$row_reserv['reserv_adult_number']?>"> 소아<input type="text" name="child_number" id="child_number" size="3" value="<?=$row_reserv['reserv_child_number']?>"> 유아<input type="text" name="baby_number" id="baby_number" size="3" value="<?=$row_reserv['reserv_baby_number']?>"></td>
                </tr>
                <tr>
                    <th >항공사</th>
                    <td  colspan="3">
                        <input type='radio' name='start_airline' value='' checked>전체
                        <?php
                        foreach ($result_airline as $airline){

                            echo "<input type='radio' name='start_airline' value='{$airline}'> {$airline}  ";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >에이전시</th>
                    <td  colspan="3">
                        <input type='radio' name='start_company' value='' checked>전체
                        <?php
                        foreach ($result_company as $company){

                            echo " <input type='radio' name='start_company' value='{$company}'>{$company}  ";
                        }
                        ?>
                    </td>

                </tr>
                <tr>
                    <th >시간대</th>
                    <td  colspan="3"> <label><input type="radio" name="time" value="0" checked>전체</label>
                        <label><input type="radio" name="time" value="1">6:00~7:59</label>
                        <label><input type="radio" name="time" value="2">8:00~9:59</label>
                        <label><input type="radio" name="time" value="3">10:00~11:59</label>
                        <label><input type="radio" name="time" value="4">12:00~13:59</label>
                        <label><input type="radio" name="time" value="5">14:00~15:59</label>
                        <label><input type="radio" name="time" value="6">16:00~18:59</label>
                        <label><input type="radio" name="time" value="3">17:00~21:59</label>
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
        </form>
        <table>
            <tr>
                <td  align="center"><img type="button" id="air_sch_btn" src="../image/search_btn2.png" style="cursor: pointer;" /></td>
            </tr>
        </table>
    </div>
    <div class="inbody" id="air_schedule" >

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#air_sch_btn").click(function () {

            var url = "sale_air_schedule.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#air_sch_frm").serialize()+"&type=add", // serializes the form's elements.
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
    });
    $(function() {
        var dates = $( "#start_date, #end_date " ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            dateFormat: 'yy-mm-dd',
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "../../sub_img/calender2.png",
            buttonImageOnly : true,
            numberOfMonths : 2,
            maxDate:'+1095d',
            onSelect: function( selectedDate ) {
                var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>

</body>
</html>