<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$i = $_POST['i'];
$main = new main();
?>
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
                <select id="aaaa" name="tel_stay_number" class="sel" style="width:70px">
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
                <img type="button" src="../sub_img/re_search_btn-sm.png" class="re-bt" style="vertical-align: middle;" onclick="tel_list(<?=$i?>);">
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