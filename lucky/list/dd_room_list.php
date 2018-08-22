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
$stay = $_POST['tel_stay'];

$k = $_POST["i"];

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
<h2>>> <?=$tel_name['lodging_name']?> 전경사진</h2>
<p>
    <img src="<?=$image_dir?>/<?=$lodging_main_image?>" width="432" height="290" class="show_img"/>
</p>
<ul class="thumb">
    <?php
    $i=0;
    foreach ($lodging_sub_image as $image){
        ?>
        <li><a href="#none"><img onmouseover="img_mod(<?=$i?>);" class="s_img_<?=$i?>" src="<?=$image_dir?>/<?=$image['lodging_image_file_m']?>"width="67" height="44" /></a></li>
        <?
        $i++;
    }
    ?>
</ul>
<h2>>> 객실선택</h2>
<table>
    <tr>
        <th width="46%">객실명</th>
        <th width="18%">인원/최대</th>
        <th width="18%">판매가</th>
        <th width="18%">예약</th>
    </tr>
    <tr>
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
        <td><span class="ph-name"><?=$room['lodging_room_name']?></span><span class="txt br">(<?=$lodging_vehicle?>객실)</span></td>
        <td ><span class="txt"><?=$room['lodging_room_min']?>명/<?=$room['lodging_room_max']?>명</span></td>
        <td ><span class="price"><?=set_comma($sale_lod_price)?>원</span></td>
        <td><a href="javascript:tel_selected(<?=$k?>,<?=$j?>);"><img src="../sub_img/select_btn3.png" /></a></td>
    </tr>
    <input type="hidden" name="tel_no" id="tel_no_<?=$j?>" value="<?=$tel_no?>">
    <input type="hidden" name="room_no" id="room_no_<?=$j?>" value="<?=$room['no']?>">
    <input type="hidden" name="tel_name" id="tel_name_<?=$j?>" value="<?=$tel_name['lodging_name']?>">
    <input type="hidden" name="room_name" id="room_name_<?=$j?>" value="<?=$room['lodging_room_name']?>">
    <input type="hidden" name="tel_start_date" id="tel_start_date_<?=$j?>" value="<?=$start_date?>">
    <input type="hidden" name="tel_stay" id="tel_stay_<?=$j?>" value="<?=$stay?>">
    <input type="hidden" name="tel_vehicle" id="tel_vehicle_<?=$j?>" value="<?=$lodging_vehicle?>">
    <input type="hidden" name="tel_total_price" id="tel_total_price_<?=$j?>" value="<?=$sale_lod_price?>">
    <input type="hidden" name="tel_main_img" id="tel_main_img_<?=$j?>" value="<?=$image_dir."/".$lodging_main_image?>">
    <?
         $j++;
    }
    ?>
</table>
<h2>>> 숙소정보 및 이용안내</h2>
<table>
    <tr>
        <td class="title-txt">
            숙소위치
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$tel_name['lodging_address']?>
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            특이사항
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$tel_name['lodging_event']?>
        </td>
    </tr>

</table>
<h2>>> 객실정보</h2>
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
<p>
    <img width="432" height="290" src="<?=$image_room_dir?>/<?=$room_main_image?>" />
</p>
<ul class="thumb-ph">
    <?php
    $i=0;
    if(is_array($room_sub_image)) {
    foreach ($room_sub_image as $image_sub) {
    ?>
    <li><a href="#none"><img width="67" height="44" src="<?= $image_room_dir ?>/<?= $image_sub['lodging_room_image_file_m'] ?>" /></a></li>
        <?
    }
    }else{
    ?>
    <?}?>

</ul>
<table>
    <tr>
        <td class="title-txt">
            객실명
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$room['lodging_room_name']?>
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            객실구조
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$room['lodging_room_structure']?>
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            객실전망
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$room['lodging_room_view']?>
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            입실기준인원
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$room['lodging_room_min']?>명(최대<?=$room['lodging_room_max']?>명), 기준인원 초과시 추가요금발생
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            1인추가요금
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$tel_name['lodging_additional']?>
        </td>
    </tr>
    <tr>
        <td class="title-txt">
            구비사항
        </td>
        <td class="title-con-txt" colspan="3">
            <?=$room['lodging_room_satisfy']?>
        </td>
    </tr>

</table>
<?}?>
<h2>>> 숙소위치</h2>
<div style="font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: dotum, sans-serif; width: 432px; height: 394px; color: rgb(51, 51, 51); position: relative;">
    <div style="height: 300px;">
        <div id="daumRoughmapContainer<?=$tel_name['lodging_timestamp']?>" class="root_daum_roughmap root_daum_roughmap_landing"></div>

        <!-- 2. 설치 스크립트 -->
        <script charset="UTF-8" class="daum_roughmap_loader_script" src="http://dmaps.daum.net/map_js_init/roughmapLoader.js"></script>

        <!-- 3. 실행 스크립트 -->
        <script charset="UTF-8">
            new daum.roughmap.Lander({
                "timestamp" : "<?=$tel_name['lodging_timestamp']?>",
                "key" : "<?=$tel_name['lodging_key']?>",
                "mapWidth" : "425",
                "mapHeight" : "300"
            }).render();
        </script>

    </div>
</div>
