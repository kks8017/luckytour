<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$c = $_REQUEST['c'];
$reserv_no = $_REQUEST['reserv_no'];
$res = new reservation();
$rent = new rent();
$lodging = new lodging();
$res->res_no = $reserv_no;
$reser_air_no = $_REQUEST['reserv_air_no'];
$sms_air = $res->sms_air($reser_air_no);
$reserv = $res->reservation_user();
$phone = str_replace("-","",$reserv[0]['reserv_phone']);

$main = new main();
$main_company = $main->tour_config();
$amount = $res->reserve_amount();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <title>문자보내기</title>
</head>
<style type="text/css" media="screen">
    .mobile {
        width: 254px;
        height: 460px;
        background: url('../image/phone.png') no-repeat center center;
        background-size: 100%;
        position: relative;
    }

    .mobile textarea.mobile-text {
        position: absolute;
        top : 85px;
        left: 22px;
        width: 200px;
        height: 222px;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 13px;
        font-weight: bold;
    }

    .mobile input.phone-number {
        position: absolute;
        top : 318px;
        left: 78px;
        width: 133px;
        height: 20px;
    }

    .mobile input.phone-number-2 {
        position: absolute;
        top : 345px;
        left: 78px;
        width: 133px;
        height: 20px;
    }

    .mobile button.phone-send {
        position: absolute;
        top : 380px;
        margin-left: 50px;
        margin-right :  50px;
        width: 150px;
        height: 40px;
        border: 0px;
        background: url('../image/send_bt.png') no-repeat center center;
    }
</style>
<body>
<form id="sms_frm" method="post" action="mms_process.php">
<div class="mobile">
    <?if($c =="deposit_send"){?>
 	    <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$main_company['tour_sms_account']?>

<?=$amount['reserv_deposit_date']?> 까지
<?=set_comma($amount['reserv_deposit_price'])?>원 입금부탁드립니다.
감사합니다.
        </textarea>
    <?}else if($c =="balance_send"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$main_company['tour_sms_account']?>

<?=$amount['reserv_balance_date']?> 까지
<?=set_comma($amount['reserv_balance_price'])?>원 입금부탁드립니다.
감사합니다.
            </textarea>
    <?}else if($c =="deposit_ok"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$reserv[0]['reserv_name']?>님<?=set_comma($amount['reserv_deposit_price'])?>원입금되었습니다.감사합니다

※본 문자는 홈페이지 또는 유선상담을 통해 고객님께서 등록하신 이메일 또는 전화번호로 발송하는 발신전용 문자입니다
고객님이 등록한 연락처 정보를 통하여 계약사항 및 거래정보를 제공하고 있으니,예약상품이 상이하거나 변경사항시 상담사에게 문의 바랍니다
자세한 사항은 홈페이지(PC)를 확인하세요.

<?=$main_company['tour_name']?> <?=$main_company['tour_domain']?>

※문의 : 고객센터 <?=$main_company['tour_phone']?>
            </textarea>
    <?}else if($c =="balance_ok"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$reserv[0]['reserv_name']?>님<?=set_comma($amount['reserv_deposit_price'])?>원입금되었습니다.감사합니다
            </textarea>
    <?}else if($c=="air_res_number"){?>
<textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
항공스케줄을 안내드립니다.

<?=$sms_air['reserv_air_departure_area']?>출발 :
[<?=$sms_air['reserv_air_departure_airline']?>]
항공사의 예약번호는
[<?=$sms_air['reserv_air_booking_number']?>]입니다.
<?=$sms_air['reserv_air_departure_area']?> → <?=$sms_air['reserv_air_end_departure_area']?>

[<?=substr($sms_air['reserv_air_departure_date'],0,4)?>년<?=substr($sms_air['reserv_air_departure_date'],5,2)?>월<?=substr($sms_air['reserv_air_departure_date'],8,2)?>일<?=substr($sms_air['reserv_air_departure_date'],11,2)?>시<?=substr($sms_air['reserv_air_departure_date'],14,2)?>분]
<?=$sms_air['reserv_air_start_arrival_area']?>출발 :
[<?=$sms_air['reserv_air_arrival_airline']?>]
<?=$sms_air['reserv_air_start_arrival_area']?> →<?=$sms_air['reserv_air_arrival_area']?>

[<?=substr($sms_air['reserv_air_arrival_date'],0,4)?>년<?=substr($sms_air['reserv_air_arrival_date'],5,2)?>월<?=substr($sms_air['reserv_air_arrival_date'],8,2)?>일<?=substr($sms_air['reserv_air_arrival_date'],11,2)?>시<?=substr($sms_air['reserv_air_arrival_date'],14,2)?>분]
입니다.
    
성인:신분증지참
소아,유아:
등본이나 의료보험증지참

항공티켓은 1시간전 발권하세요.
</textarea>
        <input type="hidden" name="reserv_air_no" value="<?=$reser_air_no?>">
    <?}else if($c =="res_ok"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
고객님 제주여행 계약메일 발송하였습니다.
즐거운여행되세요.
            </textarea>
    <?}else if($c =="absence"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
전화연결이 되지않습니다. 전화주시면 접수하신 여행일정 상담해드리겠습니다.
감사합니다.
담당: <?=$reserv[0]['reserv_person']?>
            </textarea>
    <?}else if($c =="cancel"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
입금확인 불가로 취소 되었습니다. 이용해주셔서 감사합니다.
            </textarea>
    <?}else if($c =="person"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$reserv[0]['reserv_name']?> 고객님 상담드렸던
<?=$main_company['tour_name']?>  <?=$reserv[0]['reserv_person']?> 입니다.
상담내용 결정되시면, 연락부탁드립니다.
감사합니다.
            </textarea>
    <?}else if($c =="res_all"){?>
        <textarea name="content" class="mobile-text">
<?=$main_company['tour_name']?>입니다
<?=$reserv[0]['reserv_name']?> 고객님 예약하신 여행정보입니다.
<?php
$res->reserv_no = $reserv_no;
$air_list = $res->reserv_air();
?>
<?if(is_array($air_list)){   ?>
●할인항공
<?php
foreach ($air_list as $air){
?>
<?=$air['reserv_air_departure_airline']?>예약번호[<?=$air['reserv_air_booking_number']?> ]
<?=$air['reserv_air_departure_area']?> [<?=substr($air['reserv_air_departure_date'],0,10)?> (<?=substr($air['reserv_air_departure_date'],10,6)?>)]
<?=$air['reserv_air_end_departure_area']?> [<?=substr($air['reserv_air_arrival_date'],0,10)?> (<?=substr($air['reserv_air_arrival_date'],10,6)?>)]
<?}?>
성인:신분증지참
소아,유아:등본이나 의료보험증지참
1시간전발권하세요.
<?}?>
<?php
$car_list = $res->reserv_rent();
if(is_array($car_list)){

?>
●렌트카
<?php
foreach ($car_list as $car){
    $rent->comno = $car['reserv_rent_com_no'];
    $rent_phone = $rent->company_phone();
    $rent_fuel = $rent->rent_code_name($car['reserv_rent_car_fuel']);
?>
<?=$car['reserv_rent_com_name']?>(<?=$rent_phone?>   )
차량 : <?=$car['reserv_rent_car_name']?>/<?=$rent_fuel?>

출고일: 지점 <?=substr($car['reserv_rent_start_date'],0,10)?> (<?=substr($car['reserv_rent_start_date'],11,5)?>)
반납일: 지점  <?=substr($car['reserv_rent_end_date'],0,10)?> ( <?=substr($car['reserv_rent_end_date'],11,5)?>)

  <?}?>
<?}?>
<?php
 $lod_list = $res->reserv_tel();
 if(is_array($lod_list)){
?>
●숙박
<?php
     foreach ($lod_list as $lod){
         $lodging->lodno = $lod['reserv_tel_lodno'];
         $lod_phone = $lodging->lodging_detail();
?>

<?=$lod['reserv_tel_name']?>/<?=$lod['reserv_tel_room_name']?>/<?=$lod['reserv_tel_few']?>객실
전화번호 : <?=$lod_phone['lodging_real_phone']?>

주소: <?=$lod_phone['lodging_address']?>

이용일자:<?=$lod['reserv_tel_date']?> [<?=$lod['reserv_tel_stay']?>박]

<?}?>

- 체크인:15:00 이후, 체크아웃:11:00 이전입니다. (숙소별 다소 차이가 있을 수 있습니다)
- 부대시설 이용에 대한 자세한 문의는 해당 숙소로 직접 확인하시기 바랍니다.
- 애완동물 동반시 입실거절되며 필히 해당숙소에 확인하셔야합니다. 위반시 당일취소로 간주되어 객실료를 환불받을 수 없으니 주의바랍니다.
<?}?>
<?php
  $bus_list = $res->reserv_bus();
  if(is_array($bus_list)){
?>
● 버스
<?php
foreach ($bus_list as $bus){
?>
차    종:<?=$bus['reserv_bus_name']?>[<?=$bus['reserv_bus_vehicle']?>대]
이용일자:<?=$bus['reserv_bus_date']?> [<?=$bus['reserv_bus_stay']?>일]
<?}?>

♠ 기본운행시간
- 09:00 ~ 19:00 (시간연장은 협의 후 조정가능하며, 추가요금이 부과됩니다)

♠ 포함사항
- 차량연료비, 차량전세료

♠ 불포함사항
- 봉사료(1일 5만원), 점심값 (1일 만원), 관광지 입장료

♠ 관광시 유의사항
- 관광지 할인쿠폰 사용불가
-자연위주,등산,올레길,골프 관광시에는 1일 5만원 추가요금이 발생되므로 미리 상담원에게 금액확인 또는 현장에서 추가 요금 지불 후 이용가능

♠ 버스관광안내
- 공항 도착예정 시간에 맞추어 기사님/가이드가 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.
- 가이드 요청시 별도 협의 (외국어 가이드 별도협의)
- 관광지 입장료 별도(기사님 관광지입장료는 무료입니다)
- 1일 기사님봉사료 5만원씩 별도 부과됩니다. (미리 지불 또는 현장에서 지불)
- 기사님 점심식사는 고객님과 함께 드시거나, 점심식사료(1만원) 기사님께 드리면 됩니다.

※답사 및 세미나의 경우는 금액이 달라질 수 있으므로 상담원과 상담후 예약해주세요
<?}?>
 <?php
     $bustour_list = $res->reserv_bustour();
     if(is_array($bustour_list)){
 ?>
● 패키지
<?php
 foreach ($bustour_list as $bustour){
?>
패키지명:<?=$bustour['reserv_bustour_name']?>

이용일자:<?=$bustour['reserv_bustour_date']?>
 <?}?>

         
※미팅방법
- 공항 도착예정 시간에 맞추어 기사님/가이드가 고객님의 성함표를 들고 공항 출구에 대기 하고 있습니다.
<?}?>

※본 문자는 홈페이지 또는 유선상담을 통해 고객님께서 등록하신 이메일 또는 전화번호로 발송하는 발신전용 문자입니다
고객님이 등록한 연락처 정보를 통하여 계약사항 및 거래정보를 제공하고 있으니,예약상품이 상이하거나 변경사항시 상담사에게 문의 바랍니다
자세한 사항은 홈페이지(PC)를 확인하세요.
<?=$main_company['tour_name']?>
<?=$main_company['tour_domain']?>

※문의 : 고객센터 <?=$main_company['tour_phone']?>
            </textarea>

    <?}?>
    <input type="text" name="phone" class="phone-number" value="<?=$phone?>" >
    <input type="text" name="call" class="phone-number-2" value="<?=CALL_PHONE?>" >
    <button type="button" id="send_btn" class="phone-send"></button>
    <input type="hidden" name="name" value="<?=$reserv[0]['reserv_name']?>">
    <input type="hidden" name="reserv_no" value="<?=$reserv_no?>">
    <input type="hidden" name="company" value="<?=CALL_COMPANY?>">
</div>
</form>
<script>
    $(document).ready(function () {
       $("#send_btn").click(function () {
            $("#sms_frm").submit();
       });
    });
</script>
</body>
</html>
