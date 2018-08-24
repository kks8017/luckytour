<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$main = new main();
$main_company = $main->tour_config();

$start_date = date("Y-m-d",time());
$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));

$tour_air_area = explode(",",$main_company['tour_air_area']);
$best_list = $main->best_list();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="./css/main_header.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/main_footer.css" />
    <link rel="stylesheet" type="text/css" href="./css/jq.rolling.css"/>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script language="javascript" src="./js/jquery-ui.min.js" type="text/javascript"></script>
    <script language="javascript" src="./js/jq.rolling.js" type="text/javascript"></script>
    <script src="./js/main.js"></script>
    <script src="./js/jquery.cookie.js"></script>
    <script src="./js/addfavorite.js"></script>
    <script src="./js/common.js"></script>
    <title><?=$main_company['tour_title']?></title>
</head>
<body>
<div id="wrap" style="position: relative">
    <div id="header">

        <div class="head_wrap">
            <div class="head">
                <p><span class="hide">즐겨찾기</span><img src="./main_img/favorit_btn.png"  id="favorite"/></p>
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
            <p><a href="#none"><img src="./main_img/logo.gif" /></a></p>

        </div>
        <div class="nav_wrap">
            <nav class="nav">
                <ul>
                    <li><a href="/freepackage/package.php" >자유여행패키지</a></li>
                    <li><a href="/freepackage/package.php?page=bus">버스/택시패키지</a></li>
                    <li><a href="/air/air.php">항공</a></li>
                    <li><a href="/rentcar/rent.php">렌트</a></li>
                    <li><a href="/tel/tel.php">숙박</a></li>
                    <li><a href="/bustour/bustour.php">버스투어</a></li>
                    <li><a href="/freepackage/package.php?page=golf">골프투어</a></li>
                    <li><a href="/coupon/coupon.php">관광지입장권</a></li>
                </ul>
            </nav>
        </div>
    </div> <!-- header 끝 -->
    <div id="content"> <!-- content 시작-->

        <div id="rolling">
            <ul>
                <li class="sp01"><img src="./main_img/shinra.jpg" class="banner_img"/></li>
                <li class="sp02"><img src="./main_img/lotte.jpg" class="banner_img"/></li>
                <li class="sp03"><img src="./main_img/hae.jpg" class="banner_img"/></li>
                <li class="sp04"><img src="./main_img/dam.jpg" class="banner_img"/></li>
                <li class="sp05"><img src="./main_img/can.jpg" class="banner_img"/></li>
            </ul>

        </div>
        <ul class="pages">
            <li>신라호텔</li>
            <li>롯데호텔</li>
            <li>해비치호텔</li>
            <li>담앤루리조트</li>
            <li>켄싱턴호텔</li>
        </ul>
        <div class="quick_wrap"></div>
        <ul class="quick_search">
            <li class="act menu">
                <img src="./main_img/package_icon.png" class="package"/>
                <span class="menu">패키지</span>
            </li>
            <li class="menu">
                <img src="./main_img/rent_icon.png" class="rent"/><span  class="menu">렌터카</span>
            </li>
            <li class="menu">
                <img src="./main_img/air_icon.png" class="air"/>
                <span  class="menu">항공</span>
            </li>
            <li class="menu"><img src="./main_img/lodge_icon.png" class="lodge"/><span  class="menu">숙박</span></li>
            <li class="menu"><img src="./main_img/bus_icon.png" class="bus"/>
                <img src="./main_img/taxi_icon.png" class="taxi"/><span  class="menu">버스/택시패키지</span></li>


            <li>
                <ul class="quick_form">
                    <li>
                        <div class="package">
                            <form method="post" action="/freepackage/package.php">
                                <table>
                                    <tr>
                                        <td class="item-title" colspan="3">가는날</td>
                                        <td class="item-title" colspan="3">오는날</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="start_date" id="start_date" value="<?=$start_date?>" />
                                        </td>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="end_date" id="end_date" value="<?=$end_date?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="6">
                                            패키지선택
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-form" colspan="6">
                                            <select name="package_type">
                                                <option value="ACT">할인항공+숙박+렌트카</option>
                                                <option value="CT">숙박+렌터카</option>
                                                <option value="AC">할인항공+렌트카</option>
                                                <option value="AT">할인항공+숙박</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="2">
                                            성인(만 13세이상)
                                        </td>
                                        <td class="item-title" colspan="2">
                                            소아(만 12세이하)
                                        </td>
                                        <td class="item-title" colspan="2">
                                            유아(만 24개월미만)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-form-number" colspan="2">
                                            <select name="adult_number">
                                                <?php
                                                 $main->number_option("2","성인");
                                                ?>
                                            </select>
                                        </td>

                                        <td class="item-form-number" colspan="2">
                                            <select name="child_number">
                                                <?php
                                                $main->number_option("0","소아");
                                                ?>
                                            </select>
                                        </td>

                                        <td class="item-form-number" colspan="2">
                                            <select name="baby_number">
                                                <?php
                                                $main->number_option("0","유아");
                                                ?>
                                            </select>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="6">
                                            출발지
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="item-form" colspan="3">
                                            <select name="start_area">
                                                <?php
                                                foreach ($tour_air_area as $area){
                                                    $area_name = explode("|",$area);
                                                    if($area_name[0]=="김포"){$sel="selected";}else{$sel="";}
                                                    echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top: 5px; ">
                                            <input type="submit" value="패키지검색" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </li>
                    <li>
                        <div class="rent">
                            <form action="/rentcar/rent.php" method="post">
                                <table>
                                    <tr>
                                        <td class="item-title" colspan="6">인수</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="start_date" id="rent_start_date" value="<?=$start_date?>" />
                                        </td>
                                        <td class="item-form-time"  colspan="3">
                                            <select name="start_hour" >
                                                <?php
                                                    $main->hour_option("08");
                                                ?>
                                            </select> :
                                            <select name="start_minute" >
                                                <?php
                                                    $main->minute_option("");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="6">
                                            반납
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="end_date" id="rent_end_date" value="<?=$end_date?>" />
                                        </td>
                                        <td class="item-form-time"  colspan="3">
                                            <select name="end_hour" >
                                                <?php
                                                $main->hour_option("08");
                                                ?>
                                            </select> :
                                            <select name="end_minute" >
                                                <?php
                                                $main->minute_option("");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="6">
                                            차종
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-form" colspan="6">
                                            <select name="rent_type">
                                                <?php
                                                    $main->rent_type_list();
                                                ?>
                                            </select>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top: 20px">
                                            <input type="submit" value="차량검색"  />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </li>
                    <li>
                        <div class="air">
                            <form method="post" action="/air/air.php">
                                <table>								
                                    <tr>
                                        <td class="item-title" colspan="3">출발지</td>
                                        <td class="item-title" colspan="3">도착지</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <select name="start_area">
                                                <?php
                                                foreach ($tour_air_area as $area){
                                                    $area_name = explode("|",$area);
                                                    if($area_name[0]=="김포"){$sel="selected";}else{$sel="";}
                                                    echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="item-form"  colspan="3">
                                            <select name="end_area">
                                                <?php
                                                foreach ($tour_air_area as $area){
                                                    $area_name = explode("|",$area);
                                                    if($area_name[0]=="김포"){$sel="selected";}else{$sel="";}
                                                    echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="3">가는날</td>
                                        <td class="item-title" colspan="3">오는날</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="start_date" id="air_start_date" value="<?=$start_date?>" />
                                        </td>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="end_date" id="air_end_date" value="<?=$end_date?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="2">
                                            성인(만 13세이상)
                                        </td>
                                        <td class="item-title" colspan="2">
                                            소아(만 12세이하)
                                        </td>
                                        <td class="item-title" colspan="2">
                                            유아(만 24개월미만)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-form-number" colspan="2">
                                            <select name="adult_number">
                                                <?php
                                                $main->number_option("2","성인");
                                                ?>
                                            </select>
                                        </td>

                                        <td class="item-form-number" colspan="2">
                                            <select name="child_number">
                                                <?php
                                                $main->number_option("0","소아");
                                                ?>
                                            </select>
                                        </td>

                                        <td class="item-form-number" colspan="2">
                                            <select name="baby_number">
                                                <?php
                                                $main->number_option("0","유아");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top: 20px">
                                            <input type="submit" value="할인항공 검색" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </li>
                    <li>
                        <div class="lodge">
                            <form action="/tel/tel.php" method="post">
                                <table>
                                    <tr>
                                        <td class="item-title" colspan="2">
                                            위치별
                                        </td>
                                        <td class="item-title" colspan="4">
                                            유형별
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="item-form" colspan="2">
                                            <select name="lod_area">
                                                <?php
                                                    $main->lodging_area_list();
                                                ?>
                                            </select>
                                        </td>

                                        <td class="item-form" colspan="4">
                                            <select name="lod_type">
                                                <?php
                                                    $main->lodging_type_list();
                                                ?>
                                            </select>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="3">체크인</td>
                                        <td class="item-title" colspan="3">체크아웃</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="start_date" id="lod_start_date" value="<?=$start_date?>" />
                                        </td>
                                        <td class="item-form"  colspan="3">
                                            <input type="text" name="end_date" id="lod_end_date" value="<?=$end_date?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title" colspan="6" style="text-align: center;">
                                            숙소명 검색
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="item-form" colspan="6" style="text-align: center">
                                            <input type="text" name="search_name" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top: 5px; ">
                                            <input type="submit" value="숙박검색" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </li>

                    <li>
                        <div class="bustaxi">
                            <form action="/freepackage/package.php?page=bus" method="post">
                                <table>
                                    <tr>
                                        <td class="ticket" colspan="6" style="text-align: left; ">
                                            <input type="radio" id="bus_type1" name="bus_type" checked="checked" value="B"><label for="bus_type1"><span></span>버스</label>
                                            <input type="radio" id="bus_type2" name="bus_type" value="X" ><label for="bus_type2"><span></span>택시</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title"  style="text-align: left;" colspan="6">대여일</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="6">
                                            <input type="text" name="start_date" id="bus_start_date" value="<?=$start_date?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="item-title"  style="text-align: left; " colspan="3">차량대수</td>
                                        <td class="item-title"  style="text-align: left; " colspan="3">이용일자</td>
                                    </tr>
                                    <tr>
                                        <td class="item-form"  colspan="3">
                                            <select name="bus_vehicle">
                                                <?php
                                                    $main->vehicle_option("1","대");
                                                ?>
                                            </select>
                                        </td>
                                        <td class="item-form"  colspan="3">
                                            <select name="bus_stay">
                                                <?php
                                                $main->vehicle_option("2","일");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top: 20px">
                                            <input type="submit" value="버스/택시검색" />
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="package_type" value="B">
                            </form>
                        </div>
                    </li>

                </ul>

            </li>
        </ul>
        <p class="head">BEST 여행상품 <img src="./main_img/down_arrow.gif" /></p>
        <ul class="best_goods">
            <?php
            $lod = new lodging();
            $rent = new rent();

            if(is_array($best_list)){
                foreach ($best_list as $best){




                if($best['tel_no'] >0){
                    $lod->lodno = $best['tel_no'];
                    $lod->roomno = $best['room_no'];
                    $lod_name = $lod->lodging_detail();
                    $lod_main_img  = $lod->lodging_main_image();
                    $lod->start_date = date("Y-m-d",time());
                    $lod->stay = 1;
                    $lod->adult_number = 2;
                    $lod->baby_number =0;
                    $lod->child_number =0;
                    $lod->lodging_vehicle =1;
                    $lod_price = $lod->lodging_main_price();
                    $lod_type = $lod->lodging_code_name($lod_name['lodging_type']);
                    $percent = $lod_price[0] / $lod_price[5] * 100;
                    $add_percent =  round($percent, 0);
                    $total_percent =100 - $add_percent;

            ?>
            <li>
                <?if($best['best_img']==""){?>
                <p><a href="/tel/tel_detail.php?start_date=<?=date("Y-m-d",time())?>&end_date=<?=date("Y-m-d",(time()+86400))?>&adult_number=1&child_number=0&baby_number=0&room_vehicle=1&tel_no=<?=$best['tel_no']?>"><img src="<?=KS_DATA_DIR?>/<?=KS_LOD_DIR?>/<?=$lod_main_img?>" /></a></p>
                 <?}else{?>
                    <p><a href="#none"><img src="<?=KS_DATA_DIR?>/<?=KS_BEST_DIR?>/<?=$best['best_img']?>" /></a></p>
                 <?}?>
                <p class="tit"><?=$lod_name['lodging_name']?></p>
                <p class="kind"><?=$lod_type?></p>
                <p class="tail"><span><?=$total_percent?></span><span>%</span><span><?=set_comma($lod_price[5])?></span><span><?=set_comma($lod_price[0])?>원</span></p>
            </li>
                 <?}else{
                    if($best['best_sales']==0 and $best['best_normal_amount']==0){?>
                        <li>
                            <p><a href="<?=$best['best_link']?>"><img src="<?=KS_DATA_DIR?>/<?=KS_BEST_DIR?>/<?=$best['best_img']?>" /></a></p>
                            <p class="tit"><?=$best['best_title']?></p>
                            <p class="kind"><?=$best['best_event']?></p>

                        </li>
                   <?
                    }else{
                    ?>
                    <li>
                        <p><a href="<?=$best['best_link']?>"><img src="<?=KS_DATA_DIR?>/<?=KS_BEST_DIR?>/<?=$best['best_img']?>" /></a></p>
                        <p class="tit"><?=$best['best_title']?></p>
                        <p class="kind"><?=$best['best_event']?></p>
                        <p class="tail"><span><?=$best['best_sales']?></span><span>%</span><span><?=set_comma($best['best_normal_amount'])?></span><span><?=set_comma($best['best_sale_amount'])?>원</span></p>
                    </li>
                        <?}?>
                <?}?>
              <?}?>
            <?}?>

        </ul>

    </div><!-- content끝-->
    <div class="aside_wrap">
        <ul class="aside">
            <li><a href="https://www.visitjeju.net/kr/detail/list?menuId=DOM_000001719001000000&cate1cd=cate0000000005#p1&region2cd&pageSize=6&sortListType=reviewcnt&viewType=thumb" target="_blank"><img src="./main_img/icon1.png" /><span>제주맛집</span></a></li>
            <li><a href="https://www.visitjeju.net/kr/tourInfo/weather?tap=one&menuId=DOM_000001703002001100#" target="_blank"><img src="./main_img/icon2.png" /><span>제주날씨</span></a></li>
            <li><a href="https://www.jejuolle.org/main.do" target="_blank"><img src="./main_img/icon3.png" /><span>제주올레</span></a></li>
            <li><a href="https://www.visitjeju.net/kr/tourInfo/guide?tap=two&menuId=DOM_000002000000000051#" target="_blank"><img src="./main_img/icon4.png" /><span>제주여행지도</span></a></li>
            <li><a href="http://www.jeju.go.kr/hallasan/index.htm" target="_blank"><img src="./main_img/icon5.png" /><span>한라산등반코스</span></a></li>
            <li><a href="https://www.visitjeju.net/u/xS" target="_blank"><img src="./main_img/icon6.png" /><span>제주관광지</span></a></li>
        </ul>
    </div>
    <div id="footer">
        <ul class="info">
            <li><p><a href="/privacy/average.php">국내여행표준약관</a></p></li>
            <li><p><a href="/privacy/privacy.php">개인정보처리방침</a></p></li>
            <li><p><a href="/board/board.php?board_table=notice">고객센터</a></p></li>
        </ul>
        <div style="border-top:1px solid #dadada"></div>
        <div class="foot_cont">
            <div class="lcont">
                <p>고객센터</p>
                <p>064)746-2727</p>
                <p>운영시간 09:00~18:00</p>
                <p>점심시간 12:00~13:00</p>
                <p>토.일요일 및 국공휴일 휴무</p>
            </div>
            <div class="rcont">
                <p><span>사업자등록번호 : 000-00-00000</span> <span>통신판매업신고 : 제 0000-0000&nbsp;&nbsp;&nbsp;호</span><span>관광사업등록 제 2016-11</span></p>
                <p><span>제주특별자치도 제주시 동문로 52,3층(일도이동)</span><span>(주)제주럭키투어 (대표이사 강철진)</span>
                    <span>개인정보관리책임자 : 강철진</span><a href="http://www.ftc.go.kr/bizCommPop.do" target="_blank">사업자정보확인</a><img src="./main_img/footer_arrow.png" /></p>
                <p><span>COPYRIGHT &copy; (주)제주럭키투어 ALL RIGHTS RESERVED.</span></p>
            </div>
        </div>
    </div> <!--footer 끝 -->
</div>
<script>
    $("#rolling").rolling(1400,488,{autoscroll:1, delay:4500});
    $( function() {
        var dates =  $( "#start_date, #end_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            minDate : 0,
            maxDate:'+10950d',
            onSelect: function( selectedDate ) {
                var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                $("#end_date").val(selectedDate);

            }
        });
        var dates =  $( "#rent_start_date, #rent_end_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            minDate : 0,
            maxDate:'+10950d',
            onSelect: function( selectedDate ) {
                var option = this.id == "rent_start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                $("#end_date").val(selectedDate);

            }
        });
        var dates =  $( "#lod_start_date, #lod_end_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            minDate : 0,
            maxDate:'+10950d',
            onSelect: function( selectedDate ) {
                var option = this.id == "lod_start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                $("#end_date").val(selectedDate);

            }
        });
        var dates =  $( "#air_start_date, #air_end_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            minDate : 0,
            maxDate:'+10950d',
            onSelect: function( selectedDate ) {
                var option = this.id == "lod_start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                $("#end_date").val(selectedDate);

            }
        });
        var dates =  $( "#bus_start_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            minDate : 0,
            maxDate:'+10950d',
            onSelect: function( selectedDate ) {
                var option = this.id == "lod_start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                $("#end_date").val(selectedDate);

            }
        });

    });
</script>

</body>
</html>
