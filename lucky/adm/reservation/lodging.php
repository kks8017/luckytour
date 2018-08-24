<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_lodging where reserv_user_no='{$reserv_user_no}' and reserv_del_mark!='Y'  order by no";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}


?>
    <script>
        function tel_sum(i) {
            var sum1 = get_comma($("#reserv_tel_deposit_price_"+i).val());
            var sum2 = $("#reserv_tel_total_price_"+i).val();

            var total = Number(sum2) - Number(sum1);
            $("#reserv_tel_balance_price_"+i).val(set_comma(total))
        }
    </script>
<?php
$i=0;
if(is_array($result_list)) {
    foreach ($result_list as $data){
        $lodging->lodno = $data['reserv_tel_lodno'];
        $phone = $lodging->lodging_detail();
        $start_date = $data['reserv_tel_date'];
        $end_date = date("Y-m-d",strtotime($start_date."+{$data['reserv_tel_stay']} days"));
        $lodging->lodno = $data['reserv_tel_lodno'];
        $price_date = $lodging->price_date();
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
                window.open("lod_incom.php?no=<?=$reserv_user_no?>&reserv_lod_no=<?=$data['no']?>","lod_incom","width=700,height=500,scrollbars=yes")
            }
        </script>
        <header><p>숙박정보 <img type="button" style="cursor: pointer;" src="../image/lodging_mod_btn.gif" onclick="lodging_update('<?=$data['no']?>')" /> <img type="button" style="cursor: pointer;" src="../image/upd_btn.png" onclick="lodging_ledger_update('<?=$i?>')" /> <img type="button" style="cursor: pointer;" src="../image/res_incom.gif" onclick="lod_incom()"></p>
        </header>
        <table style="width: 100%">

            <tr>
                <th >숙소명</th>
                <td ><span class="name"><?=$data['reserv_tel_name']?></span><br>(☎ <?=$phone['lodging_manager_phone']?>) <input type="hidden" name="reserv_tel_no[]" value="<?=$data['no']?>"></td>
                <th >객실명</th>
                <td ><span class="name"><?=$data['reserv_tel_room_name']?></span>( <?=$data['reserv_tel_few']?>실)</td>
            </tr>
            <tr>
                <th >계좌번호</th>
                <td colspan="3"><?=$phone['lodging_account']?></td>
            </tr>
            <tr>
                <th >입실일</th>
                <td ><span class="date"><?=$start_date?></span></td>
                <th >퇴실일</th>
                <td ><span class="date"><?=$end_date?></span></td>
            </tr>
            <tr>
                <th >사용일</th>
                <td ><?=$data['reserv_tel_stay']?>박 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;블럭<input type="checkbox" name="tel_block[]" value="Y" <?if($data['reserv_tel_block']=="Y"){?>checked<?}?>> 수배<input type="checkbox" name="tel_wait[]" value="Y" <?if($data['reserv_tel_wait']=="Y"){?>checked<?}?>></td>
                <th >적용요금일</th>
                <td ><span class="date"><?=$price_date?></span> 까지</td>
            </tr>

            <tr>
                <th >선금입금</th>
                <td ><input type="text" name="reserv_tel_deposit_price[]" size="15" id="reserv_tel_deposit_price_<?=$i?>" onkeyup="tel_sum(<?=$i?>)" class="NumbersOnly" value="<?=set_comma($data['reserv_tel_deposit_price'])?>"></td>
                <th >선금입금일</th>
                <td ><input type="text" name="reserv_tel_deposit_date[]" size="15" value="<?=$data['reserv_tel_deposit_date']?>" class="air_date"> <input type="checkbox" name="reserv_tel_deposit_state_<?=$i?>" value="Y" <?if($data['reserv_tel_deposit_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <tr>
                <th >잔금입금</th>
                <td ><input type="text" name="reserv_tel_balance_price[]" id="reserv_tel_balance_price_<?=$i?>" class="NumbersOnly" size="15" value="<?=set_comma($data['reserv_tel_balance_price'])?>"></td>
                <th >잔금입금일</th>
                <td ><input type="text" name="reserv_tel_balance_date[]" size="15" value="<?=$data['reserv_tel_balance_date']?>" class="air_date"> <input type="checkbox" name="reserv_tel_balance_state_<?=$i?>" value="Y" <?if($data['reserv_tel_balance_state']=="Y"){?>checked<?}?>>입금</td>
            </tr>
            <input type="hidden" id="reserv_tel_total_price_<?=$i?>"  value="<?=$data['reserv_tel_total_dposit_price']?>">
            <?php
            $profit = $data['reserv_tel_total_price'] - $data['reserv_tel_total_dposit_price'];
            ?>
            <tr>
                <td colspan="4">

                </td>
            </tr>
        </table>
        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;" >
            <tr>
                <td >판매액 : <span class="price"><?=set_comma($data['reserv_tel_total_price'])?>원</span></td>
                <td >입금액&nbsp;: <span class="price"><?=set_comma($data['reserv_tel_total_dposit_price'])?>원</span></td>
                <td >수익&nbsp;: <span class="profit"><?=set_comma($profit)?>원</span></td>
            </tr>
        </table>


        <table style="width: 100%;height:50px;text-align: center;font-weight:bold;margin-bottom: 5px;margin-top: 5px;border: 1px solid #aaa;">
            <tr>
                <th >예약재확인  </th>
                <td  colspan="3"> 확인일  <input type="text" name="reserv_lodging_reconfirm_date[]" class="air_date" value="<?=$data['reserv_lodging_reconfirm_date']?>" size="10">  &nbsp;&nbsp;&nbsp;&nbsp;확인담당자  <input type="text" name="reserv_lodging_reconfirm_name[]" value="<?=$data['reserv_lodging_reconfirm_name']?>" size="10"> &nbsp;&nbsp;확인여부 <input type="checkbox" name="reserv_lodging_reconfirm_state_<?=$i?>" value="Y" <?if($data['reserv_lodging_reconfirm_state']=="Y"){?>checked<?}?>>  </td>
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
                <td > <textarea name="reserv_tel_bigo" id="reserv_tel_bigo" rows="4" cols="50"><?=$bigo['reserv_tel_bigo']?></textarea></td>
            </tr>
        </table>
    </div>
<?}?>