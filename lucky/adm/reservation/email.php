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
                    <td>“<b><?=$main_company['tour_name']?></b>”와 “<b>예약자</b>”는 다음 조건으로 여행계약을 체결합니다.</td>
                </tr>
            </table>

            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse' bordercolor='#71a6ea'>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>예약자</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_name']?></td>
                    <td bgcolor='#b4d2f4' width='15%'>예약자연락처</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_phone']?></td>
                </tr>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>사용자</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_real_name']?></td>
                    <td bgcolor='#b4d2f4' width='15%'>사용자연락처</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_real_phone']?></td>
                </tr>
            </table>
            <!-- (예약자)정보 시작 -->


            <!-- (여행사)정보 시작 -->
            <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#71a6ea'>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>여행사</td>
                    <td bgcolor='#ffffff' width='35%'><?=$main_company['tour_name']?><br><a href='<?=$main_company['tour_domain']?>' target='_blank'>(<?=$main_company['tour_domain']?>)</a></td>
                    <td bgcolor='#b4d2f4' width='15%'>대표전화</td>
                    <td bgcolor='#ffffff' width='35%'><b><?=$main_company['tour_phone']?></b> </td>
                </tr>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>계약자메일</td>
                    <td bgcolor='#ffffff' width='35%'><?=$row['reserv_email']?></td>
                    <td bgcolor='#b4d2f4' width='15%'>팩스</td>
                    <td bgcolor='#ffffff' width='35%'> <span class='blue'><?=$main_company['tour_fax']?></span></td>

                </tr>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>계약일</td>
                    <td bgcolor='#ffffff' width='35%'></td>
                    <td bgcolor='#b4d2f4' width='15%'>담당자</td>
                    <td bgcolor='#ffffff' width='35%'> <?=$row['reserv_person']?></td>
                </tr>

                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>보증보험가입</td>
                    <td bgcolor='#ffffff' width='85%' colspan='3'><?=$main_company['tour_insurance']?></td>
                </tr>
                <tr>
                    <td bgcolor='#b4d2f4' width='15%'>여행자보험</td>
                    <td bgcolor='#ffffff' width='85%' colspan='3'>미가입 (원하시는 분은 별도로 보험사를 통해서 가입하실 수 있습니다.)</td>
                </tr>
            </table><table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:15px;' bordercolor='#d6c4b8'>
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
            </table> <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#d6c4b8'>
                <tr>
                    <td bgcolor='#ebe6e2' width='15%' rowspan='5'>여행경비<br>(현금입금)</td>
                    <td bgcolor='#f6f4f1' width='15%'>총금액</td>
                    <td bgcolor='#ffffff' width='70%' colspan='3'><span class='red'><b><?=set_comma($row_amount['reserv_total_price'])?></b></span>원</td>
                </tr>
                <tr>
                    <td bgcolor='#f6f4f1' width='15%'>계약금/완불</td>
                    <td bgcolor='#ffffff' width='30%'><span class='red'><b><?=set_comma($row_amount['reserv_deposit_price'])?></b></span>원<span class='red'><b>[<?=$deposit_state?>]</b></span></td>
                    <td bgcolor='#f6f4f1' width='15%'>입금기한</td>
                    <td bgcolor='#ffffff' width='25%'><span class='red'><?=$row_amount['reserv_deposit_date']?></span></td>
                </tr>
                <tr>
                    <td bgcolor='#f6f4f1' width='15%'>잔금</td>
                    <td bgcolor='#ffffff' width='30%'><span class='red'><b><?=set_comma($row_amount['reserv_balance_price'])?></b></span>원<font class='red'><b>[<?=$balance_state?>]</b></font></td>
                    <td bgcolor='#f6f4f1' width='15%'>입금기한</td>
                    <td bgcolor='#ffffff' width='25%'><span class='red'><?=$row_amount['reserv_balance_date']?></span></td>
                </tr><tr>
                    <td bgcolor='#f6f4f1' width='15%'>입금계좌</td>
                    <td bgcolor='#ffffff' width='70%' colspan='3'><?=$main_company['tour_account']?></td>
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
                <tr>
                    <td bgcolor='#ffffff' colspan='2' class='sfont'>
                        -상기항공은 단체할인항공으로   왕복여정조건으로만 이용 가능하시며.  편도사용. 여정변경.시간변경이 안되는 항공입니다 <br>

                        - 편도만 사용한후에 편도취소및 요금환불은 절대로 불가합니다<br>

                        - 출발 한 시간 전 해당공항 이용항공사에서 신분증 지참 후<br>

                        [유소아인 경우 의료보험증이나 가족관계사실확인서, 등본 등/외국인의 경우 여권지참]<br>

                        탑승수속을 하시기 바라며 출발1~2일 전 항공시간 및 예약번호는 일괄 문자발송 후 유선안내해드리고 있습니다.<br>

                        출발 30분전까지 티켓팅 미확인 시 항공예약은 자동 취소될 수 있으며 이 경우 고객유책사유로 환불이 되지 않으므로 이용시간 꼭 확인하시기 바랍니다. <br><br>

                        - 항공사 사정에 의한 출발지연, 시간변경, 결항은 여행사에서 책임지지 않습니다.<br>

                        - <b>성인</b>: 탑승일 기준 만13세부터 적용 / <b>소아</b>: 탑승일 기준 만24개월부터 적용<br>

                        - <b>유아동승자</b>: 탑승일 기준 만24개월 미만으로 별도의 좌석배정이 되지 않으며 항공요금부담은 없으나 탑승예약을 하셔야 항공이용이 가능하오니 참고바랍니다.<br>

                        [당일 유아동승자 필히 지참-의료보험증,가족관계사실확인서.등본 등]<br><br>

                        - 항공예약 발권 후 성함변경이 되지 않습니다.(911테러이후 성함변경 불가정책)<br>

                        - 외국인의 경우 여권상의 영문철자로 예약을 하시되 성과 이름이 구분되어야 하며 여권상의 성함과 차이가 있으면 이용이 불가하며 이 경우 당일취소로 간주되어 전액환불불가.<br>

                        - 신분할인(장애인,국가유공자 등)은 사전예약 후 티켓팅시 신분할인증명서(장애인증,복지카드,유공자증 등)을 꼭 소지하셔야 하며 미지참시 정상요금 차액분을 지불하시고 이용하셔야 합니다.<br>

                        - 하계,춘계,동계 항공사별 스케줄 변경이 있을 수 있습니다. 이경우 변경된 스케줄로 이용하셔야 하며 변경시 사전 안내(문자 혹은 유선)해드리고 있습니다.<br><br>

                        - <b>정확한 항공시간은 출발 2~3일전 확정되며 항공시간과 예약번호는 문자안내됩니다.</b><br>

                    </td>
                </tr>
            </table> <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>
                <tr>
                    <td bgcolor='#e9e9e9' width='15%' rowspan='4'>숙박</td>
                </tr>
                <?php
                $tel_list = $res->reserv_tel();

                if(is_array($tel_list)) {
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

                <tr>
                    <td bgcolor='#ffffff' colspan='5' class='sfont'>
                        <font class='blue'>- 체크인:15:00 이후, 체크아웃:11:00 이전입니다. (숙소별 다소 차이가 있을 수 있습니다)</font><br>
                        - 부대시설 이용에 대한 자세한 문의는 해당 숙소로 직접 확인하시기 바랍니다.<br>
                        - 애완동물 동반시 입실거절되며 당일취소로 간주되어 객실료를 환불받을 수 없으니 주의바랍니다.
                    </td>
                </tr>
            </table><table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:3px;' bordercolor='#cccccc'>


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
                if(strpos($row['reserv_type'],"C")!== false) {
                ?>
                <tr>
                    <td bgcolor='#efefef' width='15%'>대여조건</td>
                    <td bgcolor='#f2fbd0' width='70%' colspan='3'>
                        - 면허증:국내 또는 국제면허증(외국면허증 불가), 11인승부터는 '1종보통면허' 필요<br>
                        - <b>중소형</b>:<font class='red'>만21세이상</font> &amp; 운전경력1년이상 <br>
                        - <b>대형/승합/수입차</b>:<font class='red'>만26세이상</font> &amp; 운전경력2년이상<br>
                        - 탑승 정원초과시 렌터카 대여불가 (렌터카인수시 렌터카 대여가 거절됩니다.)
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' colspan='5' class='sfont'>

                    </td>
                </tr>
                <?}?>
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

                    <tr>
                        <td bgcolor='#efefef' width='15%'>이용안내</td>
                        <td bgcolor='#f2fbd0' width='70%' colspan='4'>

                            ♠ 기본운행시간<br>
                            - <b>09:00 ~ 19:00</b> (시간연장은 협의 후 조정가능하며, <span style='color : blue; font-weight : bold;'>추가요금이 부과됩니다</span>)<br><br>

                            ♠ 포함사항<br>
                            - 차량연료비, 차량전세료<br><br>

                            <span style='color : red; font-weight : bold;'>♠ 불포함사항<br>
														- 봉사료(1일 5만원), 점심값 (1일 만원), 관광지 입장료 </span><br><br>

                            <span style='font-weight : bold;'>♠ 관광시 유의사항<br>
														<span style='color:red;'>- 관광지 할인쿠폰 사용불가</span><br>
														-<span style='color:blue;'>자연위주,등산,올레길,골프 관광시에는 <span style='color:red;'>1일 5만원 추가요금</span>이 발생되므로 <span style='color:red;'>미리 상담원에게 금액확인 또는 현장에서 추가 요금 지불 </span>후 이용가능</span>
														</span><br><br>

                            ♠ 버스관광안내<br>
                            - 공항 도착예정 시간에 맞추어 기사님/가이드가 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.<br>
                            - <b>가이드 요청시 별도 협의</b> (외국어 가이드 별도협의)<br>
                            - <b>관광지 입장료 별도</b>(기사님 관광지입장료는 무료입니다)<br>
                            - 1일 기사님봉사료 5만원씩 별도 부과됩니다. (미리 지불 또는 현장에서 지불)<br>
                            - 기사님 점심식사는 고객님과 함께 드시거나, 점심식사료(1만원) 기사님께 드리면 됩니다.<br><br>

                            ※답사 및 세미나의 경우는 금액이 달라질 수 있으므로 상담원과 상담후 예약해주세요<br>

                        </td>
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

                        <tr>
                            <td bgcolor='#efefef' width='15%'>미팅방법</td>
                            <td bgcolor='#f2fbd0' width='70%' colspan='4'>
                                ♠ 기본운행시간<br>
                                - <b>09:00 ~ 19:00</b> (기본운행시간 초과시 추가비용이 발생될 수 있습니다)<br><br>

                                ♠ 포함사항<br>
                                - 차량연료비, 차량전세료 <br><br>
                                ♠ 불포함사항
                                - 봉사료(TIP) <br><br>
                                ♠ 택시관광안내<br>
                                - 공항 도착예정 시간에 맞추어 기사님 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.<br>
                                - 가이드 요청시 1일 100,000원 추가됩니다.(외국어 가이드 별도협의)<br>
                                - 관광지 입장료 별도(기사님 관광지입장료는 무료입니다)<br>
                                - 기사님 점심식사는 고객님과 함께 드시거나, 점심식사료(1만원) 기사님께 드리면 됩니다.<br><br>

                                ※일어&영어택시관광의 경우 금액이 다르니, 전화문의 부탁드립니다. <br>

                            </td>
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


                    <tr>
                        <td bgcolor='#efefef' width='15%'>미팅방법</td>
                        <td bgcolor='#f2fbd0' width='70%' colspan='4'>

                            -공항도착 예정시간에 맞추어 기사님이 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.<br><br>

                            ♠ 기본운행시간<br>
                            - 09:00 ~ 19:00 (시간연장은 협의 후 조정가능합니다).<br><br>



                            ♠ 포함사항<br>
                            -  차량연료비, 차량전세료,봉사료(TIP)<br><br>

                            ♠ 패키지관광안내<br>
                            - 공항 도착예정 시간에 맞추어 기사님/가이드가 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.<br>
                            - 가이드 요청시 1일 100,000원 추가됩니다.(외국어 가이드 별도협의)<br>
                            - 관광지 입장료 포함(기사님 관광지입장료는 무료입니다)<br>
                            - 여행시작일 전날 저녁 도착시 제주시내권 숙소 무료셔틀(그외지역 소정의 요금청구)



                        </td>
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


                <!-- 		 <table border='0' width='670' cellpadding='0' cellspacing='0'>
                                                     <tr>
                                                         <td><a href='http://www.jejuluckytour.com/coupon/list.html' target='_blank'><img src='http://www.jejuluckytour.com/byeongari/res/img/coupon.gif' vspace='5'></a></td>
                                                     </tr>
                                                 </table> -->
                <table border='1' cellpadding='4' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:15px;' bordercolor='#cccccc'>
                    <tr>
                        <td bgcolor='#e9e9e9' width='15%'>필수지참물</td>
                        <td bgcolor='#f2fbd0' width='85%'>
                            - <font class='red'><b>신분증</b></font> : 항공탑승시 신분증 필수입니다. (장애우/국가유공자 등일 경우 관련신분증 또는 소아/유아 일 경우 주민등록등본 및 의료보험증 꼭 지참하세요)<br>
                            - <font class='red'><b>운전면허증</b></font> : 렌트카 이용시 운전하실 분(2명까지 가능) 운전면허증 필히 지참하세요!
                        </td>
                    </tr>
                </table>



                <table border='0' cellpadding='0' cellspacing='0' width='670' style='margin-top:15px;'>
                    <tr>
                        <td>※ 본 계약과 관련한 다툼이 있을 경우, 문화관광부고시에 의거 운영되는 관광불편신고처리위원회 또는<br> 제주시청 관광/국제자유도시지원과로 중재를 요청할 수 있습니다.</td>
                    </tr>
                </table>
                <table border='1' cellpadding='6' cellspacing='0' width='670' style='border-collapse:collapse; margin-top:15px;' bordercolor='#71a6ea'>
                    <tr>
                        <td bgcolor='#b4d2f4'><b>예약취소에 따른 환불규정 안내</b></td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff'>
                            <?=$main_company['tour_cancel']?>
                        </td>
                    </tr>
                </table>
                </td>
                </tr>
            </table>


</body>
</html>