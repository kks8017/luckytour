<?php include "../inc/header.sub.php"; ?>
<?php
$start_date = $_REQUEST['start_date'];
$tel_start_date = $_REQUEST['tel_start_date'];
$air_no = $_REQUEST['air_no'];
$tel_no = $_REQUEST['tel_no'];
$room_no = $_REQUEST['room_no'];
$room_vehicle = $_REQUEST['room_vehicle'];
$tel_stay = $_REQUEST['tel_stay'];
$package_type = $_REQUEST['package_type'];
$adult_number = $_REQUEST['adult_number'] ;
$child_number = $_REQUEST['child_number'];
$baby_number  = $_REQUEST['baby_number'];

$air  = new air();
$rent = new rent();
$tel  = new lodging();
$bus  = new bus();
$bustour = new bustour();
$golf = new golf();
$member = new member();
if($_SESSION['user_id']) {
    $member->user_id = $_SESSION['user_id'];
    $info = $member->user_info();
}
$main->pack_type = $_REQUEST['package'];
$pack_text = $main->pack_text();
?>
<form id="reserv_frm" action="reservation_process.php" method="post">
    <input type="hidden" name="start_date" value="<?=$_REQUEST['start_date']?>">
    <input type="hidden" name="end_date" value="<?=$_REQUEST['end_date']?>">
    <input type="hidden" name="adult_number" value="<?=$_REQUEST['adult_number']?>">
    <input type="hidden" name="child_number" value="<?=$_REQUEST['child_number']?>">
    <input type="hidden" name="baby_number" value="<?=$_REQUEST['baby_number']?>">
    <input type="hidden" name="package" value="<?=$_REQUEST['package']?>">
<div class="res-form">
	<p class="res-title">내가 선택한 상품내역</p>
		<!--항공 예약 내역-->
    <?php
    if(strpos($_REQUEST["package"],"A")!== false){
    $air->air_no = $_REQUEST['air_no'];
    $air_list = $air->air_selected();
    //   print_r($air_list);
    $main->sdate = $air_list['a_sch_departure_date'];
    $s_week = $main->week();
    $main->sdate = $air_list['a_sch_arrival_date'];
    $e_week = $main->week();

    $air_oil = get_oil($air_list['a_sch_departure_date']);

    if($air_list['a_sch_adult_sale']==0){
        $air_com = get_comm($air_list['a_sch_departure_date']);
    }else{
        $air_com = 0;
    }

    $a_sch_normal_price = ($air_list['a_sch_adult_normal_price'] + $air_oil +$air_com ) ;

    $a_sch_adult_sale_price = ($air_list['a_sch_adult_sale_price'] + $air_oil +$air_com) * $_REQUEST['adult_number'];
    $a_sch_child_sale_price = ($air_list['a_sch_child_sale_price'] + $air_oil +$air_com) * $_REQUEST['child_number'];
    $a_sch_adult_deposit_price = ($air_list['a_sch_adult_deposit_price'] + $air_oil +$air_com) * $_REQUEST['adult_number'];
    $a_sch_child_deposit_price = ($air_list['a_sch_child_deposit_price'] + $air_oil +$air_com) * $_REQUEST['child_number'];

    $total_air_price = $a_sch_adult_sale_price + $a_sch_child_sale_price;

    ?>
		<div class="res-item-list-air">
			<table>
				<tr>
					<td rowspan="3" class="color-title"></td>
					<td rowspan="3" class="item-title" >[<?=$air_list['a_sch_departure_airline_name']?>]</td>
					<td class="item-text"><?=$air_list['a_sch_departure_area_name']?>출발 <?=substr($air_list['a_sch_departure_date'],5,5)?>(<?=$e_week?>) <span class="item-text-special"><?=substr($air_list['a_sch_departure_time'],0,5)?></span></td>
					<td rowspan="3" class="item-space"></td>
					<!-- <td rowspan="3" class="item-button">
						<button  class="select-button-res">변경</button>
						<button  class="select-button-res-del">삭제</button> 
					</td> -->
				</tr>
				<tr>
					<td class="item-text">제주출발 <?=substr($air_list['a_sch_arrival_date'],5,5)?>(<?=$s_week?>) <span class="item-text-special"><?=substr($air_list['a_sch_arrival_time'],0,5)?></span></td>
				</tr>
				<tr>
					<td class="item-price"><?=set_comma($total_air_price)?>원</td>
				</tr>
			</table>
		</div>
        <input type="hidden" name="air_no" value="<?=$_REQUEST['air_no']?>">
        <input type="hidden" name="air_type" value="<?=$_REQUEST['air_type']?>">
    <?}?>
		<!--숙소 예약 내역-->
    <?php
       if(strpos($_REQUEST["package"],"T")!== false) {
                $tel->lodno = $_REQUEST['tel_no'];
                $tel->roomno = $_REQUEST['room_no'];
                $tel->start_date = $_REQUEST['tel_start_date'];
                $tel->lodging_vehicle = $_REQUEST['tel_vehicle'];
                $tel->stay = $_REQUEST['tel_stay'];
                $tel->adult_number = $_REQUEST['adult_number'];
                $tel->child_number = $_REQUEST['child_number'];
                $tel->baby_number = $_REQUEST['baby_number'];
                $tel_list = $tel->lodging_room_name();
                $lodging_price = $tel->lodging_main_price();

                if (strlen($_REQUEST['package']) == 1 and $_REQUEST['package'] != "T") {
                   $total_tel_price = (($lodging_price[1] * $_REQUEST['tel_vehicle']) );
                } else if (strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] != "T") {
                   $total_tel_price = (($lodging_price[2] * $_REQUEST['tel_vehicle']) );
                } else {
                    $total_tel_price = (($lodging_price[0] * $_REQUEST['tel_vehicle']));
                }
        ?>

		<div class="res-item-list-tel">
			<table>
				<tr>
					<td rowspan="3" class="color-title"></td>
					<td rowspan="3" class="item-title" >[<?=$tel_list[0]?>]</td>
					<td class="item-text"><?=$tel_list[1]?> <?=$_REQUEST['tel_vehicle']?>실</td>
					<td rowspan="3" class="item-space"></td>
					<!-- <td rowspan="3" class="item-button">
						<button  class="select-button-res">변경</button>
						<button  class="select-button-res-del">삭제</button> 
					</td> -->
				</tr>
				<tr>
					<td class="item-text"><?=$_REQUEST['tel_start_date']?> 입실 / <span class="item-text-special"><?=$_REQUEST['tel_stay']?>박</span></td>
				</tr>
				<tr>
					<td class="item-price"><?=set_comma($total_tel_price)?>원</td>
				</tr>
			</table>
		</div>

           <input type="hidden" name="tel_no" value="<?= $_REQUEST['tel_no'] ?>">
           <input type="hidden" name="room_no" value="<?= $_REQUEST['room_no'] ?>">
           <input type="hidden" name="tel_start_date" value="<?= $_REQUEST['tel_start_date'] ?>">
           <input type="hidden" name="tel_vehicle" value="<?= $_REQUEST['tel_vehicle'] ?>">
           <input type="hidden" name="tel_stay" value="<?= $_REQUEST['tel_stay'] ?>">
           <?
             }
         ?>
		<!--렌터카 예약 내역-->
        <?php
        if(strpos($_REQUEST["package"],"C")!== false) {
        $sql_com = "select no from rent_company where rent_com_type='대표'";
        $rs_com  = $db->sql_query($sql_com);
        $row_com = $db->fetch_array($rs_com);
        $rent->carno = $_REQUEST['car_no'];
        $rent->comno = $row_com['no'];
        $rent_list = $rent->car_list();
        $rent->start_date =$_REQUEST['car_sdate']." ".$_REQUEST['car_stime'];
        $rent->end_date = $_REQUEST['car_edate']." ".$_REQUEST['car_etime'];
        $rent_time = $rent->rent_time();
        $fuel = $rent->rent_code_name($rent_list['rent_car_fuel']);

        $rent_price = $rent->rent_price_main();
        if(strlen($_REQUEST['package'])  == 1 and $_REQUEST['package'] !="C" ){
            $total_rent_price = $rent_price[1] * $_REQUEST['car_vehicle'];
        }else if(strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] !="C" ){
            $total_rent_price = $rent_price[2] * $_REQUEST['car_vehicle'];
        }else{
            $total_rent_price = $rent_price[0] * $_REQUEST['car_vehicle'];
        }

        ?>
		<div class="res-item-list-car">
			<table>
				<tr>
					<td rowspan="3" class="color-title"></td>
					<td rowspan="3" class="item-title" >[<?=$rent_list['rent_car_name']?>]</td>
					<td class="item-text"><?=$_REQUEST['car_sdate']?> <span class="item-text-special"><?=$_REQUEST['car_stime']?></span>~</td>
					<td rowspan="3" class="item-space"></td>
					<!-- <td rowspan="3" class="item-button">
						<button  class="select-button-res">변경</button>
						<button  class="select-button-res-del">삭제</button> 
					</td> -->
				</tr>
				<tr>
					<td class="item-text"><?=$_REQUEST['car_edate']?> <span class="item-text-special"><?=$_REQUEST['car_etime']?></span> /  <span class="item-text-special"><?=$rent_time[0]?></span>시간</td>
				</tr>
				<tr>
					<td class="item-price"><?=set_comma($total_rent_price)?>원</td>
				</tr>
			</table>
		</div>
            <input type="hidden" name="car_no" value="<?=$_REQUEST['car_no']?>">
            <input type="hidden" name="car_sdate" value="<?= $_REQUEST['car_sdate'] . " " . $_REQUEST['car_stime'] ?>">
            <input type="hidden" name="car_edate" value="<?= $_REQUEST['car_edate'] . " " . $_REQUEST['car_etime'] ?>">
            <input type="hidden" name="car_vehicle" value="<?=$_REQUEST['car_vehicle']?>">
            <?php
        }
        ?>
        <?php
        if(strpos($_REQUEST["package"],"B")!== false) {
        $bus->bus_no = $_REQUEST['bus_no'];
        $bus->start_date = $_REQUEST['bus_date'];
        $bus->stay = $_REQUEST['bus_stay'];
        $bus->bus_vehicle = $_REQUEST['bus_vehicle'];
        $bus_list = $bus->bus_name();
        if($_REQUEST['bus_stay']==""){
            $_REQUEST['bus_stay'] =0;
        }
        $bus_stay =0;
        $bus_stay = $_REQUEST['bus_stay']-1;
        $bus_edate   =  date("Y-m-d", strtotime($_REQUEST['bus_date']." +{$bus_stay} days"));
        $bus_price = $bus->bus_price();
        $total_bus_price =$bus_price[0];
        ?>
		<!--버스/택시 예약 내역-->
		<div class="res-item-list-bus">
			<table>
				<tr>
					<td rowspan="3" class="color-title"></td>
					<td rowspan="3" class="item-title" >[버스]</td>
					<td class="item-text"><?=$bus_list?> <?=$_REQUEST['bus_vehicle']?>대</td>
					<td rowspan="3" class="item-space"></td>
					<!-- <td rowspan="3" class="item-button">
						<button  class="select-button-res">변경</button>
						<button  class="select-button-res-del">삭제</button> 
					</td> -->
				</tr>
				<tr>
					<td class="item-text">기사봉사료 포함 /  <span class="item-text-special"><?=$_REQUEST['bus_stay']?></span>일</td>
				</tr>
				<tr>
					<td class="item-price"><?=set_comma($total_bus_price)?>원</td>
				</tr>
			</table>
		</div>
            <input type="hidden" name="bus_no" value="<?=$_REQUEST['bus_no']?>">
            <input type="hidden" name="bus_date" value="<?=$_REQUEST['bus_date']?>">
            <input type="hidden" name="bus_stay" value="<?=$_REQUEST['bus_stay']?>">
            <input type="hidden" name="bus_vehicle" value="<?=$_REQUEST['bus_vehicle']?>">
            <?php
        }
        $total_price = $total_air_price + $total_rent_price + $total_tel_price + $total_bus_price ;
        ?>
	<p class="res-title">요금 상세정보</p>
		<div class="res-price-list">
			<table>
				<tr>												
					<td class="res-price-list-title">총금액</td>
					<td class="res-price-list-text"><span class="res-price-list-price"><?=set_comma($total_price)?>원</span>(부가치세불포함)</td>
				</tr>
			</table>
		</div>
    <input type="hidden" name="start_date" value="<?=$_REQUEST['start_date']?>">
    <input type="hidden" name="end_date" value="<?=$_REQUEST['end_date']?>">
    <input type="hidden" name="adult_number" value="<?=$_REQUEST['adult_number']?>">
    <input type="hidden" name="child_number" value="<?=$_REQUEST['child_number']?>">
    <input type="hidden" name="baby_number" value="<?=$_REQUEST['baby_number']?>">
    <input type="hidden" name="package" value="<?=$_REQUEST['package']?>">

	<p class="res-title">예약자 정보입력</p>						
		<div class="res-person-list">
			<table>
				<tr>
					<td colspan="2" class="res-person-list-title">
						<input type="radio" name="nameall" value="Y" onclick="rename();" ><label>예약자와 이용자 동일 </label>
						<input type="radio" name="nameall" value="N" onclick="rename();" checked><label>예약자와 이용자다름 </label>
					</td>
				</tr>
				<tr>
					<td class="res-person-list-title">예약자 이름</td>
					<td class="res-person-list-text">
						<input type="text" name="name" id="name" placeholder="홍길동" value="<?=$info['user_name']?>" placeholder="(예)홍길동">
					</td>
				</tr>
				<tr>
					<td class="res-person-list-title">휴대폰번호</td>
					<td class="res-person-list-text">
						<input type="text" name="phone" id="phone" placeholder="(예)01012345678" value="<?=$info['user_phone']?>">
					</td>
					
				</tr>
				<tr>
					<td class="res-person-list-title">이메일</td>
					<td class="res-person-list-text">
						<input type="text" name="email" id="email" placeholder="(예)tour@naver.com" value="<?=$info['user_email']?>">
					</td>
				</tr>
                <tr>
                    <td class="res-person-list-title">사용자 이름</td>
                    <td class="res-person-list-text">
                        <input type="text" name="real_name" id="real_name" >
                    </td>
                </tr>
                <tr>
                    <td class="res-person-list-title">휴대폰번호</td>
                    <td class="res-person-list-text">
                        <input type="text" name="real_phone" id="real_phone" >
                    </td>

                </tr>
				<tr>
					<td class="res-person-list-title" style="vertical-align: top;">요청사항</td>
					<td class="res-person-list-text">
						<textarea name="reserv_real_inquiry" placeholder="상품 이용에 관한 요청사항 입력"></textarea>
					</td>
				</tr>

			</table>
		</div>

    <?php
    if(strpos($_REQUEST["package"],"A")!== false){
	?>
        <p class="res-title">탑승자 명단 입력
		<span class="info">성인 13세 이상 | 소아 12세이하 | 유아 만24개월 미만</span>
	</p>

		<div class="res-person-list">
			<table>
				<tr>
					<td class="res-person-list-title">성인탑승자</td>
					<td class="res-person-list-text-air" colspan="2">
                        <input type="text" name="adult_name"  placeholder="이름 (예)홍길동,홍길동">
					</td>
				</tr>
				<tr>
					<td class="res-person-list-title">유아탑승자</td>
					<td class="res-person-list-text-air" colspan="2">
						<input  type="text" name="" placeholder="이름 (예)홍소아(생년월일),홍소아(생년월일)"></input>
					</td>

				</tr>
				<tr>
					<td class="res-person-list-title">소아탑승자</td>
					<td class="res-person-list-text-air" colspan="2">
						<input type="text"  name="" placeholder="이름 (예)홍유아(생년월일),홍유아(생년월일)"></input>
					</td>

				</tr>
			</table>
		</div>		
    <?}?>


	<p class="res-title">이용규정 동의</p>
		<div class="res-rule-list">
			<dl>
				<dt class="res-rule-total">
				<input type="checkbox" name="all_chk"  id="all_chk" >
				전제동의
				</dt>
				<dt>
				<input type="checkbox" name="average" id="average" value="Y" class="chk"> 개인정보 수집 및 이용동의 (필수)
				</dt>
					<dd>세부내용</dd>
				<dt><input type="checkbox"  name="privacy" id="privacy" value="Y" class="chk"> 국내여행표준약관 (필수)</dt>
					<dd>세부내용</dd>
				<dt><input type="checkbox"  name="provide" id="provide" value="Y" class="chk"> 개인정보 제3자 제공(필수)</dt>
					<dd>세부내용</dd>
			</dl>
		</div>

		<div class="button-summit-area">
			<button class="button-summit-blue" type="summit" id="reserv_btn" >예약정보 입력완료</button>
		</div>
	
</div>
</form>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
    function rename() {
        if($(":radio[name=nameall]:checked").val()=="Y") {
            $("#real_name").val($("#name").val());
            $("#real_phone").val($("#phone").val());
            $("#real_email").val($("#email").val());
        }else{
            $("#real_name").val();
            $("#real_phone").val();
            $("#real_email").val();
        }
    }
var acodian = {

  click: function(target) {
    var _self = this,
      $target = $(target);
    $target.on('click', function() {
      var $this = $(this);
      if ($this.next('dd').css('display') == 'none') {
        $('dd').slideUp();
        _self.onremove($target);

        $this.addClass('on');
        $this.next().slideDown();
      } else {
        $('dd').slideUp();
        _self.onremove($target);

      }
    });
  },
  onremove: function($target) {
    $target.removeClass('on');
  }

};
acodian.click('dt');
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

    $(document).ready(function () {
        var is_t = true;
        $("#all_chk").click(function () {
            $(".chk").prop("checked", function () {
                return !$(this).prop("checked");
            });
        });
        $("#reserv_btn").click(function () {
            if($("#name").val() == ""){
                alert("예약자명을 입력해주세요");
                return false;
            }else if($("#phone").val() == "") {
                alert("예약자 전화번호을 입력해주세요");
                return false;
            }else if(!$('#average').is(':checked')){
                alert("개인정보 수집 및 이용에 동의해주세요");
                return false;
            }else if(!$('#privacy').is(':checked')){
                alert("국내 여행 표준 약관에 동의해주세요");
                return false;
            }else if(!$('#provide').is(':checked')){
                alert("개인정보 제3자 제공에 동의해주세요");
                return false;
            }else {
                <?if(strpos($_REQUEST['package'], 'A') !== false){?>
                alert("항공명단을 안넣으실경우 진행이 느져질수있습니다.");
                <?}?>
                if(is_t==true){
                    is_t = false;
                    $("#reserv_frm").submit();
                    return true;
                }else{
                    alert("예약입력중입니다");
                    return false;
                }
            }
        })
    });
</script>

<?php include "../inc/footer.php"; ?>

