<?php
$res = new reservation();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];


$start_date = $_REQUEST['start_date']." 00:00:00";
if($_REQUEST['start_date']!=""){$start_date=$start_date; }else{$start_date="";}
$end_date = $_REQUEST['end_date']." 23:59:00";
if($_REQUEST['end_date']!=""){$end_date=$end_date; }else{$end_date="";}
$search_date = $_REQUEST['search_date'];
$state = $_REQUEST['state'];
if(!$search_date){$search_date="indate";}
$sch_sql .= "";

if($_REQUEST['start_date']!=""){
    $sch_sql .= "and {$search_date} between '{$start_date}' and '{$end_date}'";
}

if($reserv_name!=""){
   $sch_sql .= " and (reserv_name like '%{$reserv_name}%' or  reserv_real_name like '%{$reserv_name}%' or reserv_adult_list like '%{$reserv_name}%' or reserv_child_list like '%{$reserv_name}%' or reserv_phone like '%{$reserv_name}%' or reserv_real_phone like '%{$reserv_name}%')";
}

if($state!=""){
    $sch_sql .= "and reserv_state='{$state}'";
}

$page_set = 15; // 한페이지 줄수
$block_set = 10; // 한페이지 블럭수

$sql_cnt = "select count(no) as total from reservation_user_content where  reserv_del_mark!='Y'  {$sch_sql} order by {$search_date} desc";
//echo $sql_cnt;
$rs_cnt  = $db->sql_query($sql_cnt);
$row_cnt = $db->fetch_array($rs_cnt);

$total = $row_cnt['total']; // 전체글수

$total_page = ceil ($total / $page_set); // 총페이지수(올림함수)
$total_block = ceil ($total_page / $block_set); // 총블럭수(올림함수)

if (!$page_no) $page_no = 1; // 현재페이지(넘어온값)

$block = ceil ($page_no / $block_set); // 현재블럭(올림함수)

$limit_idx = ($page_no - 1) * $page_set; // limit시작위치

$sql = "select no,reserv_name,reserv_phone,reserv_group_id,reserv_tour_start_date,reserv_tour_end_date,reserv_type,reserv_person,reserv_state,reserv_incom_type,reserv_ledger,indate from reservation_user_content where reserv_del_mark!='Y' {$sch_sql} 
        order by {$search_date} desc limit {$limit_idx},{$page_set}";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$search_url = "";
if($reserv_name!="" ) {
    $search_url .= "&reserv_name=" . $reserv_name ;
}else if($start_date!=""){
    $search_url .= "&start_date=" . $start_date. "&end_date=" . $end_date;
}

if($_SESSION["member_id"]!="") {
    $adm_url = "linkpage={$linkpage}&subpage={$subpage}";
}else{
    $adm_url = "";
}


$res->basic_url = $basic_url;
$res->sch_url = $search_url;
$res->adm_url = $adm_url;


?>
<div class="reservation_list">
    <div>

            <div class="search_form">
                <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                    <p><select name="search_date" >
                            <option value="indate" <?if($search_date=="indate"){?>selected<?}?>>접수일</option>
                            <option value="reserv_tour_start_date" <?if($search_date=="reserv_tour_start_date"){?>selected<?}?>>여행일</option>
                        </select>
                        <input type="text" name="start_date" id="start_date" value="<?=$_REQUEST['start_date']?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$_REQUEST['end_date']?>" class="air_date">
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
                        </select> <span>예약자명</span> <input type="text" name="reserv_name" value="<?=$reserv_name?>">
                        <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;" />
                    </p>
                </form>
            </div>
        <p class="del_btn"><img src="./image/sel_del.gif"  id="list_btn" style="cursor: pointer;" /></p>

        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>접수일</th>
                <th>이름</th>
                <th>전화번호</th>
                <th>여행일정<br>상품코드</th>
                <th>접수방법</th>
                <th>상태</th>
                <th>담당자</th>
                <th>예약장부</th>
            </tr>
            <form id="list_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
                $company_name = get_company($data['reserv_group_id']);
                $indate = explode(" ",$data['indate']);
                $res->res_no = $data['no'];
                $state = $res->reserv_state();
            ?>
            <tr>
                <td class="con"><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"</td>
                <td class="con"><a href="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>&reserv_name=<?=$data['reserv_name']?>"><?=$indate[0]?><span> (<?=substr($indate[1],0,5)?>)</span></a></td>
                <?if($data['reserv_incom_type']!="MANAGER"){?>
                    <td class="con"><a href="?linkpage=res_basic&reserv_user_no=<?=$data['no']?>"><?=$data['reserv_name']?></a></td>
                <?}else{?>
                    <td class="con"><?=$data['reserv_name']?></td>
                <?}?>
                <td class="con"><?=$data['reserv_phone']?></td>
                <td class="con"><?=$data['reserv_tour_start_date']?> ~ <?=$data['reserv_tour_end_date']?><br><?=$data['reserv_type']?></td>
                <td class="con"><?=$data['reserv_incom_type']?></td>
                <td class="con"><?=$state?></td>
                <td class="con"><?=$data['reserv_person']?></td>
                <td class="con"><?if($data['reserv_ledger']=="Y"){?><img style="cursor: pointer;" src="./image/reserve_info_btn.png"  onclick="ledger('<?=$data['no']?>')"/><?}else{?><?}?></td>
            </tr>
          <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <th colspan="9" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
                <input type="hidden" name="case" value="list_delete">
            </form>
        </table>
        <div class="paging">
                    <?php
                    $res->page = $page_no;
                    $res->block = $block;
                    $res->block_set = $block_set;
                    $res->total_block = $total_block;
                    $res->total_page =  $total_page;

                    $res->pageing();
                    ?>
        </div>
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