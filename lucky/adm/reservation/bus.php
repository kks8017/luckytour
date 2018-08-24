<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_bus where reserv_user_no='{$reserv_user_no}' and reserv_del_mark!='Y'  order by no";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
    <script>
        function bus_sum(i) {
            var sum1 = get_comma($("#reserv_bus_deposit_price_"+i).val());
            var sum2 = $("#reserv_bus_total_price_"+i).val();

            var total = Number(sum2) - Number(sum1);
            $("#reserv_bus_balance_price_"+i).val(set_comma(total))
        }
    </script>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $start_date = $data['reserv_bus_date'];
        $bus_stay = $data['reserv_bus_stay']-1;
        $end_date = date("Y-m-d",strtotime($start_date."+{$bus_stay} days"));
        if($data['reserv_bus_type']=="B"){$bus_type="버스";}else{$bus_type="택시";}
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
            function lod_incom() {
                window.open("bus_incom.php?no=<?=$reserv_user_no?>&reserv_bus_no=<?=$data['no']?>","lod_incom","width=700,height=500,scrollbars=yes")
            }
        </script>
        <header><p>버스정보 <img type="button" style="cursor: pointer;" src="../image/bus_mod_btn.gif" onclick="bus_update('<?=$data['no']?>')" /> <img type="button" style="cursor: pointer;" src="../image/upd_btn.png" onclick="bus_ledger_update('<?=$i?>')" /> <img type="button" style="cursor: pointer;" src="../image/res_incom.gif" onclick="lod_incom()"> </p>
        </header>
        <table style="width: 100%">
            <tr>
                <th >차량명</th>
                <td  colspan="3"><span class="name"><?=$data['reserv_bus_name']?></span><input type="hidden" name="reserv_bus_no[]" value="<?=$data['no']?>"</td>
            </tr>
            <tr>
                <th >여행일</th>
                <td ><span class="date"><?=$start_date?></span></td>
                <th >리턴일</th>
                <td ><span class="date"><?=$end_date?></span></td>
            </tr>
            <tr>
                <th >사용일</th>
                <td ><?=$data['reserv_bus_stay']?>일</td>
                <th >사용대수</th>
                <td ><?=$data['reserv_bus_vehicle']?>대</td>
            </tr>

            <tr>
                <th >선금입금</th>
                <td ><input type="text" name="reserv_bus_deposit_price[]" size="15" id="reserv_bus_deposit_price_<?=$i?>" onkeyup="bus_sum(<?=$i?>)" class="NumbersOnly" value="<?=set_comma($data['reserv_bus_deposit_price'])?>"></td>
                <th >선금입금일</th>
                <td ><input type="text" name="reserv_bus_deposit_date[]" size="15" value="<?=$data['reserv_bus_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_bus_deposit_state_<?=$i?>" value="Y" <?if($data['reserv_bus_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <th >잔금입금</th>
                <td ><input type="text" name="reserv_bus_balance_price[]" id="reserv_bus_balance_price_<?=$i?>" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_bus_balance_price'])?>"></td>
                <th >잔금입금일</th>
                <td ><input type="text" name="reserv_bus_balance_date[]" size="15" value="<?=$data['reserv_bus_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_bus_balance_state_<?=$i?>" value="Y" <?if($data['reserv_bus_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <input type="hidden" id="reserv_bus_total_price_<?=$i?>"  value="<?=$data['reserv_bus_total_deposit_price']?>">
            <?php
            $profit = $data['reserv_bus_total_price'] - $data['reserv_bus_total_deposit_price'];
            ?>
        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;" >
            <tr>
                <td >판매액 : <span class="price"><?=set_comma($data['reserv_bus_total_price'])?>원</span></td>
                <td >입금액&nbsp;: <span class="price"><?=set_comma($data['reserv_bus_total_deposit_price'])?>원</span></td>
                <td >수익&nbsp;: <span class="profit"><?=set_comma($profit)?>원</span></td>
            </tr>
        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;margin-top: 5px;border: 1px solid #aaa;">
            <tr>
                <th >수 배</th>
                <td  colspan="3"> 전화번호 : <input type="text" name="reserv_bus_reconfirm_phone[]" size="15"  value="<?=$data['reserv_bus_reconfirm_phone']?>" size="10">  &nbsp;&nbsp; 기사 : <input type="text" name="reserv_bus_reconfirm_person[]" size="15" value="<?=$data['reserv_bus_reconfirm_person']?>" size="10"> &nbsp;&nbsp; 수배여부 <input type="checkbox" name="reserv_bus_reconfirm_state_<?=$i?>" value="Y" <?if($data['reserv_bus_reconfirm_state']=="Y"){?>checked<?}?>>  </td>
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
                <td > <textarea name="reserv_bus_bigo" id="reserv_bus_bigo" rows="4" cols="75"><?=$bigo['reserv_bus_bigo']?></textarea></td>
            </tr>
        </table>
    </div>
<?}?>