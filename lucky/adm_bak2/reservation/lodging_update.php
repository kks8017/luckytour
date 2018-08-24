<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_lodging_no = $_REQUEST['reserv_lodging_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);

$sql_lodging = "select * from reservation_lodging where no='{$reserv_lodging_no}'";
$rs_lodging = $db->sql_query($sql_lodging);
$row_lodging = $db->fetch_array($rs_lodging);



$company = set_company();
$reserv_date = $res->reserv_date($no);

$lodging_list_area = $lodging->lodging_code('A');
$lodging_list_type = $lodging->lodging_code('C');

$start_date = explode("-",$row_lodging['reserv_tel_date']);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 숙박변경</title>
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

    function lodging_add(lodno,roomno,start_date,stay,few,adult_number,child_number,baby_number){
        var url = "lodging_reserv_process.php"; // the script where you handle the form input.
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
                $(opener.location).attr("href", "javascript:lodging();");
                 window.close();
            }
        });
    }
    function lodging_update(lodno,roomno,start_date,stay,few,adult_number,child_number,baby_number){
        var url = "lodging_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "&no=<?=$reserv_lodging_no?>&lodno="+lodno+"&roomno="+roomno+"&start_date="+start_date+"&stay="+stay+"&few="+few+"&adult_number="+adult_number+"&child_number="+child_number+"&baby_number="+baby_number+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=srh_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:lodging();");
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
                <td>숙박변경</td>
            </tr>
        </table>
        <form id="lod_sch_frm">
            <table>
                <tr>
                    <td class="title">숙소명(객실명)</td>
                    <td colspan="3" class="cont"><input type="text" name="reserv_tel_name" value="<?=$row_lodging['reserv_tel_name']?>">(<input type="text" name="reserv_tel_room_name" value="<?=$row_lodging['reserv_tel_room_name']?>">)</td>
                </tr>
                <tr>
                    <td class="title">입실일자</td>
                    <td class="cont"><input type="text" name="start_year" id="start_year" size="5" value="<?=$start_date[0]?>">년
                        <input type="text" name="start_month" id="start_month" size="3" value="<?=$start_date[1]?>">월
                        <input type="text" name="start_day" id="start_day" size="3" value="<?=$start_date[2]?>">일
                    </td>
                    <td class="title">사용일</td>
                    <td class="cont">
                        <select name="tel_stay">
                            <?for($i=1;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_lodging['reserv_tel_stay']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>박
                    </td>
                </tr>
                <tr>
                    <td class="title">객실수</td>
                    <td class="cont" >
                        <select name="lodging_vehicle">
                            <?for($i=1;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_lodging['reserv_tel_few']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>
                    </td>
                    <td class="title">인원수</td>
                    <td class="cont" >
                        성인 : <input type="text" name="adult_number" value="<?=$row_lodging['reserv_tel_adult_number']?>" size="3"> 소아 : <input type="text" name="child_number" value="<?=$row_lodging['reserv_tel_child_number']?>" size="3"> 유아 : <input type="text" name="baby_number" value="<?=$row_lodging['reserv_tel_baby_number']?>" size="3">
                    </td>
                </tr>
                <tr>
                    <td class="title">판매가</td>
                    <td class="cont" >
                        <input type="text" name="reserv_tel_total_price" value="<?=$row_lodging['reserv_tel_total_price']?>" size="12">
                    </td>
                    <td class="title">입금가</td>
                    <td class="cont" >
                        <input type="text" name="reserv_tel_total_dposit_price" value="<?=$row_lodging['reserv_tel_total_dposit_price']?>" size="12">
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4"><input type="button" id="tel_update_btn" value="숙소변경"><input type="button" id="tel_delete_btn" value="숙소삭제"></td>
                </tr>
              </table>

                <table>
                <tr>
                    <td class="title">숙박위치</td>
                    <td class="cont" colspan="3">
                        <input type='radio' name='reserv_lodging_area' value='' checked>전체
                        <?php
                        foreach ($lodging_list_area as $area){
                            echo " <input type='radio' name='reserv_lodging_area' value='{$area['no']}'>{$area['lodging_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">숙박타입</td>
                    <td class="cont" colspan="3">
                        <input type='radio' name='reserv_lodging_type' value='' checked>전체
                        <?php
                        foreach ($lodging_list_type as $type){
                            echo " <input type='radio' name='reserv_lodging_type' value='{$type['no']}'>{$type['lodging_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">숙소명</td>
                    <td class="cont" colspan="3">
                        <input type="text" name="search_name" >
                    </td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$row_reserv['no']?>">
            <input type="hidden" name="no" value="<?=$row_lodging['no']?>">
        </form>
        <table>
            <tr>
                <td align="center"><input type="button" id="lod_sch_btn" value="검색"></td>
            </tr>
        </table>
    </div>
    <div id="lod_list">

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#lod_sch_btn").click(function () {

            var url = "lodging_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#lod_sch_frm").serialize()+"&type=update", // serializes the form's elements.
                success: function (data) {
                    $("#lod_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        });
        $("#tel_update_btn").click(function () {

            var url = "lodging_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#lod_sch_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    $(opener.location).attr("href", "javascript:lodging();");
                    alert("숙소 수정을 하셨습니다.");
                    window.close();
                }
            });
        });
        $("#tel_delete_btn").click(function () {

            var url = "lodging_reserv_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#lod_sch_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        console.log(data);
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        $(opener.location).attr("href", "javascript:lodging();");
                        alert("숙소을 삭제 하셨습니다.");
                        window.close();
                    }
                });
            }
        });
    });
</script>

</body>
