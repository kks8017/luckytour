<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);


$start_date = explode("-",$reserv_date[0]);
$end_date = explode("-",$reserv_date[2]);


$stay = ( strtotime($reserv_date[2]) - strtotime($reserv_date[0]) ) / 86400;
$sql_equip  = "select * from equipment_list order by equip_sort_no";
$rs_equip   = $db->sql_query($sql_equip);
while ($row_equip = $db->fetch_array($rs_equip)){
    $result_equip[] = $row_equip;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 버스투어추가</title>
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
    #wraplod{width:970px;height:175px;border:4px solid #afafaf;background-color:#e5e8ee;
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
        loadingImg += " <img src='../images/viewLoading.gif'/>";
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

    function bustour_add(no,start_date,number,few){
        var url = "bustour_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&start_date="+start_date+"&number="+number+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_user_no=<?=$no?>&case=insert", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:bustour();");
                window.close();
            }
        });
    }
</script>
<body>
<div id="wraplod">
    <div>
        <header><p>편의장비추가 </p></header>
        <form id="lod_sch_frm">
            <table>
                <tr>
                    <th >편의장비명</th>
                    <td  colspan="3">
                        <select name="equip_no">
                            <?
                            foreach ($result_equip as $equip){
                                ?>
                                <option value="<?=$equip['no']?>"><?=$equip['equip_name']?></option>
                            <?}?>
                        </select>
                        (<input type="text" name="reserv_equip_content" id="reserv_equip_content" >)</td>
                </tr>
                <tr>
                    <th >여행일자</th>
                    <td ><input type="text" name="start_year" id="start_year" size="5" value="<?=$start_date[0]?>">년
                        <input type="text" name="start_month" id="start_month" size="3" value="<?=$start_date[1]?>">월
                        <input type="text" name="start_day" id="start_day" size="3" value="<?=$start_date[2]?>">일
                        (<select name="reserv_equip_stay">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?}?>
                        </select>일)
                    </td>
                    <th >인원/대수</th>
                    <td >
                        <select name="reserv_equip_number">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?}?>
                        </select>명 /
                        <select name="reserv_equip_vehicle">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?}?>
                        </select>대
                    </td>
                </tr>
            </table>

            <input type="hidden" name="reserv_type" value="<?=$row_reserv['reserv_type']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$row_reserv['no']?>">
        </form>
        <table>
            <tr>
                <th  align="center"><input type="button" id="add_btn" value="추가"></th>
            </tr>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#add_btn").click(function () {

            var url = "equip_reserv_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#lod_sch_frm").serialize()+"&case=insert", // serializes the form's elements.
                success: function (data) {
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {
                    $(opener.location).attr("href", "javascript:equip();");
                    window.close();
                }
            });
        });
    });
</script>
</body>
