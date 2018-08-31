<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$sql = "select * from reservation_air where reserv_air_type='N' and reserv_del_mark!='Y'  order by no desc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $start_date = explode(" ",$data['reserv_air_departure_date']);
        $start_time = explode(":",$start_date[1]);
        $end_date = explode(" ",$data['reserv_air_arrival_date']);
        $end_time = explode(":",$end_date[1]);
        ?>
        <script>
            $( function() {
                $( ".air_date" ).datepicker({
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
        <table>
            <tr>
                <td colspan="4">일반항공정보 <input type="button"  value="일반항공변경" onclick="air_update_normal('<?=$data['no']?>')"> <input type="button" value="수정" onclick="air_ledger_update_normal('<?=$data['no']?>')"></td>
            </tr>
            <tr>
                <td class="title"><?=$data['reserv_air_departure_area']?>->제주</td>
                <td><?=$start_date[0]?> (<?=$start_time[0]?> : <?=$start_time[1]?>)</td>
                <td class="title">제주-><?=$data['reserv_air_arrival_area']?></td>
                <td><?=$end_date[0]?> (<?=$end_time[0]?> : <?=$end_time[1]?>)</td>
            </tr>
            <tr>
                <td class="title">출발항공사</td>
                <td><?=$data['reserv_air_departure_airline']?></td>
                <td class="title">리턴항공사</td>
                <td><?=$data['reserv_air_arrival_airline']?></td>
            </tr>
            <tr>
                <td class="title">출발에이전시</td>
                <td><?=$data['reserv_air_departure_company']?></td>
                <td class="title">리턴에이전시</td>
                <td><?=$data['reserv_air_arrival_company']?></td>
            </tr>
            <tr>
                <td class="title">판매할인율</td>
                <td>성인 : <?=$data['reserv_air_adult_sale']?>% | 소아 : <?=$data['reserv_air_child_sale']?>%</td>
                <td class="title">입금할인율</td>
                <td>성인 : <?=$data['reserv_air_adult_deposit_sale']?>% | 소아 : <?=$data['reserv_air_child_deposit_sale']?>%</td>
            </tr>
            <tr>
                <td class="title">발권정보</td>
                <td colspan="3">발권일 : <input type="text" name="reserv_air_booking_date" size="15" value="<?=$data['reserv_air_booking_date']?>" class="air_date">   예약번호 : <input type="text" name="reserv_air_booking_number" size="15" value="<?=$data['reserv_air_booking_number']?>"></td>
            </tr>
            <tr>
                <td class="title">성인탑승명단</td>
                <td colspan="3"><textarea name="reserv_air_adult_list" rows="3" cols="60"><?=$data['reserv_air_adult_list']?></textarea></td>
            </tr>
            <tr>
                <td class="title">소아탑승명단</td>
                <td colspan="3"><textarea name="reserv_air_child_list" rows="3" cols="60"><?=$data['reserv_air_adult_list']?></textarea></td>
            </tr>
            <tr>
                <td class="title">유아탑승명단</td>
                <td colspan="3"><textarea name="reserv_air_baby_list" rows="3" cols="60"><?=$data['reserv_air_adult_list']?></textarea></td>
            </tr>
            <tr>
                <td class="title">선금입금</td>
                <td><input type="text" name="reserv_air_deposit_price" size="15" class="NumbersOnly" value="<?=set_comma($data['reserv_air_deposit_price'])?>"></td>
                <td class="title">선금입금일</td>
                <td><input type="text" name="reserv_air_deposit_date" size="15" value="<?=$data['reserv_air_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_air_deposit_state" value="Y" <?if($data['reserv_air_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <td class="title">잔금입금</td>
                <td><input type="text" name="reserv_air_balance_price" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_air_balance_price'])?>"></td>
                <td class="title">잔금입금일</td>
                <td><input type="text" name="reserv_air_balance_date" size="15" value="<?=$data['reserv_air_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_air_balance_state" value="Y" <?if($data['reserv_air_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>

        </table>
        <?php
        $profit = $data['reserv_air_total_price'] - $data['reserv_air_total_deposit_price'];
        ?>
        <table class="total">
            <tr>
                <td >판매액 : <?=set_comma($data['reserv_air_total_price'])?>원</td>
                <td>입금액 : <?=set_comma($data['reserv_air_total_deposit_price'])?>원</td>
                <td>수  익 : <?=$profit?>원</td>
                <td>정요금 : <?=$data['reserv_air_total_price']?>원</td>
            </tr>
        </table>
        <?php
        $i++;
    }
}else{
    ?>

<?}
if(is_array($result_list)) {
?>
    <div>
        <table>
            <tr>
                <td >비고</td>
                <td > <textarea name="reserv_air_bigo" id="reserv_no_air_bigo" rows="4" cols="80"></textarea></td>
            </tr>
        </table>
    </div>
<?}?>