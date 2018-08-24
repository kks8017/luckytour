<?php


$no = $_REQUEST['no'];

$sql = "select no,
                bustour_tour_name,
                bustour_tour_stay,
                bustour_tour_inclusion,
                bustour_tour_not_inclusion,
                bustour_tour_amount,
                bustour_tour_amount_receive,
                bustour_tour_main_image,
                bustour_tour_content_image
         from bustour_tour where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$image_dir = "/".KS_DATA_DIR."/".KS_BUSTOUR_DIR;

$bustour_tour_amount = set_comma($row['bustour_tour_amount']);
$bustour_tour_amount_receive = set_comma($row['bustour_tour_amount_receive']);

?>
<div class="bustour_detail">
    <div id="bustour_detail">
        <form id="bustour_frm" enctype="multipart/form-data">
        <table class="tbl">
            <tr>
                <th>버스투어명</th>
                <td><input type="text" name="bustour_tour_name" value="<?=$row['bustour_tour_name']?>"></td>
            </tr>
            <tr>
                <th>버스투어명</th>
                <td><input type="radio" name="bustour_tour_stay" value="1" <?if($row['bustour_tour_stay']=="1"){?>checked<?}?>>1박2일 <input type="radio" name="bustour_tour_stay" value="2" <?if($row['bustour_tour_stay']=="2"){?>checked<?}?>>2박3일<input type="radio" name="bustour_tour_type" value="3" <?if($row['bustour_tour_stay']=="3"){?>checked<?}?>>3박4일</td>
            </tr>
            <tr>
                <th>포함내역</th>
                <td><textarea name="bustour_tour_inclusion" rows="5" cols="50"><?=$row['bustour_tour_inclusion']?></textarea></td>
            </tr>
            <tr>
                <th>불포함내역</th>
                <td><textarea name="bustour_tour_not_inclusion" rows="5" cols="50"><?=$row['bustour_tour_not_inclusion']?></textarea></td>
            </tr>
            <tr>
                <th>가격</th>
                <td>판매가 : <input type="text" name="bustour_tour_amount" value="<?=$bustour_tour_amount?>"> 입급가 : <input type="text" name="bustour_tour_amount_receive" value="<?=$bustour_tour_amount_receive?>"></td>
            </tr>
            <tr>
                <th>메인이미지</th>
                <td>
                    <input type="file" name="bustour_tour_main_image">
                    <?=$row['bustour_tour_main_image']?>
                    <input type="hidden" name="main_old_image" value="<?=$row['bustour_tour_main_image']?>">
                </td>
            </tr>
            <tr>
                <th>상세이미지</th>
                <td><input type="file" name="bustour_tour_content_image">
                    <?=$row['bustour_tour_content_image']?>
                    <input type="hidden" name="detail_old_image" value="<?=$row['bustour_tour_content_image']?>"></td>
            </tr>
        </table>
            <input type="hidden" name="case" value="update">
            <input type="hidden" name="no" value="<?=$row['no']?>">
            <p style="text-align: center;"><input type="submit"  value="변경"></p>
        </form>

    </div>
</div>

<script>
$(document).ready(function() {
    $("form#bustour_frm").submit(function(event) {
        var url = "bustour/bustour_process.php"; // the script where you handle the form input.
            //disable the default form submission
        event.preventDefault();

        var fd = new FormData($(this)[0]);

        $.ajax({
            url: url,
            type: "POST",
            data: fd,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                /* alert(data); if json obj. alert(JSON.stringify(data));*/
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
                window.location.reload();
            }
        });
    });
});
</script>