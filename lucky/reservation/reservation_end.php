<?php include_once ("../header.sub.php");?>
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
?>
    <link rel="stylesheet" href="../css/reserve_end.css" />
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar"></span>
            <h3>예약 완료 확인</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
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
        <p class="res-title"><span class="res-dot"></span>접수가 완료되었습니다. 상담원이 확인 후 빠른시간 안에 연락 드리겠습니다.</p>
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
                        성인 <span class="res-info-text-num"><?=$row['reserv_adult_number']?>명</span>, 소아 <span class="res-info-text-num"><?=$row['reserv_child_number']?>명</span>, 유아 <span class="res-info-text-num"><?=$row['reserv_baby_number']?>명</span> (항공, 숙박, 차량 요금에 적용되는 인원 기준입니다.)
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
                                <span class="res-info-text-item">[<?=$rent['reserv_rent_car_name']?>]</span> <?=$rent['reserv_rent_vehicle']?>대 <span
                                        class="res-info-text-num"><?=$rent['reserv_rent_time']?>시간</span> 대여일정: <?=$rent_s_date[0]?> <?=substr($rent_s_date[1],0,5)?> ~ <?=$rent_e_date[0]?> <?=substr($rent_e_date[1],0,5)?>
                            </td>
                        </tr>
                        <tr>
                            <td class="res-info-title-car">
                                차량인수장소
                            </td>
                            <td class="res-info-text">
                                <?=$rent['reserv_rent_departure_place']?>
                            </td>
                        </tr>
                        <tr>
                            <td class="res-info-title-car">
                                차량반납장소
                            </td>
                            <td class="res-info-text">
                                <?=$rent['reserv_rent_arrival_place']?>
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
                            <?=$rent['reserv_rent_option']?>
                        </td>
                    </tr>

                <?
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
                        <span class="res-info-text-item">[<?=$bustour['reserv_bustour_name']?>]</span> <span class="res-info-text-num"><?=$bustour['reserv_bustour_stay']?>일</span> 여행일 : <?=$bustour['reserv_bustour_date']?>
                    </td>
                </tr>
                <?}
                }?>
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
            </table>
        </div>
        <br>
        <br>
        <br>
        <br>
        <!--예약자 정보-->
        <div class="res-parson">
            <table>
                <tr>
                    <td class="res-parson-title">
                        예약자 성함
                    </td>
                    <td class="res-parson-text">
                      <?=$row['reserv_name']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        예약자 연락처
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_phone']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        예약자 이메일
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_email']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        실사용자 성함
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_real_name']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        실사용자 연락처
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_real_phone']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        성인 탑승자명단
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_adult_list']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        소아 탑승자명단
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_child_list']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        유아 탑승자명단
                    </td>
                    <td class="res-parson-text">
                        <?=$row['reserv_baby_list']?>
                    </td>
                </tr>
                <tr>
                    <td class="res-parson-title">
                        기타요청사항
                    </td>
                    <td class="res-parson-text">
                       <?=$row['reserv_inquiry']?>
                    </td>
                </tr>
            </table>
        </div>

        <!--예약 버튼-->
        <div class="res-button">
            <button type="button" id="main_loc" >메인으로 이동</button>
        </div>
    </div><!-- content 끝 -->
    <script>
        $(document).ready(function () {

            $("#main_loc").click(function () {
                window.location.href = "../index.php";
            });


        });
    </script>
<?php include_once ("../footer.php");?>