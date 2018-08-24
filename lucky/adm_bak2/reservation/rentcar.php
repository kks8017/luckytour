<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_rent where reserv_user_no='{$reserv_user_no}' and  reserv_del_mark!='Y'  order by no desc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
<?php
$i=0;
if(is_array($result_list)) {
foreach ($result_list as $data){
$start_date = explode(" ",$data['reserv_rent_start_date']);
$start_time = explode(":",$start_date[1]);
$end_date = explode(" ",$data['reserv_rent_end_date']);
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
                <td colspan="4">렌트카정보<input type="button"  value="렌트카변경" onclick="rent_update('<?=$data['no']?>')"> <input type="button" value="수정" onclick="rent_ledger_update('<?=$i?>')"></td>
            </tr>
            <tr>
                <td>차량명</td>
                <td colspan="3"><span class="font_bule"><?=$data['reserv_rent_car_name']?></span>(<span class="font_red"><?=$data['reserv_rent_car_fuel']?></span>) <?=$data['reserv_rent_vehicle']?>대<input type="hidden" name="reserv_rent_no[]" value="<?=$data['no']?>"></td>
            </tr>
            <tr>
                <td>출고일</td>
                <td><?=$start_date[0]?> <?=$start_time[0]?>:<?=$start_time[1]?></td>
                <td>입고일</td>
                <td><?=$end_date[0]?> <?=$end_time[0]?>:<?=$end_time[1]?></td>
            </tr>
            <tr>
                <td>사용시간</td>
                <td><?=$data['reserv_rent_time']?>시간</td>
                <td>업체명</td>
                <td><?=$data['reserv_rent_com_name']?></td>
            </tr>
            <tr>
                <td>판매할인율</td>
                <td><?=$data['reserv_rent_sale']?>%</td>
                <td>입금할인율</td>
                <td><?=$data['reserv_rent_deposit_sale']?>%</td>
            </tr>
            <tr>
                <td>출고장소</td>
                <td><?=$data['reserv_rent_departure_place']?></td>
                <td>입고장소</td>
                <td><?=$data['reserv_rent_arrival_place']?></td>
            </tr>
            <tr>
                <td>부가서비스</td>
                <td colspan="3"><?=$data['reserv_rent_option']?></td>
            </tr>
            <tr>
                <td class="title">선금입금</td>
                <td><input type="text" name="reserv_rent_deposit_price[]" size="15" class="NumbersOnly" value="<?=set_comma($data['reserv_rent_deposit_price'])?>"></td>
                <td class="title">선금입금일</td>
                <td><input type="text" name="reserv_rent_deposit_date[]" size="15" value="<?=$data['reserv_rent_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_rent_deposit_state[]" value="Y" <?if($data['reserv_rent_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <td class="title">잔금입금</td>
                <td><input type="text" name="reserv_rent_balance_price[]" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_rent_balance_price'])?>"></td>
                <td class="title">잔금입금일</td>
                <td><input type="text" name="reserv_rent_balance_date[]" size="15" value="<?=$data['reserv_rent_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_rent_balance_state[]" value="Y" <?if($data['reserv_rent_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>

        </table>
    <?php
    $profit = $data['reserv_rent_total_price'] - $data['reserv_rent_total_deposit_price'];
    ?>
        <table class="total">
            <tr>
                <td >판매액 : <?=set_comma($data['reserv_rent_total_price'])?>원</td>
                <td>입금액 : <?=set_comma($data['reserv_rent_total_deposit_price'])?>원</td>
                <td>수  익 : <?=$profit?>원</td>
                <td>직  불  : <?=$data['reserv_rent_cash_price']?>원</td>
            </tr>
        </table>
        <table class="total">
            <tr>
                <td>예약재확인 : </td>
                <td colspan="3"> 확인일 : <input type="text" name="reserv_rent_reconfirm_date[]" class="air_date" value="<?=$data['reserv_rent_reconfirm_date']?>" size="10">  확인담당자 : <input type="text" name="reserv_rent_reconfirm_name[]" value="<?=$data['reserv_rent_reconfirm_name']?>" size="10"> 확인여부 <input type="checkbox" name="reserv_rent_reconfirm_state[]" value="Y" <?if($data['reserv_rent_reconfirm_state']=="Y"){?>checked<?}?>>  </td>
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
                <td > <textarea name="reserv_rent_bigo" id="reserv_rent_bigo" rows="4" cols="80"></textarea></td>
            </tr>
        </table>
    </div>
<?}?>
