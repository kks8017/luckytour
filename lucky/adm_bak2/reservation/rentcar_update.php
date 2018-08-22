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

$start_date = explode("-",$reserv_date[0]);
$start_time = explode(":",$reserv_date[1]);

$end_date = explode("-",$reserv_date[2]);
$end_time = explode(":",$reserv_date[3]);

$rent->carno = $row_rent['reserv_rent_carno'];
$rent_company = $rent->company_list();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 렌트추가</title>
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
<div class="reserv_rent_add">
    <div>
        <table>
            <tr>
                <td>렌트추가</td>
            </tr>
        </table>
        <form id="rent_sch_frm">
            <table>
                <tr>
                    <td class="title">출고일자</td>
                    <td class="cont"><input type="text" name="start_year" id="start_year" size="5" value="<?=$start_date[0]?>">년
                        <input type="text" name="start_month" id="start_month" size="3" value="<?=$start_date[1]?>">월
                        <input type="text" name="start_day" id="start_day" size="3" value="<?=$start_date[2]?>">일
                        <input type="text" name="start_hour" id="start_hour" size="3" value="<?=$start_time[0]+1?>">시
                        <input type="text" name="start_minute" id="start_minute" size="3" value="<?=$start_time[1]?>">분
                    </td>
                    <td class="title">입고일자</td>
                    <td class="cont"><input type="text" name="end_year" id="end_year" size="5" value="<?=$end_date[0]?>">년
                        <input type="text" name="end_month" id="end_month" size="3" onkeyup="use_time_set();" value="<?=$end_date[1]?>">월
                        <input type="text" name="end_day" id="end_day" size="3" onkeyup="use_time_set();" value="<?=$end_date[2]?>">일
                        <input type="text" name="end_hour" id="end_hour" size="3" onkeyup="use_time_set();" value="<?=$end_time[0]-1?>">시
                        <input type="text" name="end_minute" id="end_minute" size="3" onkeyup="use_time_set();" value="<?=$end_time[1]?>">분
                    </td>
                </tr>
                <tr>
                    <td class="title">차량명</td>
                    <td class="cont" colspan="3"><select name="reserv_type">
                            <?php
                            foreach ($rent_list_type as $rent_type){
                                if($rent_type['rent_config_name']==$row_rent['reserv_rent_car_type']){$sel ="selected";}else{$sel="";}
                                    echo " <option value='{$rent_type['rent_config_name']}'>{$rent_type['rent_config_name']}</option>";
                            }
                            ?>
                        </select> <input type="text" name="reserv_rent_car_name" id="reserv_rent_car_name" value="<?=$row_rent['reserv_rent_car_name']?>">
                    <select name="reserv_fuel">
                        <?php
                        foreach ($rent_list_fuel as $rent_fuel){
                            if($rent_fuel['rent_config_name']==$row_rent['reserv_rent_car_fuel']){$sel ="selected";}else{$sel="";}
                            echo " <option value='{$rent_fuel['rent_config_name']}' {$sel}>{$rent_fuel['rent_config_name']}</option>";
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
                    <td class="title">사용시간</td>
                    <td class="cont"><input type="text" name="reserv_rent_time" id="reserv_rent_time" value="<?=$row_rent['reserv_rent_time']?>" size="3">시간</td>
                    <td class="title">차량대수</td>
                    <td class="cont">
                        <input type="text" name="reserv_rent_vehicle" id="reserv_rent_vehicle" size="4" value="<?=$row_rent['reserv_rent_vehicle']?>"> 대
                    </td>
                </tr>
                <tr>
                    <td class="title">판매할인율</td>
                    <td class="cont"><input type="text" name="reserv_rent_sale" id="reserv_rent_sale" size="2" value="<?=$row_rent['reserv_rent_sale']?>" onkeyup="use_time_set()">%</td>
                    <td class="title">입금할인율</td>
                    <td class="cont"><input type="text" name="reserv_rent_deposit_sale" id="reserv_rent_deposit_sale" size="2" value="<?=$row_rent['reserv_rent_deposit_sale']?>" onkeyup="use_time_set()">%</td>
                </tr>
                <tr>
                    <td class="title">판매가</td>
                    <td class="cont"><input type="text" name="reserv_rent_total_price" id="reserv_rent_total_price" size="10" value="<?=set_comma($row_rent['reserv_rent_total_price'])?>">원</td>
                    <td class="title">입금가</td>
                    <td class="cont"><input type="text" name="reserv_rent_total_deposit_price" id="reserv_rent_total_deposit_price" size="10" value="<?=set_comma($row_rent['reserv_rent_total_deposit_price'])?>">원</td>
                </tr>
                <tr>
                    <td class="title">부가서비스</td>
                    <td class="cont" colspan="3">
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
                    <td class="title">출고장소</td>
                    <td class="cont"><input type="text" name="reserv_rent_departure_place" id="reserv_rent_departure_place" size="25" value="<?=$row_rent['reserv_rent_departure_place']?>"></td>
                    <td class="title">입고장소</td>
                    <td class="cont"><input type="text" name="reserv_rent_arrival_place" id="reserv_rent_arrival_place" size="25" value="<?=$row_rent['reserv_rent_arrival_place']?>"></td>
                </tr>
                </tr>
             </table>
            <table>
                <tr>
                    <td align="center"><input type="button" id="rent_update_btn" value="변경"> <input type="button" id="rent_delete_btn" value="삭제"></td>
                </tr>
            </table>
             <table>
               <tr>
                    <td class="title">차량타입</td>
                    <td class="cont" colspan="3">
                        <input type='radio' name='reserv_rent_car_type' value='' checked>전체
                        <?php
                        foreach ($rent_list_type as $rent_type){
                            echo " <input type='radio' name='reserv_rent_car_type' value='{$rent_type['rent_config_name']}'>{$rent_type['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">차량연료</td>
                    <td class="cont" colspan="3">
                        <input type='radio' name='reserv_rent_fuel_type' value='' checked>전체
                        <?php
                        foreach ($rent_list_fuel as $rent_fuel){
                            echo " <input type='radio' name='reserv_rent_fuel_type' value='{$rent_fuel['rent_config_name']}'>{$rent_fuel['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">부가서비스 선택</td>
                    <td class="cont" colspan="3">
                        <?php
                        foreach ($rent_list_add as $rent_add){
                            if($rent_add['rent_config_chk']=="Y"){$sel="checked";}else{$sel="";}
                            echo " <input type='checkbox' name='reserv_rent_option[]' value='{$rent_add['rent_config_name']}' {$sel}>{$rent_add['rent_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
            </table>
             <input type="hidden" name="reserv_rent_no" value="<?=$row_rent['no']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$no?>">
        </form>
        <table>
            <tr>
                <td align="center"><input type="button" id="rent_sch_btn" value="검색"></td>
            </tr>
        </table>
    </div>
    <div id="rent_list">

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
</script>

</body>
