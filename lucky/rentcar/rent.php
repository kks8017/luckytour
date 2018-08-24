<?php include_once ("../header.sub.php");?>

<?php
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$start_hour = $_POST['start_hour'];
$start_minute = $_POST['start_minute'];
$end_hour = $_POST['end_hour'];
$end_minute = $_POST['end_minute'];
$rent_type  = $_POST['rent_type'];
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}
if(!$end_date) {
    $end_date = date("Y-m-d", strtotime($start_date . " +1 days"));
}
if(!$start_hour){$start_hour="08";}
if(!$end_hour){$end_hour="08";}
?>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar mar"></span>
            <h3>렌트카</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
    </div>

    <div class="package_tabmenu">
        <div class="area">
            <div class="rent">
                <div class="rent_search">
                    <form id="rent_frm">
                        <div class="event">
                            <p>일반차량 <select name="rent_type" class="sel">
                                    <?php
                                    $main->rent_type_list($rent_type);
                                    ?>
                                </select>
                                <!--  금연차량 <select class="sel">
                                      <option value="0">경차(금연)</option>
                                      <option value="1">중소형(금연)</option>
                                      <option value="2">중형(금연)</option>
                                      <option value="3">고급(금연)</option>
                                      <option value="4">수입/스포츠(금연)</option>
                                      <option value="5">RV(금연)</option>
                                      <option value="6">승합/대형(금연)</option>
                                  </select>이벤트차량 <select class="lsel">
                                      <option value="0">무료 업그레이드 이벤트</option>
                                      <option value="1">이벤트1</option>
                                      <option value="2">이벤트2</option>
                                      <option value="3">이벤트3</option>
                                  </select>--></p>
                        </div>
                        <div class="search">
                            <p><span class="head">인수/반납시간</span> <input type="text" name="rent_start_date" id="rent_start_date" value="<?=$start_date?>" class="air_date"  /> <select name="start_hour" class="ssel" onchange="time_sum();">
                                    <?php
                                    $main->hour_option($start_hour);
                                    ?>
                                </select>
                                <select name="start_minute" class="ssel" onchange="time_sum();">
                                    <?php
                                    $main->minute_option($start_minute);
                                    ?>
                                </select>
                                <span style="position:relative;left:-7px">~</span>
                                <input type="text" name="rent_end_date" class="air_date" id="rent_end_date" value="<?=$end_date?>"  /> <select name="end_hour" class="ssel" onchange="time_sum();">
                                    <?php
                                    $main->hour_option($end_hour);
                                    ?>
                                </select>
                                <select name="end_minute" class="ssel">
                                    <?php
                                    $main->minute_option($end_minute);
                                    ?>
                                </select>
                                <input type="text" name="time" id="time" value="" class="stext" />시간
                                <span style="position:relative;left:30px;font-weight:bold">차량대수</span>
                                <select name="rent_vehicle" class="ssel" style="position:relative;left:30px">
                                    <?php
                                    $main->vehicle_option("","대");
                                    ?>
                                </select>
                            <div class="btn"><img type="button" id="rent_sch_btn" src="../sub_img/big_search_btn.png" /></div>
                        </div>
                    </form>
                </div>
                <div class="car_list">
                    <ul id="car_list">
                    </ul>
                </div>
            </div>
        </div>

    </div><!-- content 끝 -->
    <form id="rent_real_frm" method="post" action="../member/login_reservation.php">
        <input type="hidden" name="car_no" id="carno" value="">
        <input type="hidden" name="car_sdate" id="car_sdate" value="">
        <input type="hidden" name="car_edate" id="car_edate" value="">
        <input type="hidden" name="car_stime" id="car_stime" value="">
        <input type="hidden" name="car_etime" id="car_etime" value="">
        <input type="hidden" name="car_vehicle" id="car_vehicle" value="">
        <input type="hidden" name="package_type" id="package_type" value="C">

    </form>
    <script>
        function reservation(i) {
            //   console.log($("#air_frm").serialize());
            $("#carno").val($("#car_no_"+i).val());
            $("#car_sdate").val($("#car_sdate_"+i).val());
            $("#car_edate").val($("#car_edate_"+i).val());
            $("#car_stime").val($("#car_stime_"+i).val());
            $("#car_etime").val($("#car_etime_"+i).val());
            $("#car_vehicle").val($("#car_vehicle_"+i).val());
            $("#rent_real_frm").submit();

        }
        function time_sum() {
            var date_s1 = $('#rent_start_date').val();
            var date_e1 = $('#rent_end_date').val();
            var hour_s1 = $("select[name=start_hour]").val();
            var minute_s1 = $("select[name=start_minute]").val();
            var hour_e1 = $("select[name=end_hour]").val();
            var minute_e1 = $("select[name=end_minute]").val();
            var date_s = date_s1.split("-");
            var date_e = date_e1.split("-");

            var y1=eval(date_s[0]);
            var m1=eval(date_s[1]);
            var d1=eval(date_s[2]);
            var h1=eval(hour_s1);
            var i1=eval(minute_s1);

            var y2=eval(date_e[0]);
            var m2=eval(date_e[1]);
            var d2=eval(date_e[2]);
            var h2=eval(hour_e1);
            var i2=eval(minute_e1);
            var m1 = m1 - 1;
            var m2 = m2 - 1;
            //today=new Date();
            var day1=new Date(y1,m1,d1,h1,i1,0,0);
            var day2=new Date(y2,m2,d2,h2,i2,0,0);

            //todate=today.getTime()-60*60*24*1000;
            var date1=day1.getTime();
            var date2=day2.getTime();

            var term = Math.ceil((date2-date1)/60/60/1000);
            $("#time").val(term);
            return term;

        }
        function car_list() {
            var url = "../list/car_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_frm").serialize()+"&case=dan", // serializes the form's elements.
                success: function (data) {
                    $("#car_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {
                    wrapWindowByMask('../sub_img/rent_loding.gif');
                },
                complete: function () {
                    closeWindowByMask();
                }
            });
        }
        $(document).ready(function () {
           time_sum();
           car_list();
           $("#rent_sch_btn").click(function () {
               car_list();
           });


        });
        $( function() {
         var dates =   $( "#rent_start_date, #rent_end_date" ).datepicker({
                prevText: '이전 달',
                nextText: '다음 달',
                monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                dayNames: ['일','월','화','수','목','금','토'],
                dayNamesShort: ['일','월','화','수','목','금','토'],
                dayNamesMin: ['일','월','화','수','목','금','토'],
                numberOfMonths: 2,
                dateFormat : "yy-mm-dd",
                showOn : "both",
                buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
                buttonImageOnly : true,
                yearSuffix: '년',
                showMonthAfterYear: true,
                minDate : 0,
                maxDate:'+10950d',
                onSelect:function(selectedDate) {
                    time_sum();
                    var option = this.id == "rent_start_date" ? "minDate" : "maxDate",
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
    <?php include_once ("../footer.php");?>
