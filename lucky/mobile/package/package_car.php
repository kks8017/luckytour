<?php include "../inc/header.sub.php"; ?>
<?php
    print_r($_REQUEST);
?>
    <div class="sub-menu">
        <ul>
            <li class="sub-menu-title"><a href="package_list.php?package_type=ACT">항공+숙소+렌터카</a></li>
            <li class="sub-menu-title"><a href="package_list.php?package_type=AC">항공+렌터카</a></li>
            <li class="sub-menu-title"><a href="package_list.php?package_type=AT">항공+숙소</a></li>
            <li class="sub-menu-title"><a href="package_tel.php?package_type=CT">숙소+렌터카</a></li>
        </ul>
    </div>
<?php
$start_date = $_REQUEST['start_date'];
$tel_start_date = $_REQUEST['tel_start_date'];
$air_no = $_REQUEST['air_no'];
$tel_no = $_REQUEST['tel_no'];
$room_no = $_REQUEST['room_no'];
$room_vehicle = $_REQUEST['room_vehicle'];
$tel_stay = $_REQUEST['tel_stay'];
$package_type = $_REQUEST['package_type'];
$adult_number = $_REQUEST['adult_number'] ;
$child_number = $_REQUEST['child_number'];
$baby_number  = $_REQUEST['baby_number'];



if(!$air_no){
    $rent_start_date = $start_date;
    $rent_start_hour = "08";
    $rent_start_minute = "00";
    $rent_end_hour = "08";
    $rent_end_minute = "00";
}else{
    $air = new air();
    $air->air_no = $air_no;
    $air_list = $air->air_selected();
    $start_time = explode(":", $air_list['a_sch_departure_time']);
    $end_time = explode(":", $air_list['a_sch_arrival_time']);
    $main->sdate = $air_list['a_sch_departure_date'];
    $s_week = $main->week();
    $main->sdate = $air_list['a_sch_arrival_date'];
    $e_week = $main->week();

    $rent_start_date = $air_list['a_sch_departure_date'];
    $rent_end_date = $air_list['a_sch_arrival_date'];
    $rent_start_hour = $start_time[0] + 1;
    $rent_start_minute = $start_time[1];
    $rent_end_hour = $end_time[0]-1;
    $rent_end_minute = $end_time[1];
}
if(!$tel_no){

}else{
    $tel = new lodging();
    $tel->lodno = $tel_no;
    $tel->roomno = $room_no;
    $tel_list = $tel->lodging_room_name();
}


?>
<div class="item-select">
	<table class="item-select">
        <?if(strpos($package_type,"A")!== false){?>
        <tr>
            <td class="title">[<?=$air_list['a_sch_departure_airline_name']?>]</td>
            <td class="text">
                김포출발 <?=substr($air_list['a_sch_departure_date'],6,5)?>(<?=$s_week?>) <span class="black"><?=$start_time[0]?>:<?=$start_time[1]?></span><br>
                제주출발 <?=substr($air_list['a_sch_arrival_date'],6,5)?>(<?=$e_week?>) <span class="black"><?=$end_time[0]?>:<?=$end_time[1]?></span>
            </td>
        </tr>
        <?}?>
        <?if(strpos($package_type,"T")!==false){?>
		<tr>
			<td class="title">[<?=$tel_list[0]?>]</td>
			<td class="text">
				<?=$tel_list[0]?> <?=$room_vehicle?>실<br>
                <?=$tel_start_date?> 입실 / <span class="black"><?=$tel_stay?>박</span>
			</td>
		</tr>
        <?}?>
	</table>
</div>


<div class="select-table">
	<form id="rent_frm">
    <table>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
				인수일 -
					
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;font-size: 30px;">
				<input id="rent_start_date" name="rent_start_date" value="<?=$rent_start_date?>" type="text" >
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
				
					시간

			</td>
			<td class="select-text">
				<select name="start_hour" class="time"  onchange="car_list();">
                    <?php
                        $main->hour_option($rent_start_hour);
                    ?>
				</select>:
                <select name="start_minute" class="time"  onchange="car_list();">
                    <?php
                    $main->minute_option($rent_start_minute);
                    ?>
                </select>
			</td>
		</tr>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
			
					반납일 -
			
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;font-size: 30px;">
				<input id="rent_end_date" name="rent_end_date" value="<?=$rent_end_date?>" type="text" >
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
			
					시간
		
			</td>
			<td class="select-text">
				<select name="end_hour" class="time"  onchange="car_list();">
                    <?php
                           $main->hour_option($rent_end_hour);
                    ?>
				</select>
                <select name="end_minute" class="time"  onchange="car_list();">
                    <?php
                    $main->minute_option($rent_end_minute);
                    ?>
                </select>
			</td>
		</tr>
		<tr>
			<td class="select-title-span">
				<span class="car"></span>
					
			</td>
			<td class="select-title">
				차종			
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<select name="car_type" onchange="car_list();">
                    <?php
                        $main->rent_type_list("");
                    ?>
				</select>				
			</td>
            <td class="select-title-span">
                <span class="car"></span>

            </td>
            <td class="select-title">
                대수
            </td>
            <td class="select-text">
                <select name="rent_vehicle" onchange="car_list();">
                    <?php
                        $main->vehicle_option("","대");
                    ?>
                </select>
            </td>
		</tr>
	</table>
    </form>

</div>

<div id="rent_list" class="select-car-list">


</div>
<script>
    function car_list() {
        var url = "../list/list_rent.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#rent_frm").serialize()+"&package_type=<?=$package_type?>", // serializes the form's elements.
            success: function (data) {
                $("#rent_list").html(data); // show response from the php script.
                console.log(data);
            },
            beforeSend: function () {
                //  wrapWindowByMask();
            },
            complete: function () {
                //   closeWindowByMask();
            }
        });
    }
    function reservation(rent_no) {

        window.location.href = "../res/res_check.php?"+$("#rent_frm").serialize()+"&air_no=<?=$air_no?>&rent_no="+rent_no+"&start_date=<?=$start_date?>&tel_no=<?=$tel_no?>&room_no=<?=$room_no?>&tel_start_date=<?=$tel_start_date?>&tel_stay=<?=$tel_stay?>&room_vehicle=<?=$room_vehicle?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&package_type=<?=$package_type?>";

    }
    car_list();
</script>


<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>