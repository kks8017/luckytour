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
$air_company = $_REQUEST['air_company'];
$air_line = $_REQUEST['air_line'];
if(!$search_date){$search_date="reserv_tour_start_date";}

$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}

$sql_company = "select air_name from air_company  where air_type='S' and air_sch_ok='Y' order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company['air_name'];
}
$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}

$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->company = $air_company;
$report->airline = $air_line;
$report->search_date = $search_date;
$report->reserv_state = "OK";
$deposit_price = $report->reserv_deposit_price();
$reserv_price = $report->reserv_price();

$profit = $reserv_price[1] - $deposit_price[1] ;

?>

<div class="reservation_list">
    <div>
        <table>
            <tr>
                <td>  총항공판매액 : <?=set_comma($reserv_price[1])?>원 &nbsp;&nbsp; 총항공수익 : <?=set_comma($profit)?>원</td>
            </tr>
        </table>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table>
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
                        </select>

                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="air_line">
                            <option value="">항공사선택하세요</option>
                            <?php
                            foreach ($result_airline as $airline){
                                ?>
                                <option value="<?=$airline?>" <?if($air_line==$airline){?>selected<?}?>><?=$airline?></option>
                                <?
                            }
                            ?>
                        </select>
                        <select name="air_company">
                            <option value="">업체선택하세요</option>
                            <?php
                            foreach ($result_company as $company){
                                ?>
                                <option value="<?=$company?>" <?if($air_company==$company){?>selected<?}?>><?=$company?></option>
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
                <td>판매사</td>
                <td>출발항공사<br>리턴항공사</td>
                <td>출발지<br>리턴지</td>
                <td>출발일<br>리턴일</td>
                <td>판매가</td>
                <td>입금가</td>
                <td>수익</td>
                <td>예약대장</td>
            </tr>
            <?php
            $air_list = $report->air_report();
            $i=0;
            if(is_array($air_list)) {
                foreach ($air_list as $air) {
                    $res->res_no = $air['reserv_user_no'];
                    $reserv_list = $res->reservation_user();
                    $profit = $air['reserv_air_total_price'] - $air['reserv_air_total_deposit_price'];
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $air['indate'] ?></td>
                        <td><?= $air['reserv_type'] ?></td>
                        <td><?= $air['reserv_name'] ?></td>
                        <td><?= $air['reserv_air_departure_company'] ?></td>
                        <td><?= $air['reserv_air_departure_airline'] ?><br><?= $air['reserv_air_arrival_airline'] ?></td>
                        <td><?= $air['reserv_air_departure_area'] ?><br><?= $air['reserv_air_arrival_area'] ?></td>
                        <td><?= substr($air['reserv_air_departure_date'], 0, 16) ?><br><?= substr($air['reserv_air_arrival_date'], 0, 16) ?></td>
                        <td><?= set_comma($air['reserv_air_total_price']) ?></td>
                        <td><?= set_comma($air['reserv_air_total_deposit_price']) ?></td>
                        <td><?=set_comma($profit)?></td>
                        <td><input type="button" value="예약대장" onclick="ledger('<?= $air['reserv_user_no'] ?>')"></td>
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