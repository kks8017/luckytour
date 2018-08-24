<?php include "../inc/header.sub.php"; ?>
<?php
$start_date = date("Y-m-d",time());
?>
<br>
<br>
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
                <input id="start_date" type="text" name="start_date" value="<?=$start_date?>" >
                <input type="hidden" id="end_date" value="">
            </td>
            <td class="select-title">
                숙박일정
            </td>
            <td class="select-title-span">
                <span class="place"></span>
            </td>
            <td class="select-text" style="border-right: 1px solid #848484;">
                <select name="stay">
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
                <input type="text" value="1" id="adult_number" name="adult_number"  />
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
                <input type="text" value="0" id="child_number" name="child_number" />
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
                <input type="text" value="0" id="baby_number"  name="baby_number" />
                <button id="b_up" class="up" ></button>
            </td>

        </tr>
	</table>

</div>

<div class="button-summit-area">
	<button class="button-summit" onclick="tel_list();" type="summit">숙소 검색</button>
</div>


<div id="lodge_list"  class="select-tel-list">

</div>

<?php include "css/pop_style.css" ?>
<!--레이어 팝업 시작 -->
 <div id="pop" style="display:none;">

  </div>
<!--레이어 팝업 끝 -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<!--레이어 팝업 제이쿼리 -->
 <script type="text/javascript">
     function tel_list() {
         var url = "../list/list_tel.php"; // the script where you handle the form input.
         $.ajax({
             type: "POST",
             url: url,
             data: $("#tel_frm").serialize()+"&start_date="+$("#start_date").val()+"&adult_number="+$("#adult_number").val()+"&child_number="+$("#child_number").val()+"&baby_number="+$("#baby_number").val()+"&package_type=T&tel_stay="+$("select[name=stay]").val()+"&area="+$("select[name=tel_area]").val()+"&type="+$("select[name=tel_type]").val()+"&case=dan", // serializes the form's elements.
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
             data: "tel_no="+tel_no+"&start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("#adult_number").val()+"&child_number="+$("#child_number").val()+"&baby_number="+$("#baby_number").val()+"&package_type=T&tel_stay="+$("select[name=stay]").val()+"&room_vehicle="+$("select[name=room_vehicle]").val()+"&case=dan", // serializes the form's elements.
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