<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_golf where reserv_user_no='{$reserv_user_no}' and reserv_del_mark!='Y'  order by no";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}


?>
    <script>
        function golf_sum(i) {
            var sum1 = get_comma($("#reserv_golf_deposit_price_"+i).val());
            var sum2 = $("#reserv_golf_total_price_"+i).val();

            var total = Number(sum2) - Number(sum1);
            $("#reserv_golf_balance_price_"+i).val(set_comma(total))
        }
    </script>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $start_date = $data['reserv_golf_date'];
        $end_date = date("Y-m-d",strtotime($start_date."+{$data['reserv_golf_stay']} days"));
        $golf->golf_no = $data['reserv_golf_golf_no'];
        ?>
        <script>
            $( function() {
                $( ".air_date" ).datepicker({
                    prevText: '이전 달',
                    nextText: '다음 달',
                    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                    dayNames: ['일','월','화','수','목','금','토'],
                    dayNamesShort: ['일','월','화','수','목','금','토'],
                    dayNamesMin: ['일','월','화','수','목','금','토'],
                    numberOfMonths: 2,
                    dateFormat : "yy-mm-dd",
                });
                $('.NumbersOnly').keyup(function () {
                    if( $(this).val() != null && $(this).val() != '' ) {
                        var tmps = parseInt($(this).val().replace(/[^0-9]/g, '')) || 0;
                        var tmps2 = tmps.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        $(this).val(tmps2);
                    }
                });
            });
        </script>
        <header><p>골프정보 <img type="button" style="cursor: pointer;" src="../image/golf_mod_btn.gif" onclick="golf_update('<?=$data['no']?>')" /> <img type="button" style="cursor: pointer;" src="../image/upd_btn.png" onclick="golf_ledger_update('<?=$i?>')" /></p>
        </header>
        <table style="width: 100%">
            <tr>
                <th >골프장명(홀명)</th>
                <td ><span class="name"><?=$data['reserv_golf_name']?></span>(<span class="name"><?=$data['reserv_golf_hole_name']?></span>)   <input type="hidden" name="reserv_golf_no[]" value="<?=$data['no']?>"></td>
                <th >인원수</th>
                <td ><?=$data['reserv_golf_adult_number']?>명</td>
            </tr>
            <tr>
                <th >부킹일</th>
                <td ><span class="date"><?=$start_date?></span> (<?=$data['reserv_golf_stay']?>일)</td>
                <th >부킹시간</th>
                <td ><span class="time"><?=$data['reserv_golf_time']?></span></td>
            </tr>
            <tr>
                <th >선금입금</th>
                <td ><input type="text" name="reserv_golf_deposit_price[]" size="15" onkeyup="golf_sum(<?=$i?>)" id="reserv_golf_deposit_price_<?=$i?>" class="NumbersOnly" value="<?=set_comma($data['reserv_golf_deposit_price'])?>"></td>
                <th >선금입금일</th>
                <td ><input type="text" name="reserv_golf_deposit_date[]" size="15" value="<?=$data['reserv_golf_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_golf_deposit_state_<?=$i?>" value="Y" <?if($data['reserv_golf_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <th >잔금입금</th>
                <td ><input type="text" name="reserv_golf_balance_price[]" id="reserv_golf_balance_price_<?=$i?>" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_golf_balance_price'])?>"></td>
                <th >잔금입금일</th>
                <td ><input type="text" name="reserv_golf_balance_date[]" size="15" value="<?=$data['reserv_golf_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_golf_balance_state_<?=$i?>" value="Y" <?if($data['reserv_golf_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <input type="hidden" id="reserv_golf_total_price_<?=$i?>"  value="<?=$data['reserv_golf_total_dposit_price']?>">
            <?php
            $profit = $data['reserv_golf_total_price'] - $data['reserv_golf_total_dposit_price'];
            ?>

        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;" >
            <tr>
                <td >판매액 : <span class="price"><?=set_comma($data['reserv_golf_total_price'])?>원</span></td>
                <td >입금액&nbsp;: <span class="price"><?=set_comma($data['reserv_golf_total_dposit_price'])?>원</span></td>
                <td >수익&nbsp;: <span class="profit"><?=set_comma($profit)?>원</span></td>
            </tr>
        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;margin-top: 5px;border: 1px solid #aaa;">
            <tr>
                <th >예약재확인  </th>
                <td  colspan="3"> 확인일  <input type="text" name="reserv_golf_reconfirm_date[]" class="air_date" value="<?=$data['reserv_golf_reconfirm_date']?>" size="10">  &nbsp;&nbsp;&nbsp;&nbsp;확인담당자 : <input type="text" name="reserv_golf_reconfirm_name[]" value="<?=$data['reserv_golf_reconfirm_name']?>" size="10"> &nbsp;&nbsp;확인여부 <input type="checkbox" name="reserv_golf_reconfirm_state_<?=$i?>" value="Y" <?if($data['reserv_golf_reconfirm_state']=="Y"){?>checked<?}?>>  </td>
            </tr>
        </table>
        <?php
        $i++;
    }
}else{
    ?>

<?}
if(is_array($result_list)) {
    $res->res_no = $reserv_user_no;
    $bigo = $res->reserve_view();
    ?>
    <div>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;border: 1px solid #aaa;">
            <tr>
                <th >비고</th>
                <td > <textarea name="reserv_golf_bigo" id="reserv_golf_bigo" rows="4" cols="85"><?=$bigo['reserv_golf_bigo']?></textarea></td>
            </tr>
        </table>
    </div>
<?}?>