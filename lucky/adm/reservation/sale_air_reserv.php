<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_air_no = $_REQUEST['reserv_air_no'];

$sql_reserv = "select no,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);

$sql_air = "select no,
                    reserv_air_airno,
                    reserv_air_departure_area,
                    reserv_air_arrival_area,
                    reserv_air_end_departure_area,
                    reserv_air_start_arrival_area,
                    reserv_air_departure_airline,
                    reserv_air_arrival_airline,
                    reserv_air_departure_company,
                    reserv_air_arrival_company,
                    reserv_air_departure_date,
                    reserv_air_arrival_date,
                    reserv_air_adult_normal_price,
                    reserv_air_child_normal_price,
                    reserv_air_adult_sale,
                    reserv_air_child_sale,
                    reserv_air_adult_deposit_sale,
                    reserv_air_child_deposit_sale,
                    reserv_air_total_price,
                    reserv_air_total_deposit_price,
                    reserv_air_adult_number,
                    reserv_air_child_number,
                    reserv_air_baby_number
            from reservation_air where no='{$reserv_air_no}' and reserv_user_no='{$no}' ";
//echo $sql_air;
$rs_air  = $db->sql_query($sql_air);
$row_air = $db->fetch_array($rs_air);

$company = set_company();
$tour_air_area = explode(",",$company['tour_air_area']);

$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}
$sql_company = "select air_name from air_company  where air_type='S' and air_sch_ok='Y'  order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company['air_name'];
}
$start_date1 = explode(" ",$row_air['reserv_air_departure_date']);
$start_date = explode("-",$start_date1[0]);
$start_time = explode(":",$start_date1[1]);
$end_date1 = explode(" ",$row_air['reserv_air_arrival_date']);
$end_date = explode("-",$end_date1[0]);
$end_time = explode(":",$end_date1[1]);
?>
<table>
    <tr>
        <th >출발일자</th>
        <td > <input type="text" name="start_date" id="start_date" size="20" value="<?=$start_date1[0]?>">  <input type="text" class="snum" name="start_hour" id="start_hour" size="3" value="<?=$start_time[0]?>">시
            <input type="text" class="snum" class="snum"name="start_minute" id="start_minute" size="3" value="<?=$start_time[1]?>">분 </td>
        <th >리턴일자</th>
        <td ><input type="text" name="end_date" id="end_date" size="20" value="<?=$end_date1[0]?>"> <input type="text" class="snum" name="end_hour" id="end_hour" size="3" value="<?=$end_time[0]?>">시
            <input type="text" class="snum" class="snum"name="end_minute" id="end_minute" size="3" value="<?=$end_time[1]?>">분  </td>
    </tr>
    <tr>
        <th >출발지역</th>
        <td >
            <select name="sch_departure_area">
                <?php
                foreach ($tour_air_area as $area){
                    $area_name = explode("|",$area);
                    if($row_air['reserv_air_departure_area']==$area_name[0]){$chk_area = "selected";}else{$chk_area = "";}
                    echo "<option value='{$area_name[0]}' {$chk_area}>{$area_name[0]}</option>";
                }
                ?>
            </select> → <select name="sch_end_departure_area">
                <?php
                foreach ($tour_air_area as $area){
                    if($row_air['reserv_air_end_departure_area']==""){
                        $row_air['reserv_air_end_departure_area'] ="제주";
                    }
                    $area_name = explode("|",$area);
                    if($row_air['reserv_air_end_departure_area']==$area_name[0]){$chk_area = "selected";}else{$chk_area = "";}
                    echo "<option value='{$area_name[0]}' {$chk_area}>{$area_name[0]}</option>";
                }
                ?>
            </select>
        </td>
        <th >리턴지역</th>
        <td >
            <select name="sch_start_arrival_area">
                <?php
                foreach ($tour_air_area as $area){
                    $area_name = explode("|",$area);
                    if($row_air['reserv_air_start_arrival_area']==""){
                        $row_air['reserv_air_start_arrival_area'] ="제주";
                    }
                    if($row_air['reserv_air_start_arrival_area']==$area_name[0]){$chk_area = "selected";}else{$chk_area = "";}
                    echo "<option value='{$area_name[0]}' {$chk_area}>{$area_name[0]}</option>";
                }
                ?>
            </select> → <select name="sch_arrival_area">
                <?php
                foreach ($tour_air_area as $area){
                    $area_name = explode("|",$area);
                    if($row_air['reserv_air_arrival_area']==$area_name[0]){$chk_area = "selected";}else{$chk_area = "";}
                    echo "<option value='{$area_name[0]}' {$chk_area}>{$area_name[0]}</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <th >출발항공사</th>
        <td  >
            <select name='start_airline'>
                <?php
                foreach ($result_airline as $airline){
                    if($row_air['reserv_air_departure_airline']==$airline){$chk_airline = "selected";}else{$chk_airline = "";}
                    echo "<option value='{$airline}' {$chk_airline}>{$airline}</option>";
                }
                ?>
            </select>
        </td>
        <th >리턴항공사</th>
        <td  >
            <select name='end_airline'>
                <?php
                foreach ($result_airline as $airline){
                    if($row_air['reserv_air_arrival_airline']==$airline){$chk_airline = "selected";}else{$chk_airline = "";}
                    echo "<option value='{$airline}' {$chk_airline}>{$airline}</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <th >출발에이전시</th>
        <td  >
            <select name='start_company'>
            <?php
            foreach ($result_company as $company){
                if($row_air['reserv_air_departure_company']==$company){$chk_company = "selected";}else{$chk_company = "";}
                echo "<option value='{$company}' {$chk_company}>{$company}</option>";
            }
            ?>
            </select>
        </td>
        <th >리턴에이전시</th>
        <td  >
            <select name='end_company'>
            <?php
            foreach ($result_company as $company){
                if($row_air['reserv_air_arrival_company']==$company){$chk_company = "selected";}else{$chk_company = "";}
                echo "<option value='{$company}' {$chk_company}>{$company}</option>";
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th >인원</th>
        <td  colspan="3">성인<input type="text" class="snum" name="adult_number" id="adult_number" size="3" value="<?=$row_air['reserv_air_adult_number']?>"> 소아<input type="text" class="snum" name="child_number" id="child_number" size="3" value="<?=$row_air['reserv_air_child_number']?>"> 유아<input type="text" class="snum" name="baby_number" id="baby_number" size="3" value="<?=$row_air['reserv_air_baby_number']?>"></td>
    </tr>
    <tr>
        <th >판매할인율</th>
        <td >성인 <input type="text"  name="reserv_air_adult_sale" id="reserv_air_adult_sale" size="2" value="<?=$row_air['reserv_air_adult_sale']?>">% 소아 <input type="text" name="reserv_air_child_sale" id="reserv_air_child_sale" size="2" value="<?=$row_air['reserv_air_child_sale']?>">%
        </td>
        <th >입금할인율</th>
        <td >성인 <input type="text" name="reserv_air_adult_deposit_sale" id="reserv_air_adult_deposit_sale" size="2" value="<?=$row_air['reserv_air_adult_deposit_sale']?>">% 소아 <input type="text" name="reserv_air_child_deposit_sale" id="reserv_air_child_deposit_sale" size="2" value="<?=$row_air['reserv_air_child_deposit_sale']?>">%
        </td>
    </tr>
    <tr>
        <th >총 금액</th>
        <td ><input type="text" class="sprice" name="reserv_total_price" id="reserv_total_price" size="10" value="<?=set_comma($row_air['reserv_air_total_price'])?>">원
        </td>
        <th >총입금액</th>
        <td ><input type="text" class="sprice" name="reserv_total_deposit_price" id="reserv_total_deposit_price" size="10" value="<?=set_comma($row_air['reserv_air_total_deposit_price'])?>">원
        </td>
    </tr>
    <tr>
        <th >정상금액</th>
        <td  colspan="3">성인<input type="text" name="reserv_normal_adult_price" id="reserv_normal_adult_price" size="10" value="<?=set_comma($row_air['reserv_air_adult_normal_price'])?>"> 소아 <input type="text" name="reserv_normal_child_price" id="reserv_normal_child_price" size="10" value="<?=set_comma($row_air['reserv_air_child_normal_price'])?>"> </td>
    </tr>

</table>
<script>
    $(function() {
        var dates = $( "#start_date, #end_date " ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            dateFormat: 'yy-mm-dd',
            showOn : "both",
            yearSuffix: '년',
            showMonthAfterYear: true,
            buttonImage : "../../sub_img/calender2.png",
            buttonImageOnly : true,
            numberOfMonths : 2,
            maxDate:'+1095d',
            onSelect: function( selectedDate ) {
                var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>