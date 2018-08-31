<?php
$reserv_no = $_REQUEST['reserv_no'];
$air  = new air();
$rent = new rent();
$tel  = new lodging();
$bus  = new bus();
$bustour = new bustour();
$golf = new golf();
$res  = new reservation();
$res->reserv_no = $reserv_no;
$res->res_no = $reserv_no;
$res_view = $res->reserve_view();
?>
<?
$SQL = "select * from reservation_user_content where no='{$reserv_no}'";
$rs  = $db->sql_query($SQL);
$row = $db->fetch_array($rs);

$sql_amount ="select * from reservation_amount where reserv_user_no='{$reserv_no}'";
$rs_amount   = $db->sql_query($sql_amount);
$row_amount  = $db->fetch_array($rs_amount);
$main->pack_type = $row['reserv_type'];
$pack_text = $main->pack_text();
?>
    <div class="rcon">
        <p class="res-title"><span class="res-dot"></span> <span class="res-info-text-item"><?=$res_view['reserv_name']?> 고객님!</span>예약하신 내용입니다.</p>
        <div class="res-parson">
            <table>
                <tr>
                    <td class="res-parson-title">
                        예약자 성함
                    </td>
                    <td class="res-parson-text">
                        <?=$res_view['reserv_name']?>
                    </td>
                    <td class="res-parson-title">
                        예약자 연락처
                    </td>
                    <td class="res-parson-text">
                        <?=$res_view['reserv_phone']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        예약자 이메일
                    </td>
                    <td class="res-parson-text" colspan="3">
                        <?=$res_view['reserv_email']?>
                    </td>
                </tr>

                <tr>
                    <td class="res-parson-title" style="background-color: #fffbea;">
                        실사용자 성함
                    </td>
                    <td class="res-parson-text" style="background-color: #fffbea;">
                        <?=$res_view['reserv_real_name']?>
                    </td>
                    <td class="res-parson-title" style="background-color: #fffbea;">
                        실사용자 연락처
                    </td>
                    <td class="res-parson-text"  style="background-color: #fffbea;">
                        <?=$res_view['reserv_real_phone']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        성인 탑승자명단
                    </td>
                    <td colspan="3" class="res-parson-text">
                        <?=$res_view['reserv_adult_list']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        소아 탑승자명단
                    </td>
                    <td  colspan="3"class="res-parson-text">
                        <?=$res_view['reserv_child_list']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        유아 탑승자명단
                    </td>
                    <td   colspan="3"class="res-parson-text">
                        <?=$res_view['reserv_baby_list']?>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div class="res-info">
            <table>
                <tr>
                    <td class="res-info-title">
                        상품명
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-item"><?=$pack_text?></span>
                    </td>
                </tr>
                <tr>
                    <td class="res-info-title">
                        여행인원
                    </td>
                    <td class="res-info-text">
                        성인 <span class="res-info-text-num"> <?=$res_view['reserv_child_list']?>명</span>, 소아 <span class="res-info-text-num"> <?=$res_view['reserv_child_list']?>명</span>, 유아 <span class="res-info-text-num"> <?=$res_view['reserv_child_list']?>명</span> (항공, 숙박, 차량 요금에 적용되는 인원 기준입니다.)
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
                    <td class="res-info-title">
                        할인항공
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-item">[<?=$air['reserv_air_departure_airline']?>]</span> <span class="res-info-text-num"><?=$air['reserv_air_departure_area']?></span>출발
                        <?=$air_s_date[0]?> (<?=substr($air_s_date[1],0,5)?>) <span class="res-info-text-num">제주</span>출발 <?=$air_e_date[0]?> (<?=substr($air_e_date[1],0,5)?>)
                    </td>
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
                    <td class="res-info-title">
                        숙박
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-item">[<?=$tel['reserv_tel_name']?>]</span> <?=$tel['reserv_tel_room_name']?> <?=$tel['reserv_tel_few']?>실 (<?=$tel['reserv_tel_date']?> 입실 / <span
                                class="res-info-text-num"><?=$tel['reserv_tel_stay']?>박</span>)
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
                $rent_s_date = explode(" ",$rent['reserv_rent_start_date']);
                $rent_e_date = explode(" ",$rent['reserv_rent_end_date']);
                ?>
                <tr>
                    <td class="res-info-title">
                        렌터카
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-item">[아반떼MD]</span> 1대  <span class="res-info-text-num">48시간</span> 대여일정: 2018-06-06 07:30 ~ 2018-06-06 07:30
                    </td>
                </tr>

                    <tr>
                        <td class="res-info-title-car">
                            차량인수장소
                        </td>
                        <td class="res-info-text">
                            공항
                        </td>
                    </tr>
                    <tr>
                        <td class="res-info-title-car">
                            차량반납장소
                        </td>
                        <td class="res-info-text">
                            공항
                        </td>
                    </tr>
                    <?
                }
                ?>
                <tr>
                    <td class="res-info-title-car">
                        차량옵션선택
                    </td>
                    <td class="res-info-text">
                        네비게이션
                    </td>
                </tr>
                <?}?>
                <?php
                $bus_list = $res->reserv_bus();

                if(is_array($bus_list)) {
                foreach ($bus_list as $bus) {
                $bus_edate   =  date("Y-m-d", strtotime($bus['reserv_bus_date']." +{$bus['reserv_bus_stay']} days"));
                ?>
                <tr>
                    <td class="res-info-title">
                        버스/택시
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-item">[<?=$bus['reserv_bus_name']?>]</span> <?=$bus['reserv_bus_vehicle']?>대  <span class="res-info-text-num"><?=$bus['reserv_bus_stay']?>일</span> 대여일정: <?=$bus['reserv_bus_date']?> ~ <?=$bus_edate?>
                    </td>
                </tr>
                <?}
                }
                ?>
                <?php
                $bustour_list = $res->reserv_bustour();

                if(is_array($bustour_list)) {
                    foreach ($bustour_list as $bustour) {
                ?>
                        <tr>
                            <td class="res-info-title">
                               버스투어
                            </td>
                            <td class="res-info-text">
                                <span class="res-info-text-item">[<?=$bustour['reserv_bustour_name']?>]</span>  여행일: <?=$bustour['reserv_bustour_date']?>
                            </td>
                        </tr>
                    <?}
                }
                ?>
                <?php
                $golf_list = $res->reserv_golf();

                if(is_array($golf_list)) {
                    $i=0;
                    foreach ($golf_list as $golf) {
                        ?>
                        <tr>

                            <td class="res-info-title">
                                골프 <?=($i+1)?>일차
                            </td>
                            <td class="res-info-text">

                                <span class="res-info-text-item">[<?=$golf['reserv_golf_name']?>]</span> <?=$golf['reserv_golf_hole_name']?> (<?=$golf['reserv_golf_date']?> <?=$golf['golf_time']?>:00~ / <span  class="res-info-text-num">1일</span>)

                            </td>

                        </tr>
                        <?
                        $i++;
                    }
                }?>
                <tr>
                    <td class="res-info-title">
                        총결제액
                    </td>
                    <td class="res-info-text">
                        <span class="res-info-text-num"><?=set_comma($row_amount['reserv_total_price'])?>원</span> (확인전화를 드리기전까지 예약확정이 아니라 예약접수 상태입니다.)
                    </td>
                </tr>
                <?php

                $res->amount_no = $row_amount['no'];
                $card_list = $res->amount_card();
                if(is_array($card_list)){
                    $i=0;
                    foreach ($card_list as $card) {
                        if($card['reserv_amount_card_state']=="Y"){
                            $card_ok = "결제완료";
                        }else{
                            $card_ok = "<a href='javascript:openXml({$i});'>결제하기</a>";
                        }
                        ?>
                        <form id="card_frm_<?=$i?>">
                            <tr>
                                <td class="res-info-title">
                                    <?=$card['reserv_amount_card_subject']?>카드결제
                                </td>
                                <td class="res-info-text">
                                    <span class="res-info-text-num"><?= set_comma($card['reserv_amount_card_price']) ?>원</span><span>[<?=$card_ok?>]</span>
                                </td>
                            </tr>
                            <input type="hidden" name="reserv_no" value="<?=$reserv_no?>">
                            <input type="hidden" name="reserv_card_no" value="<?=$card['no']?>">
                            <input type="hidden" name="reserv_name" value="<?=$row['reserv_name']?>">
                            <input type="hidden" name="reserv_price" value="<?=$card['reserv_amount_card_price']?>">
                            <input type="hidden" name="reserv_phone" value="<?=$row['reserv_phone']?>">
                            <input type="hidden" name="reserv_email" value="<?=$row['reserv_email']?>">
                            <input type="hidden" name="good_name" value="<?=$pack_text?>">
                        </form>
                        <?
                        $i++;
                    }
                }
                ?>
            </table>
            <div class="res-button">
                <button type="button" onclick="window.location.href='/board/board.php?board=reserv_list&name=<?=$res_view['reserv_name']?>&phone=<?=$res_view['reserv_phone']?>'">목록으로</button>
            </div>
        </div>
        <script>
            function openXml(i){


                var frmcard = document.getElementById("card_frm_"+i);


                frmcard.target = "card_payment";
                frmcard.method = "POST"
                frmcard.action = "/kcp/pc/order.php";

                var Window = window.open("", "card_payment","top=100,left=200,width=850px,height=750px,status=no,resizable=no,channelmode=0,directories=no,location=no,address=no,menubar=no,toolbar=no,scrollbars=no");

                frmcard.submit();

            }
        </script>