<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$main = new main();
$main_company = $main->tour_config();
$page=$_REQUEST['page'];
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
<div id="wrap">
    <div id="header">
        <div class="head_wrap">
            <div class="head">
                <p><span class="hide">즐겨찾기</span><img src="/main_img/favorit_btn.png"  id="favorite"/></p>
                <ul>
                    <?if(!$_SESSION['user_id']){?>
                        <li><a href="/member/login.php">로그인</a></li>
                        <li><a href="/member/agree.php">회원가입</a></li>
                        <li><a href="/board/board.php?board=confirm">예약확인</a></li>
                    <?}else{?>
                        <li><a href="/member/logout.php">로그아웃</a></li>
                        <li><a href="/board/mypage.php">마이페이지</a></li>
                    <?}?>
                    <li><a href="/group/group.php">단체여행문의</a></li>
                    <li><a href="/board/board.php?board_table=notice">고객센터</a></li>

                </ul>
            </div>
        </div>
        <div class="header">
            <p><a href="../index.php"><span class="hide">로고</span><img src="../main_img/logo.gif" /></a></p>

        </div>
        <?php
            if($page=="free"){
                $class1 = "class='select'";
            }else if($page=="bus"){
                $class2 = "class='select'";
            }else if($page=="air"){
                $class3 = "class='select'";
            }else if($page=="rent"){
                $class4 = "class='select'";
            }else if($page=="tel"){
                $class5 = "class='select'";
            }else if($page=="bustour"){
                $class6 = "class='select'";
            }else if($page=="golf"){
                $class7 = "class='select'";
            }else if($page=="cou"){
                $class8 = "class='select'";
            }
        ?>
        <div class="nav_wrap">
            <nav class="nav">
                <ul>
                    <li><a href="/freepackage/package.php?page=free" <?=$class1?>>자유여행패키지</a></li>
                    <li><a href="/freepackage/package.php?page=bus" <?=$class2?>>버스/택시패키지</a></li>
                    <li><a href="/air/air.php?page=air" <?=$class3?>>항공</a></li>
                    <li><a href="/rentcar/rent.php?page=rent" <?=$class4?>>렌트</a></li>
                    <li><a href="/tel/tel.php?page=tel" <?=$class5?>>숙박</a></li>
                    <li><a href="/bustour/bustour.php?page=bustour" <?=$class6?>>버스투어</a></li>
                    <li><a href="/freepackage/package.php?page=golf" <?=$class7?>>골프투어</a></li>
                    <li><a href="/coupon/coupon.php?page=cou" <?=$class8?>>관광지입장권</a></li>
                </ul>
            </nav>
        </div>
    </div> <!-- header 끝 -->
    <script>
        function wrapWindowByMask(url) {

            //화면의 높이와 너비를 구한다.
            var maskHeight = $(document).height();
//      var maskWidth = $(document).width();
            var maskWidth = window.document.body.clientWidth;
            var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";

            var loadingImg = '';
            loadingImg += "<div id='loadingImg' style='position:absolute; left:45%; top:40%; display:none; z-index:10000;'>";
            loadingImg += " <img src='"+url+"'/>";
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