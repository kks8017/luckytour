<?php include "../inc/header.sub.php"; ?>
<br>
<br>
<?php
$reserv_no = $_REQUEST['reserv_no'];
$air  = new air();
$rent_l = new rent();
$tel  = new lodging();
$bus  = new bus();
$bustour = new bustour();
$golf = new golf();
$res  = new reservation();
$res->reserv_no = $reserv_no;

$SQL = "select * from reservation_user_content where no='{$reserv_no}'";
$rs  = $db->sql_query($SQL);
$row = $db->fetch_array($rs);

$sql_amount ="select * from reservation_amount where reserv_user_no='{$reserv_no}'";
$rs_amount   = $db->sql_query($sql_amount);
$row_amount  = $db->fetch_array($rs_amount);
$main->pack_type = $row['reserv_type'];
$pack_text = $main->pack_text();
?>

<div class="res-form-end">
	<p class="res-title-end"> 예약접수한 상품내역</p>

		<div class="res-item-list-end">
			<table>
				<tr>									
					<td class="res-price-list-title">상품명</td>
					<td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
						<span class="res-price-list-item"><?=$pack_text?> 패키지</span>
					</td>
				</tr>
				<tr>									
					<td class="res-price-list-title">여행인원</td>
					<td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
					성인 <span class="res-price-list-item-num"><?=$row['reserv_adult_number']?>명</span>, 소아 <span class="res-price-list-item-num"><?=$row['reserv_child_number']?>명</span>, 유아 <span class="res-price-list-item-num"><?=$row['reserv_baby_number']?>명</span>
				</td>
				</tr>
                <?php
                $air_list = $res->reserv_air();

                if(is_array($air_list)){
                foreach ($air_list as $air) {
                   $air_s_date = explode(" ",$air['reserv_air_departure_date']);
                  $air_e_date = explode(" ",$air['reserv_air_arrival_date']);

                ?>
				<tr>									
					<td class="res-price-list-title">할인항공</td>
					<td class="res-price-list-text">
					<span class="res-price-list-item">[<?=$air['reserv_air_departure_airline']?>]</span>
					</td>
             		<td class="res-price-list-text" >
              			<span class="res-price-list-item-num"><?=$air['reserv_air_departure_area']?></span>출발 <?=$air_s_date[0]?> (<?=substr($air_s_date[1],0,5)?>)<br>
             			<span class="res-price-list-item-num">제주</span>출발 <?=$air_e_date[0]?> (<?=substr($air_e_date[1],0,5)?>)
             		<td>
				</tr>
                <?
                   }
                }
                ?>
                <?php
                $tel_list = $res->reserv_tel();

                if(is_array($tel_list)) {
                foreach ($tel_list as $tel) {
                ?>
				<tr>												
					<td class="res-price-list-title">숙박</td>
					<td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
						<span class="res-price-list-item">[<?=$tel['reserv_tel_name']?>]</span> <?=$tel['reserv_tel_room_name']?> <?=$tel['reserv_tel_few']?>실
						(<?=$tel['reserv_tel_date']?> 입실 / <span class="res-price-list-item-num"><?=$tel['reserv_tel_stay']?>박</span>)
					</td>
				</tr>
                <?
                    }
                }
                ?>
                <?php
                $rent_list = $res->reserv_rent();

                if(is_array($rent_list)) {
                    foreach ($rent_list as $rent) {
                        $rent_s_date = explode(" ", $rent['reserv_rent_start_date']);
                        $rent_e_date = explode(" ", $rent['reserv_rent_end_date']);
                        $fuel = $rent_l->rent_code_name($rent['reserv_rent_car_fuel']);
                        ?>
                        <tr>
                            <td class="res-price-list-title">렌터카</td>
                            <td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
                                <span class="res-price-list-item">[<?= $rent['reserv_rent_car_name'] ?>](<?=$fuel?>
                                    )</span> <?= $rent['reserv_rent_vehicle'] ?>대
                                <span class="res-price-list-item-num"><?= $rent['reserv_rent_time'] ?>
                                    시간</span> <?= $rent_s_date[0] ?> <?= substr($rent_s_date[1], 0, 5) ?>
                                ~ <?= $rent_e_date[0] ?> <?= substr($rent_e_date[1], 0, 5) ?>
                            </td>
                        </tr>

                        <?
                    }
                }
                ?>
                <?php
                $bus_list = $res->reserv_bus();

                if(is_array($bus_list)) {
                foreach ($bus_list as $bus) {
                   $bus_stay = $bus['reserv_bus_stay']-1;
                   $bus_edate   =  date("Y-m-d", strtotime($bus['reserv_bus_date']." +{$bus_stay} days"));
                ?>
				<tr>									
					<td class="res-price-list-title">버스</td>
					<td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
						<span class="res-price-list-item"><?=$bus['reserv_bus_name']?></span> / 기사봉사료 포함 / <?=$bus['reserv_bus_stay']?>일
					</td>
				</tr>
                <?}
                }
                ?>
				<tr>												
					<td class="res-price-list-title">총결제액</td>
					<td class="res-price-list-text" colspan="2" style=" border-right: 1px solid #A4A4A4;">
						<span class="res-price-list-item-num"><?=set_comma($row_amount['reserv_total_price'])?>원</span>
					</td>
				</tr>
				<tr>												
					<td class="res-price-list-text-info" colspan="3" style=" border-right: 1px solid #A4A4A4;">
						* 예약이 접수되면 확인전화를 드리기 전까지는 예약확정이 아니라 
   						예약접수 상태입니다.
					</td>
				</tr>
			</table>
		</div>
<br>
<br>
<br>
<br>
<br>
	<p class="res-title-end">내가 접수한 내역</p>

		<div class="res-item-list-end">
			<table>
				<tr>									
					<td class="res-price-list-title-blue">예약자 성함</td>
					<td class="res-price-list-text-blue"  style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_name']?>
					</td>
				</tr>
				<tr>									
					<td class="res-price-list-title-blue">예약자 연락처</td>
					<td class="res-price-list-text-blue"  style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_phone']?>
				</td>
				</tr>
				<tr>									
					<td class="res-price-list-title-blue">예약자 이메일</td>
					<td class="res-price-list-text-blue">
                        <?=$row['reserv_email']?>
					</td>
				</tr>
				<tr>												
					<td class="res-price-list-title-red">실사용자 성함</td>
					<td class="res-price-list-text-red"  style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_real_name']?>
					</td>
				</tr>
				<tr>									
					<td class="res-price-list-title-red">실사용자 연락처</td>
					<td class="res-price-list-text-red" style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_real_phone']?>
					</td>
				</tr>
				<tr>									
					<td class="res-price-list-title-blue">성인 탑승자명단<br>
					<span style="font-size:25px;">(중학생 이상)</span></td>
					<td class="res-price-list-text-blue" style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_adult_list']?>
					</td>
				</tr>
				<tr>												
					<td class="res-price-list-title-blue">소아 탑승자명단<br>
					<span style="font-size:25px;">(만24개월~초등학생)</span>
					</td>
					<td class="res-price-list-text-blue" style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_child_list']?>
					</td>
				</tr>
                <tr>
                    <td class="res-price-list-title-blue">유아 탑승자명단<br>
                        <span style="font-size:25px;">(만24개월미만)</span>
                    </td>
                    <td class="res-price-list-text-blue" style=" border-right: 1px solid #A4A4A4;">
                        <?=$row['reserv_baby_list']?>
                    </td>
                </tr>
				<tr>												
					<td class="res-price-list-title-blue">차량인수장소</td>
					<td class="res-price-list-text-blue" style=" border-right: 1px solid #A4A4A4;">
                        <?=$rent['reserv_rent_departure_place']?>
					</td>
				</tr>				
				<tr>												
					<td class="res-price-list-title-blue">차량반납장소</td>
					<td class="res-price-list-text-blue" style=" border-right: 1px solid #A4A4A4;">
                        <?=$rent['reserv_rent_departure_place']?>
					</td>
				</tr>
			
			</table>
		</div>
		<br>
		<br>
		<div class="button-summit-area">
			<button class="button-summit-blue" type="button" id="main_loc">목록보기</button>
		</div>
	
</div>

<script>
    $(document).ready(function () {

        $("#main_loc").click(function () {
            window.location.href = "../index.php";
        });


    });
</script>

<?php include "../inc/footer.php"; ?>

