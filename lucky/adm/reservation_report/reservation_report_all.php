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
<style>
    td{text-align: center;}
</style>
<div class="reservation_list">
    <div>
        <div class="search_form">
            <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                <p><select name="search_date" >
                           <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
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
            $i=0;

                    $company_name = get_company($data['reserv_group_id']);
                    $indate = explode(" ",$data['indate']);


                    $air_list = $report->air_report();

                    $i=0;
                    if(is_array($air_list)) {
                        foreach ($air_list as $air) {
                            $res->res_no = $air['reserv_user_no'];
                            $reserv_list = $res->reservation_user();
                            ?>
                            <tr>
                                <td align="center"><?= $i + 1 ?></td>
                                <td><?= $reserv_list[0]['reserv_name'] ?></td>
                                <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                                <td><?= $air['reserv_air_departure_company'] ?><br><?= $air['reserv_air_arrival_company'] ?></td>
                                <td><?= $air['reserv_air_departure_airline'] ?><br><?= $air['reserv_air_arrival_airline'] ?></td>
                                <td><?= substr($air['reserv_air_departure_date'], 0, 16) ?><br><?= substr($air['reserv_air_arrival_date'], 0, 16) ?></td>
                                <td><?= $air['reserv_air_booking_date'] ?></td>
                                <td><?= $air['reserv_air_booking_number'] ?></td>
                                <td>미발송<br><input type="button" value="문자발송" onclick="air_sms_send('<?=$air['reserv_user_no']?>','<?=$air['air_no']?>');"></td>
                                <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$air['reserv_user_no']?>')"/></td>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>판매사</th>
                <th>렌트카</th>
                <th>출고일<br>반납일</th>
                <th>시간</th>
                <th>재확인</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php
                    $rent_list = $report->rent_report();
                    $i=0;
                    if(is_array($rent_list)) {
                        foreach ($rent_list as $rent) {
                            $res->res_no = $rent['reserv_user_no'];
                            $reserv_list = $res->reservation_user();
                            if ($rent['reserv_rent_reconfirm_state'] == "Y") {
                                $state = "확인완료";
                            } else {
                                $state = "미완료";
                            }
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $reserv_list[0]['reserv_name'] ?></td>
                                <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                                <td><?= $rent['reserv_rent_com_name'] ?></td>
                                <td><?= $rent['reserv_rent_car_name'] ?><br><?=$rent['reserv_rent_vehicle'] ?>대</td>
                                <td><?= substr($rent['reserv_rent_start_date'], 0, 16) ?><br><?= substr($rent['reserv_rent_end_date'], 0, 16) ?></td>
                                <td><?= $rent['reserv_rent_time'] ?>시간</td>
                                <td><?= $state ?></td>
                                <td>미발송<br><input type="button" value="문자발송"></td>
                                <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $rent['reserv_user_no'] ?>')"/></td>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>숙소</th>
                <th>객실명</th>
                <th>입실일(박수)</th>
                <th>객실수</th>
                <th>재확인</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php


            $lodging_list = $report->lodging_report();
            $i=0;
            if(is_array($lodging_list)) {
                foreach ($lodging_list as $lodging) {
                    $res->res_no = $lodging['reserv_user_no'];
                    $reserv_list = $res->reservation_user();
                    if ($lodging['reserv_lodging_reconfirm_state'] == "Y") {
                        $state = "확인완료";
                    } else {
                        $state = "미완료";
                    }
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                        <td><?= $lodging['reserv_tel_name'] ?></td>
                        <td><?= $lodging['reserv_tel_room_name'] ?></td>
                        <td><?=$lodging['reserv_tel_date']?>(<?=$lodging['reserv_tel_stay']?>박)</td>
                        <td><?= $lodging['reserv_tel_few'] ?>실</td>
                        <td><?= $state ?></td>
                        <td>미발송<br><input type="button" value="문자발송"></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $lodging['reserv_user_no'] ?>')"/></td>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>버스/택시</th>
                <th>이용일(일정)</th>
                <th>수배</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php


            $bus_list = $report->bus_report();
            $i=0;
            if(is_array($bus_list)) {
                foreach ($bus_list as $bus) {
                    $res->res_no = $bus['reserv_user_no'];
                    $reserv_list = $res->reservation_user();
                    if ($bus['reserv_bus_reconfirm_state'] == "Y") {
                        $state = "수배완료";
                    } else {
                        $state = "미완료";
                    }
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                        <td><?= $bus['reserv_bus_name'] ?></td>
                        <td><?= $bus['reserv_bus_date'] ?>(<?=$bus['reserv_bus_stay']?>일)</td>
                        <td><?= $state ?></td>
                        <td>미발송<br><input type="button" value="문자발송"></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $bus['reserv_user_no'] ?>')"/></td>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>패키지명</th>
                <th>이용일(인원)</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php


            $bustour_list = $report->bustour_report();
            $i=0;
            if(is_array($bustour_list)) {
                foreach ($bustour_list as $bustour) {
                    $res->res_no = $bustour['reserv_user_no'];
                    $reserv_list = $res->reservation_user();

                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                        <td><?= $bustour['reserv_bustour_name'] ?></td>
                        <td><?= $bustour['reserv_bustour_date'] ?>(<?=$bustour['reserv_bustour_number']?>명)</td>
                        <td>미발송<br><input type="button" value="문자발송"></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $bustour['reserv_user_no'] ?>')"/></td>
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
        <br>
        <br>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>전화번호</th>
                <th>골프장명</th>
                <th>홀명</th>
                <th>부킹일(시간)</th>
                <th>인원</th>
                <th>재확인</th>
                <th>문자발송</th>
                <th>예약대장</th>
            </tr>
            <?php
            $golf_list = $report->golf_report();
            $i=0;
            if(is_array($golf_list)) {
                foreach ($golf_list as $golf) {
                    $res->res_no = $golf['reserv_user_no'];
                    $reserv_list = $res->reservation_user();
                    if ($lodging['reserv_lodging_reconfirm_state'] == "Y") {
                        $state = "확인완료";
                    } else {
                        $state = "미완료";
                    }

                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $reserv_list[0]['reserv_phone'] ?></td>
                        <td><?= $golf['reserv_golf_name'] ?></td>
                        <td><?= $golf['reserv_golf_hole_name'] ?></td>
                        <td><?= $golf['reserv_golf_date'] ?>(<?=$golf['reserv_golf_time']?>~)</td>
                        <td><?= $golf['reserv_golf_adult_number'] ?></td>
                        <td><?= $state ?></td>
                        <td>미발송<br><input type="button" value="문자발송"></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $golf['reserv_user_no'] ?>')"/></td>
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