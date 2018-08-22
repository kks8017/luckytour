<?php include "../inc/header.sub.php"; ?>

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
$air_no = $_REQUEST['air_no'];
$package_type = $_REQUEST['package_type'];
$company_no = $_REQUEST['company_no'];
if($_REQUEST['adult_number']==""){$adult_number = 1;}else{$adult_number = $_REQUEST['adult_number'] ;}
if($_REQUEST['child_number']==""){$child_number = 0;}else{$child_number = $_REQUEST['child_number'] ;}
if($_REQUEST['baby_number']==""){$baby_number = 0;}else{$baby_number = $_REQUEST['baby_number'] ;}

if($air_no){

    $air = new air();
    $air->air_no = $company_no;
    $air_list = $air->air_selected();
    $start_time = explode(":", $air_list['a_sch_departure_time']);
    $end_time = explode(":", $air_list['a_sch_arrival_time']);
    $main->sdate = $air_list['a_sch_departure_date'];
    $s_week = $main->week();
    $main->sdate = $air_list['a_sch_arrival_date'];
    $e_week = $main->week();
    $ddy = ( strtotime($air_list['a_sch_arrival_date']) - strtotime($air_list['a_sch_departure_date']) ) / 86400;


?>
<div class="item-select">
	<table class="item-select">
		<tr>
			<td class="title">[<?=$air_list['a_sch_departure_airline_name']?>]</td>
			<td class="text">
				김포출발 <?=substr($air_list['a_sch_departure_date'],6,5)?>(<?=$s_week?>) <span class="black"><?=$start_time[0]?>:<?=$start_time[1]?></span><br>
				제주출발 <?=substr($air_list['a_sch_arrival_date'],6,5)?>(<?=$e_week?>) <span class="black"><?=$end_time[0]?>:<?=$end_time[1]?></span>
			</td>
		</tr>
	</table>
</div>
<?}

if(!$start_date){$start_date=date("Y-m-d",time());}
?>
<div class="select-table">
	<table>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
			</td>
			<td class="select-title">
				출발일 -
			</td>
			<td class="select-text" >
				<input id="tel_start_date" type="text" value="<?=$start_date?>" >
			</td>
            <td class="select-title">
                숙박일정
            </td>
            <td class="select-title-span">
                <span class="place"></span>
            </td>
            <td class="select-text" style="border-right: 1px solid #848484;">
                <select name="tel_stay">
                    <?php
                    $main->stay_option($ddy);
                    ?>
                </select>
            </td>
		</tr>
		<tr>
            <td class="select-title-span">
                <span class="calendar"></span>
            </td>
			<td class="select-title">
					숙소유형
			</td>
			<td class="select-text" >
				<select name="tel_type">
                    <?php
                        $main->lodging_type_list();
                    ?>
				</select>
			</td>
            <td class="select-title">
                지역권
            </td>
            <td class="select-title-span">
                <span class="place"></span>
            </td>
            <td class="select-text" >
                <select name="tel_area">
                    <?php
                    $main->lodging_area_list();
                    ?>
                </select>
            </td>
		</tr>
        <tr>
            <td class="select-title-span">
                <span class="person"></span>
            </td>
            <td class="select-title">
                성인
            </td>
            <td class="select-text-count" style="border-right: 1px solid #848484;">
                <button id="a_down" class="down"></button>
                <input type="text" value="<?=$adult_number?>" id="adult_number" name="adult_number"  />
                <button id="a_up" class="up" ></button>
            </td>
            <td class="select-title-span">
                <span class="baby"></span>
            </td>
            <td class="select-title">
                소아
            </td>
            <td class="select-text-count">
                <button id="c_down" class="down"></button>
                <input type="text" value="<?=$child_number?>" id="child_number" name="child_number" />
                <button id="c_up" class="up" ></button>
            </td>
        </tr>
        <tr>
            <td class="select-title-span">
                <span class="person"></span>
            </td>
            <td class="select-title">
                유아
            </td>
            <td class="select-text-count" style="border-right: 1px solid #848484;">
                <button id="b_down" class="down"></button>
                <input type="text" value="<?=$baby_number?>" id="baby_number"  name="baby_number" />
                <button id="b_up" class="up" ></button>
            </td>

        </tr>
	</table>

</div>

<div id="lodge_list" class="select-tel-list">

</div>

<?php include "css/pop_style.css" ?>
<!--레이어 팝업 시작 -->
 <div id="pop" style="display:none;">

 </div>
<!--레이어 팝업 끝 -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script>
        function tel_list() {
            var url = "../list/list_tel.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#tel_frm").serialize()+"&start_date="+$("#tel_start_date").val()+"&adult_number="+$("#adult_number").val()+"&child_number="+$("#child_number").val()+"&baby_number="+$("#baby_number").val()+"&package_type=<?=$package_type?>&tel_stay="+$("select[name=tel_stay]").val(), // serializes the form's elements.
                success: function (data) {
                    $("#lodge_list").html(data); // show response from the php script.
                 //   console.log(data);
                },
                beforeSend: function () {
                    //  wrapWindowByMask();
                },
                complete: function () {
                    //   closeWindowByMask();
                }
            });
        }
        function room_list(tel_no) {
            var url = "../list/list_room.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "air_no=<?=$company_no?>&air_start_date=<?=$air_list['a_sch_departure_date']?>&tel_no="+tel_no+"&start_date="+$("#tel_start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("#adult_number").val()+"&child_number="+$("#child_number").val()+"&baby_number="+$("#baby_number").val()+"&package_type=<?=$package_type?>&tel_stay="+$("select[name=tel_stay]").val()+"&room_vehicle="+$("select[name=room_vehicle]").val(), // serializes the form's elements.
                success: function (data) {
                    $("#pop").html(data); // show response from the php script.
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
     function room_layer(tel_no) {
         $('#pop').show();
         room_list(tel_no);
     }
     function room_hide_layer() {
          $('#pop').hide();
     }
     $(document).ready(function () {
         $("#a_up").on("click",function(){
             var num = $("#adult_number").val();
             num = Number(num) + 1;
             if(num==100){

             }else {
                 $("#adult_number").val(num);
             }
         });
         $("#a_down").on("click",function(){
             var num = $("#adult_number").val();
             num = Number(num) - 1;
             if(num < 1){

             }else {
                 $("#adult_number").val(num);
             }
         });
         $("#c_up").on("click",function(){
             var num = $("#child_number").val();
             num = Number(num) + 1;
             if(num==100){

             }else {
                 $("#child_number").val(num);
             }

         });
         $("#c_down").on("click",function(){
             var num = $("#adult_number").val();
             num = Number(num) - 1;
             if(num < 0){

             }else {
                 $("#child_number").val(num);
             }

         });
         $("#b_up").on("click",function(){
             var num = $("#baby_unmber").val();
             num = Number(num) + 1;
             if(num==100){

             }else {
                 $("#baby_unmber").val(num);
             }

         });
         $("#b_down").on("click",function(){
             var num = $("#baby_unmber").val();
             num = Number(num) - 1;
             if(num < 0){

             }else {
                 $("#baby_unmber").val(num);
             }

         });
     });
        tel_list();

 </script>

<!--탭메뉴 제이쿼리 -->




<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>