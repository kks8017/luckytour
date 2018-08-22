<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

$sql_reserv = "select no,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);



$company = set_company();
$tour_air_area = explode(",",$company['tour_air_area']);

$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}
$sql_company = "select air_name from air_company  where air_type='S'   order by no asc";
$rs_company  = $db->sql_query($sql_company);
while($row_company = $db->fetch_array($rs_company)) {
    $result_company[] = $row_company['air_name'];
}
$start_date1 = explode(" ",$row_reserv['reserv_tour_start_date']);
$start_date = explode("-",$start_date1[0]);
$start_time = explode(":",$start_date1[1]);
$end_date1 = explode(" ",$row_reserv['reserv_tour_end_date']);
$end_date = explode("-",$end_date1[0]);
$end_time = explode(":",$end_date1[1]);
?>
<table>
    <tr>
        <td class="title">출발일자</td>
        <td class="cont"><input type="text" name="start_year" id="start_year" size="5" value="<?=$start_date[0]?>">년
            <input type="text" name="start_month" id="start_month" size="3" value="<?=$start_date[1]?>">월
            <input type="text" name="start_day" id="start_day" size="3" value="<?=$start_date[2]?>">일
            <input type="text" name="start_hour" id="start_hour" size="3" value="<?=$start_time[0]?>">시
            <input type="text" name="start_minute" id="start_minute" size="3" value="<?=$start_time[1]?>">분
        </td>
        <td class="title">리턴일자</td>
        <td class="cont"><input type="text" name="end_year" id="end_year" size="5" value="<?=$end_date[0]?>">년
            <input type="text" name="end_month" id="end_month" size="3" value="<?=$end_date[1]?>">월
            <input type="text" name="end_day" id="end_day" size="3" value="<?=$end_date[2]?>">일
            <input type="text" name="end_hour" id="end_hour" size="3" value="<?=$end_time[0]?>">시
            <input type="text" name="end_minute" id="end_minute" size="3" value="<?=$end_time[1]?>">분
        </td>
    </tr>
    <tr>
        <td class="title">출발지역</td>
        <td class="cont">
            <select name="sch_departure_area">
                <?php
                foreach ($tour_air_area as $area){
                    $area_name = explode("|",$area);
                    if($row_air['reserv_air_departure_area']==$area_name[0]){$chk_area = "selected";}else{$chk_area = "";}
                    echo "<option value='{$area_name[0]}' {$chk_area}>{$area_name[0]}</option>";
                }
                ?>
            </select> → 제주
        </td>
        <td class="title">리턴지역</td>
        <td class="cont">
            제주 → <select name="sch_arrival_area">
                <?php
                foreach ($tour_air_area as $area){
                    $area_name = explode("|",$area);
                    echo "<option value='{$area_name[0]}' {$chk_are}>{$area_name[0]}</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="title">출발항공사</td>
        <td class="cont" >
            <select name='start_airline'>
                <?php
                foreach ($result_airline as $airline){
                   echo "<option value='{$airline}' {$chk_airline}>{$airline}</option>";
                }
                ?>
            </select>
        </td>
        <td class="title">리턴항공사</td>
        <td class="cont" >
            <select name='end_airline'>
                <?php
                foreach ($result_airline as $airline){
                    echo "<option value='{$airline}' {$chk_airline}>{$airline}</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="title">출발에이전시</td>
        <td class="cont" >
            <select name='start_company'>
             <?php
            foreach ($result_company as $company){
                echo "<option value='{$company}'>{$company}</option>";
            }
            ?>
            </select>
        </td>
        <td class="title">리턴에이전시</td>
        <td class="cont" >
            <select name='end_company'>
            <?php
            foreach ($result_company as $company){
                echo "<option value='{$company}'>{$company}</option>";
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="title">인원</td>
        <td class="cont" colspan="3">성인<input type="text" name="adult_number" id="adult_number" size="3" value="<?=$row_reserv['reserv_adult_number']?>"> 소아<input type="text" name="child_number" id="child_number" size="3" value="<?=$row_reserv['reserv_child_number']?>"> 유아<input type="text" name="baby_number" id="baby_number" size="3" value="<?=$row_reserv['reserv_baby_number']?>"></td>
    </tr>
    <tr>
        <td class="title">판매할인율</td>
        <td class="cont">성인 <input type="text" name="reserv_air_adult_sale" id="reserv_air_adult_sale" size="2" value="">% 소아 <input type="text" name="reserv_air_child_sale" id="reserv_air_child_sale" size="2" value="">%
        </td>
        <td class="title">입금할인율</td>
        <td class="cont">성인 <input type="text" name="reserv_air_adult_deposit_sale" id="reserv_air_adult_deposit_sale" size="2" value="">% 소아 <input type="text" name="reserv_air_child_deposit_sale" id="reserv_air_child_deposit_sale" size="2" value="">%
        </td>
    </tr>
    <tr>
        <td class="title">총 금액</td>
        <td class="cont"><input type="text" name="reserv_total_price" id="reserv_total_price" size="10" value="">원
        </td>
        <td class="title">총입금액</td>
        <td class="cont"><input type="text" name="reserv_total_deposit_price" id="reserv_total_deposit_price" size="10" value="">원
        </td>
    </tr>
    <tr>
        <td class="title">정상금액</td>
        <td class="cont" colspan="3">성인<input type="text" name="reserv_normal_adult_price" id="reserv_normal_adult_price" size="10" value=""> 소아 <input type="text" name="reserv_normal_child_price" id="reserv_normal_child_price" size="10" value=""> </td>
    </tr>

</table>