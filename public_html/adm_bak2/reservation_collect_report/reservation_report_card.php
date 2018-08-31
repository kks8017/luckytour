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



$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->reserv_state = "OK";

?>

<div class="reservation_report">
    <div>

        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table class="search_frm">
                <tr>
                    <td><select name="search_date" >
                            <option value="deposit_date" <?if($search_date=="deposit_date"){?>selected<?}?>>입금일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>출발일</option>
                        </select>
                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="deposit_state_schedule" >
                            <option value="" >전체</option>
                            <option value="Y" <?if($deposit_state_schedule =="Y"){?>selected<?}?>>수금현황</option>
                            <option value="N" <?if($deposit_state_schedule =="N"){?>selected<?}?>>수금예정현황</option>
                        </select>
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>

                <td class="title">No.</td>
                <td class="title">접수일</td>
                <td class="title">상품타입</td>
                <td class="title">예약상태</td>
                <td class="title">예약자</td>
                <td class="title">연락처</td>
                <td class="title">결제명</td>
                <td class="title">판매액</td>
                <td class="title">카드금액</td>
                <td class="title">입금일</td>
                <td class="title">상태</td>
                <td class="title">예약대장</td>
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
                    $res->res_no = $card['no'];
                    $report->reserv_user_no = $card['no'];
                    $state = $res->reserv_state();
                    switch ($card['reserv_amount_card_state']){
                        case "Y" :
                            $card_state = "입금완료";
                            break;
                        default :
                            $card_state = "입금요청";

                    }

                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($card['indate'], 0, 10) ?></td>
                        <td class="content"><?= $card['reserv_type'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?= $card['reserv_name'] ?></td>
                        <td class="content"><?= $card['reserv_phone'] ?></td>
                        <td class="content"><?= $card['reserv_amount_card_name'] ?></td>
                        <td class="content"><?=set_comma($card['reserv_total_price'])?></td>
                        <td class="content"><?=set_comma($card['reserv_amount_card_price']) ?></td>
                        <td class="content"><?=$card['reserv_amount_card_date']?></td>
                        <td class="content"><?=$card_state?></td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_card_price += $card['reserv_amount_card_price'];
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <th colspan="10" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
                <?
            }

            ?>
        </table>
        <br>
        <table>
            <tr>
                <td class="content">카드수금액 : <?=set_comma($total_card_price)?>원</td>
            </tr>
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
    $( function() {
        $( ".air_date" ).datepicker({
            numberOfMonths: 3,
            dateFormat : "yy-mm-dd",
        });
    });
</script>