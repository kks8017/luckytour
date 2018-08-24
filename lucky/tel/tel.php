<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/lodge.css" />
<?php
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$lod_area = $_POST['lod_area'];
$lod_type = $_POST['lod_type'];
$search_name = $_POST['search_name'];




if(!$start_date) {
    $start_date = date("Y-m-d",time());
}
if(!$end_date) {
    $end_date = date("Y-m-d", strtotime($start_date . " +1 days"));
}

?>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar mar"></span>
            <h3>숙박</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
        <div class="search_bar">
            <form id="tel_frm">
                <ul>
                    <li><p>가는날</p><input type="text" name="start_date" id="start_date" class="air_date" value="<?=$start_date?>" style="vertical-align:top"/></li>
                    <li><p>오는날</p><input type="text" name="end_date" id="end_date" class="air_date" value="<?=$end_date?>" style="vertical-align:top"/></li>
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
                    <li>  <p>객실수</p> <select name="room_vehicle" class="lsel">
                            <?php
                            $main->vehicle_option("","실");
                            ?>
                        </select></li>

                </ul>
            </form>
            <div class="btn"><img type="buttom" id="tel_sch_btn" src="../sub_img/big_search_btn.png" /></div>
        </div>
    </div>



    <div class="package_tabmenu">

        <div class="area">

            <div class="lodge_area">
                <div class="lodge_search">


                            <p>위치별<select name="area" class="sel" >
                                    <?php
                                    $main->lodging_area_list($lod_area);
                                    ?>
                                </select>
                                유형별 <select name="type" class="sel">
                                    <?php
                                    $main->lodging_type_list($lod_type);
                                    ?>
                                </select>

                                숙소명검색 <input type="text" id="search_name" name="search_name" value="<?=$search_name?>" />
                                <img type="button" id="type_sch_btn" src="../sub_img/submit_btn.png" />
                            </p>


                </div>
                <div class="lodge_search">
                    <table>
                        <tr>
                            <td>
                                <input type="radio" name="dd_lodge" onclick="" value="N" checked><b>연박하기</b><span>(일정내내 같은숙소에서 숙박을 원하시면 선택하세요)</span>
                            </td>
                            <td>
                                <input type="radio" name="dd_lodge"  onclick="dd_loc();" value="D"><b>일정별로 따로따로 숙박하기</b><span>(일정별로 다른숙소에서 숙박을 원하시면 선택하세요)</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="lodge_list">
                </div>
            </div>
        </div>
    </div>

</div><!-- content 끝 -->
<script>
    function tel_list() {
        var url = "../list/tel_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&area="+$("select[name=area]").val()+"&type="+$("select[name=type]").val()+"&search_name="+$("#search_name").val()+"&room_vehicle="+$("select[name=room_vehicle]").val()+"&package="+$("select[name=package]").val()+"&case=dan", // serializes the form's elements.
            success: function (data) {
                $(".lodge_list").html(data); // show response from the php script.
                console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask('../sub_img/tel_loding.gif');
            },
            complete: function () {
                  closeWindowByMask();
            }
        });
    }
    function tel_detail(i) {
        window.location.href = "tel_detail.php?"+$("#tel_frm").serialize()+"&tel_no="+$("#lod_no_"+i).val();
    }
    function dd_loc() {
        if($(":radio[name=dd_lodge]:checked").val() == "D") {
            window.location.href = "dd_lodge.php?" + $("#tel_frm").serialize();
        }else{
            window.location.href = "tel.php?" + $("#tel_frm").serialize();
        }
    }
    $(document).ready(function () {
        tel_list();
        $("#tel_sch_btn").click(function () {
            tel_list();
        });
        $("#type_sch_btn").click(function () {
            tel_list();
        });

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

