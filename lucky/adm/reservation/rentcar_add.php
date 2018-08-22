<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);




$company = set_company();
$reserv_date = $res->reserv_date($no);

$rent_list_type = $rent->rent_code('T');
$rent_list_fuel = $rent->rent_code('F');
$rent_list_add = $rent->rent_code('B');

$start_date = explode("-",$reserv_date[0]);
$start_time = explode(":",$reserv_date[1]);

$end_date = explode("-",$reserv_date[2]);
$end_time = explode(":",$reserv_date[3]);

if(strpos($row_reserv['reserv_type'],"A")!==false){
    $start_hour = $start_time[0] +1 ;
    $end_hour = $end_time[0]-1;
}else{
    $start_hour = "08" ;
    $end_hour = "08";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 렌트추가</title>
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

    function rent_add(no,start_date,end_date,rent_vehicle,rent_option,rent_com_no){
        var url = "rent_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&start_date="+start_date+"&end_date="+end_date+"&rent_vehicle="+rent_vehicle+"&rent_option="+rent_option+"&rent_com_no="+rent_com_no+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=insert", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:rent();");
                window.close();
            }
        });
    }
</script>
<body>
<div id="wraprent" >
    <div style="margin-bottom: 5px;">
        <header><p>렌트카추가 </p></header>
        <form id="rent_sch_frm">
            <table>
                <tr>
                    <th >출고일자</th>
                    <td ><input type="text" name="start_date" id="start_date" size="15" value="<?=$row_reserv['reserv_tour_start_date']?>">
                        <input type="text" name="start_hour" id="start_hour" size="3" value="<?=$start_hour?>">시
                        <input type="text" name="start_minute" id="start_minute" size="3" value="<?=$start_time[1]?>">분
                    </td>
                    <th >입고일자</th>
                    <td ><input type="text" name="end_date" id="end_date" size="15" value="<?=$row_reserv['reserv_tour_end_date']?>">
                        <input type="text" name="end_hour" id="end_hour" size="3" value="<?=$end_hour?>">시
                        <input type="text" name="end_minute" id="end_minute" size="3" value="<?=$end_time[1]?>">분
                    </td>
                </tr>
                <tr>
                    <th >차량대수</th>
                    <td  colspan="3">
                        <input type="text" name="reserv_rent_vehicle" id="reserv_rent_vehicle" size="4" value="1"> 대
                    </td>
                </tr>
                <tr>
                    <th >차량타입</th>
                    <td  colspan="3">
                        <input type='radio' name='reserv_rent_car_type' value='' checked>전체
                        <?php
                        foreach ($rent_list_type as $rent_type){
                            echo " <input type='radio' name='reserv_rent_car_type' value='{$rent_type['no']}'>{$rent_type['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >차량연료</th>
                    <td  colspan="3">
                        <input type='radio' name='reserv_rent_fuel_type' value='' checked>전체
                        <?php
                        foreach ($rent_list_fuel as $rent_fuel){
                            echo " <input type='radio' name='reserv_rent_fuel_type' value='{$rent_fuel['no']}'>{$rent_fuel['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >부가서비스 선택</th>
                    <td  colspan="3">
                        <?php
                        foreach ($rent_list_add as $rent_add){
                            if($rent_add['rent_config_chk']=="Y"){$sel="checked";}else{$sel="";}
                            echo " <input type='checkbox' name='reserv_rent_option[]' value='{$rent_add['rent_config_name']}' {$sel}>{$rent_add['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >이름검색</th>
                    <td  colspan="3">
                        <input type="text" name="search_name" id="search_name" >
                    </td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
        </form>
        <table>
            <tr>
                <th  ><input type="button" id="rent_sch_btn" value="검색"></th>
            </tr>
        </table>
    </div>
    <div class="inbody" id="rent_list">

    </div>
</div>
<script>
    $("#search_name").keydown(function (key){
        if(key.keyCode == 13){
            var url = "rentcar_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_sch_frm").serialize()+"&type=add", // serializes the form's elements.
                success: function (data) {
                    $("#rent_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        }
    });
    $(document).ready(function () {
        $("#rent_sch_btn").click(function () {

            var url = "rentcar_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_sch_frm").serialize()+"&type=add", // serializes the form's elements.
                success: function (data) {
                    $("#rent_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

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
