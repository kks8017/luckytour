<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$golf_no = $_POST['golf_no'];
$adult_number = $_POST['adult_number'];
$start_date   = $_POST['start_date'];
$golf_time   = $_POST['golf_time'];
echo $golf_time;
$j =$_POST['i'];

$sql = "select * from golf_list where no='{$golf_no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$golf = new golf();
$main = new main();
$image_dir = "/".KS_DATA_DIR."/".KS_GOLF_DIR;
$golf->golf_no = $golf_no;
$main_image = $golf->golf_main_image();
$main->sdate = $start_date;
$start_week = $main->week();
?>
<script>
    function img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }
    function room_img_mod(i) {
        $(".show_img").attr("src",$(".s_img_"+i).attr("src"));
    }

</script>
<h2>>><?=$row['golf_name']?></h2>
<p>
    <img src="<?=$image_dir?>/<?=$main_image?>" class="show_img" width="492" height="290" />
</p>
<ul class="thumb">
    <?php
        $sub_image = $golf->golf_sub_image();
        $i=0;
        if(is_array($sub_image)) {
            foreach ($sub_image as $image) {
                ?>
                <li><a href="#none"><img class="s_img_<?= $i ?>" onmouseover="img_mod(<?= $i ?>)" src="<?= $image_dir ?>/<?= $image[0] ?>" width="67" height="44"/></a></li>
                <?
                $i++;
            }
        }else{

        }
    ?>
</ul>
<h2>>>골프장선택</h2>
<table>
    <tr>
        <th width="25%">골프장명</th>
        <th width="25%">예약인원</th>
        <th width="25%">판매가</th>
        <th width="25%">선택</th>
    </tr>
    <?php
        $hole_list = $golf->hole_list();
        $i=0;
        foreach ($hole_list as $hole){
            $golf->hole_no = $hole['no'];
            $golf->adult_number =$adult_number;
            $golf->start_date =$start_date;
            $golf->stay =1;
            $price = $golf->golf_main_price();
    ?>
    <tr>
        <td><span class="gname"><?=$row['golf_name']?></span><span class="txt br">(<?=$hole['hole_name']?>)</span</td>
        <td><span class="txt"><?=$adult_number?>명</span></td>
        <td><span class="price"><?=set_comma($price[1])?>원</span></td>
        <td><a href="javascript:golf_selected('<?=$i?>','<?=$j?>')"><img src="../sub_img/select_btn3.png" /></a>
            <input type="hidden" id="golf_name_<?=$i?>" value="<?=$row['golf_name']?>">
            <input type="hidden" id="hole_name_<?=$i?>" value="<?=$hole['hole_name']?>">
            <input type="hidden" id="h_golf_no_<?=$i?>" value="<?=$row['no']?>">
            <input type="hidden" id="h_hole_no_<?=$i?>" value="<?=$hole['no']?>">
            <input type="hidden" id="golf_price_<?=$i?>" value="<?=$price[1]?>">
            <input type="hidden" id="main_image_<?=$i?>" value="<?=$image_dir."/".$main_image?>">
            <input type="hidden" id="golf_week_<?=$i?>" value="<?=$start_week?>">
            <input type="hidden" id="h_golf_date_<?=$i?>" value="<?=$start_date?>">
            <input type="hidden" id="h_golf_time_<?=$i?>" value="<?=$golf_time?>">
            <input type="hidden" id="h_golf_adult_number_<?=$i?>" value="<?=$adult_number?>">
        </td>
    </tr>
        <?
            $i++;
        }
        ?>
    <tr>
        <td colspan="4" class="txt">
            <p class="txt">
                <?=$row['golf_note']?>
            </p>
        </td>
    </tr>
</table>
<h2>>>골프장 전체요금</h2>
<table>
    <tr>
        <th width="33.33%">골프장명</th>
        <th width="33.33%">홀명</th>
        <th width="33.33%">그린피(1인기준)</th>
    </tr>
    <tr>
        <td><span class="gname">레이크힐스</span></td>
        <td><span class="txt">18홀</span></td>
        <td><span class="price">800,000원</span></td>
    </tr>
</table>
<h2>>>골프장 안내</h2>
<table>
    <tr>
        <th colspan="4">
            <p class="txt2">

                <?=$row['golf_content']?>

            </p>
        </th>
    </tr>

</table>
<h2>>>골프장 정보 및 위치안내</h2>
<div style="font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: dotum, sans-serif; width: 432px; height: 394px; color: rgb(51, 51, 51); position: relative;">
    <div style="height: 300px;">
        <div id="daumRoughmapContainer<?=$row['golf_timestamp']?>" class="root_daum_roughmap root_daum_roughmap_landing"></div>

        <!-- 2. 설치 스크립트 -->
        <script charset="UTF-8" class="daum_roughmap_loader_script" src="http://dmaps.daum.net/map_js_init/roughmapLoader.js"></script>

        <!-- 3. 실행 스크립트 -->
        <script charset="UTF-8">
            new daum.roughmap.Lander({
                "timestamp" : "<?=$row['golf_timestamp']?>",
                "key" : "<?=$row['golf_key']?>",
                "mapWidth" : "432",
                "mapHeight" : "300"
            }).render();
        </script>
    </div>
</div>