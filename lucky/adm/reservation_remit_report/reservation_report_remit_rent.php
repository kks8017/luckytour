<?php
$res = new reservation();
$report  = new report();
$car = new rent();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
if(!$_REQUEST['start_date']){$start_date_a = date("Y-m-d",time()); }else{$start_date_a = $_REQUEST['start_date'];}
if(!$_REQUEST['end_date']){$end_date_a = date("Y-m-d",time()); }else{$end_date_a = $_REQUEST['end_date'];}
$start_date = $start_date_a." 00:00:00";
$end_date = $end_date_a." 23:59:00";
$search_date = $_REQUEST['search_date'];
$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];
$rent_company = $_REQUEST['rent_company'];
$rent_no = $_REQUEST['rent_no'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
$sql_company = "select no,rent_com_name from rent_company  order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company;
}

$com_no =get_rentcar_company("","대표");
$sql_rent = "select no,rent_car_name,rent_car_fuel from rent_car_detail where rent_com_no='{$com_no[0]}'  order by no asc";
$rs_rent  = $db->sql_query($sql_rent);
while($row_rent = $db->fetch_array($rs_rent)) {
    $result_rent[] = $row_rent;
}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->staff = $staff;
$report->company = $rent_company;
$report->rent_no = $rent_no;
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
                        <select name="rent_no">
                            <option value="">렌트카를선택하세요</option>
                            <?php
                            foreach ($result_rent as $rent) {
                                $rent_fuel = $car->rent_code_name($rent['rent_car_fuel']);
                                ?>
                                <option value="<?=$rent['no']?>" <?if($rent_no==$rent['no']){?>selected<?}?>><?=$rent['rent_car_name']?>(<?=$rent_fuel?>)</option>
                                <?
                            }
                            ?>
                        </select>
                        <select name="rent_company">
                            <option value="">업체를선택하세요</option>
                            <?php
                            foreach ($result_company as $company) {
                                ?>
                                <option value="<?=$company['no']?>" <?if($rent_company==$company['no']){?>selected<?}?>><?=$company['rent_com_name']?></option>
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
                <th>예약자<br>상품타입</th>
                <th>렌트카<br>판매사</th>
                <th>출고일<br>반납일</th>
                <th>입금상태</th>
                <th>판매가</th>
                <th>입금가</th>
                <th>선금</th>
                <th>송금일</th>
                <th>상태</th>
                <th>잔금</th>
                <th>송금일</th>
                <th>잔금일</th>
                <th>미송금액</th>
                <th>예약대장</th>
            </tr>
            <?php
            $rent_list = $report->rent_report();
            $i=0;
            if(is_array($rent_list)) {
                $total_rent_price =0;
                $total_rent_deposit_price =0;
                $deposit_rent_price = 0;
                $balance_rent_price = 0;
                $total_rent_not_remit = 0;
                foreach ($rent_list as $rent) {
                    $res->res_no = $rent['reserv_user_no'];
                    $deposit_state = $res->reserve_amount();
                    if ($rent['reserv_rent_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($rent['reserv_rent_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    $total_remit = 0;
                    if($deposit_state['reserv_deposit_state']=="Y"){
                        $dep_ok = "<span style='color: red'>입금완료</span>";
                    }else{
                        $dep_ok = "<span style='color: blue'>미입금</span>";
                    }
                    if($deposit_state['reserv_deposit_state']=="Y") {
                        if ($rent['reserv_rent_deposit_state'] == "Y") {
                            $total_remit = $rent['reserv_rent_deposit_price'] + $rent['reserv_rent_balance_price'];
                            $not_remit = $rent['reserv_rent_total_deposit_price'] - $total_remit;
                        } else {

                            $not_remit = $rent['reserv_rent_total_deposit_price'];
                        }
                    }
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $rent['reserv_name'] ?><br><?= $rent['reserv_type'] ?></td>
                        <td class="con"><?= $rent['reserv_rent_car_name'] ?><br><?= $rent['reserv_rent_com_name'] ?></td>
                        <td class="con"><?= substr($rent['reserv_rent_start_date'], 0, 16) ?><br><?= substr($rent['reserv_rent_end_date'], 0, 16) ?></td>
                        <td class="con"><?=$dep_ok?></td>
                        <td class="con"><?= set_comma($rent['reserv_rent_total_price']) ?></td>
                        <td class="con"><?= set_comma($rent['reserv_rent_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($rent['reserv_rent_deposit_price']) ?></td>
                        <td class="con"><?= substr($rent['reserv_rent_deposit_date'],5,5) ?></td>
                        <td class="con"><?= $state_deposit ?></td>
                        <td class="con"><?= set_comma($rent['reserv_rent_balance_price']) ?></td>
                        <td class="con"><?= substr($rent['reserv_rent_deposit_date'],5,5) ?></td>
                        <td class="con"><?= $state_balance ?></td>
                        <td class="con"><?= set_comma($not_remit) ?></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $rent['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_rent_price += $rent['reserv_rent_total_price'];
                    $total_rent_deposit_price += $rent['reserv_rent_total_deposit_price'];
                    $deposit_rent_price += $rent['reserv_rent_deposit_price'];
                    $balance_rent_price += $rent['reserv_rent_balance_price'];
                    $total_rent_not_remit += $not_remit;
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
                <td class="con">총판매가 : <?=set_comma($total_rent_price)?> | 총입금가  <?=set_comma($total_rent_deposit_price)?> |  선금  <?=set_comma($deposit_rent_price)?>  | 잔금  <?=set_comma($balance_rent_price)?>  | 미송금액 <?=set_comma($total_rent_not_remit)?> </td>
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