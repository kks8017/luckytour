<?php include "../inc/header.sub.php"; ?>
<?php include "css/pop_style.css" ?>
<?
$lodging = new lodging();
$main = new main();

$adult_number        = $_REQUEST['adult_number'];
$child_number        = $_REQUEST['child_number'];
$baby_number         = $_REQUEST['baby_number'];

$tel_no              = $_REQUEST['tel_no'];
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$stay =  $_REQUEST['tel_stay'];

if($_REQUEST['room_vehicle']=="undefined" or $_REQUEST['room_vehicle']==""){
    $lodging_vehicle      = 1;
}else{
    $lodging_vehicle      = $_REQUEST['room_vehicle'];
}
$lodging->lodno = $_REQUEST['tel_no'];
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
$image_dir = KS_DOMAIN."/".KS_DATA_DIR."/".KS_LOD_DIR;
$image_room_dir = KS_DOMAIN."/".KS_DATA_DIR."/".KS_ROOM_DIR;

?>
<script>
    function img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }
    function room_img_mod(img) {

        $(".main-room-img").css('background-image','url('+img+')');

    }
    function close() {
        $(opener.location).attr("href","javascript:room_hide_layer();");
    }
    $(document).ready(function() {

        $('ul.tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        })
        $('#close').click(function() {
            $('#pop').hide();
        });
    });
</script>
<style>
    .pop-tel-img {
        width: 100%;
        height: 600px;
        background-color:#e5e5e5;
        background : url('<?=$image_dir?>/<?=$lodging_main_image?>');
        background-size: cover;

    }

</style>

<!--레이어 팝업 시작 -->
<div style="height:auto;">
    <div>
        <div id="close" >
            <span class="pop-tel-name"> >> <?=$tel_name['lodging_name']?></span>
        </div>
    </div>
    <div class="pop-tel-img"></div>
    <div id="lodge_list" class="pop-tel-info">

    </div>
    <div class="pop-room-info">
        <!--탭메뉴 -->
        <div class="container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">객실정보</li>
                <li class="tab-link" data-tab="tab-2">상세정보</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?php
                $j =0;
                foreach ($room_list as $room){
                    $lodging->roomno = $room['no'];
                    $room_sub_image = $lodging->room_sub_image(5);
                    $room_main_image = $lodging->room_main_image();

                    if($room_main_image){
                        $room_main_image = $room_main_image;
                    }else{
                        $room_main_image = "";
                    }
                    $lodging_price = $lodging->lodging_main_price();
                    $sale_lod_price = (($lodging_price[0] * $lodging_vehicle));


                    ?>
                    <style>
                        .room-info .room-photo .main-room-img{
                            width: 75%;
                            height: 600px;
                            background : url('<?=$image_room_dir?>/<?=$room_main_image?>') ;
                            background-size : cover;

                        }
                    </style>
                    <div class="room-info">
                        <div class="room-photo">

                            <div class="main-room-img"></div>
                            <div class="sub-room-img">
                                <ul>
                                    <?php
                                    $i=0;
                                    foreach ($room_sub_image as $image){
                                        ?>
                                        <style>
                                            .room-info .room-photo .sub-room-img .room_img_<?=$i?>{
                                                width: 100%;
                                                height: 115px;
                                                margin-left: 3px;
                                                margin-bottom: 3px;
                                                background : url('<?=$image_room_dir?>/<?=$image['lodging_room_image_file_m']?>') ;
                                                background-size : cover;
                                            }
                                        </style>
                                        <li class="room_img_<?=$i?>" onclick="room_img_mod('<?=$image_room_dir?>/<?=$image['lodging_room_image_file_m']?>')"></li>
                                        <?
                                        $i++;
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td class="room-neme" colspan="4">
                                    [<?=$room['lodging_room_name']?>]
                                </td>
                            </tr>
                            <tr>
                                <td class="room-text" colspan="4">
                                    <?=$room['lodging_room_structure']?>, <?=$room['lodging_room_view']?>, <?=$room['lodging_room_min']?>명(최대<?=$room['lodging_room_max']?>명)
                                </td>
                            </tr>
                            <tr>
                                <td class="room-text" colspan="4">
                                    <?=$room['lodging_room_satisfy']?>
                                </td>
                            </tr>
                            <tr>
                                <td class="room-sub-info"  colspan="4">
                                    <?=$start_date?> 입실 / <?=$stay?>박 기준인원 초과시 추가요금발생
                                </td>
                            </tr>
                            <tr>
                                <td id="room_price_<?=$j?>" class="room-price">
                                    <?=set_comma( $sale_lod_price)?>원
                                </td>
                                <td class="room-stay">
                                    <?=$stay?>박
                                </td>
                                <td class="room-num">
                                    <div>
                                        <select name="room_vehicle" onchange="room_list(<?=$tel_no?>,<?=$room['no']?>,<?=$j?>)">
                                            <?php
                                            $main->vehicle_option("{$lodging_vehicle}","실");
                                            ?>
                                        </select>
                                    </div>
                                </td>

                                    <td class="room-select">
                                        <button class="select-button-right" onclick="location.href='../res/res_check.php?start_date=<?=$start_date?>&tel_no=<?=$tel_no?>&package_type=<?=$package?>&room_no=<?=$room['no']?>&tel_start_date=<?=$start_date?>&tel_stay=<?=$stay?>&room_vehicle='+$('select[name=room_vehicle]').val()+'&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number=<?=$baby_number?>&package_type=T'">선택</button>
                                    </td>

                            </tr>
                        </table>
                        <hr>
                    </div>
                <?
                    $j++;
                }
                ?>
            </div>
            <div id="tab-2" class="tab-content">
                <div class="tel-sub-info">
                    <table>
                        <tr>
                            <td class="tel-sub-info-title">
                                [특전사항]
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tel-sub-info-text">
                                    <?=$tel_name['lodging_content']?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="tel-sub-info-title">
                                [편의시설]
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tel-sub-info-text">
                                    <?=$tel_name['lodging_facility']?>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--탭메뉴 끝-->
</div>
<script>
    function room_list(tel_no,roomno,i) {
        var url = "price.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "tel_no="+tel_no+"&room_no="+roomno+"&start_date=<?=$start_date?>&adult_number=<?=$adult_number?>&child_number=<?=$child_number?>&baby_number<?=$baby_number?>&package_type=T&tel_stay=<?=$stay?>&lodging_vehicle="+$("select[name=room_vehicle]").val()+"&case=dan", // serializes the form's elements.
            success: function (data) {
                $("#room_price_"+i).html(data);
            },
            beforeSend: function () {
                //  wrapWindowByMask();
            },
            complete: function () {
                //   closeWindowByMask();
            }
        });
    }
</script>
<?php include "../inc/footer.php"; ?>
