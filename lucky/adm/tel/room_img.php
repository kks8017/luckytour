<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['no'];

$sql_room = "select no,lodging_no,lodging_room_name,lodging_room_min,lodging_room_max,lodging_room_open,lodging_room_structure,lodging_room_satisfy,lodging_room_view,lodging_room_sort from lodging_room where no='{$no}'";

$rs_room  = $db->sql_query($sql_room);
$row_room = $db->fetch_array($rs_room);

$sql = "select no,lodging_room_image_file_s,lodging_room_image_file_m  from lodging_room_image where lodging_room_no='{$no}'";

$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$image_dir = "../../".KS_DATA_DIR."/".KS_ROOM_DIR;

?>
<script>
    $(document).ready(function () {
        $("#input_img").on("change", handleImgFileSelect2);
    });
    sele_files = [];
    function handleImgFileSelect2(e) {

        // 이미지 정보들을 초기화

        $(".img_room").empty();

        var files = e.target.files;

        var filesArr = Array.prototype.slice.call(files);

        var index = 0;

        filesArr.forEach(function(f) {
            if(!f.type.match("image.*")) {
                alert("확장자는 이미지 확장자만 가능합니다.");
                return;
            }

            sele_files.push(f);

            var reader = new FileReader();
            reader.onload = function(e) {

                var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction_up("+index+")\" id=\"img_id_"+index+"\"><img id='img_m' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'></a>";

                  $(".img_room").append(html);

                index++;
            }
            reader.readAsDataURL(f);

        });
    }
    function fileUploadAction_up() {
        $("#input_img").trigger('click');
    }
    function deleteImageAction_up(index) {
        console.log("index : "+index);
        console.log("sel length : "+sele_files.length);

        sele_files.splice(index, 1);

        var img_id = "#img_id_"+index;
        $(img_id).remove();
    }
    function submitAction_up() {


        var fd = new FormData();

        for (var i = 0, len = sele_files.length; i < len; i++) {
            var name = "image_" + i;
            fd.append(name, sele_files[i]);
        }

        fd.append("image_count", sele_files.length);
        fd.append("no", "<?=$no?>");
        fd.append("lodging_room_name", $("#lodging_room_name_up").val());
        fd.append("lodging_room_min", $("#lodging_room_min_up").val());
        fd.append("lodging_room_max", $("#lodging_room_max_up").val());
        fd.append("lodging_room_structure", $("#lodging_room_structure_up").val());
        fd.append("lodging_room_satisfy", $("#lodging_room_satisfy_up").val());
        fd.append("lodging_room_view", $("#lodging_room_view_up").val());
        fd.append("case", "room_up");

         var url = "tel/lodging_process.php"; // the script where you handle the form input.
        $.ajax({
            url: url,
            type: "POST",
            data: fd,
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
    }

</script>
<table class="tbl_com">
    <tr>
        <th>객실명</th>
        <td><input type="text" name="lodging_room_name" id="lodging_room_name_up" value="<?=$row_room['lodging_room_name']?>" size="50"></td>
    </tr>
    <tr>
        <th>기준인원</th>
        <td><input type="text" class="min" name="lodging_room_min" id="lodging_room_min_up" size="2" value="<?=$row_room['lodging_room_min']?>">/<input type="text" name="lodging_room_max" class="min" id="lodging_room_max_up" size="2" value="<?=$row_room['lodging_room_max']?>"></td>
    </tr>
    <tr>
        <th>객실구조</th>
        <td><input type="text" name="lodging_room_structure" id="lodging_room_structure_up" value="<?=$row_room['lodging_room_structure']?>" size="50"></td>
    </tr>
    <tr>
        <th>객실구비사항</th>
        <td><input type="text" name="lodging_room_satisfy" id="lodging_room_satisfy_up" value="<?=$row_room['lodging_room_satisfy']?>" size="50"></td>
    </tr>
    <tr>
        <th>객실뷰</th>
        <td><input type="text" name="lodging_room_view" id="lodging_room_view_up" value="<?=$row_room['lodging_room_view']?>" size="40"></td>
    </tr>
    <tr>
        <th>이미지</th>
        <td>
            <div>

                <div class="input_wrap">
                    <a href="javascript:" onclick="fileUploadAction_up();" class="up_btn">이미지등록</a>
                    <input type="file" id="input_img" multiple/>
                </div>
            </div>
            <div>
                <div class="image_up">
                    <div class="room_img">
                        <?
                        if(is_array($result_list)) {
                        foreach ($result_list as $img){
                        ?>
                        <div><a id="img_del" href="javascript:image_del('<?= $img['no'] ?>','<?= $no ?>');">X</a></div>
                        <img src="<?= $image_dir . "/" . $img['lodging_room_image_file_m'] ?>"</div>
                    <?
                         }
                    }else{
                      echo "<div>이미지를 등록해주세요</div>";
                    }?>
                    <div class="img_room">

                        <img id="img" />
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p><input type="button" onclick="submitAction_up();" value="객실변경"></p>
        </td>
    </tr>
</table>