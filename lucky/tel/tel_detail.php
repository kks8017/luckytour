<?php include_once ("../header.sub.php");?>
<?php
$start_date = $_GET['start_date'];
$end_date   =$_GET['end_date'];

if($start_date==""){$start_date = $main_company['start_date'];}
if($end_date==""){$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));}

$lodging = new lodging();
$main = new main();
$adult_number        = $_GET['adult_number'];
$child_number        = $_GET['child_number'];
$baby_number         = $_GET['baby_number'];
$package             = $_GET['package'];
$tel_no              = $_GET['tel_no'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$stay =  ( strtotime($end_date) - strtotime($start_date) ) / 86400;

$lodging_vehicle      = $_GET['room_vehicle'];
$lodging->lodno = $_GET['tel_no'];
$lodging->start_date = $start_date;
$lodging->stay = $stay;
$lodging->adult_number = $adult_number;
$lodging->child_number = $child_number;
$lodging->baby_number  = $baby_number;
$lodging->lodging_vehicle = $lodging_vehicle;
$tel_name = $lodging->lodging_detail();
$room_list = $lodging->room_list();
$lodging_main_image = $lodging->lodging_main_image();
$lodging_sub_image = $lodging->lodging_sub_image();
$tel_no= $_GET['tel_no'];

$area = $lodging->lodging_code_name($tel_name['lodging_area']);
$image_dir = "../".KS_DATA_DIR."/".KS_LOD_DIR;
$image_room_dir = "../".KS_DATA_DIR."/".KS_ROOM_DIR;
?>
<script>
    function img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }

</script>
<div id="content">
    <div class="search">
        <div class="search_tit">
            <!--<img src="./image/bar2.png" />-->
            <span class="bar mar"></span>
            <h3>숙소 상세보기</h3>
            <span class="bar"></span>
            <!-- <img src="./image/bar2.png" />-->
        </div>
    </div>

    <!-- 상세시작 -->
    <div class="top">
        <div class="pic">
            <p><img src="<?=$image_dir?>/<?=$lodging_main_image?>" class="show_img"/></p>
            <ul>
                <?php
                $i=0;
                foreach ($lodging_sub_image as $image){
                    ?>
                    <li><a href="#none"><img onmouseover="img_mod(<?=$i?>);" class="s_img_<?=$i?>" src="<?=$image_dir?>/<?=$image['lodging_image_file_m']?>" width="97px" height="63px"/></a></li>
                    <?
                    $i++;
                }
                ?>

            </ul>
        </div>
        <div class="pic_info">
            <table width="100%">
                <tr>
                    <td colspan="2" class="hotel_name">>> <?=$tel_name['lodging_name']?></td>
                </tr>
                <tr>
                    <th>숙소위치</th><td><?=$tel_name['lodging_address']?></td>
                </tr>
                <tr>
                    <th>부대시설</th><td><?=$tel_name['lodging_facility']?></td>
                </tr>
                <tr>
                    <th>1인추가요금</th><td><?=$tel_name['lodging_additional']?></td>
                </tr>
                <tr>
                    <th>이벤트</th><td class="special"><?=$tel_name['lodging_event']?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="middle">
        <ul class="tabmenu">
            <li><a href="#none" class="first">숙소 예약하기</a></li>
            <li><a href="#none" class="second">숙소설명 및 특전</a></li>
            <li><a href="#none" class="third">객실정보</a></li>
            <li><a href="#none" class="fourth">숙소위치정보</a></li>
        </ul>
        <div class="tab_contents">
            <div class="tab1">
                <div  id="calender" class="lcon">

                </div>
                <div class="rcon">
                    <p>원하시는 객실을 선택하시면 왼쪽 달력에 해당객실 요금이 보여집니다.</p>

                    <form action="../member/login_reservation.php" method="post">
                        <div class="tbl_wrap">
                            <table>
                                <tr>
                                    <th>객실선택</th><td><select name="room_no"  class="lsel" onchange="cal()">
                                           <?foreach ($room_list as $room){?>
                                                 <option value="<?=$room['no']?>"><?=$room['lodging_room_name']?>/기준<?=$room['lodging_room_min']?>인, 최대<?=$room['lodging_room_max']?>인</option>
                                            <?}?>

                                        </select></td>
                                </tr>
                                <tr>
                                    <th>입실일자</th><td><input type="text" name="tel_start_date" id="start_date" class="date" value="<?=$start_date?>" readonly/><span class="com">좌측 달력에서 선택해 주세요</span></td>
                                </tr>
                                <tr>
                                    <th>일정</th><td><select name="tel_stay" class="csel" onchange="cal()">
                                            <?php
                                            $main->stay_option($stay);
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>인원</th><td>
                                        <select name="adult_number" class="csel" onchange="cal()">
                                            <?php
                                                $main->number_option("{$adult_number}","성인");
                                            ?>
                                        </select>
                                        <select name="child_number" class="csel" onchange="cal()">
                                            <?php
                                            $main->number_option("{$child_number}","소아");
                                            ?>
                                        </select>
                                        <select name="baby_number" class="csel" onchange="cal()">
                                            <?php
                                            $main->number_option("{$baby_number}","유아");
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>객실수</th><td>
                                        <select name="tel_vehicle"  class="csel" onchange="cal()">
                                            <?php
                                            $main->vehicle_option($lodging_vehicle,"실");
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>총요금</th><td><span id="price" class="price">0원</span><span class="dec">최대인원 초과시 입실불가</span></td>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="tel_no" value="<?=$tel_no?>">
                        <input type="hidden" name="package_type" value="T">
                        <input type="submit" value="예약하기" />
                    </form>

                </div>
            </div>
            <div class="tab2">
                <?=$tel_name['lodging_content']?>
            </div>
            <div class="tab3">
                <?php
                $j=0;
                $room_list = $lodging->room_list();
                foreach ($room_list as $room){
                    ?>
                    <script>
                        function room_img_mod_<?=$j?>(i) {
                            console.log($(".room_s_img_"+i).attr("src"));
                            $("#room_big_<?=$j?>").attr("src",$(".room_s_img_"+i).attr("src"));
                        }

                    </script>
                <div class="tab3_wrap1">

                    <div class="pic">
                        <?php
                        $lodging->roomno = $room['no'];
                        $room_sub_image = $lodging->room_sub_image(7);
                        $room_main_image = $lodging->room_main_image();

                        $lodging_price = $lodging->lodging_main_price();
                        $sale_lod_price = (($lodging_price[0] * $lodging_vehicle) + $lodging_price[3]);

                        if($room_main_image){
                            $room_main_image = $room_main_image;
                        }else{
                            $room_main_image = "";
                        }
                        $lodging_basic_price = $lodging->lodging_basic_price();
                        $basic_price = $lodging_basic_price[5];

                        $percent = $sale_lod_price / $basic_price * 100;
                        $add_percent =  round($percent, 0);
                        $total_percent =100 - $add_percent;

                        ?>
                        <p><img src="<?=$image_room_dir?>/<?=$room_main_image?>" id="room_big_<?=$j?>" class="show_pic" width="532" height="329"/></p>
                        <ul>
                            <?php
                            $i=0;
                            if(is_array($room_sub_image)) {
                                foreach ($room_sub_image as $image_sub) {
                            ?>
                                    <li><a href="#none"><img class="room_s_img_<?=$i?>" src="<?= $image_room_dir ?>/<?=$image_sub['lodging_room_image_file_m']?>" onmouseover="room_img_mod_<?=$j?>(<?=$i?>);" width="72px" height="48px"/></a></li>
                            <?
                                    $i++;
                                }
                            }else{
                             ?>
                                <li><a href="#none"><img src="" class="thm1"/></a></li>
                            <?}?>

                        </ul>
                    </div>
                    <div class="pic_info">
                        <div class="tbl_wrap">
                            <table width="100%">
                                <tr>
                                    <th>객실명</th><td class="land"><?=$room['lodging_room_name']?></td>
                                </tr>
                                <tr>
                                    <th>객실구조</th><td><?=$room['lodging_room_structure']?></td>
                                </tr>
                                <tr>
                                    <th>객실전망</th><td><?=$room['lodging_room_view']?></td>
                                </tr>
                                <tr>
                                    <th>입실기준인원</th><td><span class="inwon"><?=$room['lodging_room_min']?>명/최대<?=$room['lodging_room_max']?>명</span> (기준인원 초과시 추가요금발생)</td>
                                </tr>
                                <tr>
                                    <th>1인추가요금</th><td><?=$tel_name['lodging_additional']?></td>
                                </tr>
                                <tr>
                                    <th>구비사항</th><td><?=$room['lodging_room_satisfy']?></td>
                                </tr>
                                <tr>
                                    <th>1박요금</th><td>입실기준 : <?=set_comma($basic_price)?>원 → (↓<?=$total_percent?>%) <span class="price"><?=set_comma($sale_lod_price)?>원</span></td>
                                </tr>
                                <tr>
                                    <th class="direct">패키지예약<br>바로가기</th><td><button>항공,렌트추가</button><button>항공추가</button><button>렌트추가</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                    <div style="clear: both;"></div>
                <?
                    $j++;
                }
                ?>
            </div><!-- tab3 끝 -->

            <div class="tab4">
                <div>
                    <div id="map">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 상세 끝 -->


</div><!-- content 끝 -->
<script>
    function cal(date) {
        var url = "cal.php"; // the script where you handle the form input.
        if(date=="" || date==undefined){
            var date = $("#start_date").val();
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "tel_no=<?=$tel_no?>&room_no="+$("select[name=room_no]").val()+"&start_date="+date+"&stay="+$("select[name=tel_stay]").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val()+"&baby_number="+$("select[name=baby_number]").val()+"&area="+$("select[name=area]").val()+"&type="+$("select[name=type]").val()+"&search_name="+$("#search_name").val()+"&room_vehicle="+$("select[name=tel_vehicle]").val()+"&package="+$("select[name=package]").val(), // serializes the form's elements.
                success: function (data) {
                $("#calender").html(data); // show response from the php script.
                //console.log(data);
                $("#price").html(set_comma($("#total_price").val()));
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
            }
        });
    }
    function map_view() {
        var url = "map.php"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "tel_no=<?=$tel_no?>", // serializes the form's elements.
            success: function (data) {
                console.log(data);
                $("#map").html(data); // show response from the php script.

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function select_day(date_s) {
        $("#start_date").val(date_s);
        cal(date_s);
    }


    $(document).ready(function(){
        $(".middle .tabmenu li a.first").click(function(){
            $(".middle .tabmenu li:nth-child(1)").css({"background-color":"#4474cc"});
            $(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
            $(".middle .tabmenu li a.first").css({"color":"#fff"});
            $(".middle .tabmenu li a.second").css({"color":"#000"});
            $(".middle .tabmenu li a.third").css({"color":"#000"});
            $(".middle .tabmenu li a.fourth").css({"color":"#000"});
            $(".middle .tab_contents .tab1").show();
            $(".middle .tab_contents .tab2").hide();
            $(".middle .tab_contents .tab3").hide();
            $(".middle .tab_contents .tab4").hide();

        });
        $(".middle .tabmenu li a.second").click(function(){
            $(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(2)").css({"background-color":"#4474cc"});
            $(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
            $(".middle .tabmenu li a.first").css({"color":"#000"});
            $(".middle .tabmenu li a.second").css({"color":"#fff"});
            $(".middle .tabmenu li a.third").css({"color":"#000"});
            $(".middle .tabmenu li a.fourth").css({"color":"#000"});
            $(".middle .tab_contents .tab1").hide();
            $(".middle .tab_contents .tab2").show();
            $(".middle .tab_contents .tab3").hide();
            $(".middle .tab_contents .tab4").hide();
        });
        $(".middle .tabmenu li a.third").click(function(){
            $(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(3)").css({"background-color":"#4474cc"});
            $(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
            $(".middle .tabmenu li a.first").css({"color":"#000"});
            $(".middle .tabmenu li a.second").css({"color":"#000"});
            $(".middle .tabmenu li a.third").css({"color":"#fff"});
            $(".middle .tabmenu li a.fourth").css({"color":"#000"});
            $(".middle .tab_contents .tab1").hide();
            $(".middle .tab_contents .tab2").hide();
            $(".middle .tab_contents .tab3").show();
            $(".middle .tab_contents .tab4").hide();
        });
        $(".middle .tabmenu li a.fourth").click(function(){
            $(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
            $(".middle .tabmenu li:nth-child(4)").css({"background-color":"#4474cc"});
            $(".middle .tabmenu li a.first").css({"color":"#000"});
            $(".middle .tabmenu li a.second").css({"color":"#000"});
            $(".middle .tabmenu li a.third").css({"color":"#000"});
            $(".middle .tabmenu li a.fourth").css({"color":"#fff"});
            $(".middle .tab_contents .tab1").hide();
            $(".middle .tab_contents .tab2").hide();
            $(".middle .tab_contents .tab3").hide();
            $(".middle .tab_contents .tab4").show();
            map_view();
        });
        cal('<?=$start_date?>');
    });

</script>

<?php include_once ("../footer.php");?>
