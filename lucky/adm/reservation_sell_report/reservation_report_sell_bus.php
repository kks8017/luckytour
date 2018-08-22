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
        <div class="inbody">
            <table class="conbox3">
                <tr>
                    <td > 총판매액 : <span class="price"><?=set_comma($reserv_price[4])?></span>원</td>
                    <td >총입금액 : <span class="price"><?=set_comma($deposit_price[4])?></span>원</td>
                    <td >총수익 : <span class="price"><?=set_comma($profit)?></span>원</td>
                </tr>
            </table>
        </div>
        <div class="search_form">
            <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                <p><select name="search_date" >
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
                    <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;vertical-align: middle;" />
                </p>
            </form>
        </div>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>접수일</th>
                <th>상품타입</th>
                <th>예약자</th>
                <th>버스/택시</th>
                <th>이용일(일정)</th>
                <th>판매가</th>
                <th>입금가</th>
                <th>수익</th>
                <th>예약대장</th>
            </tr>
            <?php


            $bus_list = $report->bus_report();
            $i=0;
            if(is_array($bus_list)) {
                foreach ($bus_list as $bus) {
                    $profit = $bus['reserv_bus_total_price'] - $bus['reserv_bus_total_deposit_price'];
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"> <?= $bus['indate'] ?></td>
                        <td class="con"><?= $bus['reserv_type'] ?></td>
                        <td class="con"><?= $bus['reserv_name'] ?></td>
                        <td class="con"><?= $bus['reserv_bus_name'] ?></td>
                        <td class="con"><span class="date"><?= $bus['reserv_bus_date'] ?></span>(<?=$bus['reserv_bus_stay']?>일)</td>
                        <td class="con"><span class="price"><?= set_comma($bus['reserv_bus_total_price']) ?></span>원</td>
                        <td class="con"><span class="price"><?= set_comma($bus['reserv_bus_total_deposit_price']) ?></span>원</td>
                        <td class="con"><span class="price"><?=set_comma($profit)?></span>원</td>
                        <td class="con"><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$bus['reserv_user_no']?>')"/></td>
                    <?php
                    $i++;
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