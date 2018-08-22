<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$lodging = new lodging();

$adult_number        = $_POST['adult_number'];
$child_number        = $_POST['child_number'];
$baby_number         = $_POST['baby_number'];
$package             = $_POST['package'];
$tel_no              = $_POST['tel_no'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$stay =  ( strtotime($end_date) - strtotime($start_date) ) / 86400;

$lodging_vehicle      = $_POST['room_vehicle'];
$lodging->lodno = $_POST['tel_no'];
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

$area = $lodging->lodging_code_name($tel_name['lodging_area']);
$image_dir = "../".KS_DATA_DIR."/".KS_LOD_DIR;
$image_room_dir = "../".KS_DATA_DIR."/".KS_ROOM_DIR;

?>
<script>
    function img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }
    function room_img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }
    function close() {
        $(opener.location).attr("href","javascript:overlays_close('overlay','layer_d')");
    }
</script>
<div class="content">
    <h1>>><?=$tel_name['lodging_name']?>(<?=$area?>) </h1>

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
                <th width="46%">객실명</th>
                <th width="18%">인원/최대</th>
                <th width="18%">판매가</th>
                <th width="18%">예약</th>
            </tr>
            <?php
            $j=0;
            foreach ($room_list as $room){
                $lodging->roomno = $room['no'];
                $lodging_price = $lodging->lodging_main_price();

                if(strlen($package)  == 1 and $package !="T" ){
                    $sale_lod_price = (($lodging_price[1] * $lodging_vehicle) );
                }else if(strlen($package) > 1 and $package !="T" ){
                    $sale_lod_price = (($lodging_price[2] * $lodging_vehicle) );
                }else{
                    $sale_lod_price = (($lodging_price[0] * $lodging_vehicle) );
                }
                ?>
                <tr>
                    <td><span class="b"><?=$room['lodging_room_name']?></span><br>(<?=$lodging_vehicle?>객실)</td>
                    <td class="inwon"><?=$room['lodging_room_min']?>명/<?=$room['lodging_room_max']?>명</td>
                    <td class="price"><?=set_comma($sale_lod_price)?>원</td>
                    <td><a href="javascript:tel_selected(<?=$i?>,<?=$j?>)"><img src="../sub_img/select_btn2.png" /></a></td>
                </tr>
                <input type="hidden" name="tel_no" id="tel_no_<?=$j?>" value="<?=$tel_no?>">
                <input type="hidden" name="room_no" id="room_no_<?=$j?>" value="<?=$room['no']?>">
                <input type="hidden" name="tel_name" id="tel_name_<?=$j?>" value="<?=$tel_name['lodging_name']?>">
                <input type="hidden" name="room_name" id="room_name_<?=$j?>" value="<?=$room['lodging_room_name']?>">
                <input type="hidden" name="tel_start_date" id="tel_start_date_<?=$j?>" value="<?=$start_date?>">
                <input type="hidden" name="tel_stay" id="tel_stay_<?=$j?>" value="<?=$stay?>">
                <input type="hidden" name="tel_vehicle" id="tel_vehicle_<?=$j?>" value="<?=$lodging_vehicle?>">
                <input type="hidden" name="tel_total_price" id="tel_total_price_<?=$j?>" value="<?=$sale_lod_price?>">
            <?
                $j++;
            }
            ?>


        </table>
    </div>
    <div class="middle">
        <p class="tit">>> 숙소정보 및 이용안내</p>
        <div class="kcon">
            <table>
                <tr>
                    <th>숙소위치</th>
                    <td><?=$tel_name['lodging_address']?></td>
                </tr>
                <tr>
                    <th>부대시설</th>
                    <td><?=$tel_name['lodging_facility']?></td>
                </tr>
                <tr>
                    <th>추가요금</th>
                    <td><?=$tel_name['lodging_additional']?></td>
                </tr>
                <tr>
                    <th>이벤트</th>
                    <td><?=$tel_name['lodging_event']?></td>
                </tr>
                <tr>
                    <th>기본정보</th>
                    <td><?=$tel_name['lodging_content']?></td>
                </tr>
            </table>
        </div>

    </div> <!-- middle 끝-->
    <div class="foot">
        <p class="tit">>> 객실정보</p>
        <?php

        foreach ($room_list as $room){
            $lodging->roomno = $room['no'];
            $room_sub_image = $lodging->room_sub_image(6);
            $room_main_image = $lodging->room_main_image();

            if($room_main_image){
                $room_main_image = $room_main_image;
            }else{
                $room_main_image = "";
            }

            ?>
            <div class="lcon">
                <img src="<?=$image_room_dir?>/<?=$room_main_image?>" class="show_pic1"/>
                <ul>
                    <?php
                    $i=0;
                    if(is_array($room_sub_image)) {
                        foreach ($room_sub_image as $image_sub) {
                            ?>
                            <li><a href="#none"><img src="<?= $image_room_dir ?>/<?= $image_sub['lodging_room_image_file_m'] ?>" class="thm1"/></a></li>

                            <?
                        }
                    }else{
                        ?>
                        <li><a href="#none"><img src="" class="thm1"/></a></li>
                    <?}?>
                </ul>
            </div>
            <div class="rcon">
                <table>
                    <tr>
                        <th>객실명</th>
                        <td class="bold"><?=$room['lodging_room_name']?></td>
                    </tr>
                    <tr>
                        <th>객실구조</th>
                        <td><?=$room['lodging_room_structure']?></td>
                    </tr>
                    <tr>
                        <th>객실전망</th>
                        <td><?=$room['lodging_room_structure']?></td>
                    </tr>
                    <tr>
                        <th>입실 기준인원</th>
                        <td><?=$room['lodging_room_min']?>명/최대<?=$room['lodging_room_max']?>명(기준인원 초과시 추가요금 발생)</td>
                    </tr>
                    <tr>
                        <th>1인 추가요금</th>
                        <td><?=$tel_name['lodging_additional']?></td>
                    </tr>
                    <tr>
                        <th>구비사항</th>
                        <td><?=$room['lodging_room_satisfy']?></td>
                    </tr>
                </table>
            </div>
        <?}?>
    </div>
    <div class="map">
        <p class="tit">>> 숙소위치</p>
        <div style="font: 400 12px/normal dotum, sans-serif; width: 1390px; height: 813px; color: rgb(51, 51, 51); position: relative; font-size-adjust: none; font-stretch: normal;padding-left:10px;padding-right:30px"><div style="height: 780px;"><a href="http://map.daum.net/?urlX=388024.0&amp;urlY=7229.0&amp;itemId=15292731&amp;q=%EB%9D%BC%EB%A7%88%EB%8B%A4%ED%94%84%EB%9D%BC%EC%9E%90%EC%A0%9C%EC%A3%BC%ED%98%B8%ED%85%94&amp;srcid=15292731&amp;map_type=TYPE_MAP&amp;from=roughmap" target="_blank"><img width="1320" height="778" class="map" style="border: 1px solid rgb(204, 204, 204); border-image: none;" src="//t1.daumcdn.net/roughmap/imgmap/4f436b5d3866000116c7c2540fcce2814637f017f50f610f614ce01baaa5b231"></a></div><div><span style="left: 0px; top: 780px; width: 1390px; height: 33px; border-right-color: rgb(219, 219, 219); border-bottom-color: rgb(219, 219, 219); border-left-color: rgb(219, 219, 219); border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; position: absolute; box-sizing: border-box; background-color: rgb(249, 249, 249);"></span><span style="left: 12px; top: 787px; position: absolute;"><img src="//t1.daumcdn.net/localimg/localimages/07/2013/map/test/ico_road.gif"></span><a style="font: 400 12px/14px gulim, sans-serif; left: 29px; top: 791px; color: rgb(51, 51, 51); text-decoration: none; position: absolute; font-size-adjust: none; font-stretch: normal;" href="http://map.daum.net/?from=roughmap&amp;srcid=15292731&amp;confirmid=15292731&amp;q=%EB%9D%BC%EB%A7%88%EB%8B%A4%ED%94%84%EB%9D%BC%EC%9E%90%EC%A0%9C%EC%A3%BC%ED%98%B8%ED%85%94&amp;rv=on" target="_blank">로드뷰</a><span style="left: 81px; top: 787px; position: absolute;"><img src="//t1.daumcdn.net/localimg/localimages/07/2013/map/test/ico_street.gif"></span><a style="font: 400 12px/14px gulim, sans-serif; left: 97px; top: 791px; color: rgb(51, 51, 51); text-decoration: none; position: absolute; font-size-adjust: none; font-stretch: normal;" href="http://map.daum.net/?from=roughmap&amp;eName=%EB%9D%BC%EB%A7%88%EB%8B%A4%ED%94%84%EB%9D%BC%EC%9E%90%EC%A0%9C%EC%A3%BC%ED%98%B8%ED%85%94&amp;eX=388024.0&amp;eY=7229.0" target="_blank">길찾기</a></div>
        </div>
    </div> <!-- content 끝-->