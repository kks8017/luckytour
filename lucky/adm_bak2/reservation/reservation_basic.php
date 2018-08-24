<?php
$no = $_REQUEST['reserv_user_no'];
$sql = "select * from reservation_user_content_basic,reservation_amount_basic where reservation_user_content_basic.no= reservation_amount_basic.reserv_user_no and reservation_user_content_basic.reserv_user_no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$res_list = new reservation();
$res_list->res_no = $no;
$deposit_price = $res_list->reserv_deposit_price($no);
?>
<div class="reservation_content">
    <div>
        <table>
            <tr>
                <td>예약자명</td>
                <td><?=$row['reserv_name']?></td>
                <td>연락처</td>
                <td><?=$row['reserv_phone']?></td>
            </tr>
            <tr>
                <td>이메일</td>
                <td colspan="3"><?=$row['reserv_email']?></td>
            </tr>
            <tr>
                <td>사용자명</td>
                <td><?=$row['reserv_real_name']?></td>
                <td>연락처</td>
                <td><?=$row['reserv_real_phone']?></td>
            </tr>
            <tr>
                <td>성인명단</td>
                <td colspan="3"><?=$row['reserv_adult_list']?></td>
            </tr>
            <tr>
                <td>소아명단</td>
                <td colspan="3"><?=$row['reserv_child_list']?></td>
            </tr>
            <tr>
                <td>유아명단</td>
                <td colspan="3"><?=$row['reserv_baby_list']?></td>
            </tr>
            <tr>
                <td>문의사항</td>
                <td colspan="3"><?=$row['reserv_inquiry']?></td>
            </tr>
            <?php
            $result_air = $res_list->air_basic_list();
            if($result_air) {
                ?>
                <tr>
                    <td colspan="4">항공정보</td>
                </tr>
             <?php
            }

            foreach ($result_air as $air){
            ?>
            <tr>
                <td><?=$air['reserv_air_departure_area']?>->제주</td>
                <td><?=$air['reserv_air_departure_date']?></td>
                <td>제주-><?=$air['reserv_air_arrival_area']?></td>
                <td><?=$air['reserv_air_arrival_date']?></td>
            </tr>
            <tr>
                <td>출발항공사</td>
                <td><?=$air['reserv_air_departure_airline']?></td>
                <td>리턴항공사</td>
                <td><?=$air['reserv_air_arrival_airline']?></td>
            </tr>
            <tr>
                <td>출발에이전시</td>
                <td><?=$air['reserv_air_departure_company']?></td>
                <td>리턴에이전시</td>
                <td><?=$air['reserv_air_arrival_company']?></td>
            </tr>
            <tr>
                <td>판매할인율</td>
                <td>성인 : <?=$air['reserv_air_adult_sale']?> 소아 : <?=$air['reserv_air_child_sale']?></td>
                <td>입금할인율</td>
                <td>성인 : <?=$air['reserv_air_adult_deposit_sale']?> 소아 : <?=$air['reserv_air_child_deposit_sale']?></td>
            </tr>
            <tr>
                <td colspan="4">판매액 : <?=set_comma($air['reserv_air_total_price'])?> 입금액 : <?=set_comma($air['reserv_air_total_deposit_price'])?> 정요금 : <?=set_comma($air['reserv_air_normal_total_price'])?></td>
            </tr>
            <?}?>
            <?php
            $result_rent = $res_list->rent_basic_list();
            if($result_rent) {
                ?>
                <tr>
                    <td colspan="4">렌트카정보</td>
                </tr>
                <?php
            }

            foreach ($result_rent as $rent){
            ?>
            <tr>
                <td>차량명 </td>
                <td><?$rent['reserv_rent_car_name']?> <?=$rent['reserv_rent_vehicle']?>대 <?=$rent['reserv_rent_vehicle']?>시간</td>
            </tr>
            <tr>
                <td>출고일 </td>
                <td><?$rent['reserv_rent_start_date']?></td>
                <td>입고일 </td>
                <td><?$rent['reserv_rent_end_date']?></td>
            </tr>
                <tr>
                    <td>판매할인율 </td>
                    <td><?$rent['reserv_rent_sale']?></td>
                    <td>입금할인율 </td>
                    <td><?$rent['reserv_rent_deposit_sale']?></td>
                </tr>
            <tr>
                <td>출고장소 </td>
                <td><?$rent['reserv_rent_departure_place']?></td>
                <td>입고장소 </td>
                <td><?$rent['reserv_rent_arrival_place']?></td>
            </tr>
            <tr>
                <td colspan="4"><?$rent['reserv_rent_option']?></td>
            </tr>
            <tr>
                <td colspan="4">판매액 : <?set_comma($rent['reserv_rent_total_price'])?> 입금액 : <?set_comma($rent['reserv_rent_total_deposit_price'])?></td>
            </tr>
            <?}?>
            <?php
            $result_tel = $res_list->tel_basic_list();
            if($result_tel) {
                ?>
                <tr>
                    <td colspan="4">숙소정보</td>
                </tr>
                <?php
            }

            foreach ($result_tel as $tel){
            ?>
            <tr>
                <td>숙소명 </td>
                <td><?=$tel['reserv_tel_name']?>(<?=$tel['reserv_tel_room_name']?>) <?=$tel['reserv_tel_stay']?>박 <?=$tel['reserv_tel_few']?>실</td>
            </tr>
            <tr>
                <td>입실일 </td>
                <td><?=$tel['reserv_tel_date']?></td>
                <td>퇴실일 </td>
                <td><?=date("Y-m-d",strtotime($start_date."+{$tel['reserv_tel_stay']} days"));?></td>
            </tr>
            <tr>
                <td colspan="4">판매액 : <?=set_comma($tel['reserv_tel_total_price'])?> 입금액 : <?=set_comma($tel['reserv_tel_total_dposit_price'])?></td>
            </tr>
            <?}?>
            <?php
            $result_bus = $res_list->bus_basic_list();
            if($result_bus) {
                ?>
                <tr>
                    <td colspan="4">버스정보</td>
                </tr>
                <?php
            }

            foreach ($result_bus as $bus){
            ?>
            <tr>
                <td>차량명 </td>
                <td><?=$bus['reserv_bus_name']?> <?=$bus['reserv_bus_stay']?>일 <?=$bus['reserv_bus_vehicle']?>대</td>
            </tr>
            <tr>
                <td>여행일 </td>
                <td><?=$bus['reserv_bus_date']?></td>
                <td>리턴일 </td>
                <td><?=date("Y-m-d",strtotime($start_date."+{$bus['reserv_bus_stay']} days"));?></td>
            </tr>
            <tr>
                <td>판매액 : <?=set_comma($bus['reserv_bus_total_price'])?> 입금액 : <?=set_comma($bus['reserv_bus_total_deposit_price'])?></td>
             </tr>
            <?}?>
            <?php
            $result_bustour = $res_list->bustour_basic_list();
            if($result_bustour) {
                ?>
                <tr>
                    <td colspan="4">버스투어정보</td>
                </tr>
                <?php
            }

            foreach ($result_bustour as $bustour){
            ?>
            <tr>
                <td>투어명 </td>
                <td><?=$bustour['reserv_bustour_name']?></td>
            </tr>
            <tr>
                <td>여행날짜 </td>
                <td><?=$bustour['reserv_bustour_date']?></td>
                <td>투어일 </td>
                <td><?=$bustour['reserv_bustour_stay']?></td>
            </tr>
            <tr>
                <td colspan="4">판매액 : <?=set_comma($bustour['reserv_bustour_total_price'])?> 입금액 : <?=set_comma($bustour['reserv_bustour_total_deposit_price'])?></td>
            </tr>
            <?}?>
            <?php
            $result_golf = $res_list->golf_basic_list();
            if($result_golf) {
                ?>
                <tr>
                    <td colspan="4">골프정보</td>
                </tr>
                <?php
            }

            foreach ($result_golf as $golf){
            ?>
            <tr>
                <td>골프장명(홀명) </td>
                <td><?=$golf['reserv_golf_name']?>(<?=$golf['reserv_golf_hole_name']?>)</td>
            </tr>
            <tr>
                <td>부킹일(시간) </td>
                <td><?=$golf['reserv_golf_date']?>(<?=$golf['reserv_golf_time']?>)</td>
                <td>사용일 </td>
                <td><?=$golf['reserv_golf_stay']?>일</td>
            </tr>
                <tr>
                    <td>인원 </td>
                    <td colspan="3"><?=$golf['reserv_golf_adult_number']?>명</td>
                </tr>
            <tr>
                <td>판매액 : <?=set_comma($golf['reserv_golf_total_price'])?> 입금액 : <?=set_comma($golf['reserv_golf_total_dposit_price'])?></td>
            </tr>
            <?}?>
        </table>
        <table>
            <tr>
                <td>판매액 : <?=set_comma($row['reserv_total_price'])?> 입금액 : <?=set_comma($deposit_price)?></td>
            </tr>
        </table>
        <table>
            <tr>
                <td><input type="button" value="예약대장만들기"> <input type="button" value="목록으로"></td>
            </tr>
        </table>
    </div>
</div>