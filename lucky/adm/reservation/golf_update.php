<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_golf_no = $_REQUEST['reserv_golf_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);

$sql_golf = "select * from reservation_golf where no='{$reserv_golf_no}'";
$rs_golf = $db->sql_query($sql_golf);
$row_golf = $db->fetch_array($rs_golf);



$company = set_company();
$reserv_date = $res->reserv_date($no);

$golf_list_area = $golf->golf_code("A");


$start_date = explode("-",$row_golf['reserv_golf_date']);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 골프변경</title>
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
    #wraplod{width:970px;height:373px;border:4px solid #afafaf;background-color:#e5e8ee;
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

    function golf_add(lodno,roomno,start_date,stay,few,adult_number,child_number,baby_number){
        var url = "golf_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "lodno="+lodno+"&roomno="+roomno+"&start_date="+start_date+"&stay="+stay+"&few="+few+"&adult_number="+adult_number+"&child_number="+child_number+"&baby_number="+baby_number+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=insert", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:golf();");
                window.close();
            }
        });
    }
    function golf_update(golfno,holeno,start_date,stay,adult_number){
        var url = "golf_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "&no=<?=$reserv_golf_no?>&golfno="+golfno+"&holeno="+holeno+"&start_date="+start_date+"&stay="+stay+"&golf_time="+$("#reserv_golf_time").val()+"&adult_number="+adult_number+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=srh_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:golf();");
                window.close();
            }
        });
    }
</script>
<body>
<div id="wraplod">
    <div style="margin-bottom: 20px;">
        <header><p>골프변경 </p></header>
        <form id="golf_sch_frm">
            <table>
                <tr>
                    <th >골프장명(홀명)</th>
                    <td colspan="3" ><input type="text" name="reserv_golf_name" value="<?=$row_golf['reserv_golf_name']?>">(<input type="text" name="reserv_golf_hole_name" value="<?=$row_golf['reserv_golf_hole_name']?>">)</td>
                </tr>
                <tr>
                    <th >부킹일자</th>
                    <td ><input type="text" name="start_date" id="start_date" size="16" value="<?=$row_golf['reserv_golf_date']?>">
                    </td>
                    <th >사용일</th>
                    <td >
                        <select name="golf_stay">
                            <?for($i=1;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_golf['reserv_golf_stay']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>일
                    </td>
                </tr>
                <tr>
                    <th >부킹시간</th>
                    <td  >
                        <input type="text" name="reserv_golf_time" id="reserv_golf_time" value="<?=$row_golf['reserv_golf_time']?>" size="15">
                    </td>
                    <th >인원수</th>
                    <td  >
                        <input type="text" name="adult_number" value="<?=$row_golf['reserv_golf_adult_number']?>" size="3">
                    </td>
                </tr>
                <tr>
                    <th >판매가</th>
                    <td  >
                        <input type="text" name="reserv_golf_total_price" value="<?=set_comma($row_golf['reserv_golf_total_price'])?>" size="12">
                    </td>
                    <th >입금가</th>
                    <td  >
                        <input type="text" name="reserv_golf_total_dposit_price" value="<?=set_comma($row_golf['reserv_golf_total_dposit_price'])?>" size="12">
                    </td>
                </tr>
                <tr>
                    <th align="center" colspan="4" ><input type="button" id="golf_update_btn" value="골프변경"><input type="button" id="golf_delete_btn" value="골프삭제"></th>
                </tr>
            </table>

            <table>
                <tr>
                    <th >위치</th>
                    <td  colspan="3">
                        <input type='radio' name='reserv_golf_area' value='' checked>전체
                        <?php
                        foreach ($golf_list_area as $area){
                            echo " <input type='radio' name='reserv_golf_area' value='{$area['no']}'>{$area['golf_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >골프명</th>
                    <td  colspan="3">
                        <input type="text" name="search_name" >
                    </td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$row_reserv['no']?>">
            <input type="hidden" name="no" value="<?=$row_golf['no']?>">
        </form>
        <table>
            <tr>
                <th  align="center"><input type="button" id="golf_sch_btn" value="검색"></th>
            </tr>
        </table>
    </div>

    <div class="inbody" id="golf_list">

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#golf_sch_btn").click(function () {

            var url = "golf_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#golf_sch_frm").serialize()+"&type=update", // serializes the form's elements.
                success: function (data) {
                    $("#golf_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        });
        $("#golf_update_btn").click(function () {

            var url = "golf_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#golf_sch_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    $(opener.location).attr("href", "javascript:golf();");
                    alert("골프수정을 하셨습니다.");
                    window.close();
                }
            });
        });
        $("#golf_delete_btn").click(function () {

            var url = "golf_reserv_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#golf_sch_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        console.log(data);
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        $(opener.location).attr("href", "javascript:golf();");
                        alert("숙소을 삭제 하셨습니다.");
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
