<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$name = $_REQUEST['reserv_name'];
$phone = $_REQUEST['reserv_phone'];
$res = new reservation();
$res->name = $name;
$res->phone = $phone;

$res_list = $res->reserve_cash();
?>

<div>
    <div class="inbody" >
        <table class="conbox3">
            <tr>
                <td class="titbox">여행일자</td>
                <td class="titbox">예약자명</td>
                <td class="titbox">상품명</td>
            </tr>
            <?php
                if(is_array($res_list)){
                    $i=0;
                    foreach ($res_list as $re){
                        $type = $res->package_type($re['reserv_type']);
            ?>
            <tr>
                <td><?=$re['reserv_tour_start_date']?></td>
                <td><?=$re['reserv_name']?></td>
                <td><a href="javascript:sele_name(<?=$i?>);"><?=$type?></a></td>
            </tr>
                        <input type="hidden" id="name_<?=$i?>" value="<?=$re['reserv_name']?>">
                        <input type="hidden" id="phone_<?=$i?>" value="<?=$re['reserv_phone']?>">
                        <input type="hidden" id="reserv_no_<?=$i?>" value="<?=$re['no']?>">
               <?
                        $i++;
                    }
               ?>
            <?}?>
        </table>
    </div>
</div>
<script>
    function sele_name(i) {
        alert($("#reserv_no_"+i).val());
        $(opener.document).find("#reserv_no").val($("#reserv_no_"+i).val());
        $(opener.document).find("#name").val($("#name_"+i).val());
        window.close();
    }
</script>