<?php
$start_date = $_REQUEST['start_date'];
if(!$start_date){
    $start_date = date("Y-m-d",time());
}
$end_date = $_REQUEST['end_date'];
if(!$end_date){
    $end_date = date("Y-m-d",time());
}
$reserv_name = $_REQUEST['reserv_name'];
$sch_sql = "";
if($start_date!=""){
    $sch_sql .= "where indate between '{$start_date}' and '{$end_date}'";
    $sch_sql .="and cash_name like '%{$reserv_name}%'";
}else if($start_date=="" and $reserv_name!=""){
    $sch_sql .="where cash_name like '%{$reserv_name}%'";

}

$sql = "select * from cash {$sch_sql} order by indate";
$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result[] = $row;
}
$res = new reservation();
?>
<div >
    <div class="inbody">
        <table class="conbox4">
            <tr>
                <td style="text-align: left;width: 200px;border-top: 0px;border-left: 0px;border-right: 0px;"><input type="button" id="up_btn" value="선택수정"><input type="button" id="del_btn" value="선택삭제"></td>
                <td style="border-top: 0px;border-left: 0px;border-right: 0px;">
                    <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
                        <p>
                            <input type="text" name="start_date" id="start_date" value="<?=$start_date?>" class="air_date"> ~ <input type="text" name="end_date" id="end_date" value="<?=$end_date?>" class="air_date">
                            <span>예약자명</span> <input type="text" name="reserv_name" value="<?=$reserv_name?>">
                            <input type="image" id="sch_btn" src="./image/search_btn2.png" style="cursor: pointer;vertical-align: middle" />
                        </p>
                    </form>
                </td>
            </tr>
        </table>
        <form id="cash_frm">
        <table class="conbox4">
            <tr>
                <td class="titbox"><input type="checkbox" id="allsel" ></td>
                <td class="titbox">신청일</td>
                <td class="titbox">예약자</td>
                <td class="titbox">발급번호</td>
                <td class="titbox">발급지</td>
                <td class="titbox">여행상품</td>
                <td class="titbox">발급상태</td>
                <td class="titbox">예약대장</td>
            </tr>
            <?php
            if(is_array($result)){
                $i =0;
                foreach ($result as $data){
                    $res->res_no = $data['reserv_no'];
                    $user = $res->reserve_view();
            ?>
            <tr>
                <td><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>" ><input type="hidden" name="no[]"  value="<?=$data['no']?>" ></td>
                <td><?=substr($data['indate'],0,10)?></td>
                <td><input type="text" name="name[]" value="<?=$data['cash_name']?>" size="15"></td>
                <td><input type="text" name="phone[]" value="<?=$data['cash_phone']?>" size="15"> </td>
                <td><input type="radio" name="use_<?=$i?>"  value="개인" <?if($data['cash_use']=="개인"){?>checked<?}?>>개인<input type="radio" name="use_<?=$i?>" value="사업자" <?if($data['cash_use']=="사업자"){?>checked<?}?>>사업자</td>
                <td><?=$user['reserv_type']?></td>
                <td><select name="state_<?=$i?>">
                        <option value="미발급"<?if($data['state']=="미발급"){?>selected<?}?>>미발급</option>
                        <option value="발급완료" <?if($data['state']=="발급완료"){?>selected<?}?>>발급완료</option>
                    </select>
                </td>
                <td><input type="button" value="예약대장" onclick="ledger(<?=$data['reserv_no']?>)"> </td>
            </tr>
            <?
                    $i++;
                }
            }
            ?>
        </table>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })

        $("#up_btn").click(function () {
            $("#case").val("update");
            var url = "cash_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#cash_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function(data)
                {
                     console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                 //   window.location.reload();
                }
            });

        });

        $("#del_btn").click(function () {
            var url = "cash_process.php"; // the script where you handle the form input.
            $("#case").val("delete");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#cash_frm").serialize() + "&case=delete", // serializes the form's elements.
                    success: function (data) {
                        // console.log(data); // show response from the php script.
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


    });
</script>