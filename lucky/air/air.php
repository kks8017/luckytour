<?php include_once ("../header.sub.php");?>

<?php
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$start_area = $_POST['start_area'];
$adult_number = $_POST['adult_number'];
$child_number = $_POST['child_number'];
$baby_number = $_POST['baby_number'];


if(!$start_date) {
    $start_date = date("Y-m-d",time());
}
if(!$end_date) {
    $end_date = date("Y-m-d", strtotime($start_date . " +1 days"));
}
if($start_area==""){
    $start_area = "김포";
}
$tour_air_area = explode(",",$main_company['tour_air_area']);
$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}

?>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar mar"></span>
            <h3>항공</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
        <div class="search_bar">
            <form id="air_frm" action="#" method="POST" >
                <ul>
                    <li><p>가는날</p><input type="text" name="start_date" id="start_date" class="air_date" value="<?=$start_date?>" style="vertical-align:top"/></li>
                    <li><p>오는날</p><input type="text" name="end_date" id="end_date" class="air_date" value="<?=$end_date?>" style="vertical-align:top"/></li>
                    <li><p>출발지</p><select name="start_area" class="lsel">
                            <?php
                            foreach ($tour_air_area as $area){
                                $area_name = explode("|",$area);
                                if($area_name[0]==$start_area){$sel="selected";}else{$sel="";}
                                echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}</option>";
                            }
                            ?>
                        </select></li>
                    <li><p>성인<span class="sp">만 13세이상</span></p><select name="adult_number" class="lsel">
                            <?for($i=1;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($adult_number==$i){?>selected<?}?>><?=$i?>명</option>
                            <?}?>
                        </select></li>
                    <li><p>소아<span class="sp">만 12세이하</span></p><select name="child_number" class="lsel">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($child_number==$i){?>selected<?}?>><?=$i?>명</option>
                            <?}?>
                        </select></li>
                    <li><p>유아<span>만 24개월미만</span></p><select name="baby_number" class="lsel">
                            <?for($i=0;$i < 100;$i++){?>
                                <option value="<?=$i?>" <?if($baby_number==$i){?>selected<?}?>><?=$i?>명</option>
                            <?}?>
                        </select></li>
                    <li>

                </ul>
            </form>
            <div class="btn"><img type="button"  src="../sub_img/big_search_btn.png"  onclick="schedule(1,'time');"/></div>
        </div>
    </div>

    <div class="package_tabmenu">

        <div class="area">
            <div class="event">

                    <!-- <p>시간대 : <label><input type="radio" name="time" value="0" onclick="schedule(1,'time');" checked>전체</label>
                                    <label><input type="radio" name="time" value="1" onclick="schedule(1,'time');">6:00~7:59</label>
                                    <label><input type="radio" name="time" value="2" onclick="schedule(1,'time');">8:00~9:59</label>
                                    <label><input type="radio" name="time" value="3" onclick="schedule(1,'time');">10:00~11:59</label>
                                    <label><input type="radio" name="time" value="4" onclick="schedule(1,'time');">12:00~13:59</label>
                                    <label><input type="radio" name="time" value="5" onclick="schedule(1,'time');">14:00~17:59</label>
                                    <label><input type="radio" name="time" value="6" onclick="schedule(1,'time');">18:00~21:59</label>
                                </p>
                                <p> 할인율 :  <label><input type="radio" name="sale" value="0" checked>전체</label>
                                    <label><input type="radio" name="sale" value="1">50%이상</label>
                                    <label><input type="radio" name="sale" value="2">30~40%</label>
                                    <label><input type="radio" name="sale" value="3">20~29%</label>
                                    <label><input type="radio" name="sale" value="4">10~19%</label>
                                    <label><input type="radio" name="sale" value="5">0~9%</label>
                                </p>
                                <p>항공사 :
                                    <input type='radio' name='start_airline' value='' checked>전체
                                    <?php
                    foreach ($result_airline as $airline){

                        echo "<input type='radio' name='start_airline' value='{$airline}'> {$airline}";
                    }
                    ?>
                                </p>-->
                <div class="event">
                    <p>시간대&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="time" value="0" onclick="schedule(1,'time');" checked><b>전체</b>
                        <input type="radio" name="time" value="1" onclick="schedule(1,'time');"><b>6:00~7:59</b>
                        <input type="radio" name="time" value="2" onclick="schedule(1,'time');"><b>8:00~9:59</b>
                        <input type="radio" name="time"  value="3" onclick="schedule(1,'time');"><b>10:00~11:59</b>
                        <input type="radio" name="time" value="4" onclick="schedule(1,'time');"><b>12:00~13:59</b>
                        <input type="radio" name="time" value="5" onclick="schedule(1,'time');"><b>14:00~17:59</b>
                        <input type="radio" name="time" value="6" onclick="schedule(1,'time');"><b>18:00~21:59</b>
                    </p>
                </div>
                <div class="event">
                    <p>할인율&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="sale" value="0" onclick="schedule(1,'time');" checked><b>전체</b>
                        <input type="radio" name="sale" value="1" onclick="schedule(1,'time');"><b>50% 이상</b>
                        <input type="radio" name="sale" value="2" onclick="schedule(1,'time');"><b>30%~40%</b>
                        <input type="radio" name="sale" value="3" onclick="schedule(1,'time');"><b>20%~29%</b>
                        <input type="radio" name="sale" value="4" onclick="schedule(1,'time');"><b>10%~19%</b>
                        <input type="radio" name="sale" value="5" onclick="schedule(1,'time');"><b>0%~9%</b>
                    </p>
                </div>
                <div class="event">
                    <p>항공사
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="start_airline" value="" onclick="schedule(1,'time');" checked><b>전체</b>
                        <?php
                        foreach ($result_airline as $airline){

                            echo "<input type='radio' name='start_airline' value='{$airline}' onclick=\"schedule(1,'time');\"><b>{$airline}</b>";
                        }
                        ?>&nbsp;&nbsp;&nbsp;
                    </p>
                </div>
            </div>

            <div class="air_area">
                <table id="air_schedule" style="width:1200px">
                    <tr>
                        <th width="100px">항공사</th>
                        <th width="150px"><span id="s_area"></span>출발일자</th>
                        <th width="150px"><span >제주</span>출발일자</th>
                        <th width="100px">여행일정</th>
                        <th width="100px">1인정상가</th>
                        <th width="100px">할인율</th>
                        <th width="100px">인원</th>
                        <th width="100px">할인가</th>
                        <th width="200px">기타사항</th>
                        <th width="100px">예약</th>
                    </tr>
                </table>
            </div>
            <table style="width:1200px">
                <tr>
                    <td align="center"><img src="../sub_img/air_more.gif" type="button" id="page" style="cursor: pointer;" ></td>
                </tr>
            </table>
        </div>
    </div>

</div><!-- content 끝 -->
<form id="air_real_frm" action="../member/login_reservation.php">
    <input type="hidden" name="air_no" id="airno" value="">
    <input type="hidden" name="air_company_no" id="air_company_no" value="">
    <input type="hidden" name="package_type" id="package_type" value="A">
    <input type="hidden" name="start_date" id="sdate" value="">
    <input type="hidden" name="end_date" id="edate" value="">
    <input type="hidden" name="adult_number" id="adult_number" value="">
    <input type="hidden" name="child_number" id="child_number" value="">
    <input type="hidden" name="baby_number" id="baby_number" value="">
    <input type="hidden" name="air_type" id="air_type" value="">
</form>
<script>
    function reservation(i) {
     //   console.log($("#air_frm").serialize());
        $("#sdate").val($("#air_departure_date_"+i).val());
        $("#edate").val($("#air_arrival_date_"+i).val());
        $("#adult_number").val($("select[name=adult_number]").val());
        $("#child_number").val($("select[name=child_number]").val());
        $("#baby_number").val($("select[name=baby_number]").val());
        $("#air_type").val($("#air_type_"+i).val());
        $("#airno").val($("#air_no_"+i).val());
        $("#air_company_no").val($("#air_company_no_"+i).val());
        $("#air_real_frm").submit();

    }
    function schedule(pagenum,re) {
        $("#s_area").html($("select[name=start_area]").val());
        var url = "../list/air_list.php"; // the script where you handle the form input.
        if(re=="time"){ is_init = true; $(".odd").remove();pagenum=1;  }

        if(pagenum==1){  var pagenum2 = 0;}else{var pagenum2 = pagenum -1;}

        $.ajax({
            type: "POST",
            url: url,
            data: "start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&package="+$("select[name=package]").val()+"&area="+$("select[name=start_area]").val()+"&start_airline="+$("input[name=start_airline]:checked").val()+"&time="+$( 'input[name=time]:checked' ).val()+"&sale="+$( 'input[name=sale]:checked' ).val()+"&pagenum="+pagenum2+"&case=dan", // serializes the form's elements.
            success: function (data) {

                $("#air_schedule").append(data); // show response from the php script.
              console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask('../sub_img/air_loding.gif');
            },
            complete: function () {
                   closeWindowByMask();
            }
        });
    }
    var reloadCount = 1;
    var pagenum = 1;
    var is_init = false;
    $(document).ready(function () {

        $("#page").click(function () {

            if (is_init) {
                is_init = false;
                pagenum = 1;
                return;
            }
            pagenum += 1;
            schedule(pagenum, '');
        });
        $("#s_area").html($("select[name=start_area]").val());
        schedule(1,"");

    });
    $( function() {
        var dates =   $( "#start_date, #end_date" ).datepicker({
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

<?php include_once ("../footer.php");?>