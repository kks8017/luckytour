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

if(!$search_date){$search_date="reserv_tour_start_date";}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->company = $air_company;
$report->airline = $air_line;
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
            </form>
        </div>
        <table class="tbl">
            <tr>
                <th>No.</th>
                <th>상품타입</th>
                <th>예약자</th>
                <th>항공사<br>판매사</th>
                <th>출발지</th>
                <th>출발일<br>리턴일</th>
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
            $i=0;

            $company_name = get_company($data['reserv_group_id']);
            $indate = explode(" ",$data['indate']);


            $air_list = $report->air_report();

            $i=0;
            if(is_array($air_list)) {
                $total_air_price =0;
                $total_air_deposit_price =0;
                $deposit_air_price = 0;
                $balance_air_price = 0;
                $total_air_not_remit = 0;
                foreach ($air_list as $air) {
                    $res->res_no = $bus['reserv_user_no'];
                    $deposit_state = $res->reserve_amount();
                    if ($air['reserv_air_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($air['reserv_air_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    if($deposit_state['reserv_deposit_state']=="Y") {
                        if ($air['reserv_air_deposit_state'] == "Y") {
                            $total_remit = $air['reserv_air_deposit_price'] + $air['reserv_air_balance_price'];
                            $not_remit = $air['reserv_air_total_deposit_price'] - $total_remit;
                        } else {
                            $total_remit = 0;
                            $not_remit = $air['reserv_air_total_deposit_price'];
                        }
                    }
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $air['reserv_type'] ?></td>
                        <td class="con"><?= $air['reserv_name'] ?></td>
                        <td class="con"><?= $air['reserv_air_departure_airline'] ?><br><?= $air['reserv_air_departure_company'] ?></td>
                        <td class="con"><?= $air['reserv_air_departure_area'] ?></td>
                        <td class="con"><?= substr($air['reserv_air_departure_date'], 0, 16) ?><br><?= substr($air['reserv_air_arrival_date'], 0, 16) ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_total_price']) ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_deposit_price']) ?></td>
                        <td class="con"><?= substr($air['reserv_air_deposit_date'],5,5)?></td>
                        <td class="con"><?= $state_deposit ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_balance_price']) ?></td>
                        <td class="con"><?= substr($air['reserv_air_balance_date'],5,5) ?></td>
                        <td class="con"><?= $state_balance ?></td>
                        <td class="con"><?=set_comma($not_remit)?></td>
                        <td class="con"><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$air['reserv_user_no']?>')"/></td>
                    </tr>
                    <?php
                    $total_air_price += $air['reserv_air_total_price'];
                    $total_air_deposit_price += $air['reserv_air_total_deposit_price'];
                    $deposit_air_price += $air['reserv_air_deposit_price'];
                    $balance_air_price += $air['reserv_air_balance_price'];
                    $total_air_not_remit += $not_remit;
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
                <td>총판매가 : <?=set_comma($total_air_price)?> | 총입금가  <?=set_comma($total_air_deposit_price)?> |  선금  <?=set_comma($deposit_air_price)?>  | 잔금  <?=set_comma($balance_air_price)?>  | 미송금액 <?=set_comma($total_air_not_remit)?> </td>
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