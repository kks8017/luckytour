<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$reserv_user_no = $_REQUEST['reserv_user_no'];
$main = new main();
$main_company = $main->tour_config();

$no = $_REQUEST['no'];

$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$sql_amount = "select * from reservation_amount where reserv_user_no='{$no}'";
$rs_amount  = $db->sql_query($sql_amount);
$row_amount = $db->fetch_array($rs_amount);

$main->sdate = $row['reserv_tour_start_date'];
$s_week = $main->week();
$main->sdate = $row['reserv_tour_end_date'];
$e_week = $main->week();

$ddy = ( strtotime($row['reserv_tour_end_date']) - strtotime($row['reserv_tour_start_date']) ) / 86400;

$stay = $ddy."박".($ddy+1)."일";

$main->pack_type = $row['reserv_type'];
$pack = $main->pack_text();
$res->reserv_no = $no;

if($row_amount['reserv_deposit_state']=="Y") {
    $deposit_state = "입금완료";
}else{
    $deposit_state = "미입금";
}
if($row_amount['reserv_balance_state']=="Y") {
    $balance_state = "입금완료";
}else{
    $balance_state = "미입금";
}


?>
<html>
<head>
    <title><?=$main_company['tour_name']?></title>
    <meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
    <meta http-equiv='imagetoolbar' content='no'>
    <style>
        body,table,td 			{ margin:0; font-size:12px; font-family:돋움, arial; line-height:14pt; color:#333333; }
        img						{ border:0px; }
        input					{ font-size:9pt; font-family:돋움, arial; }
        form 					{ display : inline; }
        a:link					{ font-size:12px; font-family:돋움, arial; color:#0000ff; text-decoration: none; }
        a:visited				{ font-size:12px; font-family:돋움, arial; color:#0000ff; text-decoration: none; }
        a:hover					{ font-size:12px; font-family:돋움, arial; color:#ff0000; text-decoration: none; }

        .red					{ font-family:돋움, arial; color:#FF3333;}
        .blue					{ font-family:돋움, arial; color:#0033CC;}
        .orange					{ font-family:돋움, arial; color:#FF6600;}

        .sfont					{ font-size:11px; font-family:돋움, arial; color:#555555;}
        .lfont					{ font-size:14px;}


    </style>

</head>
<body>
<table border='0' cellpadding='0' cellspacing='0' align='center' width='710'>
    <tr>
        <td style='padding:0 20px 20px 20px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='670'>
                <tr>
                    <td>요청하신 제주도여행 견적내역입니다.</td>
                </tr>
            </table>


            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse' bordercolor='#71a6ea'>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>예약자</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_name']?></td>
                    <td bgcolor='#b4d2f4' width='15%'>예약자연락처</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_phone']?></td>
                </tr>
            </table>
            <!-- (예약자)정보 시작 -->


            <!-- (여행사)정보 시작 -->
           <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:15px;' bordercolor='#d6c4b8'>
                <tr>
                    <td bgcolor='#ebe6e2' width='15%'>여행기간</td>
                    <td bgcolor='#ffffff' width='85%'><b><?=$row['reserv_tour_start_date']?>(<?=$s_week?>) ~ <?=$row['reserv_tour_end_date']?>(<?=$e_week?>) <span class='orange'>[ <?=$stay?>]</span></b></td>
                </tr>
                <tr>
                    <td bgcolor='#ebe6e2' width='15%'>예약상품</td>
                    <td bgcolor='#ffffff' width='85%'><?=$pack?></td>
                </tr>
                <tr>
                    <td bgcolor='#ebe6e2' width='15%'>여행인원</td>
                    <td bgcolor='#ffffff' width='85%'>성인 <?=$row['reserv_adult_number']?> 명 / 소아 <?=$row['reserv_child_number']?> / 유아 <?=$row['reserv_baby_number']?></td>
                </tr>
               <tr>
                   <td bgcolor='#f6f4f1' width='15%'>총금액</td>
                   <td bgcolor='#ffffff' width='70%' colspan='3'><span class='red'><b><?=set_comma($row_amount['reserv_total_price'])?></b></span>원</td>
               </tr>
            </table>


            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:15px;' bordercolor='#cccccc'>
                <?php
                $air_list = $res->reserv_air();

                if(is_array($air_list)){
                    foreach ($air_list as $air) {
                        $air_s_date = explode(" ",$air['reserv_air_departure_date']);
                        $air_e_date = explode(" ",$air['reserv_air_arrival_date']);

                        ?>
                        <tr>
                            <td bgcolor='#e9e9e9' width='15%' colspan="2" >할인항공</td>
                        </tr>
                        <tr>

                            <td bgcolor='#efefef' width='15%'>항공일정</td>
                            <td bgcolor='#ffffff' width='70%'> [ <?=$air['reserv_air_departure_airline']?> ] <?=$air['reserv_air_departure_area']?> -> 제주  <?=$air_s_date[0]?> <?=substr($air_s_date[1],0,5)?> <br> [ <?=$air['reserv_air_arrival_airline']?> ] 제주 -> <?=$air['reserv_air_arrival_area']?>   2<?=$air_e_date[0]?> <?=substr($air_e_date[1],0,5)?></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>성인탑승명단</td>
                            <td bgcolor='#ffffff' width='70%'><?=$air['reserv_air_adult_list']?></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>소아탑승명단</td>
                            <td bgcolor='#ffffff' width='70%'> <?=$air['reserv_air_child_list']?></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>유아탑승명단</td>
                            <td bgcolor='#ffffff' width='70%'><?=$air['reserv_air_baby_list']?></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>예약번호</td>
                            <td bgcolor='#ffffff' width='70%'><span class='red'>[ <?=$air['reserv_air_booking_number']?> ]출발일 1~3일전에 예약번호를 알려드립니다.</span></td>
                        </tr>
                        <?
                    }
                }
                ?>

            </table>
            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>

                <?php
                $tel_list = $res->reserv_tel();

                if(is_array($tel_list)) {
                 ?>
                    <tr>
                        <td bgcolor='#e9e9e9' width='15%' rowspan='4'>숙박</td>
                    </tr>
                <?
                    foreach ($tel_list as $tel) {
                        $lodging->lodno = $tel['reserv_tel_lodno'];
                        $phone = $lodging->lodging_detail();
                        ?>
                        <tr>

                            <td bgcolor='#efefef' width='15%'>숙소명 1</td>
                            <td bgcolor='#ffffff' width='30%'><b><?=$tel['reserv_tel_name']?></b><br>(전화번호 :<?=$phone['lodging_real_phone']?> )</td>
                            <td bgcolor='#efefef' width='15%'>숙박기간</td>
                            <td bgcolor='#ffffff' width='25%'><b><?=$tel['reserv_tel_date']?> 부터 <span class='red'><?=$tel['reserv_tel_stay']?>박</span></b></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>숙소주소</td>
                            <td bgcolor='#ffffff' width='30%' colspan='3'><?=$phone['lodging_address']?>/td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>객실명</td>
                            <td bgcolor='#ffffff' width='30%'><span class='orange'><b><?=$tel['reserv_tel_room_name']?></b></span></td>
                            <td bgcolor='#efefef' width='15%'>객실수</td>
                            <td bgcolor='#ffffff' width='25%'><?=$tel['reserv_tel_few']?> 실</td>
                        </tr>
                        <?
                    }
                }
                ?>
            </table>
            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>


                <?php
                $rent_list = $res->reserv_rent();

                if(is_array($rent_list)) {
                    foreach ($rent_list as $car) {
                        $rent_s_date = explode(" ", $car['reserv_rent_start_date']);
                        $rent_e_date = explode(" ", $car['reserv_rent_end_date']);
                        $rent_fuel = $rent->rent_code_name($car['reserv_rent_car_fuel']);
                        $rent->comno = $car['reserv_rent_com_no'];
                        $phone = $rent->company_phone();
                        ?>
                        <tr>
                            <td bgcolor='#e9e9e9' width='15%' colspan="4" style="text-align: center;">렌터카</td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>차종명</td>
                            <td bgcolor='#ffffff' width='30%'><b><?=$car['reserv_rent_car_name']?>(<?=$rent_fuel?>)/ <?=$car['reserv_rent_vehicle']?>대</b></td>
                            <td bgcolor='#efefef' width='15%'>렌터카업체</td>
                            <td bgcolor='#ffffff' width='25%'><?=$car['reserv_rent_com_name']?>(☎ <?=$phone?> )</td>
                        </tr>

                        <tr>
                            <td bgcolor='#efefef' width='15%'>인수일시</td>
                            <td bgcolor='#ffffff' width='30%'><span class='red'><?=substr($car['reserv_rent_start_date'],0,16)?></span></td>
                            <td bgcolor='#efefef' width='15%'>반납일시</td>
                            <td bgcolor='#ffffff' width='25%'><span class='red'><?=substr($car['reserv_rent_end_date'],0,16)?></span></td>
                        </tr>
                        <tr>
                            <td bgcolor='#efefef' width='15%'>인수장소</td>
                            <td bgcolor='#ffffff' width='30%'><?=$car['reserv_rent_departure_place']?></td>
                            <td bgcolor='#efefef' width='15%'>반납장소</td>
                            <td bgcolor='#ffffff' width='25%'><?=$car['reserv_rent_arrival_place']?></td>
                        </tr>
                        <?
                    }
                }
                ?>
            </table>
                <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>
                    <?php
                    $bus_list = $res->reserv_bus();

                    if(is_array($bus_list)) {
                        ?>
                        <tr>
                            <td bgcolor='#e9e9e9' width='15%' colspan='4'>버스 </td>
                        </tr>
                        <?
                        foreach ($bus_list as $bus) {
                            $bus_stay = $bus['reserv_bus_stay']-1;
                            $bus_edate   =  date("Y-m-d", strtotime($bus['reserv_bus_date']." +{$bus_stay} days"));

                            if($bus['reserv_bus_type']=="B"){

                                ?>
                                <tr>
                                    <td bgcolor='#efefef' width='15%'>차종명</td>
                                    <td bgcolor='#ffffff' width='30%'><b><?=$bus['reserv_bus_name']?></b></td>
                                    <td bgcolor='#efefef' width='15%'>사용대수</td>
                                    <td bgcolor='#ffffff' width='25%'><?=$bus['reserv_bus_vehicle']?>대</td>
                                </tr>

                                <tr>
                                    <td bgcolor='#efefef' width='15%'>시작일</td>
                                    <td bgcolor='#ffffff' width='30%'><span class='red'><?=$bus['reserv_bus_date']?> </span></td>
                                    <td bgcolor='#efefef' width='15%'>종료일</td>
                                    <td bgcolor='#ffffff' width='25%'><span class='red'><?=$bus_edate?> </span></td>
                                </tr>
                                <tr>
                                    <td bgcolor='#efefef' width='15%'>사용일</td>
                                    <td bgcolor='#ffffff' width='30%'><?=$bus['reserv_bus_stay']?>일</td>
                                    <td bgcolor='#efefef' width='15%'></td>
                                    <td bgcolor='#ffffff' width='25%'></td>
                                </tr>


                            <?}else{?>
                                <tr>
                                    <td bgcolor='#e9e9e9' width='15%' rowspan='4'>택시 </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#efefef' width='15%'>차종명</td>
                                    <td bgcolor='#ffffff' width='30%'><b><?=$bus['reserv_bus_name']?></b></td>
                                    <td bgcolor='#efefef' width='15%'>사용대수</td>
                                    <td bgcolor='#ffffff' width='25%'><?=$bus['reserv_bus_vehicle']?>대</td>
                                </tr>

                                <tr>
                                    <td bgcolor='#efefef' width='15%'>시작일</td>
                                    <td bgcolor='#ffffff' width='30%'><span class='red'><?=$bus['reserv_bus_date']?> </span></td>
                                    <td bgcolor='#efefef' width='15%'>종료일</td>
                                    <td bgcolor='#ffffff' width='25%'><span class='red'><?=$bus_edate?> </span></td>
                                </tr>
                                <tr>
                                    <td bgcolor='#efefef' width='15%'>사용일</td>
                                    <td bgcolor='#ffffff' width='30%'><?=$bus['reserv_bus_stay']?>일</td>
                                    <td bgcolor='#efefef' width='15%'></td>
                                    <td bgcolor='#ffffff' width='25%'></td>
                                </tr>


                            <?}?>
                        <?}?>
                    <?}?>
                </table>
                <?php
                $bustour_list = $res->reserv_bustour();

                if(is_array($bustour_list)) {

                    ?>
                    <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>
                        <?php
                        foreach ($bustour_list as $bustour) {
                            ?>
                            <tr>
                                <td bgcolor='#e9e9e9' width='15%' rowspan='4' >패키지</td>
                            </tr>
                            <tr>
                                <td bgcolor='#efefef' width='15%'>패키지명</td>
                                <td bgcolor='#ffffff' width='30%'><b>탐나는 제주</b></td>
                                <td bgcolor='#efefef' width='15%'>사용인원</td>
                                <td bgcolor='#ffffff' width='25%'>성인 1 명/소아 0 명</td>
                            </tr>

                            <tr>
                                <td bgcolor='#efefef' width='15%'>시작일</td>
                                <td bgcolor='#ffffff' width='30%'><font class='red'>2018-06-13 </font></td>
                                <td bgcolor='#efefef' width='15%'>종료일</td>
                                <td bgcolor='#ffffff' width='25%'><font class='red'>2018-06-16</font></td>
                            </tr>
                            <tr>
                                <td bgcolor='#efefef' width='15%'>사용일</td>
                                <td bgcolor='#ffffff' width='30%'> 2 박 3 일</td>
                                <td bgcolor='#efefef' width='15%'></td>
                                <td bgcolor='#ffffff' width='25%'></td>
                            </tr>



                        <?}?>
                    </table>
                <?}?>

                <?php
                $golf_list = $res->reserv_golf();

                if(is_array($golf_list)) {

                    ?>
                    <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>
                        <?php
                        $i=0;
                        foreach ($golf_list as $golf) {
                            ?>

                            <tr>
                                <td bgcolor='#e9e9e9' width='15%' rowspan='3'>골프</td>
                            </tr>
                            <tr>
                                <td bgcolor='#efefef' width='15%'>골프장명</td>
                                <td bgcolor='#ffffff' width='85%' colspan='3'><b><?=$golf['reserv_golf_name']?></b></td>
                            </tr>

                            <tr>
                                <td bgcolor='#efefef' width='15%'>이용일자</td>
                                <td bgcolor='#ffffff' width='30%'><span class='red'> <?=$golf['reserv_golf_date']?> <?=$golf['golf_time']?>:00</span></td>
                                <td bgcolor='#efefef' width='15%'>홀명</td>
                                <td bgcolor='#ffffff' width='25%'><span class='red'> <?=$golf['reserv_golf_hole_name']?></span></td>


                            </tr>
                            <?
                            $i++;
                        }
                        ?>

                        <tr><td colspan='5' ></td></tr> </table>
                <?}?>

            <table border='0' cellpadding='0' cellspacing='0' width='670'>
                <tr>
                    <td class='red'>※ 예약요청이 접수되면 업무시간중에는 2시간 이내에 전화연락을 드리며, 업무 외 시간과 휴일에는 익일 오전중으로 <br>
                        &nbsp;&nbsp;&nbsp;예약확인을 해드립니다. [<b>업무시간 : 09:00 ~ 18:00</b>] </td>
                </tr>
            </table>

            <!-- 		 <table border='0' width='670' cellpadding='0' cellspacing='0'>
                                                 <tr>
                                                     <td><a href='http://www.jejuluckytour.com/coupon/list.html' target='_blank'><img src='http://www.jejuluckytour.com/byeongari/res/img/coupon.gif' vspace='5'></a></td>
                                                 </tr>
                                             </table> -->

                </td>
                </tr>
            </table>


</body>
</html>