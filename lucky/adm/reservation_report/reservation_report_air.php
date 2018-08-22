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
if(!$search_date){$search_date="reserv_air_departure_date";}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->company = $air_company;
$report->airline = $air_line;
$report->search_date = $search_date;
?>
<style>
    td{text-align: center;}
</style>
<div class="reservation_list">
    <div>
           <div class="search_form">
                <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                    <p><select name="search_date" >
                            <option value="reserv_air_departure_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>출발일</option>
                            <option value="reserv_air_arrival_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>리턴일</option>
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
                        <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;vertical-align: middle;" />
                    </p>
           </div>
          </form>

        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>판매사</th>
                <th>항공사</th>
                <th>출발일<br>리턴일</th>
                <th>발권일</th>
                <th>예약번호</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php
            $air_list = $report->air_report();
            $i=0;
            if(is_array($air_list)) {
                foreach ($air_list as $air) {
                    $res->res_no = $air['reserv_user_no'];
                    $reserv_list = $res->reservation_user();
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                        <td><?= $air['reserv_air_departure_company'] ?><br><?= $air['reserv_air_arrival_company'] ?></td>
                        <td><?= $air['reserv_air_departure_airline'] ?><br><?= $air['reserv_air_arrival_airline'] ?></td>
                        <td><?= substr($air['reserv_air_departure_date'], 0, 16) ?><br><?= substr($air['reserv_air_arrival_date'], 0, 16) ?></td>
                        <td><?= $air['reserv_air_booking_date'] ?></td>
                        <td><?= $air['reserv_air_booking_number'] ?></td>
                        <td>미발송<br><input type="button" value="문자발송" onclick="air_sms_send('<?=$air['reserv_user_no']?>','<?=$air['air_no']?>');"></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$air['reserv_user_no']?>')"/</td>
                    </tr>
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
    function air_sms_send(no,air) {
        window.open("SMS/mms.php?reserv_no="+no+"&reserv_air_no="+air+"&c=air_res_number","sms","width=254,height=460");
    }
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