<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_equip_no = $_REQUEST['reserv_equip_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);

$sql_eq = "select * from reservation_equip where no='{$reserv_equip_no}'";
//echo $sql_bustour;
$rs_eq = $db->sql_query($sql_eq);
$row_eq = $db->fetch_array($rs_eq);

$start_date = explode("-",$row_eq['reserv_equip_date']);

$sql_equip  = "select * from equipment_list order by equip_sort_no";
$rs_equip   = $db->sql_query($sql_equip);
while ($row_equip = $db->fetch_array($rs_equip)){
    $result_equip[] = $row_equip;
}

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
<div id="wraplod">
    <div>
        <header><p>편의장비변경 </p></header>
        <form id="bustour_sch_frm">
            <table>
                <tr>
                    <th >편의장비명</th>
                    <td  colspan="3">
                        <select name="equip_no">
                            <?foreach ($result_equip as $equip){?>
                                <option value="<?=$equip['no']?>" <?if($row_eq['reserv_equip_no']==$equip['no']){?>selected<?}?>><?=$equip['equip_name']?></option>
                            <?}?>
                        </select>
                        (<input type="text" name="reserv_equip_content" id="reserv_equip_content" value="<?=$row_eq['reserv_equip_content']?>" >)</td>
                </tr>
                <tr>
                    <th >여행일자</th>
                    <td ><input type="text" name="start_year" id="start_year" size="5" value="<?=$start_date[0]?>">년
                        <input type="text" name="start_month" id="start_month" size="3" value="<?=$start_date[1]?>">월
                        <input type="text" name="start_day" id="start_day" size="3" value="<?=$start_date[2]?>">일
                        (<select name="reserv_equip_stay">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_eq['reserv_equip_stay']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>일)
                    </td>
                    <th >인원/대수</th>
                    <td >
                        <select name="reserv_equip_number">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_eq['reserv_equip_number']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>명 /
                        <select name="reserv_equip_vehicle">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($row_eq['reserv_equip_vehicle']==$i){?>selected<?}?>><?=$i?></option>
                            <?}?>
                        </select>대
                    </td>
                </tr>
                <tr>
                    <th >판매가</th>
                    <td  ><input type="text" name="reserv_equip_total_price" value="<?=set_comma($row_eq['reserv_equip_total_price'])?>" size="10"></td>
                    <th >입금가</th>
                    <td  ><input type="text" name="reserv_equip_total_deposit_price" value="<?=set_comma($row_eq['reserv_equip_total_deposit_price'])?>" size="10"></td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$row_reserv['no']?>">
            <input type="hidden" name="no" value="<?=$row_eq['no']?>">
        </form>
        <table>
            <tr>
                <th align="center"><input type="button" id="update_btn" value="변경"> <input type="button" id="delete_btn" value="삭제"></th>
            </tr>
        </table>
    </div>

</div>
<script>
    $(document).ready(function () {

        $("#update_btn").click(function () {

            var url = "equip_reserv_process.php"; // the script where you handle the form input.
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
                    $(opener.location).attr("href", "javascript:equip();");
                    alert("편의장비을 수정 하셨습니다.");
                    // window.close();
                }
            });
        });
        $("#delete_btn").click(function () {

            var url = "equip_reserv_process.php"; // the script where you handle the form input.
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
                        $(opener.location).attr("href", "javascript:equip();");
                        alert("편의장비을 삭제 하셨습니다.");
                        window.close();
                    }
                });
            }
        });
    });
</script>

</body>
