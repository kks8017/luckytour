<?php include_once ("../header.sub.php");?>
<?php
$air  = new air();
$rent = new rent();
$tel  = new lodging();
$bus  = new bus();
$bustour = new bustour();
$golf = new golf();
$member = new member();
if($_SESSION['user_id']) {
    $member->user_id = $_SESSION['user_id'];
    $info = $member->user_info();
}
$main->pack_type = $_REQUEST['package'];
$pack_text = $main->pack_text();

?>
    <link rel="stylesheet" href="../css/reserve_info.css" />

    <div id="content">
        <div class="search">
            <div class="search_tit">
                <span class="bar mar"></span>
                <h3>예약정보입력</h3>
                <span class="bar"></span>
            </div>
        </div>

        <div class="reserve_info">
            <form id="reserv_frm" action="reservation_process.php" method="post">
                <h4><img src="../sub_img/dot.png" />상품 상세정보</h4>
                <div class="goods_detail">
                    <table>
                        <tr>
                            <td class="res-info-title">
                                상품명
                            </td>
                            <td class="res-info-text">
                                <span class="res-info-text-item"><?=$pack_text?> </span>
                            </td>
                        </tr>
                        <?if($_REQUEST['package']=="C" || $_REQUEST['package']=="B"){?>
                        <?}else{?>
                            <tr>
                                <td class="res-info-title">
                                    여행인원
                                </td>
                                <td class="res-info-text">
                                    성인 <span class="res-info-text-num"><?=$_REQUEST['adult_number']?>명</span>, 소아 <span class="res-info-text-num"><?=$_REQUEST['child_number']?>명</span>, 유아 <span class="res-info-text-num"><?=$_REQUEST['baby_number']?>명</span> (항공, 숙박, 차량 요금에 적용되는 인원 기준입니다.)
                                </td>
                            </tr>

                        <?}?>
                        <input type="hidden" name="start_date" value="<?=$_REQUEST['start_date']?>">
                        <input type="hidden" name="end_date" value="<?=$_REQUEST['end_date']?>">
                        <input type="hidden" name="adult_number" value="<?=$_REQUEST['adult_number']?>">
                        <input type="hidden" name="child_number" value="<?=$_REQUEST['child_number']?>">
                        <input type="hidden" name="baby_number" value="<?=$_REQUEST['baby_number']?>">
                        <input type="hidden" name="package" value="<?=$_REQUEST['package']?>">
                        <?php
                        if(strpos($_REQUEST["package"],"A")!== false){
                            $air->air_no = $_REQUEST['air_company_no'];
                            $air_list = $air->air_selected();
                            //   print_r($air_list);


                            $air_oil = get_oil($air_list['a_sch_departure_date']);

                            if($air_list['a_sch_adult_sale']==0){
                                $air_com = get_comm($air_list['a_sch_departure_date']);
                            }else{
                                $air_com = 0;
                            }

                            $a_sch_normal_price = ($air_list['a_sch_adult_normal_price'] + $air_oil +$air_com ) ;

                            $a_sch_adult_sale_price = ($air_list['a_sch_adult_sale_price'] + $air_oil +$air_com) * $_REQUEST['adult_number'];
                            $a_sch_child_sale_price = ($air_list['a_sch_child_sale_price'] + $air_oil +$air_com) * $_REQUEST['child_number'];
                            $a_sch_adult_deposit_price = ($air_list['a_sch_adult_deposit_price'] + $air_oil +$air_com) * $_REQUEST['adult_number'];
                            $a_sch_child_deposit_price = ($air_list['a_sch_child_deposit_price'] + $air_oil +$air_com) * $_REQUEST['child_number'];

                            $total_air_price = $a_sch_adult_sale_price + $a_sch_child_sale_price;

                            ?>
                            <tr>
                                <td class="res-info-title">
                                    할인항공
                                </td>
                                <td class="res-info-text">
                                    <span class="res-info-text-item">[<?=$air_list['a_sch_departure_airline_name']?>]</span> <span class="res-info-text-num"><?=$air_list['a_sch_departure_area_name']?></span>출발 <?=$air_list['a_sch_departure_date']?> (<?=substr($air_list['a_sch_departure_time'],0,5)?>)     <span class="res-info-text-num">제주</span>출발 <?=$air_list['a_sch_arrival_date']?> (<?=substr($air_list['a_sch_arrival_time'],0,5)?>)
                                </td>
                            </tr>
                            <input type="hidden" name="air_no" value="<?=$_REQUEST['air_no']?>">
                            <input type="hidden" name="air_company_no" value="<?=$_REQUEST['air_company_no']?>">
                            <input type="hidden" name="air_type" value="<?=$_REQUEST['air_type']?>">
                        <?}?>
                        <?php
                        if(strpos($_REQUEST["package"],"T")!== false) {
                            if ($_POST['tel_t'] == "D") {
                                $total_tel_price = 0;
                                for($i=0;$i < count($_POST['tel_no']) ;$i++) {
                                    $tel->lodno = $_REQUEST['tel_no'][$i];
                                    $tel->roomno = $_REQUEST['room_no'][$i];
                                    $tel->start_date = $_REQUEST['tel_start_date'][$i];
                                    $tel->lodging_vehicle = $_REQUEST['tel_vehicle'][$i];
                                    $tel->adult_number = $_REQUEST['adult_number'];
                                    $tel->child_number = $_REQUEST['child_number'];
                                    $tel->baby_number = $_REQUEST['baby_number'];
                                    $tel->stay = $_REQUEST['tel_stay'][$i];
                                    $tel_list = $tel->lodging_room_name();

                                    $lodging_price = $tel->lodging_main_price();


                                    if (strlen($_REQUEST['package']) == 1 and $_REQUEST['package'] != "T") {
                                        $total_tel_price += (($lodging_price[1] * $_REQUEST['tel_vehicle'][$i]) );
                                    } else if (strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] != "T") {
                                        $total_tel_price += (($lodging_price[2] * $_REQUEST['tel_vehicle'][$i]));
                                    } else {
                                        $total_tel_price += (($lodging_price[0] * $_REQUEST['tel_vehicle'][$i]) );
                                    }

                                    ?>
                                    <tr>
                                        <td class="res-info-title">
                                            숙박
                                        </td>
                                        <td class="res-info-text">
                                        <span class="res-info-text-item">[<?= $tel_list[0] ?>
                                            ]</span> <?= $tel_list[1] ?> <?= $_REQUEST['tel_vehicle'][$i] ?>실
                                            (<?= $_REQUEST['tel_start_date'][$i] ?> 입실 / <span
                                                    class="res-info-text-num"><?= $_REQUEST['tel_stay'][$i] ?>박</span>)
                                        </td>
                                    </tr>
                                    <input type="hidden" name="tel_no[]" value="<?= $_REQUEST['tel_no'][$i] ?>">
                                    <input type="hidden" name="room_no[]" value="<?= $_REQUEST['room_no'][$i] ?>">
                                    <input type="hidden" name="tel_start_date[]" value="<?= $_REQUEST['tel_start_date'][$i] ?>">
                                    <input type="hidden" name="tel_vehicle[]" value="<?= $_REQUEST['tel_vehicle'][$i] ?>">
                                    <input type="hidden" name="tel_stay[]" value="<?= $_REQUEST['tel_stay'][$i] ?>">

                                    <?
                                }
                            } else {
                                $tel->lodno = $_REQUEST['tel_no'];
                                $tel->roomno = $_REQUEST['room_no'];
                                $tel->start_date = $_REQUEST['tel_start_date'];
                                $tel->lodging_vehicle = $_REQUEST['tel_vehicle'];
                                $tel->stay = $_REQUEST['tel_stay'];
                                $tel->adult_number = $_REQUEST['adult_number'];
                                $tel->child_number = $_REQUEST['child_number'];
                                $tel->baby_number = $_REQUEST['baby_number'];
                                $tel_list = $tel->lodging_room_name();

                                $lodging_price = $tel->lodging_main_price();

                                if (strlen($_REQUEST['package']) == 1 and $_REQUEST['package'] != "T") {
                                    $total_tel_price = (($lodging_price[1] * $_REQUEST['tel_vehicle']) );
                                } else if (strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] != "T") {
                                    $total_tel_price = (($lodging_price[2] * $_REQUEST['tel_vehicle']) );
                                } else {
                                    $total_tel_price = (($lodging_price[0] * $_REQUEST['tel_vehicle']));
                                }

                                ?>
                                <tr>
                                    <td class="res-info-title">
                                        숙박
                                    </td>
                                    <td class="res-info-text">
                                        <span class="res-info-text-item">[<?= $tel_list[0] ?>
                                            ]</span> <?= $tel_list[1] ?> <?= $_REQUEST['tel_vehicle'] ?>실
                                        (<?= $_REQUEST['tel_start_date'] ?> 입실 / <span
                                                class="res-info-text-num"><?= $_REQUEST['tel_stay'] ?>박</span>)
                                    </td>
                                </tr>
                                <input type="hidden" name="tel_no" value="<?= $_REQUEST['tel_no'] ?>">
                                <input type="hidden" name="room_no" value="<?= $_REQUEST['room_no'] ?>">
                                <input type="hidden" name="tel_start_date" value="<?= $_REQUEST['tel_start_date'] ?>">
                                <input type="hidden" name="tel_vehicle" value="<?= $_REQUEST['tel_vehicle'] ?>">
                                <input type="hidden" name="tel_stay" value="<?= $_REQUEST['tel_stay'] ?>">
                            <?
                            }
                            ?>
                            <input type="hidden" name="tel_t" value="<?= $_REQUEST['tel_t'] ?>">
                        <?
                        }
                        ?>
                        <?php
                        if(strpos($_REQUEST["package"],"C")!== false) {
                            $sql_com = "select no from rent_company where rent_com_type='대표'";
                            $rs_com  = $db->sql_query($sql_com);
                            $row_com = $db->fetch_array($rs_com);
                            $rent->carno = $_REQUEST['car_no'];
                            $rent->comno = $row_com['no'];
                            $rent_list = $rent->car_list();
                            $rent->start_date =$_REQUEST['car_sdate']." ".$_REQUEST['car_stime'];
                            $rent->end_date = $_REQUEST['car_edate']." ".$_REQUEST['car_etime'];
                            $rent_time = $rent->rent_time();
                            $fuel = $rent->rent_code_name($rent_list['rent_car_fuel']);

                            $rent_price = $rent->rent_price_main();
                            if(strlen($_REQUEST['package'])  == 1 and $_REQUEST['package'] !="C" ){
                                $total_rent_price = $rent_price[1] * $_REQUEST['car_vehicle'];
                            }else if(strlen($_REQUEST['package']) > 1 and $_REQUEST['package'] !="C" ){
                                $total_rent_price = $rent_price[2] * $_REQUEST['car_vehicle'];
                            }else{
                                $total_rent_price = $rent_price[0] * $_REQUEST['car_vehicle'];
                            }

                            ?>
                            <tr>
                                <td class="res-info-title">
                                    렌터카
                                </td>
                                <td class="res-info-text"><span class="res-info-text-item">[<?= $rent_list['rent_car_name'] ?>](<?=$fuel?>)</span> <?= $_REQUEST['car_vehicle'] ?>대 <span
                                            class="res-info-text-num"><?= $rent_time[0] ?>시간</span>
                                    대여일정: <?= $_REQUEST['car_sdate'] . " " . $_REQUEST['car_stime'] ?>
                                    ~ <?= $_REQUEST['car_edate'] . " " . $_REQUEST['car_etime'] ?>
                                </td>
                            </tr>
                            <input type="hidden" name="car_no" value="<?=$_REQUEST['car_no']?>">
                            <input type="hidden" name="car_sdate" value="<?= $_REQUEST['car_sdate'] . " " . $_REQUEST['car_stime'] ?>">
                            <input type="hidden" name="car_edate" value="<?= $_REQUEST['car_edate'] . " " . $_REQUEST['car_etime'] ?>">
                            <input type="hidden" name="car_vehicle" value="<?=$_REQUEST['car_vehicle']?>">
                            <?php
                        }
                        ?>
                        <?php
                        if(strpos($_REQUEST["package"],"B")!== false) {
                            $bus->bus_no = $_REQUEST['bus_no'];
                            $bus->start_date = $_REQUEST['bus_date'];
                            $bus->stay = $_REQUEST['bus_stay'];
                            $bus->bus_vehicle = $_REQUEST['bus_vehicle'];
                            $bus_list = $bus->bus_name();
                            if($_REQUEST['bus_stay']==""){
                                $_REQUEST['bus_stay'] =0;
                            }
                            $bus_stay =0;
                            $bus_stay = $_REQUEST['bus_stay']-1;
                            $bus_edate   =  date("Y-m-d", strtotime($_REQUEST['bus_date']." +{$bus_stay} days"));
                            $bus_price = $bus->bus_price();
                            $total_bus_price =$bus_price[0];
                            ?>
                            <tr>
                                <td class="res-info-title">
                                    버스/택시
                                </td>
                                <td class="res-info-text">
                                    <span class="res-info-text-item">[<?=$bus_list?>]</span> <?=$_REQUEST['bus_vehicle']?>대 <span
                                            class="res-info-text-num"><?=$_REQUEST['bus_stay']?>일</span> 대여일정: <?=$_REQUEST['bus_date']?> ~ <?=$bus_edate?>
                                </td>
                            </tr>
                            <input type="hidden" name="bus_no" value="<?=$_REQUEST['bus_no']?>">
                            <input type="hidden" name="bus_date" value="<?=$_REQUEST['bus_date']?>">
                            <input type="hidden" name="bus_stay" value="<?=$_REQUEST['bus_stay']?>">
                            <input type="hidden" name="bus_vehicle" value="<?=$_REQUEST['bus_vehicle']?>">
                            <?php
                        }
                        ?>
                        <?php
                        if(strpos($_REQUEST["package"],"P")!== false) {
                            $bustour->bustour_no = $_REQUEST['bustour_no'];
                            $bustour_list = $bustour->bustour_name();
                            $bustour->start_date = $start_date;
                            $bustour->number = ($_REQUEST['adult_number']+$_REQUEST['child_number']);
                            $total_bustour_price = $bustour->bustour_price();

                            ?>
                            <tr>
                                <td class="res-info-title">
                                    버스투어
                                </td>
                                <td class="res-info-text">
                                    <span class="res-info-text-item">[<?=$bustour_list[0]['bustour_tour_name']?>]</span> <span class="res-info-text-num"><?=$bustour_list[0]['bustour_tour_stay']?>일</span> 여행일 : <?=$_REQUEST['start_date']?>
                                </td>
                            </tr>
                            <input type="hidden" name="bustour_no" value="<?=$_REQUEST['bustour_no']?>">
                            <input type="hidden" name="bustour_date" value="<?=$_REQUEST['start_date']?>">
                            <input type="hidden" name="bustour_number" value="<?=($_REQUEST['adult_number']+$_REQUEST['child_number'])?>">
                            <?php
                        }
                        ?>
                        <?php

                        if(strpos($_REQUEST["package"],"G")!== false) {

                            for($i=0;$i <count($_REQUEST['golf_no']);$i++){
                                $golf->golf_no = $_REQUEST['golf_no'][$i];
                                $golf->hole_no = $_REQUEST['hole_no'][$i];
                                $golf_name = $golf->golf_name();
                                $golf->adult_number =$_REQUEST['golf_number'][$i];
                                $golf->start_date = $_REQUEST['golf_date'][$i];
                                $golf->stay =1;
                                $total_golf_price = $golf->golf_main_price();
                                ?>
                                <tr>

                                    <td class="res-info-title">
                                        골프 <?=($i+1)?>일차
                                    </td>
                                    <td class="res-info-text">

                                        <span class="res-info-text-item">[<?=$golf_name[0]?>]</span> <?=$golf_name[1]?> (<?=$_REQUEST['golf_no'][$i]?> <?=$_REQUEST['golf_time'][$i]?>:00~ / <span  class="res-info-text-num">1일</span>)

                                    </td>

                                </tr>
                                <input type="hidden" name="golf_no[]" value="<?=$_REQUEST['golf_no'][$i]?>">
                                <input type="hidden" name="hole_no[]" value="<?=$_REQUEST['hole_no'][$i]?>">
                                <input type="hidden" name="golf_date[]" value="<?=$_REQUEST['golf_date'][$i]?>">
                                <input type="hidden" name="golf_number[]" value="<?=$_REQUEST['golf_number'][$i]?>">
                                <input type="hidden" name="golf_time[]" value="<?=$_REQUEST['golf_time'][$i]?>">
                            <?}?>
                            <?
                        }
                     //   echo "$total_price = $total_air_price + $total_rent_price + $total_tel_price + $total_bus_price + $total_bustour_price + $total_golf_price";
                        $total_price = $total_air_price + $total_rent_price + $total_tel_price + $total_bus_price + $total_bustour_price[0] + $total_golf_price;
                        ?>
                        <tr>
                            <td class="res-info-title">
                                총결제액
                            </td>
                            <td class="res-info-text">
                                <span class="res-info-text-num"><?=set_comma($total_price)?>원</span> (확인전화를 드리기전까지 예약확정이 아니라 예약접수 상태입니다.)
                            </td>
                        </tr>
                    </table>
                </div>

                <h4><img src="../sub_img/dot.png" />예약자 정보 입력</h4>
                <div class="reserve_input">
                    <p class="radio_box"><input type="radio" name="nameall" value="Y" onclick="rename();" />
                        <span class="ma">예약자와 사용자 동일</span>
                        <input type="radio"  name="nameall" value="N" onclick="rename();" checked="checked"/><span>예약자와 사용자 다름</span></p>
                    <div class="lcon">
                        <p class="b">예약자</p>
                        성명 <input type="text" name="name" id="name" placeholder="홍길동" value="<?=$info['user_name']?>" checked="checked"/>
                        연락처 <input type="text" name="phone" id="phone" placeholder="010-0000-0000" value="<?=$info['user_phone']?>"/>
                        이메일 <input type="text" name="email" id="email" class="email" placeholder="(예)tour@naver.com" value="<?=$info['user_email']?>" /><br>
                        <p>요청사항</p>
                        <textarea name="reserv_inquiry"></textarea>
                    </div>
                    <div class="rcon">
                        <p class="b">사용자</p>
                        성명 <input type="text" name="real_name" id="real_name" value=""/>
                        연락처 <input type="text" name="real_phone" id="real_phone"  value=""/>
                        이메일 <input type="text" name="real_email" id="real_email" class="email" value=""/><br>
                        <p>요청사항</p>
                        <textarea name="reserv_real_inquiry"></textarea>
                    </div>
                </div>
               <?  if(strpos($_REQUEST["package"],"A")!== false){?>
                <h4><img src="../sub_img/dot.png" />탑승자 명단 입력</h4>
                <div class="res-parson">
                    <table>

                            <tr>
                                <td class="res-parson-title">
                                    성인 탑승자명단
                                </td>
                                <td class="res-parson-text" colspan="3">
                                    <textarea type="text" name="adult_name" id="adult_name_<?=$j?>" placeholder="(예)홍길동,홍길동"></textarea>
                               </td>
                            </tr>
                           <tr>
                                <td class="res-parson-title">
                                    소아 탑승자명단
                                </td>
                                <td class="res-parson-text" colspan="3">
                                    <textarea type="text" name="child_name" id="child_name_<?=$j?>" placeholder="(예)홍소아(생년월일),홍소아(생년월일)"></textarea>
                                </td>

                            </tr>


                            <tr>
                                <td class="res-parson-title">
                                    유아 탑승자명단
                                </td>
                                <td class="res-parson-text" colspan="3">
                                    <textarea type="text" name="baby_name" id="baby_name_<?=$j?>"  placeholder="(예)홍유아(생년월일),홍유아(생년월일)"></textarea>
                                </td>

                            </tr>


                    </table>
                </div>
               <?}?>

                <div class="agree1">
                    <div class="chk_agree">
                        <p><input type="checkbox" name="privacy" id="privacy" class="chk" value="Y"/><span>개인정보 수집 및 이용에 동의합니다. </span><a href="#none" id="privacy_open"><img src="../sub_img/view_btn.png" /></a></p>
                        <p><input type="checkbox" name="average" id="average" class="chk" value="Y"/><span>국내 여행 표준 약관에 동의합니다.</span><a href="#none" id="average_open"><img src="../sub_img/view_btn.png" /></a></p>
                        <p><input type="checkbox" name="cancel" id="cancel" class="chk" value="Y"/><span>여행상품이용약관 동의합니다.</span><a href="#none" id="cancel_open"><img src="../sub_img/view_btn.png" /></a></p>
                    </div>
                    <div class="all_agree">
                        <p><span>개인정보 수집 및 이용,국내여행 표준약관,여행상품이용약관 모두 동의 하십니까?</span></p>
                        <p><input type="checkbox" name="all_chk" id="all_chk" /><span class="b">전체동의</span><span>합니다.</span></p>
                    </div>
                </div>
                <div class="submit_btn">
                    <img type="button" id="reserv_btn"  src="../sub_img/reserve_confirm.png" style="cursor: pointer;" />
                </div>

            </form>
        </div>


    </div><!-- content 끝 -->
    <div class="overlay"></div>
    <div id="privacy_layer">
        <div class="privacy_layer"><?=$main_company['tour_privacy']?></div>
    </div>
    <div id="average_layer">
        <div class="average_layer"><?=$main_company['tour_average']?></div>
    </div>
    <div id="cancel_layer">
        <div class="cancel_layer"><?=$main_company['tour_cancel']?></div>
    </div>
    <script>

        function rename() {
            if($(":radio[name=nameall]:checked").val()=="Y") {
                $("#real_name").val($("#name").val());
                $("#real_phone").val($("#phone").val());
                $("#real_email").val($("#email").val());
            }else{
                $("#real_name").val();
                $("#real_phone").val();
                $("#real_email").val();
            }
        }
        $(document).ready(function () {
            var is_t = true;
            $("#all_chk").click(function () {
                $(".chk").prop("checked", function () {
                    return !$(this).prop("checked");
                });
            });
            $("#reserv_btn").click(function () {
                if($("#name").val() == ""){
                    alert("예약자명을 입력해주세요");
                    return false;
                }else if($("#phone").val() == "") {
                    alert("예약자 전화번호을 입력해주세요");
                    return false;
                }else if(!$('#privacy').is(':checked')){
                    alert("개인정보 수집 및 이용에 동의해주세요");
                    return false;
                }else if(!$('#average').is(':checked')){
                    alert("국내 여행 표준 약관에 동의해주세요");
                    return false;
                }else if(!$('#cancel').is(':checked')){
                    alert("여행상품이용약관 동의해주세요");
                    return false;
                }else {
                    <?if(strpos($_REQUEST['package'], 'A') !== false){?>
                    alert("항공명단을 안넣으실경우 진행이 느져질수있습니다.");
                    <?}?>
                    if(is_t==true){
                        is_t = false;
                        $("#reserv_frm").submit();
                        return true;
                    }else{
                        alert("예약입력중입니다");
                        return false;
                    }
                }
            })
        });
        function phone_chk(str){
            str = str.replace(/[^0-9]/g, '');
            var tmp = '';
            if( str.length < 4){
                return str;
            }else if(str.length < 7){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3);
                return tmp;
            }else if(str.length < 11){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 3);
                tmp += '-';
                tmp += str.substr(6);
                return tmp;
            }else{
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 4);
                tmp += '-';
                tmp += str.substr(7);
                return tmp;
            }
            return str;
        }

        var phone = document.getElementById('phone');
        phone.onkeyup = function(event){
            event = event || window.event;
            var _val = this.value.trim();
            this.value = phone_chk(_val) ;
        }
        $("#privacy_open").click(function () {
            overlays_view("overlay","privacy_layer")
        });
        $("#average_open").click(function () {
            overlays_view("overlay","average_layer")
        });
        $("#cancel_open").click(function () {
            overlays_view("overlay","cancel_layer")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","privacy_layer")
            overlays_close("overlay","average_layer")
            overlays_close("overlay","cancel_layer")
        });
    </script>

<?php include_once ("../footer.php");?>