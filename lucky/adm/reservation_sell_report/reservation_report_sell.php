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
if(!$search_date){$search_date="reserv_ok_date";}



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
$all_deposit = $report->reserv_deposit_price();
$all_total = $report->reservation_state_total();
$all_total_deposit = $report->reserv_deposit_total_price();

$profit = $report->reservation_profit();
?>

<div class="reservation_report">
    <div >
        <div class="inbody">
            <table class="conbox3">
                <tr>
                    <td colspan="3">
                        <span style='padding:5px;background-color:#0054FF;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>접수</span>&nbsp; :&nbsp;<?=$all_state['cnt_wt']?>건&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#53C14B;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>보류</span>&nbsp; :&nbsp;<?=$all_state['cnt_bl']?>건&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#FF3636;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>완료</span>&nbsp; :&nbsp;<?=$all_state['cnt_ok']?>건&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#BDBDBD;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>취소</span>&nbsp; :&nbsp;<?=$all_state['cnt_cl']?>건&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#6324BD;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>결항</span>&nbsp; :&nbsp;<?=$all_state['cnt_bl']?>건&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#484848;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>부재</span>&nbsp; :&nbsp;<?=$all_state['cnt_bj']?>건&nbsp;&nbsp;
                        <span style='padding:5px;background-color:#FFB85A;width:60px;height:35px;font-size: 12px;color:#fff;font-weight:bold;vertical-align: middle;'>대기</span>&nbsp; :&nbsp;<?=$all_state['cnt_bw']?>건</td>

                </tr>
                <tr>
                    <td > 총판매액 : <span class="price"><?=set_comma($all_total['total_sum'])?></span>원</td>
                    <td >총입금액 : <span class="price"><?=set_comma($all_total_deposit[0])?></span>원</td>
                    <td >총수익 : <span class="price"><?=set_comma($profit)?></span>원</td>
                </tr>
            </table>
        </div>

            <div class="search_form">
                <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                    <p><select name="search_date" >
                            <option value="reserv_ok_date" <?if($search_date=="reserv_ok_date"){?>selected<?}?>>확정일</option>
                            <option value="indate" <?if($search_date=="indate"){?>selected<?}?>>접수일</option>
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>출발일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>리턴일</option>
                           
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
                            <option value="BC" <?if($state=="BC"){?>selected<?}?>>블럭</option>
                            <option value="BW" <?if($state=="BW"){?>selected<?}?>>입금대기</option>
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
            <p class="del_btn"></p>
        <table class="tbl_buy">
            <tr>

                <th >No.</th>
                <th >접수일</th>
                <th >상품타입</th>
                <th >예약자</th>
                <th >여행일정</th>
                <th >판매액</th>
                <th >담당자</th>
                <th >예약상태</th>
                <th >수익</th>
                <th >예약대장</th>
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

                    if($reservation['reserv_state']=="OK"){
                        $profit = $reservation['reserv_total_price'] - $deposit_price;
                    }else{
                        $profit = 0;
                    }


                    $report->reserv_price_state = "reserv_deposit_state";
                    $deposit_state = $report->reservation_sell_state();
                    $report->reserv_price_state = "reserv_payment_state";
                    $payment_state = $report->reservation_sell_state();
                    $report->reserv_price_state = "reserv_balance_state";
                    $balance_state = $report->reservation_sell_state();
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= substr($reservation['indate'], 0, 16) ?></td>
                        <td class="con"><?= $reservation['reserv_type'] ?></td>
                        <td class="con"><?= $reservation['reserv_name'] ?></td>
                        <td class="con"><?= $reservation['reserv_tour_start_date'] ?> ~ <?= $reservation['reserv_tour_end_date'] ?></td>
                        <td>총금액 : <span class="price"> <?=set_comma($reservation['reserv_total_price'])?>원</span> </br></br>
                            예약금 : <span class="price"><?=set_comma($reservation['reserv_deposit_price'])?></span>원 (<span class="date"><?=substr($reservation['reserv_deposit_date'],5,8)?></span>)  <?=$deposit_state?></br></br>
                            잔  &nbsp;&nbsp;금 :  <span class="price"><?=set_comma($reservation['reserv_balance_price'])?></span>원 (<span class="date"><?=substr($reservation['reserv_balance_date'],5,8)?></span>)<?=$balance_state?>
                        </td>
                        <td class="con"><?= $reservation['reserv_person'] ?></td>
                        <td class="con"><?=$state?></td>
                        <td class="con"><span class="price"><?=set_comma($profit)?></span>원</td>
                        <td class="con"><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$reservation['no']?>')"/></td>
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

</script>