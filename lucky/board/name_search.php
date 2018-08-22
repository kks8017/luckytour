<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="imagetoolbar" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="<?=KS_SUB_DIR?>css/reset.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?=KS_SUB_DIR?>css/common.css" />
    <link rel="stylesheet" href="<?=KS_SUB_DIR?>css/package.css" />
    <link rel="stylesheet" href="<?=KS_SUB_DIR?>css/lodge_layer.css" />
    <link rel="stylesheet" href="<?=KS_SUB_DIR?>css/basic.css" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="<?=KS_SUB_DIR?>js/jquery.cookie.js"></script>
    <script src="<?=KS_SUB_DIR?>js/common.js"></script>
    <script src='<?=KS_SUB_DIR?>js/basic.js'></script>
    <script charset="UTF-8" class="daum_roughmap_loader_script" src="https://spi.maps.daum.net/imap/map_js_init/roughmapLoader.js"></script>
    <title><?=$main_company['tour_name']?></title>
</head>
<body>
<link rel="stylesheet" href="../css/customer.css" />
<div  style="margin-top: 30px;">
     <div class="inbody">
        <table class="conbox3">
            <tr>
                <td class="tit">예약자검색</td>
            </tr>
        </table>

        <form method="post" id="name_frm">
        <table class="conbox3">
            <tr>
                <td class="titbox">예약자명</td>
                <td ><input type="text" name="reserv_name" size="30"></td>

            </tr>
            <tr>
                <td class="titbox">연락처</td>
                <td><input type="text" name="reserv_phone" id="phone" size="30"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="button" id="sch_btn" value="검색"></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<div id="reserv_list" style="margin-top: 20px;">

</div>
<script>
    $(document).ready(function () {
        $("#sch_btn").click(function () {

            var url = "name_data.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#name_frm").serialize(), // serializes the form's elements.
                success: function (data) {
                    $("#reserv_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        });
    });
    function phone_chk(str){
        str = str.replace(/[^0-9]/g, '');
        var tmp = '';
        if( str.length < 4){
            return str;
        }else if(str.length < 7){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3);
            return tmp;
        }else if(str.length < 11){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 3);
            tmp += '-';
            tmp += str.substr(6);
            return tmp;
        }else{
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 4);
            tmp += '-';
            tmp += str.substr(7);
            return tmp;
        }
        return str;
    }

    var phone = document.getElementById('phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }
</script>