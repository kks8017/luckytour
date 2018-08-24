<?php
$res = new reservation();
$report  = new report();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
if(!$_REQUEST['start_date']){$start_date_a = date("Y-m-d",time()); }else{$start_date_a = $_REQUEST['start_date'];}
if(!$_REQUEST['end_date']){$end_date_a = date("Y-m-d",time()); }else{$end_date_a = $_REQUEST['end_date'];}
$start_date = $start_date_a;
$end_date = $end_date_a;
$search_date = $_REQUEST['search_date'];

$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];
$deposit_state_schedule = $_REQUEST['deposit_state_schedule'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
if(!$search_date){$search_date="deposit_date";}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();

$report->reserv_state = "OK";

?>

<div class="reservation_report_card">
    <div>

        <div class="search_form">
            <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                <p><select name="search_date" >
                            <option value="deposit_date" <?if($search_date=="deposit_date"){?>selected<?}?>>입금일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>출발일</option>
                        </select>
                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <input type="button" id="sch_btn" value="검색">
                </p>
            </form>
        </div>
        <table class="tbl_buy">
            <tr>

                <th class="title">No.</th>
                <th class="title">예약자</th>
                <th class="title">카드결제</th>
                <th class="long">내용</th>
                <th class="title">예약대장</th>
            </tr>
            <?php
            if($search_date=="deposit_date"){
                $report->search_date = "reserv_amount_card_date";
            }else{
                $report->search_date = $search_date;
            }
            $report->reserv_deposit_state_schedule = $deposit_state_schedule;
            $i=0;
            $reservation_card = $report->reservation_collect_card_report();
            $total_card_price = 0;
            if(is_array($reservation_card)) {
                foreach ($reservation_card as $card) {
                    $res->res_no = $card['reserv_user_no'];
                    $report->reserv_user_no = $card['reserv_user_no'];
                    $state = $res->reserv_state();


                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?=$card['reserv_name'] ?></td>
                        <td class="content">
                            결제명   : <?=$card['reserv_amount_card_name']?><br>
                            결제일   : <?=$card['reserv_amount_card_date']?><br>
                            결제금액 : <?=set_comma($card['reserv_amount_card_price'])?>원<br>
                        </td>
                        <td  class="content">

                            <table style="width: 700px;" >
                                <?php
                                $report->reserv_user_no = $card['reserv_user_no'];
                                $air_list = $report->air_report();
                                if(is_array($air_list)) {
                                ?>
                                <tr>
                                    <td>업체명</td>
                                    <td>입금가</td>
                                    <td>선금액</td>
                                    <td>송금일</td>
                                </tr>
                                <?php

                                foreach ($air_list as $air){
                                ?>
                                <tr>
                                    <td><?=$air['reserv_air_departure_company']?></td>
                                    <td><?=set_comma($air['reserv_air_total_deposit_price'])?>원</td>
                                    <td><?=set_comma($air['reserv_air_deposit_price'])?>원</td>
                                    <td><?=substr($air['reserv_air_deposit_date'],5,5)?></td>
                                </tr>
                                <?}?>
                                <?}?>
                                <?php

                                $rent_list = $report->rent_report();
                                if(is_array($rent_list)) {
                                ?>
                                <tr>
                                    <td>업체명</td>
                                    <td>입금가</td>
                                    <td>선금액</td>
                                    <td>송금일</td>
                                </tr>
                                <?php
                                foreach ($rent_list as $rent){
                                    ?>
                                    <tr>
                                        <td><?=$rent['reserv_rent_com_name']?></td>
                                        <td><?=set_comma($rent['reserv_rent_total_deposit_price'])?>원</td>
                                        <td><?=set_comma($rent['reserv_rent_deposit_price'])?>원</td>
                                        <td><?=substr($rent['reserv_rent_deposit_date'],5,5)?></td>
                                    </tr>
                                    <?}?>
                                <?}?>
                                <?php

                                $lod_list = $report->lodging_report();
                                if(is_array($lod_list)) {
                                    ?>
                                    <tr>
                                        <td>숙소명(객실)</td>
                                        <td>입금가</td>
                                        <td>선금액</td>
                                        <td>송금일</td>
                                    </tr>
                                    <?php
                                    foreach ($lod_list as $lodging){
                                        ?>
                                        <tr>
                                            <td><?=$lodging['reserv_tel_name']?>(<?=$lodging['reserv_tel_room_name']?>)</td>
                                            <td><?=set_comma($lodging['reserv_tel_total_dposit_price'])?>원</td>
                                            <td><?=set_comma($lodging['reserv_tel_deposit_price'])?>원</td>
                                            <td><?=substr($lodging['reserv_tel_deposit_date'],5,5)?></td>
                                        </tr>
                                    <?}?>
                                <?}?>
                                <?php

                                $bus_list = $report->bus_report();
                                if(is_array($bus_list)) {
                                    ?>
                                    <tr>
                                        <td >버스/택시명</td>
                                        <td>입금가</td>
                                        <td>선금액</td>
                                        <td>송금일</td>
                                    </tr>
                                    <?php
                                    foreach ($bus_list as $bus){
                                        ?>
                                        <tr>
                                            <td style="height: 30px;"><?=$bus['reserv_bus_name']?></td>
                                            <td><?=set_comma($bus['reserv_bus_total_deposit_price'])?>원</td>
                                            <td><?=set_comma($bus['reserv_bus_deposit_price'])?>원</td>
                                            <td><?=substr($bus['reserv_bus_deposit_date'],5,5)?></td>
                                        </tr>
                                    <?}?>
                                <?}?>
                                <?php

                                $bustour_list = $report->bustour_report();
                                if(is_array($bustour_list)) {
                                    ?>
                                    <tr>
                                        <td>버스투어명</td>
                                        <td>입금가</td>
                                        <td>선금액</td>
                                        <td>송금일</td>
                                    </tr>
                                    <?php
                                    foreach ($bustour_list as $bustour){
                                        ?>
                                        <tr>
                                            <td><?=$bustour['reserv_bustour_name']?></td>
                                            <td><?=set_comma($bustour['reserv_bustour_total_deposit_price'])?>원</td>
                                            <td><?=set_comma($bustour['reserv_bustour_deposit_price'])?>원</td>
                                            <td><?=substr($bustour['reserv_bustour_deposit_date'],5,5)?></td>
                                        </tr>
                                    <?}?>
                                <?}?>
                                <?php

                                $golf_list = $report->golf_report();
                                if(is_array($golf_list)) {
                                    ?>
                                    <tr>
                                        <td>골프장명<br>(홀명)</td>
                                        <td>입금가</td>
                                        <td>선금액</td>
                                        <td>송금일</td>
                                    </tr>
                                    <?php
                                    foreach ($golf_list as $golf){
                                        ?>
                                        <tr>
                                            <td><?=$golf['reserv_golf_name']?><br>(<?=$golf['reserv_golf_hole_name']?>)</td>
                                            <td><?=set_comma($golf['reserv_golf_total_dposit_price'])?>원</td>
                                            <td><?=set_comma($golf['reserv_golf_deposit_price'])?>원</td>
                                            <td><?=substr($golf['reserv_golf_deposit_date'],5,5)?></td>
                                        </tr>
                                    <?}?>
                                <?}?>
                            </table>

                        </td>

                        
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $card['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php

                }
            }else{
                ?>
                <tr>
                    <td colspan="10" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
                <?
            }

            ?>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#allsel").click(function () {
            $("input[name='sel[]']").prop("checked", function () {
                return !$(this).prop("checked");
            });
        });
        $("#sch_btn").click(function () {
            $("#sch_frm").submit();
        });
    });

</script>