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
$lodging_no = $_REQUEST['lodging_no'];
$reserv_block = $_REQUEST['reserv_block'];



$sql_lodging = "select no,lodging_name from lodging_list  order by no asc";
$rs_lodging  = $db->sql_query($sql_lodging);
while($row_lodging = $db->fetch_array($rs_lodging)) {
    $result_lodging[] = $row_lodging;
}


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
$report->lod_no = $lodging_no;
$report->lod_block = $reserv_block;
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
                    <select name="lodging_no">
                        <option value="">숙소를선택하세요</option>
                        <?php
                        foreach ($result_lodging as $lodging) {
                            ?>
                            <option value="<?=$lodging['no']?>" <?if($lodging_no==$lodging['no']){?>selected<?}?>><?=$lodging['lodging_name']?></option>
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
                    <select name="reserv_block">
                        <option value="" <?if($reserv_block==""){?>selected<?}?>>선택하세요</option>
                        <option value="block" <?if($reserv_block=="block"){?>selected<?}?>>블럭</option>
                        <option value="wait" <?if($reserv_block=="wait"){?>selected<?}?>>수배</option>
                    </select>
                    <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;vertical-align: middle;" />
                </p>
            </form>
        </div>
        <table class="tbl">
            <tr>

                <th>No.</th>
                <th>예약자</th>
                <th>숙소</th>
                <th>객실명</th>
                <th>입실일(박수)</th>
                <th>객실수</th>
                <th>담당자</th>
                <th>예약대장</th>
            </tr>
            <?php
            $lodging_list = $report->lodging_block_list();
            $i=0;
            if(is_array($lodging_list)) {
                foreach ($lodging_list as $lodging) {
                    $res->res_no = $lodging['reserv_user_no'];
                    $reserv_list = $res->reservation_user();

                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $reserv_list[0]['reserv_name'] ?></td>
                        <td><?= $lodging['reserv_tel_name'] ?></td>
                        <td><?= $lodging['reserv_tel_room_name'] ?></td>
                        <td><?=$lodging['reserv_tel_date']?>(<?=$lodging['reserv_tel_stay']?>박)</td>
                        <td><?= $lodging['reserv_tel_few'] ?>실</td>
                        <td><?= $reserv_list[0]['reserv_person'] ?></td>
                        <td><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?= $lodging['reserv_user_no'] ?>')"/></td>
                    </tr>
                    <?php
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <td colspan="9" align="center"><p>등록된 정보가 없습니다.</p></td>
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