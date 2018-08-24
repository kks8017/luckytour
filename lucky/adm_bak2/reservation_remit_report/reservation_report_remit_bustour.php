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
$bustour_no = $_REQUEST['bustour_no'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
$sql_bustour = "select no,bustour_tour_name from bustour_tour order by no";
$rs_bustour    = $db->sql_query($sql_bustour);
while ($row_bustour = $db->fetch_array($rs_bustour)){
    $result_bustour[] = $row_bustour;
}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->bustour_no = $bustour_no;
$report->search_date = $search_date;
?>

<div class="reservation_list">
    <div>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table>
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
                            <option value="deposit" <?if($search_date=="deposit"){?>selected<?}?>>선금일</option>
                        </select>

                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="bustour_no">
                            <option value="">버스투어선택해주세요</option>
                            <?php
                            foreach ($result_bustour as $bustour) {
                                ?>
                                <option value="<?=$bustour['no']?>" <?if($bustour_no==$bustour['no']){?>selected<?}?>><?=$bustour['bustour_tour_name']?></option>
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
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>

                <td>No.</td>
                <td>예약자</td>
                <td>상품타입</td>
                <td>패키지명</td>
                <td>이용일(인원)</td>
                <td>판매가</td>
                <td>입금가</td>
                <td>선금</td>
                <td>송금일</td>
                <td>상태</td>
                <td>잔금</td>
                <td>송금일</td>
                <td>상태</td>
                <td>미송금액</td>
                <td>예약대장</td>
            </tr>
            <?php


            $bustour_list = $report->bustour_report();
            $i=0;
            if(is_array($bustour_list)) {
                $total_bustour_price =0;
                $total_bustour_deposit_price =0;
                $deposit_bustour_price = 0;
                $balance_bustour_price = 0;
                $total_bustour_not_remit = 0;
                foreach ($bustour_list as $bustour) {
                    if ($bustour['reserv_bustour_deposit_state'] == "Y") {
                        $state_deposit = "입금완료";
                    } else {
                        $state_deposit = "미입금";
                    }
                    if ($bustour['reserv_bustour_balance_state'] == "Y") {
                        $state_balance = "입금완료";
                    } else {
                        $state_balance = "미입금";
                    }
                    $total_remit = 0;
                    if($bustour['reserv_bustour_deposit_state']=="Y") {
                        $total_remit = $bustour['reserv_bustour_deposit_price'] + $bustour['reserv_bustour_balance_price'];
                        $not_remit = $bustour['reserv_bustour_total_deposit_price'] - $total_remit;
                    }else{

                        $not_remit = 0;
                    }

                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $bustour['reserv_name'] ?></td>
                        <td><?= $bustour['reserv_type'] ?></td>
                        <td><?= $bustour['reserv_bustour_name'] ?></td>
                        <td><?= $bustour['reserv_bustour_date'] ?>(<?=$bustour['reserv_bustour_number']?>명)</td>
                        <td><?= set_comma($bustour['reserv_bustour_total_price']) ?></td>
                        <td><?= set_comma($bustour['reserv_bustour_total_deposit_price']) ?></td>
                        <td><?= set_comma($bustour['reserv_bustour_deposit_price']) ?></td>
                        <td><?= substr($bustour['reserv_bustour_deposit_date'],5,5) ?></td>
                        <td><?=$state_deposit?></td>
                        <td><?= set_comma($bustour['reserv_bustour_balance_price']) ?></td>
                        <td><?= substr($bustour['reserv_bustour_balance_date'],5,5) ?></td>
                        <td><?=$state_balance?></td>
                        <td><?= set_comma($not_remit) ?></td>
                        <td><input type="button" value="예약대장" onclick="ledger('<?= $bustour['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_bustour_price += $bustour['reserv_bustour_total_price'];
                    $total_bustour_deposit_price += $bustour['reserv_bustour_total_deposit_price'];
                    $deposit_bustour_price += $bustour['reserv_bustour_deposit_price'];
                    $balance_bustour_price += $bustour['reserv_bustour_balance_price'];
                    $total_bustour_not_remit += $not_remit;
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <th colspan="16" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
                <?
            }
            ?>
        </table>
        <br>
        <table>
            <tr>
                <td>총판매가 : <?=set_comma($total_bustour_price)?> | 총입금가  <?=set_comma($total_bustour_deposit_price)?> |  선금  <?=set_comma($deposit_bustour_price)?>  | 잔금  <?=set_comma($balance_bustour_price)?>  | 미송금액 <?=set_comma($total_bustour_not_remit)?> </td>
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
            dateFormat : "yy-mm-dd",
        });
    });
</script>