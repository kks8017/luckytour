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
$sql_rent = "select no,rent_car_name from rent_car_detail where rent_com_no='{$com_no[0]}'  order by no asc";
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
?>
<div class="reservation_list">
    <div>
        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table>
                <tr>
                    <td><select name="search_date" >
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
                        </select>

                        <input type="text" name="start_date" id="start_date" value="<?=$start_date_a?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date_a?>" class="air_date">
                        <select name="rent_no">
                            <option value="">렌트카를선택하세요</option>
                            <?php
                            foreach ($result_rent as $rent) {
                                ?>
                                <option value="<?=$rent['no']?>" <?if($rent_no==$rent['no']){?>selected<?}?>><?=$rent['rent_car_name']?></option>
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
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>

                <td>No.</td>
                <td>예약자</td>
                <td>전화번호</td>
                <td>판매사</td>
                <td>렌트카</td>
                <td>출고일<br>반납일</td>
                <td>시간</td>
                <td>재확인</td>
                <td>문자발송</td>
                <td>예약대장</td>
            </tr>
            <?php
            $indate = explode(" ",$data['indate']);

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
                        <td><input type="button" value="예약대장" onclick="ledger('<?= $rent['reserv_user_no'] ?>')"></td>
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