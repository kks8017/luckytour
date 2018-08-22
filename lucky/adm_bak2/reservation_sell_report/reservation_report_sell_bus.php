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
if(!$search_date){$search_date="reserv_tour_start_date";}

$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->bus_no = $bus_no;
$report->reserv_state = "OK";
$report->search_date = $search_date;
$deposit_price = $report->reserv_deposit_price();
$reserv_price = $report->reserv_price();

$profit = $reserv_price[4] - $deposit_price[4] ;
?>

<div class="reservation_list">
    <div>
        <table>
            <tr>
                <td>  총버스/택시판매액 : <?=set_comma($reserv_price[4])?>원 &nbsp;&nbsp; 총버스/택시수익 : <?=set_comma($profit)?>원</td>
            </tr>
        </table>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table>
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
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
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>

                <td>No.</td>
                <td>접수일</td>
                <td>상품타입</td>
                <td>예약자</td>
                <td>버스/택시</td>
                <td>이용일(일정)</td>
                <td>판매가</td>
                <td>입금가</td>
                <td>수익</td>
                <td>예약대장</td>
            </tr>
            <?php


            $bus_list = $report->bus_report();
            $i=0;
            if(is_array($bus_list)) {
                foreach ($bus_list as $bus) {
                    $profit = $bus['reserv_bus_total_price'] - $bus['reserv_bus_total_deposit_price'];
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $bus['indate'] ?></td>
                        <td><?= $bus['reserv_type'] ?></td>
                        <td><?= $bus['reserv_name'] ?></td>
                        <td><?= $bus['reserv_bus_name'] ?></td>
                        <td><?= $bus['reserv_bus_date'] ?>(<?=$bus['reserv_bus_stay']?>일)</td>
                        <td><?= set_comma($bus['reserv_bus_total_price']) ?>원</td>
                        <td><?= set_comma($bus['reserv_bus_total_deposit_price']) ?>원</td>
                        <td><?=set_comma($profit)?></td>
                        <td><input type="button" value="예약대장" onclick="ledger('<?= $bus['reserv_user_no'] ?>')"></td>
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