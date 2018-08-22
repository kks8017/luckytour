<?php include_once ("../header.sub.php");?>

<?php
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$adult_number = $_POST['adult_number'];
$child_number = $_POST['child_number'];
$baby_number = $_POST['baby_number'];
$package_type = $_POST['package_type'];
$start_area = $_POST['start_area'];
$bus_stay = $_POST['bus_stay'] -1;
$bus_type = $_POST['bus_type'];
$bus_vehicle = $_POST['bus_vehicle'];
$page =$_GET['page'];
if($start_area==""){
    $start_area = "김포";
}
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}

if(!$end_date) {
    if($page=="bus"){
        if(!$bus_stay) {
            $end_date = date("Y-m-d", strtotime($start_date . " +{$bus_stay} days"));
        }else{
            $end_date = date("Y-m-d", strtotime($start_date . " +1 days"));
        }
    }else {
        $end_date = date("Y-m-d", strtotime($start_date . " +1 days"));
    }
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
                <?if($page=="bus"){?>
                    <h3>버스여행패키지</h3>
                <?}else if($page=="golf"){?>
                    <h3>골프여행패키지</h3>
                <?}else{?>
                    <h3>자유여행패키지</h3>
                <?}?>
                <span class="bar"></span>
                <!-- <img src="./image/bar2.png" />-->
            </div>
            <div class="search_bar">
                <form action="#" method="POST" >
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
                        <?php
                        if($page=="bus"){
                        ?>
                            <li><p>여행상품선택</p><select name="package" class="lsel2">
                                    <option value="ABT"  <?if($package_type=="ABT"){?>selected<?}?>>할인항공+숙소+버스/택시</option>
                                    <option value="AB"  <?if($package_type=="AB"){?>selected<?}?>>할인항공+버스/택시</option>
                                    <option value="BT"  <?if($package_type=="BT"){?>selected<?}?>>숙소+버스/택시</option>
                                    <option value="B"  <?if($package_type=="B"){?>selected<?}?>>버스/택시</option>
                                </select></li>
                        <?}else if($page=="golf"){?>
                            <li><p>여행상품선택</p><select name="package" class="lsel2">
                                    <option value="ACTG">할인항공+숙소+렌트+골프</option>
                                    <option value="ATG">할인항공+숙소+골프</option>
                                    <option value="ACG">할인항공+렌트+골프</option>
                                    <option value="CTG">숙소+렌트+골프</option>
                                    <option value="AG">할인항공+골프</option>
                                    <option value="CG">렌트+골프</option>
                                    <option value="TG">숙소+골프</option>
                                    <option value="G">골프</option>
                                </select></li>
                        <?
                        }else{
                        ?>
                        <li><p>여행상품선택</p><select name="package" class="lsel2">
                                <option value="ACT" <?if($package_type=="ACT"){?>selected<?}?>>할인항공+숙소+렌트카</option>
                                <option value="AT"  <?if($package_type=="AT"){?>selected<?}?>>할인항공+숙소</option>
                                <option value="AC"  <?if($package_type=="AC"){?>selected<?}?>>할인항공+렌트카</option>
                                <option value="CT"  <?if($package_type=="CT"){?>selected<?}?>>숙소+렌트카</option>
                            </select></li>
                        <?}?>
                        <li></li>

                    </ul>
                </form>
                <div class="btn"><img type="buttom" id="package_sch_btn" src="../sub_img/big_search_btn.png" /></div>
            </div>

        </div>
        <div class="search_list">
            <div class="tit"><h4><img src="../sub_img/choice_arrow.png" /> 선택하신 내역입니다.</h4></div>
            <div>
                <form id="package_frm" method="post" action="../member/login_reservation.php">
                <table class="table_list">
                    <tr>
                        <th>
                            <span class="gray">여행일정 및</span><span class="b">인원<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td>
                            <p class="data"><span id="d_day" class="blue">2018-05-01(목)</span><span class="txt">부터</span><span id="sty" class="blue">&nbsp;2박</span><span id="number" class="txt">(성인2,&nbsp;소인0,&nbsp;유아0)</span></p>
                        </td>
                    </tr>
                    <tr id="air_content">
                        <th>
                            <span class="gray">내가 선택한</span><span class="b">항공<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td id="air_selected_content">
                            <p class="data" ><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>
                        </td>
                    </tr>
                    <tr id="tel_content">
                        <th>
                            <span class="gray">내가 선택한</span><span class="b">숙소<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td id="tel_selected_content">
                            <p class="data"><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></a></p>
                        </td>
                    </tr>
                    <?php if($page=="bus"){ ?>
                        <tr id="bus_content">
                            <th>
                                <span class="gray">내가 선택한</span><span class="b">버스/택시<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                            </th>
                            <td id="bus_selected_content">
                                <p  class="data"><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>
                            </td>
                        </tr>
                    <?}else{?>
                    <tr id="rent_content">
                        <th>
                            <span class="gray">내가 선택한</span><span class="b">렌터카<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td id="rent_selected_content">
                            <p  class="data"><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span> </p>
                        </td>
                    </tr>
                    <?}?>
                    <?php if($page=="golf"){ ?>
                    <tr id="golf_content">
                        <th>
                            <span class="gray">내가 선택한</span><span class="b">골프<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td id='golf_selected_content'>
                           <p  class="data" ><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span</p>
                        </td>
                    </tr>
                    <?}?>
                </table>
                <input type="hidden" name="start_date" id="s_date" value="">
                <input type="hidden" name="end_date" id="e_date" value="">
                <input type="hidden" name="adult_number" id="adult_number" value="">
                <input type="hidden" name="child_number" id="child_number" value="">
                <input type="hidden" name="baby_number" id="baby_number" value="">
                <input type="hidden" name="package_type" id="package_type" value="">
                </form>
            </div>
            <div class="total_price">
                <p><span>총 금액</span><span id="total">0원</span><img type="button" id="reserv_btn" onclick="reservation();" src="../sub_img/pkg_reserve_btn.png"  /></p>
            </div>
        </div> <!-- search_list 끝 -->

        <div class="package_tabmenu">
            <ul class="tab">
                
              
                <?php if($page=="bus"){ ?>
                    <li id="air_tab" class="select"><p><a href="#none" class="air">항공</a></p></li>
                    <li id="lod_tab"><p><a href="#none" class="lodge">숙박</a></p></li>
                    <li id="bus_tab"><p><a href="#none" class="bus">버스/택시</a></p></li>
                <?}else if($page=="golf"){?>
                    <li id="air_tab" class="select"><p><a href="#none" class="air">항공</a></p></li>
                    <li id="golf_tab"><p><a href="#none" class="golf">골프</a></p></li>
                    <li id="lod_tab"><p><a href="#none" class="lodge">숙박</a></p></li>
                    <li id="rent_tab"><p><a href="#none" class="rent">렌트카</a></p></li>
                <?}else{?>
                    <li id="air_tab" class="select"><p><a href="#none" class="air">항공</a></p></li>
                    <li id="lod_tab"><p><a href="#none" class="lodge">숙박</a></p></li>
                    <li id="rent_tab"><p><a href="#none" class="rent">렌트카</a></p></li>
                <?}?>

              
               
            </ul>
            <div class="area">
                <div class="air_area">
                    <div class="air_search">
                        <form id="air_frm" method="POST"action="#">
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
                                <!--
                                <p>시간대&nbsp;&nbsp;&nbsp;
                                    <select class="psel" name="time" onchange="schedule(1,'time');">
                                        <option value="0">전체</option>
                                        <option value="1">6:00~7:59</option>
                                        <option value="2">8:00~9:59</option>
                                        <option value="3">10:00~11:59</option>
                                        <option value="4">12:00~13:59</option>
                                        <option value="5">14:00~17:59</option>
                                        <option value="6">18:00~21:59</option>
                                    </select></p>
                                <p>할인율&nbsp;&nbsp;&nbsp;
                                    <select class="psel" onchange="schedule(1,'time');" name="sale">
                                        <option value="0">전체</option>
                                        <option value="1">50%이상</option>
                                        <option value="2">30~40%</option>
                                        <option value="3">20~29%</option>
                                        <option value="4">10~19%</option>
                                        <option value="5">0~9%</option>
                                    </select></p>
                                <p>항공사&nbsp;&nbsp;&nbsp;
                                    <select class="psel" onchange="schedule(1,'time');" name='start_airline'>
                                        <option value="">전체</option>
                                          <?php
                                           foreach ($result_airline as $airline){
                                               echo "<option  value='{$airline}'> {$airline} </option>";
                                           }
                                          ?>
                                    </select></p>-->
                            </div>
                            <input type="hidden" name="start_date" id="sdate" value="">
                            <input type="hidden" name="end_date" id="edate" value="">
                            <input type="hidden" name="start_area" id="area" value="">
                            <input type="hidden" name="adult_number" id="adult" value="">
                            <input type="hidden" name="child_number" id="child" value="">
                            <input type="hidden" name="baby_number" id="baby" value="">
                            <input type="hidden" name="package" value="">
                        </form>
                    </div>


                    <table  id="air_schedule" style="width:1200px">
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
                    <table style="width:1200px">
                        <tr>
                            <td align="center"><img src="../sub_img/air_more.gif" type="button" id="page" style="cursor: pointer;" ></td>
                        </tr>
                    </table>
                </div>
                <div class="rent_area" style="display: none;">
                    <div class="rent_search">
                        <form id="rent_frm">
                            <div class="event">
                                <p>일반차량 <select name="rent_type" class="sel">
                                        <?php
                                        $main->rent_type_list();
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
                                <p><span class="head">인수/반납시간</span> <input type="text" name="rent_start_date" id="rent_start_date" class="air_date" /> <select name="start_hour" class="ssel">
                                        <?php
                                        $main->hour_option();
                                        ?>
                                    </select>
                                    <select name="start_minute" class="ssel">
                                        <?php
                                        $main->minute_option();
                                        ?>
                                    </select>
                                    <span style="position:relative;left:-7px">~</span>
                                    <input type="text" name="rent_end_date" class="air_date" id="rent_end_date" style="vertical-align:top" /> <select name="end_hour" class="ssel">
                                        <?php
                                        $main->hour_option();
                                        ?>
                                    </select>
                                    <select name="end_minute" class="ssel">
                                        <?php
                                        $main->minute_option();
                                        ?>
                                    </select>
                                    <input type="text" name="time" id="time" value="" class="stext" />시간
                                    <span style="position:relative;left:30px;font-weight:bold">차량대수</span>
                                    <select name="rent_vehicle" class="ssel" style="position:relative;left:30px">
                                        <?php
                                        $main->vehicle_option("","대");
                                        ?>
                                    </select>
                                    <img class="btn" type="button" src="../sub_img/re_search_btn.png" style="cursor: pointer;" onclick="car_list();"/>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="car_list">
                        <ul id="car_list">
                        </ul>
                    </div>
                </div>
                <div class="bus_area" style="display: none;">
                    <div class="bus_pkg_txt">
                        <img src="../sub_img/bus_pkg_txt.png" />
                    </div>
                    <div class="bus_search">
                        <form method="" action="">
                            <p><span>이용일자</span> <input type="text" name="bus_date" id="bus_date" style=""  class="air_date"/>
                                <span class="bar">~</span>
                                <select name="bus_stay" class="lsel">
                                    <?php
                                        $main->vehicle_option($bus_stay,"일");
                                    ?>
                                </select>
                               <select name="bus_type" class="lsel">
                                    <option value="B" <?if($bus_type=="B"){?>selected<?}?>>버스</option>
                                    <option value="X" <?if($bus_type=="X"){?>selected<?}?>>택시</option>
                                </select>
                                <span class="car_cnt">차량대수</span>
                                <select name="bus_vehicle" class="lsel2">
                                    <?php
                                    $main->vehicle_option($bus_vehicle,"대");
                                    ?>
                                </select>
                                <img class="btn"  type="button" src="../sub_img/re_search_btn.png"  onclick="bus_list();"/>
                            </p>

                        </form>

                    </div>
                    <div class="bus_list">

                    </div>
                </div>
                <div class="lodge_area" style="display: none;">
                    <div class="lodge_search">
                        <form id="tel_frm">

                                <p>위치별<select name="area" class="sel" >
                                        <?php
                                        $main->lodging_area_list();
                                        ?>
                                    </select>
                                    유형별 <select name="type" class="sel">
                                        <?php
                                        $main->lodging_type_list();
                                        ?>
                                    </select>
                                    객실수 <select name="room_vehicle" class="sel">
                                        <?php
                                        $main->vehicle_option("","실");
                                        ?>
                                    </select>

                                    숙소명검색 <input type="text" name="search_name" id="search_name" />
                                    <img  type="button"  src="../sub_img/submit_btn.png" style="cursor: pointer;" onclick="tel_list();" />
                                </p>

                        </form>
                    </div>
                    <div class="lodge_list">
                    </div>
                </div>
                <div class="golf_area" style="display: none;">
                    <div class="golf_search">
                        <form method="" action="">
                            <p class="tit"><span>라운딩 일정</span> <input type="text" name="golf_date" id="golf_date" />&nbsp;~&nbsp;
                                <select name="golf_stay" class="lsel">
                                    <?php
                                        $main->vehicle_option("","일");
                                    ?>
                                </select>
                                <span>인원수</span> <select name="golf_num" class="csel">
                                    <?php
                                        $main->number_option("","성인");
                                    ?>
                                </select>
                                <img id="golf_sch_btn" type="button" src="../sub_img/golf_search_btn.png"   />
                            </p>
                        </form>
                        <div id="golf_detail" class="golf_date">

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div><!-- content 끝 -->
    <div class="overlay"></div>
    <div id="layer_d" >
        <div id="wrap_layer">

        </div>
    </div> <!-- modal 창 종료-->
    <div id="layer_golf"  >
        <div id="golf_layer" class="golf_layer">
            <div class="content">
                <div id="golf_left" class="lcon">

                </div>
                <div id="golf_right" class="rcon">

                </div>
            </div> <!-- content 끝-->
        </div>
    </div>
    <script>
        function time_sum() {
            var date_s1   = $('#rent_start_date').val();
            var date_e1   = $('#rent_end_date').val();
            var hour_s1   = $("select[name=start_hour]").val();
            var minute_s1 = $("select[name=start_minute]").val();
            var hour_e1   = $("select[name=end_hour]").val();
            var minute_e1 = $("select[name=end_minute]").val();
            var date_s    = date_s1.split("-");
            var date_e    = date_e1.split("-");

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

            return term;

        }
        function schedule(pagenum,re) {
            var url = "../list/air_list.php"; // the script where you handle the form input.
            if(re=="time"){ is_init = true; $(".odd").remove(); pagenum=1;  }
            if(pagenum==1){  var pagenum2 = 0;}else{var pagenum2 = pagenum-1 ;}
            // alert(pagenum2);
            $.ajax({
                type: "POST",
                url: url,
                data: $("#air_frm").serialize()+"&start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&package="+$("select[name=package]").val()+"&area="+$("select[name=start_area]").val()+"&pagenum="+pagenum2, // serializes the form's elements.
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
        function car_list() {
            var url = "../list/car_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_frm").serialize()+"&package="+$("select[name=package]").val(), // serializes the form's elements.
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
        function tel_list() {
            var url = "../list/tel_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#tel_frm").serialize()+"&start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&room_vehicle="+$("select[name=room_vehicle]").val()+"&package="+$("select[name=package]").val(), // serializes the form's elements.
                success: function (data) {
                    $(".lodge_list").html(data); // show response from the php script.
                },
                beforeSend: function () {
                    wrapWindowByMask('../sub_img/tel_loding.gif');
                },
                complete: function () {
                    closeWindowByMask();
                }
            });
        }
        function room_list(tel_no) {
            var url = "../list/room_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#tel_frm").serialize()+"&tel_no="+tel_no+"&start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&package="+$("select[name=package]").val()+"&room_vehicle="+$("select[name=room_vehicle]").val(), // serializes the form's elements.
                success: function (data) {
                    $("#wrap_layer").html(data); // show response from the php script.
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
        function bus_list() {

            var url = "../list/bus_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "start_date="+$("#bus_date").val()+"&bus_vehicle="+$("select[name=bus_vehicle]").val()+"&bus_type="+$("select[name=bus_type]").val()+"&bus_stay="+$("select[name=bus_stay]").val()+"&package="+$("select[name=package]").val(), // serializes the form's elements.
                success: function (data) {
                    $(".bus_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {
                      wrapWindowByMask();
                },
                complete: function () {
                       closeWindowByMask();
                }
            });
        }
        function golf_list(i) {

            var url = "../list/golf_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "start_date="+$("#golf_date").val()+"&golf_stay="+$("select[name=golf_stay]").val()+"&golf_num="+$("select[name=golf_num]").val()+"&package="+$("select[name=package]").val()+"&i="+i, // serializes the form's elements.
                success: function (data) {
                    $("#golf_left").html(data); // show response from the php script.
                    $("#golf_right").html("");
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
        function hole_detail(i,no) {

            var url = "../list/hole_detail.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "start_date="+$("#golf_stay_date_"+i).val()+"&golf_time="+$("#golf_time_"+i).val()+"&adult_number="+$("select[name=golf_adult_number_"+i+"]").val()+"&golf_no="+no+"&package="+$("select[name=package]").val()+"&i="+i, // serializes the form's elements.
                success: function (data) {
                    $("#golf_right").html(data); // show response from the php script.
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
        function day_half(time) {
            if(time >="11"){
                var day = "오후";
            }else{
                var day = "오전";
            }

            return day;
        }
       
        function air_selected(i) {

            var s_day = day_half($("#air_start_hour_"+i).val());
            var e_day = day_half($("#air_end_hour_"+i).val());
            var air_html="";
            air_html += "<p  class=\"data\"><img src='"+$("#air_img_"+i).val()+"' class='air_mark'/><span class='txt'>"+$("#air_area_"+i).val()+"</span><span class='txt'>출발</span><span class='date'>"+$("#air_departure_date_"+i).val()+" ("+$("#air_start_week_"+i).val()+")</span> ";
            air_html += "<span class=\"blue\">"+s_day+" "+$("#air_start_hour_"+i).val()+":"+$("#air_start_minute_"+i).val()+"</span><span class='arrow'>↔</span>";
            air_html += "<img src='"+$("#air_img_"+i).val()+"' class='air_mark'/><span class='txt'>제주</span><span class='txt'>출발</span><span class='date'>"+$("#air_arrival_date_"+i).val()+" ("+$("#air_end_week_"+i).val()+")</span>";
            air_html += " <span class=\"blue\">"+e_day+" "+$("#air_end_hour_"+i).val()+":"+$("#air_end_minute_"+i).val()+"</span></p><a href='#none' id='aaa'><span class='hide'>상품변경</span>  <img src='../sub_img/goods_upt_btn.png' onclick='air_mod();'  class='goods_upt'/></a>";
            air_html += "<input type='hidden' name='air_no' id='air_no' value='"+$("#air_no_"+i).val()+"'>";
            air_html += "<input type='hidden' name='air_company_no' id='air_company_no' value='"+$("#air_company_no_"+i).val()+"'>";
            air_html += "<input type='hidden' name='air_price' id='air_price' value='"+$("#air_total_price_"+i).val()+"'>";
            air_html += "<input type='hidden' name='air_type' id='air_type' value='"+$("#air_type_"+i).val()+"'>";
            $("#air_selected_content").html(air_html);
            next_tab();
            $("#rent_start_date").val($("#air_departure_date_"+i).val());
            $("#rent_end_date").val($("#air_arrival_date_"+i).val());
            $("#bus_date").val($("#air_departure_date_"+i).val());
            $("#golf_date").val($("#air_departure_date_"+i).val());

            var s_date = new Date($("#air_departure_date_"+i).val());
            var e_date = new Date($("#air_arrival_date_"+i).val());
            var stay = e_date - s_date;
            stay =  (stay/(24 * 3600 * 1000));
            $("select[name=golf_stay]").val((stay+1));

            $("select[name=bus_stay]").val($("#air_stay2_"+i).val());
            var air_start_hour_a = Number($("#air_start_hour_"+i).val())+1;
            var air_end_hour_a   = Number($("#air_end_hour_"+i).val())-1;
            if(air_start_hour_a < 10){var air_start_hour ="0"+air_start_hour_a;}else{ var air_start_hour= air_start_hour_a; }
            if(air_end_hour_a < 10){var air_end_hour ="0"+air_end_hour_a;}else{ var air_end_hour= air_end_hour_a; }

        //    console.log(air_start_hour+"==="+$("#air_start_minute_"+i).val()+"====="+air_end_hour+"====="+$("#air_end_minute_"+i).val());
            $("select[name=start_hour]").val(air_start_hour);
            $("select[name=start_minute]").val($("#air_start_minute_"+i).val());
            $("select[name=end_hour]").val(air_end_hour);
            $("select[name=end_minute]").val($("#air_end_minute_"+i).val());
            var rent_time = time_sum();
            $("#time").val(rent_time);
            g_stay_list();
            total_price();

        }
        function rent_selected(i) {
            var rent_html="";
            rent_html += "<p class='data'>  <span class='blue'>[ "+$("#car_name_"+i).val()+"]</span>";
            rent_html += "<span class='txt'>"+$("#car_sdate_"+i).val()+"("+$("#car_sweek_"+i).val()+")  "+$("#car_stime_"+i).val()+" ~ "+$("#car_edate_"+i).val()+"("+$("#car_eweek_"+i).val()+") "+$("#car_etime_"+i).val()+" /</span>";
            rent_html += " <span class='blue'>"+$("#car_time_"+i).val()+"시간 "+$("select[name=rent_vehicle]").val()+"대</span></p>  <a href='#none'><img src='../sub_img/goods_upt_btn.png' onclick='rent_mod();'  class='goods_upt'/></a>";
            rent_html += "<input type='hidden' name='car_no' id='car_no' value='"+$("#car_no_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_sdate' id='car_sdate' value='"+$("#car_sdate_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_edate' id='car_edate' value='"+$("#car_edate_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_stime' id='car_stime' value='"+$("#car_stime_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_etime' id='car_etime' value='"+$("#car_etime_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_vehicle' id='car_vehicle' value='"+$("#car_vehicle_"+i).val()+"'>";
            rent_html += "<input type='hidden' name='car_price' id='car_price' value='"+$("#car_total_price_"+i).val()+"'>";
            $("#rent_selected_content").html(rent_html);
            total_price();
            $(window).scrollTop(0);

        }
        function tel_selected(i,j) {
            var tel_html="";
            tel_html += "<span class='txt'>"+$("#tel_start_date_"+j).val()+" 부터</span> <span class='blue'>"+$("#tel_stay_"+j).val()+"박</span>";
            tel_html += "<span class='blue'>["+$("#tel_name_"+j).val()+"]"+$("#room_name_"+j).val()+"</span><span class='txt'>"+$("select[name=room_vehicle]").val()+"객실</span>" +
                "     <a href=\"#none\"><span class=\"hide\">상품변경</span>\n" +
                "     <img src=\"../sub_img/goods_upt_btn.png\"  onclick='tel_mod();'  class=\"goods_upt\"/></a>";
            tel_html += "<input type='hidden' name='tel_no' id='tel_no' value='"+$("#tel_no_"+j).val()+"'>";
            tel_html += "<input type='hidden' name='room_no' id='room_no' value='"+$("#room_no_"+j).val()+"'>";
            tel_html += "<input type='hidden' name='tel_start_date' id='tel_start_date' value='"+$("#tel_start_date_"+j).val()+"'>";
            tel_html += "<input type='hidden' name='tel_vehicle' id='tel_vehicle' value='"+$("#tel_vehicle_"+j).val()+"'>";
            tel_html += "<input type='hidden' name='tel_stay' id='tel_stay' value='"+$("#tel_stay_"+j).val()+"'>";
            tel_html += "<input type='hidden' name='tel_price' id='tel_price' value='"+$("#tel_total_price_"+j).val()+"'>";
            $("#tel_selected_content").html(tel_html);
            $("select[name=bus_stay]").val(Number($("#tel_stay_"+j).val())+1);
            next_tab();

            overlays_close("overlay","layer_d");


            total_price();
        }
        function bus_selected(i) {

            var bus_html="";
            bus_html += "<span class='blue'>["+$("#bus_name_"+i).val()+"]</span><span class='txt'>"+$("#bus_date").val()+"("+$("#bus_week_"+i).val()+")부터 "+$("#bus_stay_"+i).val()+"일 ("+$("#bus_vehicle_"+i).val()+"대)</span>"+
                "     <a href=\"#none\"><span class=\"hide\">상품변경</span>\n" +
                "     <img src=\"../sub_img/goods_upt_btn.png\" onclick='bus_mod();' class=\"goods_upt\"/></a>";
            bus_html += "<input type='hidden' name='bus_no' id='bus_no' value='"+$("#bus_no_"+i).val()+"'>";
            bus_html += "<input type='hidden' name='bus_date' id='bus_date' value='"+$("#b_date_"+i).val()+"'>";
            bus_html += "<input type='hidden' name='bus_stay' id='bus_stay' value='"+$("#bus_stay_"+i).val()+"'>";
            bus_html += "<input type='hidden' name='bus_vehicle' id='bus_vehicle' value='"+$("#bus_vehicle_"+i).val()+"'>";
            bus_html += "<input type='hidden' name='bus_price' id='bus_price' value='"+$("#bus_price_"+i).val()+"'>";

            $("#bus_selected_content").html(bus_html);
            total_price();
            $(window).scrollTop(0);
        }
        function golf_selected(i,j) {

            var golf_html="";
            golf_html += "<span class='blue'>["+$("#golf_name_"+i).val()+"("+$("#hole_name_"+i).val()+")]</span><span class='txt'>"+$("#golf_stay_date_"+j).val()+"("+$("#golf_week_"+i).val()+")</span>"+
        "     <a href=\"#none\"><span class=\"hide\">상품변경</span>\n" +
                "     <img src=\"../sub_img/goods_upt_btn.png\" onclick='golf_mod();' class=\"goods_upt\"/></a>";
            golf_html  += "<input type='hidden' name='golf_no[]' id='golf_no_"+j+"' value='"+$("#h_golf_no_"+i).val()+"'> ";
            golf_html  += "<input type='hidden' name='hole_no[]' id='hole_no_"+j+"' value='"+ $("#h_hole_no_"+i).val()+"'> ";
            golf_html  += "<input type='hidden' name='golf_date[]' value='"+ $("#h_golf_date_"+i).val()+"'> ";
            golf_html  += "<input type='hidden' name='golf_time[]' value='"+ $("#h_golf_time_"+i).val()+"'> ";
            golf_html  += "<input type='hidden' name='golf_number[]' value='"+ $("#h_golf_adult_number_"+i).val()+"'> ";
            golf_html  += "<input type='hidden' name='golf_total_price_"+j+"' id='golf_total_price_"+j+"' value='"+ $("#golf_price_"+i).val()+"'> ";
            var h_no = $("#h_hole_no_"+i).val();

            $("#selected_golf_"+j).html(golf_html);

            $("#golf_no_"+j).val($("#h_golf_no_"+i).val());
            $("#golf_img_"+j).attr("src",""+$("#main_image_"+i).val());
            hole(j,h_no);
            overlays_close("overlay","layer_golf")
            total_price();
        }
        function total_price() {
            var total_price = 0;

            var air = $("#air_price").val();
            var car = $("#car_price").val();
            var tel = $("#tel_price").val();
            var bus = $("#bus_price").val();

            var s_date = new Date($("#start_date").val());
            var e_date = new Date($("#end_date").val());
            var stay = e_date - s_date;
            stay =  (stay/(24 * 3600 * 1000));
            if(air == undefined ||  car ==""){
                air = 0;
            }else{
                air = air;
            }

            if(car == undefined ||  car ==""){
                car = 0;
            }else{
                car = car;
            }
            if(tel == undefined ||  tel ==""){
                tel = 0;
            }else{
                tel = tel;
            }
            if(bus == undefined ||  bus ==""){
                bus = 0;
            }else{
                bus = bus;
            }
            var golf = 0;
            for(var i=0 ;i < stay;i++ ){
                if($("#golf_total_price_" + i).val() == undefined ||  $("#golf_total_price_" + i).val() =="") {
                    golf = 0;
                }else{
                    golf += Number($("#golf_total_price_" + i).val());

                }
            }
            total_price = Number(air) + Number(car) + golf + Number(tel) + Number(bus);

            $("#total").html(set_comma(total_price)+"원");
        }

        function next_tab() {
            var type= "<?=$page?>";

            if ($("#air_no").val()!=""  || $("#air_no").val()!=undefined){
                if(type=="bus") {

                    $(".air_area").hide();
                    $(".bus_area").hide();
                    $(".lodge_area").show();
                    $(".package_tabmenu ul li .bus").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
                    tel_list();
                }else if(type=="golf"){
                    $(".air_area").hide();
                    $(".golf_area").show();
                    $(".rent_area").hide();
                    $(".lodge_area").hide();
                    $(".package_tabmenu ul li .golf").css({backgroundColor: "#4474cc", color: "#fff"});
                    $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                    g_stay_list();
                }else {
                    if($("select[name=package]").val()=="AC") {
                        $(".air_area").hide();
                        $(".rent_area").show();
                        $(".lodge_area").hide();
                        $(".package_tabmenu ul li .rent").css({backgroundColor: "#4474cc", color: "#fff"});
                        $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                        car_list();
                    }else if($("select[name=package]").val()=="AT"){
                        $(".air_area").hide();
                        $(".rent_area").hide();
                        $(".lodge_area").show();
                        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
                        $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
                        tel_list();
                    }else{
                        $(".air_area").hide();
                        $(".rent_area").hide();
                        $(".lodge_area").show();
                        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
                        $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
                        tel_list();
                    }
                }
            }
            if ($("#golf_no").val() != undefined) {

                $(".air_area").hide();
                $(".golf_area").hide();
                $(".rent_area").show();
                $(".lodge_area").hide();
                $(".package_tabmenu ul li .rent").css({backgroundColor: "#4474cc", color: "#fff"});
                $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                $(".package_tabmenu ul li .golf").css({backgroundColor: "#fff", color: "#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                tel_list();

            }

            if ($("#tel_no").val() != undefined) {
                if(type=="bus") {
                    $(".air_area").hide();
                    $(".bus_area").show();
                    $(".lodge_area").hide();
                    $(".package_tabmenu ul li .bus").css({backgroundColor: "#4474cc", color: "#fff"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                    bus_list();
                }else{
                    $(".air_area").hide();
                    $(".rent_area").show();
                    $(".lodge_area").hide();
                    $(".package_tabmenu ul li .rent").css({backgroundColor: "#4474cc", color: "#fff"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                    car_list();
                }

            }
            if ($("#bus_no").val() != undefined) {
                if($("select[name=package]").val()=="ABT" || $("select[name=package]").val()=="BT" ) {
                    $(".air_area").hide();
                    $(".bus_area").hide();
                    $(".lodge_area").show();
                    $(".package_tabmenu ul li .bus").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
                    tel_list();
                }else{
                    $(".air_area").hide();
                    $(".bus_area").show();
                    $(".lodge_area").hide();
                    $(".package_tabmenu ul li .bus").css({backgroundColor: "#4474cc", color: "#fff"});
                    $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
                    $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
                }

            }
        }
        function reservation() {
            reserv_chk($("select[name=package]").val());
        }
        function g_stay_list() {
            var stay = $("select[name=golf_stay]").val();
            var html_golf = "";
            var selected_golf = "";
            var date = new Date($("#golf_date").val()); /* 현재 */
            var s_date = "";

            var b_ate = date.getDate()
            for(var i =0;i < stay ; i++) {
                date.setDate(b_ate + i); /* 날짜 + 1일 */

                if(date.getDate() < 10) {
                   var dd='0'+date.getDate();

                }else{
                    var dd = date.getDate();
                }

                if((date.getMonth()+1)<10) {
                    var mm='0'+(date.getMonth()+1);
                }else{
                    var mm= (date.getMonth()+1);
                }

                s_date = date.getFullYear()+"-"+mm+"-"+dd;
                html_golf += "<p><span>"+(i+1)+"일차</span><img id='golf_img_"+i+"' src='../sub_img/golf_thumb.jpg' width='81' height='54' /><span class='com'>라운딩일시</span><input type='text' id='golf_stay_date_"+i+"' value='"+s_date+"' />";
                html_golf += "<select id='golf_time_"+i+"' class='msel'><?php $main->golf_hour_option();?></select>";
                html_golf += "<select id='golf_no_"+i+"' name='golf_no_"+i+"'  class='lsel' onchange='hole("+i+")'> <option value=''>선택하세요</option></select>";
                html_golf += "<select id='hole_no_"+i+"' name='hole_no_"+i+"' class='hsel'></select>";
                html_golf += "<select name='golf_adult_number_"+i+"' class='wsel'><?php $main->number_option("","성인");?></select><img type='button' id='golf_sel_"+i+"' src='../sub_img/golf_change_btn.png' class='cbasic' onclick='golf_layer_detail("+i+");' style='cursor: pointer;'/>";
                selected_golf += "<p  class=\"data\" ><span id='selected_golf_"+i+"' class='select_none'>아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>";
                $("#golf_detail").html(html_golf);

            }
            $("#golf_selected_content").html(selected_golf);



        }
        function hole(i,h_no) {
            var no = $("select[name=golf_no_"+i+"]").val();

            $("select[name=hole_no_"+i+"] option").remove();

            $.post('../list/hole_list.php',{
                "golf_no":no
            },function(oJson){
                $.each(oJson['list'],function(nIdx,item){
                    if(h_no==item['no']){ var sele ="selected";}else{var sele ="";}

                    $("select[name=hole_no_"+i+"]").append("<option value='"+item['no']+"'"+sele+">"+item['hole_name']+"</option>");
                });


            },'json');
        }
        function golf_layer_detail(i) {
            overlays_view("overlay","layer_golf")
            golf_list(i);
        }
        var reloadCount = 1;
        var pagenum = 1;
        var is_init = false;
        function air_mod() {
            schedule(1,'time');
            $(".air_area").show();
            $(".rent_area").hide();
            $(".lodge_area").hide();
            $(".bus_area").hide();
            $(".golf_area").hide();
            $(".package_tabmenu ul li .air").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});

        }
        function tel_mod() {
            tel_list();
            $(".air_area").hide();
            $(".rent_area").hide();
            $(".lodge_area").show();
            $(".bus_area").hide();
            $(".golf_area").hide();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});

        }
        function rent_mod() {
            car_list();
            $(".air_area").hide();
            $(".rent_area").show();
            $(".lodge_area").hide();
            $(".bus_area").hide();
            $(".golf_area").hide();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});

        }
        function bus_mod() {
            bus_list();
            $(".air_area").hide();
            $(".rent_area").hide();
            $(".bus_area").show();
            $(".lodge_area").hide();
            $(".golf_area").hide();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .bus").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});

        }
        function golf_mod() {
            $(".air_area").hide();
            $(".rent_area").hide();
            $(".bus_area").hide();
            $(".lodge_area").hide();
            $(".golf_area").show();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .golf").css({backgroundColor:"#4474cc",color:"#fff"});
            g_stay_list();

        }
        function main_search() {
            var s_date = new Date($("#start_date").val());
            var e_date = new Date($("#end_date").val());
            var stay = e_date - s_date;
            stay = (stay / (24 * 3600 * 1000));

            $("#d_day").html($("#start_date").val());
            $("#s_date").val($("#start_date").val());
            $("#e_date").val($("#end_date").val());
            $("#adult_number").val($("select[name=adult_number]").val());
            $("#child_number").val($("select[name=child_number]").val());
            $("#baby_number").val($("select[name=baby_number]").val());
            $("#package_type").val($("select[name=package]").val());
            $("select[name=golf_stay]").val(Number(stay) + 1);
            $("select[name=bus_stay]").val(Number(stay) + 1);
            $("#sty").html(" "+stay + "박")+" ";
            $("#s_area").html($("select[name=start_area]").val());
            $("#number").html("(성인 " + $("select[name=adult_number]").val() + "명, 소아 " + $("select[name=child_number]").val() + "명, 유아 " + $("select[name=baby_number]").val() + "명)");
            var type_pack = $("select[name=package]").val();
            $("#air_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
            $("#rent_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
            $("#tel_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
            $("#bus_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
            for (var i = 0; i < stay; i++) {
                $("#golf_selected_content").html("<p  class=\"data\" ><span id='selected_golf_" + i + "' class='select_none'>아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
            }
            pack_type(type_pack);
            g_stay_list();
        }

        $(document).ready(function () {
            $('input[name=search_name]').keydown(function() {
                if (event.keyCode === 13) {
                    tel_list();
                    event.preventDefault();
                }
            });

            $("#page").click(function () {

                if (is_init) {
                    is_init = false;
                    pagenum =1;
                    return;
                }
                pagenum += 1;
                schedule(pagenum, '');
            });
            $(".overlay").click(function () {
                overlays_close("overlay","layer_d")
                overlays_close("overlay","layer_golf")
            });


            var rent_time = time_sum();
            $("#time").val(rent_time);
            $(".s_img").mouseover(function(){
                alert("aaa");
                $(".show_img").attr("src",$(this).attr("src"));
            });

            var s_date = new Date($("#start_date").val());
            var e_date = new Date($("#end_date").val());
            var stay = e_date - s_date;
            stay =  (stay/(24 * 3600 * 1000));

            $("#d_day").html($("#start_date").val());
            $("#s_date").val($("#start_date").val());
            $("#e_date").val($("#end_date").val());
            $("#adult_number").val($("select[name=adult_number]").val());
            $("#child_number").val($("select[name=child_number]").val());
            $("#baby_number").val($("select[name=baby_number]").val());
            $("#package_type").val($("select[name=package]").val());

            $("#sty").html(" "+stay+"박");
            $("#s_area").html($("select[name=start_area]").val());
            $("#number").html("(성인 "+$("select[name=adult_number]").val()+"명, 소아 "+$("select[name=child_number]").val()+"명, 유아 "+$("select[name=baby_number]").val()+"명)");
            $("#rent_start_date").val($("#start_date").val());
            $("#rent_end_date").val($("#end_date").val());
            $("#bus_date").val($("#start_date").val());
            $("#golf_date").val($("#start_date").val());
            $("select[name=golf_stay]").val(Number(stay)+1);


            $("#package_sch_btn").click(function () {
                var s_date = new Date($("#start_date").val());
                var e_date = new Date($("#end_date").val());
                var stay = e_date - s_date;
                stay = (stay / (24 * 3600 * 1000));

                $("#d_day").html($("#start_date").val());
                $("#s_date").val($("#start_date").val());
                $("#e_date").val($("#end_date").val());
                $("#adult_number").val($("select[name=adult_number]").val());
                $("#child_number").val($("select[name=child_number]").val());
                $("#baby_number").val($("select[name=baby_number]").val());
                $("#package_type").val($("select[name=package]").val());
                $("select[name=golf_stay]").val(Number(stay) + 1);
                $("select[name=bus_stay]").val(Number(stay) + 1);
                $("#sty").html(" "+stay + "박")+" ";
                $("#s_area").html($("select[name=start_area]").val());
                $("#number").html("(성인 " + $("select[name=adult_number]").val() + "명, 소아 " + $("select[name=child_number]").val() + "명, 유아 " + $("select[name=baby_number]").val() + "명)");
                var type_pack = $("select[name=package]").val();
                $("#air_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
                $("#rent_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
                $("#tel_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
                $("#bus_selected_content").html(" <p  class=\"data\"><span class=\"select_none\">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
                for (var i = 0; i < stay; i++) {
                    $("#golf_selected_content").html("<p  class=\"data\" ><span id='selected_golf_" + i + "' class='select_none'>아직 선택 전입니다. 다음 단계에서 선택해주세요.</span></p>");
                }
                pack_type(type_pack);
                total_price();
                g_stay_list();

            });
            $(".air").click(function(){
                schedule(1,'time');
                $(".air_area").show();
                $(".rent_area").hide();
                $(".lodge_area").hide();
                $(".bus_area").hide();
                $(".golf_area").hide();
                $(".package_tabmenu ul li .air").css({backgroundColor:"#4474cc",color:"#fff"});
                $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});
            });
            $(".rent").click(function(){
                var pack = $("select[name=package]").val();
                if(pack=="ACT" || pack=="AC" ){
                    if($("#air_company_no").val()=="" || $("#air_company_no").val()==undefined) {
                        alert("항공을선택해주세요.");
                        return false;
                    }
                }
                car_list();
                $(".air_area").hide();
                $(".rent_area").show();
                $(".lodge_area").hide();
                $(".bus_area").hide();
                $(".golf_area").hide();
                $(".package_tabmenu ul li .rent").css({backgroundColor:"#4474cc",color:"#fff"});
                $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});
            });
            $(".lodge").click(function(){
                var pack = $("select[name=package]").val();
                if(pack=="ACT" || pack=="AT" ){

                    if($("#air_company_no").val()=="" || $("#air_company_no").val()==undefined) {
                        alert("항공을선택해주세요.");
                        return false;
                    }
                }
                tel_list();
                $(".air_area").hide();
                $(".rent_area").hide();
                $(".lodge_area").show();
                $(".bus_area").hide();
                $(".golf_area").hide();
                $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor:"#4474cc",color:"#fff"});
                $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});

            });
            $(".bus").click(function(){
                var pack = $("select[name=package]").val();
                if(pack=="ABT" || pack=="AB" ){

                    if($("#air_company_no").val()=="" || $("#air_company_no").val()==undefined) {
                        alert("항공을선택해주세요.");
                        return false;
                    }
                }
                bus_list();
                $(".air_area").hide();
                $(".rent_area").hide();
                $(".bus_area").show();
                $(".lodge_area").hide();
                $(".golf_area").hide();
                $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .bus").css({backgroundColor:"#4474cc",color:"#fff"});
                $(".package_tabmenu ul li .golf").css({backgroundColor:"#fff",color:"#000"});
            });
            $(".golf").click(function(){
                $(".air_area").hide();
                $(".rent_area").hide();
                $(".bus_area").hide();
                $(".lodge_area").hide();
                $(".golf_area").show();
                $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .bus").css({backgroundColor:"#fff",color:"#000"});
                $(".package_tabmenu ul li .golf").css({backgroundColor:"#4474cc",color:"#fff"});
                g_stay_list();
            });
            $("#golf_sch_btn").click(function () {
                g_stay_list();
            })

            $("#header .nav ul li a").click(function(){
                $("#header .nav ul li a").css({"border-bottom":"none"});    /// a 태그 전체
                $(this).css({"border-bottom":"3px solid #498517"});
            });

        });


        g_stay_list();
        $( function() {
          var dates =  $( "#start_date, #end_date" ).datepicker({
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
                yearSuffix: '년',
                showMonthAfterYear: true,
                buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
                buttonImageOnly : true,
                minDate : 0,
                maxDate:'+10950d',
                onSelect: function( selectedDate ) {
                    var option = this.id == "start_date" ? "minDate" : "maxDate",
                        instance = $( this ).data( "datepicker" ),
                        date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                    $("#end_date").val(selectedDate);

                }
            });
            var dates =  $("#bus_date" ).datepicker({
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
                yearSuffix: '년',
                showMonthAfterYear: true,
                buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
                buttonImageOnly : true,
                minDate : 0,
                maxDate:'+10950d',
                onSelect: function( selectedDate ) {
                    time_sum();
                    var option = this.id == "bus_date" ? "minDate" : "maxDate",
                        instance = $( this ).data( "datepicker" ),
                        date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                }
            });
            var dates =  $( "#rent_start_date, #rent_end_date" ).datepicker({
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
                yearSuffix: '년',
                showMonthAfterYear: true,
                buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
                buttonImageOnly : true,
                minDate : 0,
                maxDate:'+10950d',
                onSelect: function( selectedDate ) {
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
        time_sum();
        main_search();
    </script>
<?php include_once ("../footer.php");?>