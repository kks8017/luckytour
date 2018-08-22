<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_air where reserv_user_no='{$reserv_user_no}' and reserv_air_type='N' and reserv_del_mark!='Y'  order by no ";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
<script>
    $( function() {
        $( ".a_date" ).datepicker({
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
<?php
$i=0;
if(is_array($result_list)) {
foreach ($result_list as $data){
$air->air_name = $data['reserv_air_departure_company'];
$departure_company = $air->air_company();
$air->air_name = $data['reserv_air_arrival_company'];
$arrival_company = $air->air_company();
    $air->air_name = $data['reserv_air_departure_airline'];
    $s_img_departure_airline = $air->s_air_line_img();
    $air->air_name = $data['reserv_air_arrival_airline'];
    $s_img_arrival_airline = $air->s_air_line_img();
$start_date = explode(" ",$data['reserv_air_departure_date']);
$start_time = explode(":",$start_date[1]);
$end_date = explode(" ",$data['reserv_air_arrival_date']);
$end_time = explode(":",$end_date[1]);
?>
<script>

        $( function() {
            $( ".a_date_<?=$i?>" ).datepicker({
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
        function air_incom() {
            window.open("air_incom.php?no=<?=$reserv_user_no?>&reserv_air_no=<?=$data['no']?>","content_update","width=700,height=700,scrollbars=yes")
        }
        function air_sms_send(no,air) {
            window.open("../SMS/mms.php?reserv_no="+no+"&reserv_air_no="+air+"&c=air_res_number","sms","width=254,height=460");
        }

</script>
<header><p>일반항공정보 <img src="../image/normal_air_mod_btn.gif" type="button"  value="일반항공변경" onclick="air_update_normal('<?=$data['no']?>')" style="cursor: pointer;"> <img type="button" style="cursor: pointer;" src="../image/upd_btn.png" onclick="air_ledger_update_normal('<?=$i?>')" /></p>
</header>

    <table style="width: 100%">
        <tr>
            <th ><?=$data['reserv_air_departure_area']?>-><?=$data['reserv_air_end_departure_area']?><input type="hidden" name="reserv_air_no[]" value="<?=$data['no']?>"></th>
            <td ><span class="date"><?=$start_date[0]?></span> (<span class="time"><?=$start_time[0]?>:<?=$start_time[1]?></span>) <img style="vertical-align: middle;" src="<?=$s_img_departure_airline?>"> <?=$data['reserv_air_departure_airline']?></td>
            <th ><?=$data['reserv_air_start_arrival_area']?>-><?=$data['reserv_air_arrival_area']?></th>
            <td ><span class="date"><?=$end_date[0]?></span> (<span class="time"><?=$end_time[0]?>:<?=$end_time[1]?></span>) <img style="vertical-align: middle;" src="<?=$s_img_arrival_airline?>"><?=$data['reserv_air_arrival_airline']?></td>
        </tr>
        <tr>
            <th >출발에이전시</th>
            <td > <?=$data['reserv_air_departure_company']?> (☎ <?=$departure_company['air_phone']?>)</td>
            <th >리턴에이전시</th>
            <td  ><?=$data['reserv_air_arrival_company']?> (☎ <?=$arrival_company['air_phone']?>)</td>
        </tr>
        <tr>
            <th >판매할인율 </th>
            <td >성인 : <?=$data['reserv_air_adult_sale']?>% | 소아 : <?=$data['reserv_air_child_sale']?>%</td>
            <th >입금할인율 </th>
            <td >성인 : <?=$data['reserv_air_adult_deposit_sale']?>% | 소아 : <?=$data['reserv_air_child_deposit_sale']?>%</td>
        </tr>
        <tr>
            <th >발권정보</th>
            <td  colspan="3"><span>발권일 : <input type="text" name="reserv_air_booking_date[]" id="stxt"  size="15" value="<?=$data['reserv_air_booking_date']?>" class="a_date_<?=$i?>">   예약번호 : <input type="text" name="reserv_air_booking_number[]" id="stxt" size="15" value="<?=$data['reserv_air_booking_number']?>"></span><input type="button" value="항공문자" onclick="air_sms_send('<?=$data['reserv_user_no']?>','<?=$data['no']?>');"></td>
        </tr>
        <tr>
            <th >성인탑승명단</th>
            <td   colspan="3"><textarea name="reserv_air_adult_list[]" rows="2" cols="75" ><?=$data['reserv_air_adult_list']?></textarea></td>

        </tr>
        <tr>
            <th >소아탑승명단</th>
            <td  colspan="3"><textarea name="reserv_air_child_list[]" rows="2" cols="75"><?=$data['reserv_air_child_list']?></textarea></td>
        </tr>
        <tr>
            <th >유아탑승명단</th>
            <td class="baby"><textarea name="reserv_air_baby_list[]" rows="2" cols="26"><?=$data['reserv_air_baby_list']?></textarea></td>
            <th >인원</th>
            <td ><span>성인 : <?=$data['reserv_air_adult_number']?> 소아 : <?=$data['reserv_air_child_number']?> 유아 : <?=$data['reserv_air_baby_number']?></span></td>
        </tr>
        <tr>
            <th ><span>선금입금</span></th>
            <td ><input type="text" name="reserv_air_deposit_price[]" size="15" id="reserv_air_deposit_price_<?=$i?>" onkeyup="air_sum(<?=$i?>)" class="NumbersOnly" value="<?=set_comma($data['reserv_air_deposit_price'])?>"></td>
            <th ><span>선금입금일</span></th>
            <td ><input type="text" name="reserv_air_deposit_date[]" size="15" value="<?=$data['reserv_air_deposit_date']?>" class="a_date"> <span class="check"><input type="checkbox" name="reserv_air_deposit_state_<?=$i?>" value="Y" <?if($data['reserv_air_deposit_state']=="Y"){?>checked<?}?>>입금</span></td>
        </tr>
        <tr>
            <th ><span>잔금입금</span></th>
            <td ><input type="text" name="reserv_air_balance_price[]" id="reserv_air_balance_price_<?=$i?>" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_air_balance_price'])?>"></td>
            <th ><span>잔금입금일</span></th>
            <td ><input type="text" name="reserv_air_balance_date[]" size="15" value="<?=$data['reserv_air_balance_date']?>" class="a_date"> <span class="check"><input type="checkbox" name="reserv_air_balance_state_<?=$i?>" value="Y" <?if($data['reserv_air_balance_state']=="Y"){?>checked<?}?>>입금</span></td>
        </tr>
        <?php
        $profit = $data['reserv_air_total_price'] - $data['reserv_air_total_deposit_price'];
        ?>

    </table>
    <div>
        <table  style="width: 100%;height:50px;text-align: center;font-weight:bold;" >
            <tr>
                <td >판매액 : <span class="price"><?=set_comma($data['reserv_air_total_price'])?>원</span></td>
                <td >입금액&nbsp;: <span class="price"><?=set_comma($data['reserv_air_total_deposit_price'])?>원</span></td>
                <td >수익&nbsp;: <span class="profit"><?=set_comma($profit)?>원</span></td>
                <td >정요금: <span class="price"><?=set_comma($data['reserv_air_adult_normal_price'])?>원</span></td>
            </tr>
        </table>
    </div>
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
            <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-top: 5px;margin-bottom: 5px;border: 1px solid #aaa;">
                <tr>
                    <th ><span>비고</span></th>
                    <td > <textarea name="reserv_no_air_bigo" id="reserv_no_air_bigo" rows="4" cols="73"><?=$bigo['reserv_no_air_bigo']?></textarea></td>
                </tr>
            </table>
        </div>
    <?}?>
