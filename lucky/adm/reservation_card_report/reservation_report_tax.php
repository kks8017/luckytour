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

$state = $_REQUEST['state'];
$reserv_staff = $_REQUEST['reserv_staff'];
$deposit_state_schedule = $_REQUEST['deposit_state_schedule'];




$sql_staff = "select no,ad_name from ad_member order by no";
$rs_staff    = $db->sql_query($sql_staff);
while ($row_staff = $db->fetch_array($rs_staff)){
    $result_staff[] = $row_staff;
}
if(!$search_date){$search_date="reserv_equip_date";}
$res->staff_no = $reserv_staff;
$staff = $res->staff_name();
$report->start_date = $start_date;
$report->end_date = $end_date;
$report->search_date = $search_date;
$report->reserv_state = "OK";

?>
<div class="reservation_report">
    <div>
        <div class="search_form">
            <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                <p><select name="search_date" >
                            <option value="reserv_equip_date" <?if($search_date=="reserv_equip_date"){?>selected<?}?>>발행일</option>
                            <option value="reserv_tour_end_date" <?if($search_date=="reserv_tour_end_date"){?>selected<?}?>>출발일</option>
                        </select>
                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <input type="button" id="sch_btn" value="검색">
                </p>
            </form>
        </div>
        <table class="tbl_buy">
            <tr>
                <th>접수일</th>
                <th>상품타입</th>
                <th>예약자</th>
                <th>연락처</th>
                <th>발행명</th>
                <th>발행일</th>
                <th>발행금액</th>
                <th>발행상태</th>
                <th>예약대장</th>
            </tr>
            <?
            $reservation_tax = $report->reservation_tax();
            if(is_array($reservation_tax)) {
            foreach ($reservation_tax as $tax) {
                if($tax['reserv_equip_state']=="Y"){
                    $tax_state = "<span style='color: red'>발행완료</span>";
                }else{
                    $tax_state = "<span style='color: blue'>미발행</span>";
                }

            ?>
            <tr>
                <td><?=substr($tax['indate'],0,16)?></td>
                <td><?=$tax['reserv_type']?></td>
                <td><?=$tax['reserv_name']?></td>
                <td><?=$tax['reserv_phone']?></td>
                <td><?=$tax['reserv_equip_content']?></td>
                <td><?=$tax['reserv_equip_date']?></td>
                <td><?=set_comma($tax['reserv_equip_total_price'])?></td>
                <td><?=$tax_state?></td>
                <td><input type="button" value="예약대장" onclick="ledger('<?= $tax['user_no'] ?>')"></td>
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
    $(document).ready(function () {
            $("#sch_btn").click(function () {
            $("#sch_frm").submit();
        });
    });

</script>