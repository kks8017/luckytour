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
$bus_no = $_REQUEST['bus_no'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
$sql_bus = "select no,bus_name from bus_taxi_car order by no";
$rs_bus    = $db->sql_query($sql_bus);
while ($row_bus = $db->fetch_array($rs_bus)){
    $result_bus[] = $row_bus;
}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->bus_no = $bus_no;
$report->search_date = $search_date;
?>

<div class="reservation_list">
    <div>
        <div class="search_form">
            <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                <p><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
                            <option value="deposit" <?if($search_date=="deposit"){?>selected<?}?>>선금일</option>
                        </select>

                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="bus_no">
                            <option value="">차량을선택하세요</option>
                            <?php
                            foreach ($result_bus as $bus) {
                                ?>
                                <option value="<?=$bus['no']?>" <?if($bus_no==$bus['no']){?>selected<?}?>><?=$bus['bus_name']?></option>
                                <?
                            }
                            ?>
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
                    <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;vertical-align: middle;" />
                </p>
            </form>
        </div>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>상품타입</th>
                <th>버스/택시</th>
                <th>이용일(일정)</th>
                <th>판매가</th>
                <th>입금가</th>
                <th>선금</th>
                <th>송금일</th>
                <th>상태</th>
                <th>잔금</th>
                <th>송금일</th>
                <th>상태</th>
                <th>미송금액</th>
                <th>예약대장</th>
            </tr>
            <?php


            $bus_list = $report->bus_report();
            $i=0;
            if(is_array($bus_list)) {
                $total_bus_price =0;
                $total_bus_deposit_price =0;
                $deposit_bus_price = 0;
                $balance_bus_price = 0;
                $total_bus_not_remit = 0;
                foreach ($bus_list as $bus) {
                    $res->res_no = $bus['reserv_user_no'];
                    $deposit_state = $res->reserve_amount();
                    if ($bus['reserv_bus_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($bus['reserv_bus_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    if($deposit_state['reserv_deposit_state']=="Y"){
                        $dep_ok = "<span style='color: red'>입금완료</span>";
                    }else{
                        $dep_ok = "<span style='color: blue'>미입금</span>";
                    }
                    $total_remit = 0;
                    if($deposit_state['reserv_deposit_state']=="Y") {
                        if ($bus['reserv_bus_deposit_state'] == "Y") {
                            $total_remit = $bus['reserv_bus_deposit_price'] + $bus['reserv_bus_balance_price'];
                            $not_remit = $bus['reserv_bus_total_deposit_price'] - $total_remit;
                        } else {

                            $not_remit = $bus['reserv_bus_total_deposit_price'];
                        }
                    }
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $bus['reserv_name'] ?><br><?= $bus['reserv_type'] ?></td>

                        <td class="con"><?= $bus['reserv_bus_name'] ?></td>
                        <td class="con"><?= $bus['reserv_bus_date'] ?>(<?=$bus['reserv_bus_stay']?>일)</td>
                        <td class="con"><?=$dep_ok?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_total_price']) ?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_deposit_price']) ?></td>
                        <td class="con"><?= substr($bus['reserv_bus_deposit_date'],5,5) ?></td>
                        <td class="con"><?=$state_deposit?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_balance_price']) ?></td>
                        <td class="con"><?= substr($bus['reserv_bus_balance_date'],5,5) ?></td>
                        <td class="con"><?=$state_balance?></td>
                        <td class="con"><?= set_comma($not_remit) ?></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $bus['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_bus_price += $bus['reserv_bus_total_price'];
                    $total_bus_deposit_price += $bus['reserv_bus_total_deposit_price'];
                    $deposit_bus_price += $bus['reserv_bus_deposit_price'];
                    $balance_bus_price += $bus['reserv_bus_balance_price'];
                    $total_bus_not_remit += $not_remit;
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <td colspan="16" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
                <?
            }
            ?>
        </table>
        <br>
        <table class="tbl_total">
            <tr>
                <td class="con">총판매가 : <?=set_comma($total_bus_price)?> | 총입금가  <?=set_comma($total_bus_deposit_price)?> |  선금  <?=set_comma($deposit_bus_price)?>  | 잔금  <?=set_comma($balance_bus_price)?>  | 미송금액 <?=set_comma($total_bus_not_remit)?> </td>
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

</script>