<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_bustour where reserv_user_no='{$reserv_user_no}' and  reserv_del_mark!='Y'  order by reserv_bustour_date";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}


?>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $start_date = $data['reserv_bustour_date'];
        $end_date = date("Y-m-d",strtotime($start_date."+{$data['reserv_bustour_stay']} days"));

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
                <td colspan="4">버스투어정보<input type="button"  value="버스투어변경" onclick="bustour_update('<?=$data['no']?>')"> <input type="button" value="수정" onclick="bustour_ledger_update('<?=$i?>')"></td>
            </tr>
            <tr>
                <td>버스투어명</td>
                <td colspan="3"><span class="font_red"><?=$data['reserv_bustour_name']?></span> <input type="hidden" name="reserv_bustour_no[]" value="<?=$data['no']?>"</td>
            </tr>
            <tr>
                <td>여행날짜</td>
                <td><?=$start_date?>(<?=$data['reserv_bustour_stay']?>일)</td>
                <td>인원</td>
                <td><?=$data['reserv_bustour_number']?>명</td>
            </tr>
           <tr>
                <td class="title">선금입금</td>
                <td><input type="text" name="reserv_bustour_deposit_price[]" size="15" class="NumbersOnly" value="<?=set_comma($data['reserv_bustour_deposit_price'])?>"></td>
                <td class="title">선금입금일</td>
                <td><input type="text" name="reserv_bustour_deposit_date[]" size="15" value="<?=$data['reserv_bustour_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_bustour_deposit_state[]" value="Y" <?if($data['reserv_bustour_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <td class="title">잔금입금</td>
                <td><input type="text" name="reserv_bustour_balance_price[]" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_bustour_balance_price'])?>"></td>
                <td class="title">잔금입금일</td>
                <td><input type="text" name="reserv_bustour_balance_date[]" size="15" value="<?=$data['reserv_bustour_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_bustour_balance_state[]" value="Y" <?if($data['reserv_bustour_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>

        </table>
        <?php
        $profit = $data['reserv_bustour_total_price'] - $data['reserv_bustour_total_deposit_price'];
        ?>
        <table class="total">
            <tr>
                <td>판매액 : <?=set_comma($data['reserv_bustour_total_price'])?>원</td>
                <td>입금액 : <?=set_comma($data['reserv_bustour_total_deposit_price'])?>원</td>
                <td>수  익 : <?=$profit?>원</td>
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
                <td > <textarea name="reserv_bustour_bigo" id="reserv_bustour_bigo" rows="4" cols="80"></textarea></td>
            </tr>
        </table>
    </div>
<?}?>