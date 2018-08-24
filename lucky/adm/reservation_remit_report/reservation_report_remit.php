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

if(!$search_date){$search_date="reserv_tour_start_date";}


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
                <th>항공사<br>판매사</th>
                <th>출발지</th>
                <th>출발일<br>리턴일</th>
                <th>입금상태</th>
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
                    $res->res_no = $air['reserv_user_no'];
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
                    if($deposit_state['reserv_deposit_state']=="Y"){
                        $dep_ok = "<span style='color: red'>입금완료</span>";
                    }else{
                        $dep_ok = "<span style='color: blue'>미입금</span>";
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
                        <td class="con"><?= $air['reserv_name'] ?><br><?= $air['reserv_type'] ?></td>
                        <td class="con"><?= $air['reserv_air_departure_airline'] ?><br><?= $air['reserv_air_departure_company'] ?></td>
                        <td class="con"><?= $air['reserv_air_departure_area'] ?></td>
                        <td class="con"><?= substr($air['reserv_air_departure_date'], 0, 16) ?><br><?= substr($air['reserv_air_arrival_date'], 0, 16) ?></td>
                        <td class="con"><?=$dep_ok?></td>
                        <td class="con"><?= set_comma($air['reserv_air_total_price']) ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_deposit_price']) ?></td>
                        <td class="con"><?= substr($air['reserv_air_deposit_date'],5,5)?></td>
                        <td class="con"><?= $state_deposit ?></td>
                        <td class="con"><?= set_comma($air['reserv_air_balance_price']) ?></td>
                        <td class="con"><?= substr($air['reserv_air_balance_date'],5,5) ?></td>
                        <td class="con"><?= $state_balance ?></td>
                        <td class="con"><?=set_comma($not_remit)?></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $air['reserv_user_no'] ?>')"></td>
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
                <td >총판매가 : <?=set_comma($total_air_price)?> | 총입금가  <?=set_comma($total_air_deposit_price)?> |  선금  <?=set_comma($deposit_air_price)?>  | 잔금  <?=set_comma($balance_air_price)?>  | 미송금액 <?=set_comma($total_air_not_remit)?> </td>
            </tr>
        </table>
        <br>
        <br>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>숙소<br>객실명</th>
                <th>입실일(박수)</th>
                <th>입금상태</th>
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


            $lodging_list = $report->lodging_report();
            $i=0;
            if(is_array($lodging_list)) {
                $total_lod_price =0;
                $total_lod_deposit_price =0;
                $deposit_lod_price = 0;
                $balance_lod_price = 0;
                $total_lod_not_remit = 0;
                foreach ($lodging_list as $lodging) {
                    $res->res_no = $lodging['reserv_user_no'];
                    $deposit_state = $res->reserve_amount();
                    if ($lodging['reserv_tel_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($lodging['reserv_tel_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    if($deposit_state['reserv_deposit_state']=="Y"){
                        $dep_ok = "<span style='color: red'>입금완료</span>";
                    }else{
                        $dep_ok = "<span style='color: blue'>미입금</span>";
                    }
                    $total_remit = 0;
                    if($deposit_state['reserv_deposit_state']=="Y") {
                        if ($lodging['reserv_tel_deposit_state'] == "Y") {
                            $total_remit = $lodging['reserv_tel_deposit_price'] + $lodging['reserv_tel_balance_price'];
                            $not_remit = $lodging['reserv_tel_total_dposit_price'] - $total_remit;
                        } else {
                            $not_remit = $lodging['reserv_tel_total_dposit_price'];
                        }
                    }

                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $lodging['reserv_name'] ?><br><?= $lodging['reserv_type'] ?></td>
                        <td class="con"><?= $lodging['reserv_tel_name'] ?><br><?= $lodging['reserv_tel_room_name'] ?></td>
                        <td class="con"><?=$lodging['reserv_tel_date']?>(<?=$lodging['reserv_tel_stay']?>박)</td>
                        <td class="con"><?=$dep_ok?></td>
                        <td class="con"><?= set_comma($lodging['reserv_tel_total_price']) ?></td>
                        <td class="con"><?= set_comma($lodging['reserv_tel_total_dposit_price']) ?></td>
                        <td class="con"><?= set_comma($lodging['reserv_tel_deposit_price']) ?></td>
                        <td class="con"><?=substr($lodging['reserv_tel_deposit_date'],5,5)?></td>
                        <td class="con"><?=$state_deposit?></td>
                        <td class="con"><?= set_comma($lodging['reserv_tel_balance_price']) ?></td>
                        <td class="con"><?=substr($lodging['reserv_tel_balance_date'],5,5)?></td>
                        <td class="con"><?=$state_balance?></td>
                        <td class="con"><span style="color: red;"> <?=set_comma($not_remit) ?></span></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $lodging['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_lod_price += $lodging['reserv_tel_total_price'];
                    $total_lod_deposit_price += $lodging['reserv_tel_total_dposit_price'];
                    $deposit_lod_price += $lodging['reserv_tel_deposit_price'];
                    $balance_lod_price += $lodging['reserv_tel_balance_price'];
                    $total_lod_not_remit += $not_remit;
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
                <td class="con">총판매가 : <?=set_comma($total_lod_price)?> | 총입금가  <?=set_comma($total_lod_deposit_price)?> |  선금  <?=set_comma($deposit_price)?>  | 잔금  <?=set_comma($balance_lod_price)?>  | 미송금액 <?=set_comma($total_lod_not_remit)?> </td>
            </tr>
        </table>
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>버스/택시</th>
                <th>이용일(일정)</th>
                <th>입금상태</th>
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


            $bus_list = $report->bus_report();
            $i=0;
            if(is_array($bus_list)) {
                $total_bus_price =0;
                $total_bus_deposit_price =0;
                $deposit_bus_price = 0;
                $balance_bus_price = 0;
                $total_bus_not_remit = 0;
                foreach ($bus_list as $bus) {
                    $res->res_no = $bus['reserv_user_no'];
                    $deposit_state = $res->reserve_amount();
                    if ($bus['reserv_bus_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($bus['reserv_bus_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    if($deposit_state['reserv_deposit_state']=="Y"){
                        $dep_ok = "<span style='color: red'>입금완료</span>";
                    }else{
                        $dep_ok = "<span style='color: blue'>미입금</span>";
                    }
                    $total_remit = 0;
                    if($deposit_state['reserv_deposit_state']=="Y") {
                        if ($bus['reserv_bus_deposit_state'] == "Y") {
                            $total_remit = $bus['reserv_bus_deposit_price'] + $bus['reserv_bus_balance_price'];
                            $not_remit = $bus['reserv_bus_total_deposit_price'] - $total_remit;
                        } else {

                            $not_remit = $bus['reserv_bus_total_deposit_price'];
                        }
                    }
                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $bus['reserv_name'] ?><br><?= $bus['reserv_type'] ?></td>

                        <td class="con"><?= $bus['reserv_bus_name'] ?></td>
                        <td class="con"><?= $bus['reserv_bus_date'] ?>(<?=$bus['reserv_bus_stay']?>일)</td>
                        <td class="con"><?=$dep_ok?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_total_price']) ?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_deposit_price']) ?></td>
                        <td class="con"><?= substr($bus['reserv_bus_deposit_date'],5,5) ?></td>
                        <td class="con"><?=$state_deposit?></td>
                        <td class="con"><?= set_comma($bus['reserv_bus_balance_price']) ?></td>
                        <td class="con"><?= substr($bus['reserv_bus_balance_date'],5,5) ?></td>
                        <td class="con"><?=$state_balance?></td>
                        <td class="con"><span style="color: red;"><?= set_comma($not_remit) ?></span></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $bus['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_bus_price += $bus['reserv_bus_total_price'];
                    $total_bus_deposit_price += $bus['reserv_bus_total_deposit_price'];
                    $deposit_bus_price += $bus['reserv_bus_deposit_price'];
                    $balance_bus_price += $bus['reserv_bus_balance_price'];
                    $total_bus_not_remit += $not_remit;
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
                <td class="con">총판매가 : <?=set_comma($total_bus_price)?> | 총입금가  <?=set_comma($total_bus_deposit_price)?> |  선금  <?=set_comma($deposit_bus_price)?>  | 잔금  <?=set_comma($balance_bus_price)?>  | 미송금액 <?=set_comma($total_bus_not_remit)?> </td>
            </tr>
        </table>
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>패키지명</th>
                <th>이용일(인원)</th>
                <th>입금상태</th>
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
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($bustour['reserv_bustour_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
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
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $bustour['reserv_name'] ?></td>
                        <td class="con"><?= $bustour['reserv_type'] ?></td>
                        <td class="con"><?= $bustour['reserv_bustour_name'] ?></td>
                        <td class="con"><?= $bustour['reserv_bustour_date'] ?>(<?=$bustour['reserv_bustour_number']?>명)</td>
                        <td class="con"><?= set_comma($bustour['reserv_bustour_total_price']) ?></td>
                        <td class="con"><?= set_comma($bustour['reserv_bustour_total_deposit_price']) ?></td>
                        <td class="con"><?= set_comma($bustour['reserv_bustour_deposit_price']) ?></td>
                        <td class="con"><?= substr($bustour['reserv_bustour_deposit_date'],5,5) ?></td>
                        <td class="con"><?=$state_deposit?></td>
                        <td class="con"><?= set_comma($bustour['reserv_bustour_balance_price']) ?></td>
                        <td class="con"><?= substr($bustour['reserv_bustour_balance_date'],5,5) ?></td>
                        <td class="con"><?=$state_balance?></td>
                        <td class="con"><?= set_comma($not_remit) ?></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $bustour['reserv_user_no'] ?>')"></td>
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
                    <td colspan="16" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
                <?
            }
            ?>
        </table>
        <br>
        <table class="tbl_total">
            <tr>
                <td class="con">총판매가 : <?=set_comma($total_bustour_price)?> | 총입금가  <?=set_comma($total_bustour_deposit_price)?> |  선금  <?=set_comma($deposit_bustour_price)?>  | 잔금  <?=set_comma($balance_bustour_price)?>  | 미송금액 <?=set_comma($total_bustour_not_remit)?> </td>
            </tr>
        </table>
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>골프장명(홀명)</th>
                <th>부킹일(시간)</th>
                <th>입금상태</th>
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
            $golf_list = $report->golf_report();
            $i=0;
            if(is_array($golf_list)) {
                $total_golf_price =0;
                $total_golf_deposit_price =0;
                $deposit_golf_price = 0;
                $balance_golf_price = 0;
                $total_golf_not_remit = 0;
                foreach ($golf_list as $golf) {
                    if ($golf['reserv_golf_deposit_state'] == "Y") {
                        $state_deposit = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_deposit = "<span style='color: blue'>미입금</span>";
                    }
                    if ($golf['reserv_golf_balance_state'] == "Y") {
                        $state_balance = "<span style='color: red'>입금완료</span>";
                    } else {
                        $state_balance = "<span style='color: blue'>미입금</span>";
                    }
                    $total_remit = 0;
                    if($golf['reserv_golf_deposit_state']=="Y") {
                        $total_remit = $golf['reserv_golf_deposit_price'] + $bustour['reserv_golf_balance_price'];

                        $not_remit = $golf['reserv_golf_total_dposit_price'] - $total_remit;
                        // echo  $golf['reserv_golf_total_dposit_price'];
                    }else{

                        $not_remit = 0;
                    }

                    ?>
                    <tr>
                        <td class="con"><?= $i + 1 ?></td>
                        <td class="con"><?= $golf['reserv_name'] ?></td>
                        <td class="con"><?= $golf['reserv_type'] ?></td>
                        <td class="con"><?= $golf['reserv_golf_name'] ?>(<?= $golf['reserv_golf_hole_name'] ?>)</td>
                        <td class="con"><?= $golf['reserv_golf_date'] ?>(<?=$golf['reserv_golf_time']?>~)</td>
                        <td class="con"><?= set_comma($golf['reserv_golf_total_price']) ?></td>
                        <td class="con"><?= set_comma($golf['reserv_golf_total_dposit_price']) ?></td>
                        <td class="con"><?= set_comma($golf['reserv_golf_deposit_price']) ?></td>
                        <td class="con"><?= substr($golf['reserv_golf_date'],5,5) ?></td>
                        <td class="con"><?= $state_deposit ?></td>
                        <td class="con"><?= set_comma($golf['reserv_golf_balance_price']) ?></td>
                        <td class="con"><?= substr($golf['reserv_golf_balance_date'],5,5) ?></td>
                        <td class="con"><?=$state_balance?></td>
                        <td class="con"><?=set_comma($not_remit)?></td>
                        <td class="con"><input type="button" value="예약대장" onclick="ledger('<?= $golf['reserv_user_no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_golf_price += $golf['reserv_golf_total_price'];
                    $total_golf_deposit_price += $golf['reserv_golf_total_dposit_price'];
                    $deposit_price += $golf['reserv_golf_deposit_price'];
                    $balance_golf_price += $golf['reserv_golf_balance_price'];
                    $total_golf_not_remit += $not_remit;
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
                <td >총판매가 : <?=set_comma($total_golf_price)?> | 총입금가  <?=set_comma($total_golf_deposit_price)?> |  선금  <?=set_comma($deposit_price)?>  | 잔금  <?=set_comma($balance_golf_price)?>  | 미송금액 <?=set_comma($total_golf_not_remit)?> </td>
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