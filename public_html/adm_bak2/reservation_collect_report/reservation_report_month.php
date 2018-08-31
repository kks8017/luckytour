<?php
$res = new reservation();
$report  = new report();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
if(!$_REQUEST['start_date']){$start_date_a = date("Y-m",time()); }else{$start_date_a = $_REQUEST['start_date'];}
if(!$_REQUEST['end_date']){$end_date_a = date("Y-m",time()); }else{$end_date_a = $_REQUEST['end_date'];}
$start_date = $start_date_a."-01";
$end_date = $start_date_a."-31";
$search_date = $_REQUEST['search_date'];
echo $search_date;
$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];




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
                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date">
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
                <td class="title">판매액</td>
                <td class="title">예약금</td>
                <td class="title">입금일</td>
                <td class="title">상태</td>
                <td class="title">예약대장</td>
            </tr>
            <?php
            $i=0;

            $company_name = get_company($data['reserv_group_id']);
            $indate = explode(" ",$data['indate']);
            if($search_date=="deposit_date"){
              $report->search_date = "reserv_deposit_date";
            }else{
              $report->search_date = $search_date;
            }
            $report->reserv_deposit_state = "reserv_deposit_state";
            $report->reserv_deposit_state_schedule = "Y";
            $reservation_list = $report->reservation_collect_report();
            $i=0;
            $total_deposit_price = 0;
            if(is_array($reservation_list)) {
                foreach ($reservation_list as $reservation) {
                    $res->res_no = $reservation['no'];
                    $report->reserv_user_no = $reservation['no'];
                    $state = $res->reserv_state();


                    $report->reserv_price_state = "reserv_deposit_state";
                    $deposit_state = $report->reservation_sell_state();
             ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($reservation['indate'], 0, 10) ?></td>
                        <td class="content"><?= $reservation['reserv_type'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?= $reservation['reserv_name'] ?></td>
                        <td class="content"><?= $reservation['reserv_phone'] ?></td>
                        <td class="content"><?=set_comma($reservation['reserv_total_price'])?></td>
                        <td class="content"><?=set_comma($reservation['reserv_deposit_price']) ?></td>
                        <td class="content"><?=$reservation['reserv_deposit_date']?></td>
                        <td class="content"><?=$deposit_state?></td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_deposit_price += $reservation['reserv_deposit_price'];
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
                <td class="content">예약금수금액 : <?=set_comma($total_deposit_price)?>원</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>

                <td class="title">No.</td>
                <td class="title">접수일</td>
                <td class="title">상품타입</td>
                <td class="title">예약상태</td>
                <td class="title">예약자</td>
                <td class="title">연락처</td>
                <td class="title">판매액</td>
                <td class="title">중도금</td>
                <td class="title">입금일</td>
                <td class="title">상태</td>
                <td class="title">예약대장</td>
            </tr>
            <?php
            if($search_date=="deposit_date"){
                $report->search_date = "reserv_payment_date";

            }else{
                $report->search_date = $search_date;
            }
            $report->reserv_deposit_state = "reserv_payment_state";
            $report->reserv_deposit_state_schedule = "Y";
            $reservation_payment = $report->reservation_collect_report();
            $i=0;
            $total_payment_price = 0;
            if(is_array($reservation_payment)) {
                foreach ($reservation_payment as $reservation) {
                    $res->res_no = $reservation['no'];
                    $report->reserv_user_no = $reservation['no'];
                    $state = $res->reserv_state();


                    $report->reserv_price_state = "reserv_payment_state";
                    $payment_state = $report->reservation_sell_state();
                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($reservation['indate'], 0, 10) ?></td>
                        <td class="content"><?= $reservation['reserv_type'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?= $reservation['reserv_name'] ?></td>
                        <td class="content"><?= $reservation['reserv_phone'] ?></td>
                        <td class="content"><?=set_comma($reservation['reserv_total_price'])?></td>
                        <td class="content"><?=set_comma($reservation['reserv_payment_price']) ?></td>
                        <td class="content"><?=$reservation['reserv_payment_date']?></td>
                        <td class="content"><?=$payment_state?></td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_payment_price += $reservation['reserv_payment_price'];
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
                <td class="content">중도금수금액 : <?=set_comma($total_payment_price)?>원</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>

                <td class="title">No.</td>
                <td class="title">접수일</td>
                <td class="title">상품타입</td>
                <td class="title">예약상태</td>
                <td class="title">예약자</td>
                <td class="title">연락처</td>
                <td class="title">판매액</td>
                <td class="title">잔 금</td>
                <td class="title">입금일</td>
                <td class="title">상태</td>
                <td class="title">예약대장</td>
            </tr>
            <?php
            if($search_date=="deposit_date"){
                $report->search_date = "reserv_balance_date";
            }else{
                $report->search_date = $search_date;
            }
            $i=0;
            $report->reserv_deposit_state = "reserv_balance_state";
            $report->reserv_deposit_state_schedule = "Y";
            $reservation_balance = $report->reservation_collect_report();
            $total_balance_price = 0;
            if(is_array($reservation_balance)) {
                foreach ($reservation_balance as $reservation) {
                    $res->res_no = $reservation['no'];
                    $report->reserv_user_no = $reservation['no'];
                    $state = $res->reserv_state();

                    $report->reserv_price_state = "reserv_balance_state";
                    $balance_state = $report->reservation_sell_state();
                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($reservation['indate'], 0, 10) ?></td>
                        <td class="content"><?= $reservation['reserv_type'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?= $reservation['reserv_name'] ?></td>
                        <td class="content"><?= $reservation['reserv_phone'] ?></td>
                        <td class="content"><?=set_comma($reservation['reserv_total_price'])?></td>
                        <td class="content"><?=set_comma($reservation['reserv_balance_price']) ?></td>
                        <td class="content"><?=$reservation['reserv_balance_date']?></td>
                        <td class="content"><?=$balance_state?></td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_balance_price += $reservation['reserv_balance_price'];
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
                <td class="content">잔금수금액 : <?=set_comma($total_balance_price)?>원</td>
            </tr>
        </table>
        <br>
        <br>
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
        $("#list_btn").click(function () {


            var url = "reservation/reserv_user_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#list_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        console.log(data); // show response from the php script.
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        window.location.reload();
                    }
                });
            }
        });
        $("#sch_btn").click(function () {
            $("#sch_frm").submit();
        });
    });
    $( function() {
        $( ".air_date" ).datepicker({
            numberOfMonths: 3,
            dateFormat : "yy-mm",
        });
    });
</script>