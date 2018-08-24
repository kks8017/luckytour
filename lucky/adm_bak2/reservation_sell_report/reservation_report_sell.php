<?php
$res = new reservation();
$report  = new report();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
if(!$_REQUEST['start_date']){$start_date_a = date("Y-m-d",time()); }else{$start_date_a = $_REQUEST['start_date'];}
if(!$_REQUEST['end_date']){$end_date_a = date("Y-m-d",time()); }else{$end_date_a = $_REQUEST['end_date'];}
$start_date = $start_date_a." 00:00:00";
$end_date = $end_date_a." 23:59:00";
$search_date = $_REQUEST['search_date'];
$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];
if(!$search_date){$search_date="reserv_tour_start_date";}



$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->search_date = $search_date;
$report->reserv_state = $state;
$all_state = $report->reservation_state_number();

$profit = $report->reservation_profit();
?>

<div class="reservation_report">
    <div>
        <table>
            <tr>
                <td>접수 : <?=$all_state['cnt_wt']?> 보류 : <?=$all_state['cnt_bl']?> 완료 : <?=$all_state['cnt_ok']?>  취소: <?=$all_state['cnt_cl']?>  결항 : <?=$all_state['cnt_bl']?> 부재 : <?=$all_state['cnt_bj']?>  총판매액 : <?=set_comma($all_state['total_sum'])?>원 총수익 : <?=set_comma($profit)?>원</td>
            </tr>
        </table>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table class="search_frm">
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>출발일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>리턴일</option>
                            <option value="indate" <?if($search_date=="indate"){?>selected<?}?>>접수일</option>
                        </select>

                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="state">
                            <option value="" <?if($state==""){?>selected<?}?>>접수상태</option>
                            <option value="WT" <?if($state=="WT"){?>selected<?}?>>접수</option>
                            <option value="BL" <?if($state=="BL"){?>selected<?}?>>보류</option>
                            <option value="OK" <?if($state=="OK"){?>selected<?}?>>완료</option>
                            <option value="CL" <?if($state=="CL"){?>selected<?}?>>취소</option>
                            <option value="GL" <?if($state=="GL"){?>selected<?}?>>결항</option>
                            <option value="BJ" <?if($state=="BJ"){?>selected<?}?>>부재</option>
                        </select>
                        <select name="reserv_staff">
                            <option value="">관리자</option>
                            <?php
                            foreach ($result_staff as $staff) {
                                ?>
                                <option value="<?=$staff['no']?>" <?if($reserv_staff==$staff['no']){?>selected<?}?>><?=$staff['ad_name']?></option>
                                <?
                            }
                            ?>
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
                <td class="title">예약자</td>
                <td class="title">여행일정</td>
                <td class="title">판매액</td>
                <td class="title">담당자</td>
                <td class="title">예약상태</td>
                <td class="title">수익</td>
                <td class="title">예약대장</td>
            </tr>
            <?php
            $i=0;

            $company_name = get_company($data['reserv_group_id']);
            $indate = explode(" ",$data['indate']);


            $reservation_list = $report->reservation_report();

            $i=0;
            if(is_array($reservation_list)) {
                foreach ($reservation_list as $reservation) {
                    $res->res_no = $reservation['no'];
                    $report->reserv_user_no = $reservation['no'];
                    $state = $res->reserv_state();
                    $deposit_price = $res->reserv_deposit_price();
                    $profit = $reservation['reserv_total_price'] - $deposit_price;

                    $report->reserv_price_state = "reserv_deposit_state";
                    $deposit_state = $report->reservation_sell_state();
                    $report->reserv_price_state = "reserv_payment_state";
                    $payment_state = $report->reservation_sell_state();
                    $report->reserv_price_state = "reserv_balance_state";
                    $balance_state = $report->reservation_sell_state();
                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($reservation['indate'], 0, 16) ?></td>
                        <td class="content"><?= $reservation['reserv_type'] ?></td>
                        <td class="content"><?= $reservation['reserv_name'] ?></td>
                        <td class="content"><?= $reservation['reserv_tour_start_date'] ?> ~ <?= $reservation['reserv_tour_end_date'] ?></td>
                        <td>총금액 : <?=set_comma($reservation['reserv_total_price'])?>원 </br>
                            예약금 : <?=$deposit_state?> <?=set_comma($reservation['reserv_deposit_price'])?>원 (<?=substr($reservation['reserv_deposit_date'],5,8)?>)</br>
                            중도금 : <?=$payment_state?> <?=set_comma($reservation['reserv_payment_price'])?>원 (<?=substr($reservation['reserv_payment_date'],5,8)?>)</br>
                            잔 &nbsp;&nbsp;금 : <?=$balance_state?> <?=set_comma($reservation['reserv_balance_price'])?>원 (<?=substr($reservation['reserv_balance_date'],5,8)?>)
                        </td>
                        <td class="content"><?= $reservation['reserv_person'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?=set_comma($profit)?>원</td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
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
            dateFormat : "yy-mm-dd",
        });
    });
</script>