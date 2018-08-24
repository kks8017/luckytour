<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/dd_lodge.css" />
<?php
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}

$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));

?>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar"></span>
            <h3>따로 따로 숙박하기</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
    </div>
    <div class="lodge_search">
        <table>
            <tr>
                <td>
                    <input type="radio" name="dd_lodge" onclick="dd_loc();" value="N" ><b>연박하기</b><span>(일정내내 같은숙소에서 숙박을 원하시면 선택하세요)</span>
                </td>
                <td>
                    <input type="radio" name="dd_lodge"  onclick="dd_loc();" value="D" checked><b>일정별로 따로따로 숙박하기</b><span>(일정별로 다른숙소에서 숙박을 원하시면 선택하세요)</span>
                </td>
            </tr>
        </table>
    </div>
    <form id="lodge_frm" method="post" action="../member/login_reservation.php">
    <div class="dd-lodge_search">

            <p class="tit"><span>숙박 일정</span>
                <input type="text" name="start_date" id="start_date" value="<?=$start_date?>"/>&nbsp;~&nbsp;
                <select name="tel_stay" class="lsel">
                    <?php
                    $main->stay_option("");
                    ?>
                </select>
                <span>인원수</span>
                <select name="ad_number" class="csel">
                    <?php
                    $main->number_option("","성인")
                    ?>
                </select>
                <select name="ch_number"  class="csel">
                    <?php
                    $main->number_option("","소아")
                    ?>
                </select>
                <select name="ba_number"  class="csel">
                    <?php
                    $main->number_option("","유아")
                    ?>
                </select>
                <img class="btn" type="button" src="../sub_img/submit_btn.png"  onclick="t_stay_list();" style="cursor: pointer;" />
            </p>


        <div id="tel_stay_list" class="dd-lodge_date">

        </div>
        <input type="hidden" name="adult_number" id="adult_number" value="">
        <input type="hidden" name="child_number" id="child_number" value="">
        <input type="hidden" name="baby_number" id="baby_number" value="">
     </form>
     <br>
     <br>
    <div class="search_list">
        <div class="tit"><h4><img src="../sub_img/choice_arrow.png" /> 선택하신 내역입니다.</h4></div>
        <div>
            <div>
                <!-- 선택 내역이 추가되면 틀이 틀어지는 문제로 다시 코딩 -->
                <table class="table_list">

                    <tr>
                        <th>
                            <span class="gray">내가 선택한</span><span class="b">숙소<img src="../sub_img/choice_left_arrow.png" class="arrow"/></span>
                        </th>
                        <td id="tel_selected_content">
                            <p  class="data" ><span class="select_none">아직 선택 전입니다. 다음 단계에서 선택해주세요.</span</p>
                        </td>
                    </tr>

                </table>

            </div>
            <div class="total_price">
                <p><span>총 금액</span><span id="total">0원</span><img type="button" id="reserv_btn" src="../sub_img/pkg_reserve_btn.png"  /></p>
            </div>
        </div> <!-- search_list 끝 -->
    </div>
</div><!-- content 끝 -->
    <div class="overlay"></div>

    <div id="lodge_layer">
        <div class="content">
            <div class="pop_lodge_search">
                <table>
                    <tr>
                        <td class="pop-lodge-img">
                            <img src="../sub_img/num1.png" class="icon"/>
                        <td class="pop-lodge" >
                            원하시는 숙소을 클릭 하세요.
                        </td>
                    </tr>
                    <tr>
                        <td class="pop-lodge_text" colspan="2">
                            <div class="kind">
                                입실일자 <span id="tel_date"></span>&nbsp;
                                <select name="tel_stay_number" class="sel" style="width:70px">
                                    <?php
                                    $main->stay_option("");
                                    ?>
                                </select>
                                객실수&nbsp;<select name="room_vehicle" class="sel" style="width:50px">
                                    <?php
                                    $main->vehicle_option("","실");
                                    ?>
                                </select>
                                인원수&nbsp;<select name="l_adult_number" class="sel" style="width:70px">
                                    <?php
                                    $main->number_option("","성인");
                                    ?>
                                </select>
                                <select name="l_child_number" class="sel" style="width:70px">
                                    <?php
                                    $main->number_option("","소아");
                                    ?>
                                </select>
                                <select name="l_baby_number" class="sel" style="width:70px">
                                    <?php
                                    $main->number_option("","유아");
                                    ?>
                                </select>
                                위치별&nbsp;<select name="area" class="sel" >
                                    <?php
                                    $main->lodging_area_list("");
                                    ?>
                                </select>
                                숙소명검색 <input type="text" name="search" id="search" class="search"/>
                                <img type="button" src="../sub_img/re_search_btn-sm.png" class="re-bt" style="vertical-align: middle;" onclick="tel_list()">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pop-lodge_text" colspan="2">
                            <img type="button" src="../sub_img/all.png" style="cursor: pointer;" class="re-select">
                            <img type="button" src="../sub_img/hotel.png" style="cursor: pointer;" class="re-select">
                            <img type="button" src="../sub_img/condo.png" style="cursor: pointer;" class="re-select">
                            <img type="button" src="../sub_img/pension.png" style="cursor: pointer;" class="re-select">
                            <img type="button" src="../sub_img/golf_tel.png" style="cursor: pointer;" class="re-select">
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tel_left"  class="lcon">

            </div>
            <div id="tel_right" class="rcon">

            </div>
        </div> <!-- content 끝-->
    </div><!-- wrap 끝-->

<input type="hidden" id="h_i" value="">
<script>
    function t_stay_list() {
        $("#adult_number").val($("select[name=ad_number]").val());
        $("#child_number").val($("select[name=ch_number]").val());
        $("#baby_number").val($("select[name=ba_number]").val());
        var stay = $("select[name=tel_stay]").val();
        var selected_tel ="";
        var html_tel = "";
        var date = new Date($("#start_date").val()); /* 현재 */
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
            html_tel += "<p><span>"+(i+1)+"일차</span><img class='sel_btn' id='tel_img_"+i+"' src='../sub_img/golf_thumb.jpg' width='81' height='54' /><span class='com'>숙박일시</span><input type='text' name='tel_date[]' id='tel_date_"+i+"' value='"+s_date+"' />";
            html_tel += "<input type='text' class='name' id='lod_name_"+i+"' value='' />";
            html_tel += "<select id='tel_adult_number_"+i+"' name='tel_adult_number[]' class='wsel'><?php $main->number_option("","성인");?></select>";
            html_tel += "<select id='tel_child_number_"+i+"' name='tel_child_number[]' class='wssel'><?php $main->number_option("","소아");?></select>";
            html_tel += "<select id='tel_baby_number_"+i+"' name='tel_baby_number[]' class='wsell'><?php $main->number_option("","유아");?></select>";
            html_tel += "<input type='hidden' id='d_tel_no_"+i+"' name='tel_no[]'   >";
            html_tel += "<input type='hidden' id='d_room_no_"+i+"' name='room_no[]'   >";
            html_tel += "<input type='hidden' id='room_stay_"+i+"' name='tel_stay[]'   >";
            html_tel += "<input type='hidden' id='room_vehicle_"+i+"' name='tel_vehicle[]'   >";
            html_tel += "<input type='hidden'  name='tel_t'  value='D'  >";
            html_tel += "<input type='hidden'  name='package_type'  value='T'  >";
            html_tel += "<input type='hidden' id='room_total_price_"+i+"'   >";
            html_tel += "<img src='../sub_img/dd_lodge_change_btn.gif'  class='sel_btn' onclick='tel_layer_detail("+i+")'/></p>";
            selected_tel += "<p  class=\"data\" ><span id='selected_tel_"+i+"' class='select_none'>아직 선택 전입니다. 숙소를 선택해주세요.</span></p>";


            $("#tel_stay_list").html(html_tel);
            $("#tel_selected_content").html(selected_tel);
            $(".wsel").val($("select[name=ad_number]").val());
            $(".wssel").val($("select[name=ch_number]").val());
            $(".wsell").val($("select[name=ba_number]").val());


        }
  }
    function tel_list(i) {

        if(i==null){
            i = $("#h_i").val();
        }else{
            $("#h_i").val(i);
        }

        $("#tel_right").html("");
        var url = "../list/dd_tel_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#tel_frm").serialize()+"&start_date="+$("#start_date").val()+"&tel_stay="+$("select[name=tel_stay]").val()+"&adult_number="+$("#tel_adult_number_"+i).val()+"&child_number="+$("#tel_child_number_"+i).val()+"&baby_number="+$("#tel_baby_number_"+i).val()+"&area="+$("select[name=area]").val()+"&search_name="+$("#search").val()+"&i="+i, // serializes the form's elements.
            success: function (data) {
                $("#tel_left").html(data); // show response from the php script.
                //console.log(data);
            },
            beforeSend: function () {
                //  wrapWindowByMask();
            },
            complete: function () {
                //   closeWindowByMask();

            }
        });
    }
    function room_list(i,tel_no) {
        var url = "../list/dd_room_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#tel_frm").serialize()+"&tel_no="+tel_no+"&start_date="+$("#tel_date_"+i).val()+"&tel_stay="+$("select[name=tel_stay_number]").val()+"&adult_number="+$("select[name=l_adult_number]").val()+"&child_number="+$("select[name=l_child_number]").val()+"&baby_number="+$("select[name=l_baby_number]").val()+"&room_vehicle="+$("select[name=room_vehicle").val()+"&i="+i, // serializes the form's elements.
            success: function (data) {
                $("#tel_right").html(data); // show response from the php script.
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
    function tel_selected(i,j) {
        $("#lod_name_"+i).val($("#tel_name_"+j).val()+"("+$("#room_name_"+j).val()+")");
        $("#d_tel_no_"+i).val($("#tel_no_"+j).val());
        $("#d_room_no_"+i).val($("#room_no_"+j).val());
        $("#room_stay_"+i).val($("#tel_stay_"+j).val());
        $("#room_vehicle_"+i).val($("#tel_vehicle_"+j).val());
        $("#room_total_price_"+i).val($("#tel_total_price_"+j).val());
        $("#tel_img_"+i).attr("src",""+$("#tel_main_img_"+j).val());
        var tel_html="";
        tel_html += "<span class='txt'>"+$("#tel_start_date_"+j).val()+" 부터</span><span class='blue'>"+$("#tel_stay_"+j).val()+"박</span>";
        tel_html += "<span class='blue'>["+$("#tel_name_"+j).val()+"]"+$("#room_name_"+j).val()+"</span><span class='txt'>"+$("select[name=room_vehicle]").val()+"객실</span>";
        $("#selected_tel_"+i).html(tel_html);

        overlays_close("overlay", "lodge_layer");
        total_price();
    }
    function reservation(i) {
        //   console.log($("#air_frm").serialize());
        $("#air_real_frm").submit();

    }
    $(document).ready(function () {
        t_stay_list();
        $(".overlay").click(function () {
            overlays_close("overlay", "lodge_layer")
        });
        $("#reserv_btn").click(function () {
           $("#lodge_frm").submit();
        });
    });
    function tel_layer_detail(i) {
        overlays_view("overlay","lodge_layer");
        $("#tel_date").html($("#tel_date_"+i).val());

        $("select[name=l_adult_number]").val($("select[name=ad_number]").val());
        $("select[name=l_child_number]").val($("select[name=ch_number]").val());
        $("select[name=l_baby_number]").val($("select[name=ba_number]").val());
        $("#tel_right").html("");
        tel_list(i);
    }
    function dd_loc() {
        if($(":radio[name=dd_lodge]:checked").val() == "D") {
            window.location.href = "dd_lodge.php?" + $("#tel_frm").serialize();
        }else{
            window.location.href = "tel.php?" + $("#tel_frm").serialize();
        }
    }
    function total_price() {

        var total_price = 0;


        var tel = $("#tel_price").val();
        var stay = $("select[name=tel_stay]").val()


        var tel = 0;
        for(var i=0 ;i < stay;i++ ){

            tel += Number($("#room_total_price_" + i).val());
        }

        total_price = Number(tel) ;

        $("#total").html(set_comma(total_price)+"원");
    }
    $( function() {
        var dates =   $( "#start_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
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