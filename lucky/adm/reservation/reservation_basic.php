<?php
$no = $_REQUEST['reserv_user_no'];
$sql = "select * from reservation_user_content_basic,reservation_amount_basic where reservation_user_content_basic.reserv_user_no= reservation_amount_basic.reserv_user_no and reservation_user_content_basic.reserv_user_no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$res_list = new reservation();
$res_list->res_no = $no;
$deposit_price = $res_list->reserv_deposit_price($no);
$ledger = $res_list->reservation_ledger();
?>
<div id="wrapbasic">
    <header><p>예약기본정보</p></header>
    <div class="inbody3">
        <table class="conbox3">
            <tr>
                <td class="titbox">예약자명</td>
                <td><?=$row['reserv_name']?></td>
                <td class="titbox">연락처</td>
                <td><?=$row['reserv_phone']?></td>
            </tr>
            <?php
            if($row['reserv_group']=="Y"){
                ?>
                <tr>
                    <td class="titbox">단체명</td>
                    <td><?=$row['reserv_group_name']?></td>
                    <td class="titbox">연락처</td>
                    <td><?=$row['reserv_fax']?></td>
                </tr>
                <tr>
                    <td class="titbox">연락가능시간</td>
                    <td><?=$row['reserv_time']?></td>
                    <td class="titbox">연락방법</td>
                    <td><?=$row['reserv_counsel']?></td>
                </tr>
                <tr>
                    <td class="titbox">출발지</td>
                    <td colspan="3"><?=$row['reserv_departure_area']?></td>
                </tr>
            <?}?>
            <tr>
                <td class="titbox">이메일</td>
                <td colspan="3"><?=$row['reserv_email']?></td>
            </tr>
            <tr>
                <td class="titbox">사용자명</td>
                <td><?=$row['reserv_real_name']?></td>
                <td class="titbox">연락처</td>
                <td><?=$row['reserv_real_phone']?></td>
            </tr>

            <tr>
                <td class="titbox">성인명단</td>
                <td colspan="3" class="list"><?=$row['reserv_adult_list']?></td>
            </tr>
            <tr>
                <td class="titbox">소아명단</td>
                <td colspan="3" class="list"><?=$row['reserv_child_list']?></td>
            </tr>
            <tr>
                <td class="titbox">유아명단</td>
                <td colspan="3" class="list"><?=$row['reserv_baby_list']?></td>
            </tr>
            <tr>
                <td class="titbox">문의사항</td>
                <td colspan="3"><?=$row['reserv_inquiry']?></td>
            </tr>
            <?php
            $result_air = $res_list->air_basic_list();

                if ($result_air) {
                    ?>
                    <tr>
                        <td colspan="4" class="titbox">항공정보</td>
                    </tr>
                    <?php
                }

           if(is_array($result_air)) {
               foreach ($result_air as $air) {
                   ?>
                   <tr>
                       <td class="titbox"><?= $air['reserv_air_departure_area'] ?>->제주</td>
                       <td><?= substr($air['reserv_air_departure_date'],0,16) ?></td>
                       <td class="titbox">제주-><?= $air['reserv_air_arrival_area'] ?></td>
                       <td><?= substr($air['reserv_air_arrival_date'],0,16) ?></td>
                   </tr>
                   <tr>
                       <td class="titbox">출발항공사</td>
                       <td><?= $air['reserv_air_departure_airline'] ?></td>
                       <td class="titbox">리턴항공사</td>
                       <td><?= $air['reserv_air_arrival_airline'] ?></td>
                   </tr>
                   <tr>
                       <td class="titbox">출발에이전시</td>
                       <td><?= $air['reserv_air_departure_company'] ?></td>
                       <td class="titbox">리턴에이전시</td>
                       <td><?= $air['reserv_air_arrival_company'] ?></td>
                   </tr>
                   <tr>
                       <td class="titbox">판매할인율</td>
                       <td>성인 : <?= $air['reserv_air_adult_sale'] ?> 소아 : <?= $air['reserv_air_child_sale'] ?></td>
                       <td class="titbox">입금할인율</td>
                       <td>성인 : <?= $air['reserv_air_adult_deposit_sale'] ?> 소아
                           : <?= $air['reserv_air_child_deposit_sale'] ?></td>
                   </tr>
                   <tr>
                       <td class="titbox">항공금액</td>
                       <td colspan="3" class="total">판매액 : <?= set_comma($air['reserv_air_total_price']) ?>원 &nbsp;&nbsp;&nbsp; 입금액 : <span class="price"><?= set_comma($air['reserv_air_total_deposit_price']) ?></span>원 &nbsp;&nbsp;&nbsp; 정요금 : <?= set_comma($air['reserv_air_normal_total_price']) ?>원</td>
                   </tr>
               <?
               }
           }
            ?>
            <?php
            $result_rent = $res_list->rent_basic_list();

            if($result_rent) {
                ?>
                <tr>
                    <td colspan="4" class="titbox">렌트카정보</td>
                </tr>
                <?php
            }
            if(is_array($result_rent)) {
                foreach ($result_rent as $rent) {
                    ?>
                    <tr>
                        <td class="titbox">차량명</td>
                        <td colspan="3"><?=$rent['reserv_rent_car_name'] ?><?= $rent['reserv_rent_vehicle'] ?> 대 <?= $rent['reserv_rent_vehicle'] ?>시간
                        </td>
                    </tr>
                    <tr>
                        <td class="titbox">출고일</td>
                        <td><?=substr($rent['reserv_rent_start_date'],0,16) ?></td>
                        <td class="titbox">입고일</td>
                        <td><?=substr($rent['reserv_rent_end_date'],0,16) ?></td>
                    </tr>
                    <tr>
                        <td class="titbox">판매할인율</td>
                        <td><?=$rent['reserv_rent_sale'] ?></td>
                        <td class="titbox">입금할인율</td>
                        <td><?=$rent['reserv_rent_deposit_sale'] ?></td>
                    </tr>
                    <tr>
                        <td class="titbox">출고장소</td>
                        <td><?=$rent['reserv_rent_departure_place'] ?></td>
                        <td class="titbox">입고장소</td>
                        <td><?=$rent['reserv_rent_arrival_place'] ?></td>
                    </tr>
                    <tr>
                        <td class="titbox">렌트금액</td>
                        <td colspan="3"  class="total">판매액 : <span class="price"><?=set_comma($rent['reserv_rent_total_price']) ?></span>원 &nbsp;&nbsp;&nbsp; 입금액 : <?=set_comma($rent['reserv_rent_total_deposit_price']) ?>원</td>
                    </tr>
                <?
                }
            }
            ?>
            <?php
            $result_tel = $res_list->tel_basic_list();
            if($result_tel) {
                ?>
                <tr>
                    <td colspan="4" class="titbox">숙소정보</td>
                </tr>
                <?php
            }
            if(is_array($result_tel)) {
                foreach ($result_tel as $tel) {
                    ?>
                    <tr>
                        <td class="titbox">숙소명</td>
                        <td colspan="3"><?= $tel['reserv_tel_name'] ?>(<?= $tel['reserv_tel_room_name'] ?>
                            ) <?= $tel['reserv_tel_stay'] ?>박 <?= $tel['reserv_tel_few'] ?>실
                        </td>
                    </tr>
                    <tr>
                        <td class="titbox">입실일</td>
                        <td><?= $tel['reserv_tel_date'] ?></td>
                        <td class="titbox">퇴실일</td>
                        <td><?= date("Y-m-d", strtotime($start_date . "+{$tel['reserv_tel_stay']} days")); ?></td>
                    </tr>
                    <tr>
                        <td class="titbox">숙박금액</td>
                        <td colspan="3" class="total">판매액 : <span class="price"><?= set_comma($tel['reserv_tel_total_price']) ?></span>원 &nbsp;&nbsp;&nbsp; 입금액
                            : <?= set_comma($tel['reserv_tel_total_dposit_price']) ?>원</td>
                    </tr>
                <?
                }
            }
            ?>
            <?php
            $result_bus = $res_list->bus_basic_list();
            if($result_bus) {
                ?>
                <tr>
                    <td colspan="4" class="titbox">버스정보</td>
                </tr>
                <?php
            }
            if(is_array($result_bus)) {
                foreach ($result_bus as $bus) {
                    $bus_stay = $bus['reserv_bus_stay']-1;
                    ?>
                    <tr>
                        <td class="titbox">차량명</td>
                        <td colspan="3"><?= $bus['reserv_bus_name'] ?> <?= $bus['reserv_bus_stay'] ?>
                            일 <?= $bus['reserv_bus_vehicle'] ?>대
                        </td>
                    </tr>
                    <tr>
                        <td class="titbox">여행일</td>
                        <td><?= $bus['reserv_bus_date'] ?></td>
                        <td class="titbox">리턴일</td>
                        <td><?= date("Y-m-d", strtotime($start_date . "+{$bus_stay} days")); ?></td>
                    </tr>
                    <tr>
                        <td class="titbox">버스투어금액</td>
                        <td class="total" colspan="3">판매액 : <span class="price"><?= set_comma($bus['reserv_bus_total_price']) ?></span>원 &nbsp;&nbsp;&nbsp; 입금액
                            : <?= set_comma($bus['reserv_bus_total_deposit_price']) ?>원</td>
                    </tr>
                <?
                }
            }
            ?>
            <?php
            $result_bustour = $res_list->bustour_basic_list();
            if($result_bustour) {
                ?>
                <tr>
                    <td colspan="4" class="titbox">버스투어정보</td>
                </tr>
                <?php
            }
            if(is_array($result_bustour)) {
                foreach ($result_bustour as $bustour) {
                    ?>
                    <tr>
                        <td class="titbox">투어명</td>
                        <td ><?= $bustour['reserv_bustour_name'] ?></td>
                        <td class="titbox">여행날짜</td>
                        <td><?= $bustour['reserv_bustour_date'] ?></td>
                    </tr>
                    <tr>
                         <td class="titbox">버스투어금액</td>
                         <td colspan="3" class="con">판매액 : <?= set_comma($bustour['reserv_bustour_total_price']) ?> 입금액
                            : <?= set_comma($bustour['reserv_bustour_total_deposit_price']) ?></td>
                    </tr>
                <?
                }
            }
            ?>
            <?php
            $result_golf = $res_list->golf_basic_list();
            if($result_golf) {
                ?>
                <tr>
                    <td colspan="4" class="titbox">골프정보</td>
                </tr>
                <?php
            }
            if(is_array($result_golf)) {
                foreach ($result_golf as $golf) {
                    ?>
                    <tr>
                        <td class="titbox">골프장명(홀명)</td>
                        <td><?= $golf['reserv_golf_name'] ?>(<?= $golf['reserv_golf_hole_name'] ?>)</td>
                    </tr>
                    <tr>
                        <td class="titbox">부킹일(시간)</td>
                        <td><?= $golf['reserv_golf_date'] ?>(<?= $golf['reserv_golf_time'] ?>)</td>
                        <td class="titbox">사용일</td>
                        <td><?= $golf['reserv_golf_stay'] ?>일</td>
                    </tr>
                    <tr>
                        <td class="titbox">인원</td>
                        <td colspan="3"><?= $golf['reserv_golf_adult_number'] ?>명</td>
                    </tr>
                    <tr>
                        <td class="con">골프금액</td>
                        <td class="con" colspan="3">판매액 : <?= set_comma($golf['reserv_golf_total_price']) ?> 입금액
                            : <?= set_comma($golf['reserv_golf_total_dposit_price']) ?></td>
                    </tr>
                <?
                }
            }
            ?>
            <tr>
                <td class="titbox"> 총금액</td>
                <td class="total" colspan="3" > ▶ 판매액 : <span class="price"> <?=set_comma($row['reserv_total_price'])?></span>원 &nbsp;&nbsp;&nbsp; ▶ 입금액 : <?=set_comma($deposit_price)?>원</td>
            </tr>
        </table>
        <table class="conbox3">

            <tr>
                <td align="center">
                    <?if($ledger!="Y"){?><input type="button" value="예약대장만들기" onclick="adm_ledger();"><?}?> <input type="button" value="목록으로" onclick="window.location.href='?linkpage=reservation&subpage=res_list'"></td>
            </tr>
        </table>
    </div>
</div>
<script>
    function adm_ledger() {
        window.open("reservation/reservation_ledger.php?ledger=ledger&reserv_no=<?=$no?>","ledger_pop_<?=$no?>","width=1450,height=900");
    }
</script>