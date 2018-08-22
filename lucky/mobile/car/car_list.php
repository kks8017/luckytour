<?php include "../inc/header.sub.php"; ?>
<?php
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}

$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));
?>
<br>
<br>
<div class="select-table">
    <form id="rent_frm" method="post">
	<table>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
				인수일
					
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<input id="start_date" name="rent_start_date" type="text"  value="<?=$start_date?>">
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
				
					시간

			</td>
			<td class="select-text">
				<select name="start_hour" class="time">
                    <?php
                        $main->hour_option("08");
                    ?>
                </select>:
                <select  name="start_minute" class="time">
                    <?php
                        $main->minute_option("00");
                    ?>
                </select>
			</td>
		</tr>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
			
					반납일 
			
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<input id="end_date" name="rent_end_date" type="text" value="<?=$end_date?>" >
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
			
					시간
		
			</td>
			<td class="select-text">
				<select name="end_hour" class="time">
                    <?php
                    $main->hour_option("08");
                    ?>
				</select>:
                <select name="end_minute" class="time">
                    <?php
                    $main->minute_option("00");
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
			<td class="select-text" >
				<select name="car_type">
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
                <select name="rent_vehicle" >
                    <?php
                    $main->vehicle_option("","대");
                    ?>
                </select>
            </td>
		</tr>
	</table>
    </form>
</div>

<div class="button-summit-area">
	<button class="button-summit" onclick="car_list();" type="summit">렌터카 검색</button>
</div>


<div id="rent_list" class="select-car-list">

</div>
    <script>
        function car_list() {
            var url = "../list/list_rent.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                    data: $("#rent_frm").serialize()+"&package_type=C", // serializes the form's elements.
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

            window.location.href = "../res/res_check.php?"+$("#rent_frm").serialize()+"&start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&rent_no="+rent_no+"&package_type=C";

        }
        car_list();
    </script>
<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>