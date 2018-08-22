<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_rent where reserv_user_no='{$reserv_user_no}' and  reserv_del_mark!='Y'  order by no ";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
<script>
    function rent_sum(i) {
        var sum1 = get_comma($("#reserv_rent_deposit_price_"+i).val());
        var sum2 = $("#reserv_rent_total_price_"+i).val();

        var total = Number(sum2) - Number(sum1);
        $("#reserv_rent_balance_price_"+i).val(set_comma(total))
    }
</script>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $rent->comno = $data['reserv_rent_com_no'];
        $phone = $rent->company_phone();
        $start_date = explode(" ",$data['reserv_rent_start_date']);
        $start_time = explode(":",$start_date[1]);
        $end_date = explode(" ",$data['reserv_rent_end_date']);
        $end_time = explode(":",$end_date[1]);
        $rent_fuel = $rent->rent_code_name($data['reserv_rent_car_fuel']);
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
            function rent_incom() {
                window.open("rent_incom.php?no=<?=$reserv_user_no?>&reserv_rent_no=<?=$data['no']?>","rent_incom","width=700,height=500,scrollbars=yes")
            }

        </script>
        <header><p>렌트카정보 <img type="button" style="cursor: pointer;" src="../image/rent_mod_btn.gif" onclick="rent_update('<?=$data['no']?>')" /> <img type="button" style="cursor: pointer;" src="../image/upd_btn.png" onclick="rent_ledger_update('<?=$i?>')" /> <img type="button" style="cursor: pointer;" src="../image/res_incom.gif" onclick="rent_incom()"></p>
        </header>
        <table style="width: 100%">
            <tr>
                <th >차량명</th>
                <td colspan="3"><span class="name"><?=$data['reserv_rent_car_name']?></span>(<span class="fuel"><?=$rent_fuel?></span>) <?=$data['reserv_rent_vehicle']?>대<input type="hidden" name="reserv_rent_no[]" value="<?=$data['no']?>">   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;블럭<input type="checkbox" name="rent_block[]" value="Y" <?if($data['reserv_rent_block']=="Y"){?>checked<?}?>> 수배<input type="checkbox" name="rent_wait[]" value="Y" <?if($data['reserv_rent_wait']=="Y"){?>checked<?}?>></td>
            </tr>
            <tr>
                <th >출고일</th>
                <td ><span class="date"><?=$start_date[0]?></span> (<span class="time"><?=$start_time[0]?>:<?=$start_time[1]?></span>)</td>
                <th >입고일</th>
                <td ><span class="date"><?=$end_date[0]?></span> (<span class="time"><?=$end_time[0]?>:<?=$end_time[1]?></span>)</td>
            </tr>
            <tr>
                <th >사용시간</th>
                <td ><?=$data['reserv_rent_time']?>시간</td>
                <th >업체명</th>
                <td ><?=$data['reserv_rent_com_name']?> <br>(☎ <?=$phone?>)</td>
            </tr>
            <tr>
                <th >판매할인율</th>
                <td ><?=$data['reserv_rent_sale']?>%</td>
                <th >입금할인율</th>
                <td ><?=$data['reserv_rent_deposit_sale']?>%</td>
            </tr>
            <tr>
                <th >출고장소</th>
                <td ><?=$data['reserv_rent_departure_place']?></td>
                <th >입고장소</th>
                <td ><?=$data['reserv_rent_arrival_place']?></td>
            </tr>
            <tr>
                <th >부가서비스</th>
                <td  colspan="3"><?=$data['reserv_rent_option']?></td>
            </tr>
            <tr>
                <th >선금입금</th>
                <td ><input type="text" name="reserv_rent_deposit_price[]" id="reserv_rent_deposit_price_<?=$i?>" onkeyup="rent_sum(<?=$i?>)" class="price_sum1" size="15" class="NumbersOnly" value="<?=set_comma($data['reserv_rent_deposit_price'])?>"></td>
                <th >선금입금일</th>
                <td ><input type="text" name="reserv_rent_deposit_date[]" size="15" value="<?=$data['reserv_rent_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_rent_deposit_state_<?=$i?>" value="Y" <?if($data['reserv_rent_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <th >잔금입금</th>
                <td ><input type="text" name="reserv_rent_balance_price[]" id="reserv_rent_balance_price_<?=$i?>" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_rent_balance_price'])?>"></td>
                <th >잔금입금일</th>
                <td ><input type="text" name="reserv_rent_balance_date[]" size="15" value="<?=$data['reserv_rent_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_rent_balance_state_<?=$i?>"  value="Y" <?if($data['reserv_rent_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <input type="hidden" id="reserv_rent_total_price_<?=$i?>"  value="<?=$data['reserv_rent_total_deposit_price']?>">


        </table>
        <?php
        $profit = $data['reserv_rent_total_price'] - $data['reserv_rent_total_deposit_price'];
        ?>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;" >
            <tr>
                <td >판매액 : <span class="price"><?=set_comma($data['reserv_rent_total_price'])?>원</span></td>
                <td >입금액&nbsp;: <span class="price"><?=set_comma($data['reserv_rent_total_deposit_price'])?>원</span></td>
                <td >수익&nbsp;: <span class="profit"><?=set_comma($profit)?>원</span></td>
                <td >정요금: <span class="price"><?=set_comma($data['reserv_rent_cash_price'])?>원</span></td>
            </tr>
        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;margin-top: 5px;border: 1px solid #aaa;">
            <tr>
                <th >예약재확인  </th>
                <td colspan="3"> 확인일  <input type="text" name="reserv_rent_reconfirm_date[]" class="air_date" value="<?=$data['reserv_rent_reconfirm_date']?>" size="10">  &nbsp;&nbsp;&nbsp;확인담당자 <input type="text" name="reserv_rent_reconfirm_name[]" value="<?=$data['reserv_rent_reconfirm_name']?>" size="10"> &nbsp;&nbsp;확인여부 <input type="checkbox" name="reserv_rent_reconfirm_state_<?=$i?>" value="Y" <?if($data['reserv_rent_reconfirm_state']=="Y"){?>checked<?}?>>  </td>
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
    <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;border: 1px solid #aaa;">
        <tr>
            <th >비고</th>
            <td > <textarea name="reserv_rent_bigo" id="reserv_rent_bigo" rows="4" cols="50"><?=$bigo['reserv_rent_bigo']?></textarea></td>
        </tr>
    </table>

<?}?>
