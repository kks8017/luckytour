<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_rent_no = $_REQUEST['reserv_rent_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);

$sql_rent = "select 
               no,
               reserv_rent_com_no,
               reserv_rent_com_name,
               reserv_rent_carno,
               reserv_rent_car_name,
               reserv_rent_car_fuel,
               reserv_rent_car_type,
               reserv_rent_start_date,
               reserv_rent_end_date,
               reserv_rent_time,
               reserv_rent_vehicle,
               reserv_rent_sale,
               reserv_rent_deposit_sale,
               reserv_rent_total_price,
               reserv_rent_total_deposit_price,
               reserv_rent_cash_price,
               reserv_rent_departure_place,
               reserv_rent_arrival_place,
               reserv_rent_option
             from reservation_rent where no='{$reserv_rent_no}'";

$rs_rent = $db->sql_query($sql_rent);
$row_rent = $db->fetch_array($rs_rent);

$rent_list_type = $rent->rent_code('T');
$rent_list_fuel = $rent->rent_code('F');
$rent_list_add = $rent->rent_code('B');

$start_date1 = explode(" ",$row_rent['reserv_rent_start_date']);
$start_date = explode("-",$start_date1[0]);
$start_time = explode(":",$start_date1[1]);
$end_date1 = explode(" ",$row_rent['reserv_rent_end_date']);
$end_date = explode("-",$end_date1[0]);
$end_time = explode(":",$end_date1[1]);

$rent->carno = $row_rent['reserv_rent_carno'];
$rent_company = $rent->company_list();

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

    function rent_update(no,start_date,end_date,rent_vehicle,rent_option,rent_com_no){
        var url = "rent_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&start_date="+start_date+"&end_date="+end_date+"&rent_vehicle="+rent_vehicle+"&rent_option="+rent_option+"&rent_com_no="+rent_com_no+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_rent_no=<?=$reserv_rent_no?>&reserv_user_no=<?=$no?>&case=sch_update", // serializes the form's elements.
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
    <div>
        <table>
            <tr>
                <th>렌트추가</th>
            </tr>
        </table>
        <form id="rent_sch_frm">
            <table>
                <tr>
                    <th >출고일자</th>
                    <td ><input type="text" name="start_date" id="start_date" size="15" value="<?=$start_date1[0]?>">년
                        <input type="text" name="start_hour" id="start_hour" size="3" value="<?=$start_time[0]?>">시
                        <input type="text" name="start_minute" id="start_minute" size="3" value="<?=$start_time[1]?>">분
                    </td>
                    <th >입고일자</th>
                    <td ><input type="text" name="end_date" id="end_date" size="15" value="<?=$end_date1[0]?>">년
                        <input type="text" name="end_hour" id="end_hour" size="3" onkeyup="use_time_set();" value="<?=$end_time[0]?>">시
                        <input type="text" name="end_minute" id="end_minute" size="3" onkeyup="use_time_set();" value="<?=$end_time[1]?>">분
                    </td>
                </tr>
                <tr>
                    <th >차량명</th>
                    <td  colspan="3"><select name="reserv_type">
                            <?php
                            foreach ($rent_list_type as $rent_type){
                                if($rent_type['no']==$row_rent['reserv_rent_car_type']){$sel ="selected";}else{$sel="";}
                                echo " <option value='{$rent_type['no']}' {$sel}>{$rent_type['rent_config_name']}</option>";
                            }
                            ?>
                        </select> <input type="text" name="reserv_rent_car_name" id="reserv_rent_car_name" value="<?=$row_rent['reserv_rent_car_name']?>">
                        <select name="reserv_fuel">
                            <?php
                            foreach ($rent_list_fuel as $rent_fuel){
                                if($rent_fuel['no']==$row_rent['reserv_rent_car_fuel']){$sel ="selected";}else{$sel="";}
                                echo " <option value='{$rent_fuel['no']}' {$sel}>{$rent_fuel['rent_config_name']}</option>";
                            }
                            ?>
                        </select>
                        <select name="company_list" onchange="use_time_set();">
                            <?php
                            foreach ($rent_company as $com_list){
                                if($com_list['rent_com_no']==$row_rent['reserv_rent_com_no']){$sel ="selected";}else{$sel="";}
                                echo "<option value='{$com_list['rent_com_no']}' {$sel}>{$com_list['rent_com_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>

                </tr>
                <tr>
                    <th >사용시간</th>
                    <td ><input type="text" name="reserv_rent_time" id="reserv_rent_time" value="<?=$row_rent['reserv_rent_time']?>" size="3">시간</td>
                    <th >차량대수</th>
                    <td >
                        <input type="text" name="reserv_rent_vehicle" id="reserv_rent_vehicle" size="4" value="<?=$row_rent['reserv_rent_vehicle']?>"> 대
                    </td>
                </tr>
                <tr>
                    <th >판매할인율</th>
                    <td ><input type="text" name="reserv_rent_sale" id="reserv_rent_sale" size="2" value="<?=$row_rent['reserv_rent_sale']?>" onkeyup="use_time_set()">%</td>
                    <th >입금할인율</th>
                    <td ><input type="text" name="reserv_rent_deposit_sale" id="reserv_rent_deposit_sale" size="2" value="<?=$row_rent['reserv_rent_deposit_sale']?>" onkeyup="use_time_set()">%</td>
                </tr>
                <tr>
                    <th >판매가</th>
                    <td ><input type="text" name="reserv_rent_total_price" id="reserv_rent_total_price" size="10" value="<?=set_comma($row_rent['reserv_rent_total_price'])?>">원</td>
                    <th >입금가</th>
                    <td ><input type="text" name="reserv_rent_total_deposit_price" id="reserv_rent_total_deposit_price" size="10" value="<?=set_comma($row_rent['reserv_rent_total_deposit_price'])?>">원</td>
                </tr>
                <tr>
                    <th >부가서비스</th>
                    <td  colspan="3">
                        <?php
                        $option_add = explode(",",$row_rent['reserv_rent_option']);
                        $j=0;
                        foreach ($rent_list_add as $rent_add){
                            if($option_add[$j]==$rent_add['rent_config_name']){$sel="checked";}else{$sel="";}
                            echo " <input type='checkbox' name='reserv_option[]' value='{$rent_add['rent_config_name']}' {$sel}>{$rent_add['rent_config_name']}";
                            $j++;
                        }
                        ?>
                    </td>
                <tr>
                    <th >출고장소</th>
                    <td ><input type="text" name="reserv_rent_departure_place" id="reserv_rent_departure_place" size="25" value="<?=$row_rent['reserv_rent_departure_place']?>"></td>
                    <th >입고장소</th>
                    <td ><input type="text" name="reserv_rent_arrival_place" id="reserv_rent_arrival_place" size="25" value="<?=$row_rent['reserv_rent_arrival_place']?>"></td>
                </tr>
                </tr>
            </table>
            <table>
                <tr>
                    <th align="center"><input type="button" id="rent_update_btn" value="변경"> <input type="button" id="rent_delete_btn" value="삭제"></th>
                </tr>
            </table>
            <table>
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
                        <input type="text" name="search_name" >
                    </td>
                </tr>
            </table>
            <input type="hidden" name="reserv_rent_no" value="<?=$row_rent['no']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$no?>">
        </form>
        <table>
            <tr>
                <th align="center"><input type="button" id="rent_sch_btn" value="검색"></th>
            </tr>
        </table>
    </div>
    <div class="inbody" id="rent_list">

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#rent_sch_btn").click(function () {

            var url = "rentcar_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_sch_frm").serialize()+"&type=update", // serializes the form's elements.
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
        $("#rent_update_btn").click(function () {

            var url = "rent_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_sch_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    $(opener.location).attr("href", "javascript:rent();");
                    alert("렌트카 수정을 하셨습니다.");
                    window.close();
                }
            });
        });
        $("#rent_delete_btn").click(function () {

            var url = "rent_reserv_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#rent_sch_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        console.log(data);
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        $(opener.location).attr("href", "javascript:rent();");
                        alert("렌트을 삭제 하셨습니다.");
                        window.close();
                    }
                });
            }
        });
    });
    function use_time_set() {
        var start_date;
        var end_date;
        start_date = $("#start_year").val()+"-"+$("#start_month").val()+"-"+$("#start_day").val()+" "+$("#start_hour").val()+":"+$("#start_minute").val();
        end_date   = $("#end_year").val()+"-"+$("#end_month").val()+"-"+$("#end_day").val()+" "+$("#end_hour").val()+":"+$("#end_minute").val();
        var url = "rentcar_price_set.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "start_date="+start_date+"&end_date="+end_date+"&carno=<?=$row_rent['reserv_rent_carno']?>&sale="+$("#reserv_rent_sale").val()+"&sale_deposit="+$("#reserv_rent_deposit_sale").val()+"&rent_vehicle="+$("#reserv_rent_vehicle").val()+"&company_list="+$("select[name=company_list]").val()+"&reserv_type=<?=$row_reserv['reserv_type']?>", // serializes the form's elements.
            success: function (data) {
                console.log(data);
                price = data.split("|");
                $("#reserv_rent_time").val(price[0]); // show response from the php script.
                $("#reserv_rent_total_price").val(set_comma(price[1]));
                $("#reserv_rent_total_deposit_price").val(set_comma(price[2]));

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    $(function() {
        var dates = $("#start_date, #end_date ").datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            dateFormat: 'yy-mm-dd',
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "../../sub_img/calender2.png",
            buttonImageOnly : true,
            numberOfMonths : 2,
            maxDate: '+1095d',
            onSelect: function (selectedDate) {
                var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
                use_time_set();
            }
        });
    });
</script>

</body>
