<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_bustour_no = $_REQUEST['reserv_bustour_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);

$sql_bustour = "select * from reservation_bustour where no='{$reserv_bustour_no}'";
//echo $sql_bustour;
$rs_bustour = $db->sql_query($sql_bustour);
$row_bustour = $db->fetch_array($rs_bustour);

$start_date = explode("-",$row_bustour['reserv_bustour_date']);



$stay = ( strtotime($reserv_date[2]) - strtotime($reserv_date[0]) ) / 86400;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 버스투어변경</title>
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
<style>
    #wraplod{width:970px;height:221px;border:4px solid #afafaf;background-color:#e5e8ee;
        position: relative;}
</style>
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

    function bustour_update(no,start_date,number){
        var url = "bustour_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_bustour_no=<?=$reserv_bustour_no?>&no="+no+"&start_date="+start_date+"&number="+number+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=srh_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:bustour();");
                alert("버스투어을 변경 했습니다.");
                window.close();
            }
        });
    }
</script>
<body>
<div id="wraplod">
    <div style="margin-bottom: 10px;">
        <header><p>버스투어변경 </p></header>
        <form id="bustour_sch_frm">
            <table>
                <tr>
                    <th >투어명</th>
                    <td  colspan="3"><input type="text" name="reserv_bustour_name" value="<?=$row_bustour['reserv_bustour_name']?>"> </td>
                </tr>
                <tr>
                    <th >여행일자</th>
                    <td ><input type="text" name="start_date" id="start_date" size="16" value="<?=$row_bustour['reserv_bustour_date']?>">

                    </td>
                    <td >인원</td>
                    <td >
                        <select name="bustour_number">
                            <?for($i=1;$i < 100;$i++){?>
                                <option value="<?=$i?>"<?if($row_bustour['reserv_bustour_number']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select> 명
                    </td>
                </tr>
                <tr>
                    <th >판매가</th>
                    <td  ><input type="text" name="reserv_bustour_total_price" value="<?=set_comma($row_bustour['reserv_bustour_total_price'])?>" size="10"></td>
                    <th >입금가</th>
                    <td  ><input type="text" name="reserv_bustour_deposit_price" value="<?=set_comma($row_bustour['reserv_bustour_total_deposit_price'])?>" size="10"></td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$row_reserv['no']?>">
            <input type="hidden" name="no" value="<?=$row_bustour['no']?>">
        </form>
        <table>
            <tr>
                <th  align="center"><input type="button" id="bustour_sch_btn" value="검색"> <input type="button" id="bustour_update_btn" value="변경"> <input type="button" id="bustour_delete_btn" value="삭제"></th>
            </tr>
        </table>
    </div>
    <div class="inbody" id="bustour_list">

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#bustour_sch_btn").click(function () {

            var url = "bustour_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bustour_sch_frm").serialize()+"&type=update", // serializes the form's elements.
                success: function (data) {
                    $("#bustour_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        });
        $("#bustour_update_btn").click(function () {

            var url = "bustour_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bustour_sch_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    $(opener.location).attr("href", "javascript:bustour();");
                    alert("버스투어을 수정 하셨습니다.");
                    // window.close();
                }
            });
        });
        $("#bustour_delete_btn").click(function () {

            var url = "bustour_reserv_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#bustour_sch_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        console.log(data);
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        $(opener.location).attr("href", "javascript:bustour();");
                        alert("버스투어을 삭제 하셨습니다.");
                        window.close();
                    }
                });
            }
        });
    });
    $(function() {
        var dates = $( "#start_date" ).datepicker({
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
