<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);
$sms = new message();
$sms->reserv_no =$no;
$sms_data = $sms->total_report();

$sql_content = "select * from SDK_MMS_REPORT where  SDK_MMS_REPORT.USER_ID='{$no}' order by NOW_DATE desc";

$rs_content = $db->sql_query($sql_content);
while ($row_content = $db->fetch_array($rs_content)){
    $result[] = $row_content;
}
$sql_sms = "select * from SDK_SMS_REPORT where  SDK_SMS_REPORT.USER_ID='{$no}' order by NOW_DATE desc";
//echo $sql_sms;

$rs_sms = $db->sql_query($sql_sms);
while ($row_sms = $db->fetch_array($rs_sms)){
    $result_sms[] = $row_sms;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 변경내용</title>
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
    #wraplod{width:290px;height:180px;border:4px solid #afafaf;background-color:#e5e8ee;
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


    function content(i) {
        $("#content_"+i).slideToggle();
    }
</script>
<body>
<div>

</div>
<div id="wrapcon">
    <div >
        <table>
            <tr>
                <td class="title">보낸자</td>
                <td class="title">전화번호</td>
                <td class="title">문자제목</td>
                <td class="title">발송일시</td>
                <td class="title">전송상태</td>
            </tr>
            <?
            $i=0;
            if(is_array($sms_data)) {
            foreach ($sms_data as $data){
            if($data['MSG_ID']!="") {
            $name = explode("^", $data['DEST_INFO']);
            ?>
            <tr>
                <td class="cont"><?= $data['RESERVED2'] ?></td>

                                         <td class="cont"><?= $name[1] ?></td>
                           <td class="cont"><a href="javascript:content(<?= $i ?>);"><?= $data['SUBJECT'] ?></a></td>
                           <td class="cont"><?= substr($data['NOW_DATE'], 0, 4) ?>-<?= substr($data['NOW_DATE'], 4, 2) ?>-<?= substr($data['NOW_DATE'], 6, 2) ?> <?= substr($data['NOW_DATE'], 7, 2) ?>:<?= substr($data['NOW_DATE'], 9, 2) ?></td>
                           <td class="cont"></td>
                       </tr>
                       <tr id="content_<?= $i ?>" style="display:none;">
                           <td colspan="5" class="detail"><?= $data['SMS_MSG'] ?><?= $data['MMS_MSG'] ?></td>
                       </tr>
                       <?php
                   }
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <td colspan="4">변경내역이 없습니다.</td>
                </tr>
            <?}?>
        </table>
    </div>
</div>

</body>
</html>