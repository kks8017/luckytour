<?php
$res = new reservation();
$report  = new report();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
if(!$_REQUEST['start_date']){$start_date_a = date("Y-m-d",time()); }else{$start_date_a = $_REQUEST['start_date'];}
if(!$_REQUEST['end_date']){$end_date_a = date("Y-m-d",time()); }else{$end_date_a = $_REQUEST['end_date'];}
$start_date = $start_date_a;
$end_date = $end_date_a;
$search_date = $_REQUEST['search_date'];
$refund_type = $_REQUEST['refund'];

$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];
$deposit_state_schedule = $_REQUEST['deposit_state_schedule'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
if(!$search_date){$search_date="reserv_etc_date";}

$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->search_date = $search_date;
$report->refund = $refund_type;


?>
<div class="reservation_report">
    <div>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table class="search_frm">
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_etc_date" <?if($search_date=="reserv_etc_date"){?>selected<?}?>>환불일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>출발일</option>
                        </select>
                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="refund" >
                            <option value="">전체</option>
                            <option value="part" <?if($refund_type=="part"){?>selected<?}?>>부분환불</option>
                            <option value="all" <?if($refund_type=="all"){?>selected<?}?>>전체환불</option>
                        </select>
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>
                <td>접수일</td>
                <td>상품타입</td>
                <td>예약자</td>
                <td>연락처</td>
                <td>환불명</td>
                <td>환불일</td>
                <td>환불금액</td>
                <td>환불상태</td>
                <td>예약대장</td>
            </tr>
            <?

            $reservation_refund = $report->reservation_refund_report();
            if(is_array($reservation_refund)) {
                foreach ($reservation_refund as $refund) {
                    if($refund['reserv_etc_state']=="Y"){
                        $refund_state = "환불완료";
                    }else{
                        $refund_state = "환불미완료";
                    }

                    ?>
                    <tr>
                        <td><?=$refund['indate']?></td>
                        <td><?=$refund['reserv_type']?></td>
                        <td><?=$refund['reserv_name']?></td>
                        <td><?=$refund['reserv_phone']?></td>
                        <td><?=$refund['reserv_etc_depositor']?></td>
                        <td><?=$refund['reserv_etc_date']?></td>
                        <td><?=set_comma($refund['reserv_etc_price'])?></td>
                        <td><?=$refund_state?></td>
                        <td><input type="button" value="예약대장" onclick="ledger('<?= $refund['user_no'] ?>')"></td>
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