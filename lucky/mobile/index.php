<?php include "inc/header.php"; ?>

<div class="main-slide">
	
</div>

<div class="main-table">
	<table>
		<tr>
			<td style="border-right: 5px solid #ffffff;">
				<a href="package/package_list.php">
					<div class="main-package">
					</div>
					<span class="main-sub-title">패키지</span>
				</a>
			</td>
			<td style="border-right: 5px solid #ffffff;">
				<a href="#">
					<div class="main-place"></div>
					<span class="main-sub-title">관광지</span>
				</a>
			</td>
			<td style="border-right: 5px solid #ffffff;">
				<a href="customer/notice.php">
					<div class="main-center"></div>
					<span class="main-sub-title">고객센터</span>
				</a>
			</td>
			<td>
				<a href="res/res_end.php">
					<div class="main-res"></div>
					<span class="main-sub-title">예약확인</span>
				</a>
			</td>
		</tr>

    </table>
    <table style="border-top: 5px solid #fff">
    <tr>
        <td style="border-right: 5px solid #ffffff;">
            <a href="package/package_list.php">
                <div class="main-package">
                </div>
                <span class="main-sub-title">패키지</span>
            </a>
        </td>
        <td style="border-right: 5px solid #ffffff;">
            <a href="#">
                <div class="main-place"></div>
                <span class="main-sub-title">관광지</span>
            </a>
        </td>
        <td style="border-right: 5px solid #ffffff;">
            <a href="customer/notice.php">
                <div class="main-center"></div>
                <span class="main-sub-title">고객센터</span>
            </a>
        </td>
        <td>
            <a href="res/res_end.php">
                <div class="main-res"></div>
                <span class="main-sub-title">예약확인</span>
            </a>
        </td>
    </tr>
    </table>
</div>
<?php
$lod = new lodging();
$rent = new rent();

$best_list = $main->mobile_best_list_sub();
$best_list_main = $main->mobile_best_list_main();
?>
<div class="main-item">
	<p>BEST 특가상품 <span class="deco">놓치면 후회~</span></p>
	<table>
<?php

if(is_array($best_list_main)) {
    $i=0;
    foreach ($best_list_main as $best_main) {
        $lod->lodno = $best_main['tel_no'];
        $lod->roomno = $best_main['room_no'];
        $lod_name = $lod->lodging_detail();
        $lod_main_img = $lod->lodging_main_image();
        $lod->start_date = date("Y-m-d", time());
        $lod->stay = 1;
        $lod->adult_number = 2;
        $lod->baby_number = 0;
        $lod->child_number = 0;
        $lod->lodging_vehicle = 1;
        $lod_price = $lod->lodging_main_price();
        $lod_type = $lod->lodging_code_name($lod_name['lodging_type']);

        $percent = $lod_price[0] / $lod_price[5] * 100;
        $add_percent = round($percent, 0);
        $total_percent = 100 - $add_percent;

        if ($best_main['tel_no'] != "") {
            ?>
        <style>
            .main-item-lg {
                border: 20px solid #fff;
                width: 100%;
                height: 50%;
                background : url('<?=KS_DOMAIN?>/<?=KS_DATA_DIR?>/<?=KS_LOD_DIR?>/<?=$lod_main_img?>');
                background-size: cover;
            }

        </style>
		<tr>
			<td colspan="2" class="main-item-lg" >
				<div class="main-item-lg-img">
					<div class="main-item-lg-text">
						<span class="main-item-title"><?=$lod_name['lodging_name']?></span></br>
						<span class="main-item-sub-title"><?=$lod_name['lodging_event']?></span>
						<span class="main-item-sub-price"><?=set_comma($lod_price[0])?>원~</span>
					</div>
				</div>
			</td>
		</tr>
            <?
            $i++;
        }
    }
}
?>
		<tr>
        <?php

        if(is_array($best_list)) {
            $i=0;
            foreach ($best_list as $best) {
                $lod->lodno = $best['tel_no'];
                $lod->roomno = $best['room_no'];
                $lod_name = $lod->lodging_detail();
                $lod_main_img = $lod->lodging_main_image();
                $lod->start_date = date("Y-m-d", time());
                $lod->stay = 1;
                $lod->adult_number = 2;
                $lod->baby_number = 0;
                $lod->child_number = 0;
                $lod->lodging_vehicle = 1;
                $lod_price = $lod->lodging_main_price();
                $lod_type = $lod->lodging_code_name($lod_name['lodging_type']);

                $percent = $lod_price[0] / $lod_price[5] * 100;
                $add_percent = round($percent, 0);
                $total_percent = 100 - $add_percent;
                if($i % 2==0){echo "</tr><tr>";}
                if ($best['tel_no'] != "") {
                    ?>
                    <style>
                        .main-item-sm_<?=$i?> {
                            border: 20px solid #fff;
                            width: 48%;
                            height: 25%;
                            background : url('<?=KS_DOMAIN?>/<?=KS_DATA_DIR?>/<?=KS_LOD_DIR?>/<?=$lod_main_img?>');
                            background-size: cover;
                        }

                    </style>
                    <td class="main-item-sm_<?=$i?>">
                        <div class="main-item-sm-img">
                            <div class="main-item-sm-text">
                                <span class="main-item-title-sm"><?=$lod_name['lodging_name']?></span></br>
                                <span class="main-item-sub-price-sm"><?=set_comma($lod_price[0])?>원~</span>
                            </div>
                        </div>
                    </td>
                <?
                    $i++;
                  }
                }
            }
           ?>

		</tr>

	</table>
</div>


<?php include "inc/footer.php"; ?>