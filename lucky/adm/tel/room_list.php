<?php

$sql = "select no,lodging_name,lodging_type,lodging_area  from lodging_list order by binary(lodging_name)";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$lodging_no = $_REQUEST['lodging_no'];
if(!$lodging_no){$lodging_no=$result_list[0]['no'];}

$sql_room = "select no,lodging_no,lodging_room_name,lodging_room_min,lodging_room_max,lodging_room_open,lodging_room_sort from lodging_room  where lodging_no='{$lodging_no}'  order by lodging_room_sort asc";
$rs_room  = $db->sql_query($sql_room);
while($row_room = $db->fetch_array($rs_room)) {
    $result_room[] = $row_room;
}
?>
<script>
    function room_up_layer(no,mode) {
        var url = "tel/room_img.php"; // the script where you handle the form input.
        if(mode =="img") {

        }else{
            $(".overlay").show();
            $("#layer_room_up").show();

        }
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no, // serializes the form's elements.
            success: function (data) {
                $(".layer_room_up").html(data); // show response from the php script.
                // console.log(data);
                //  console.log($("#car_up_tb").find("#car_mod_frm"));
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function image_del(no,r_no) {
        if(confirm("정말삭제 하시겠습니다?") == false) {
            return false;
        }else {

            $.post("tel/lodging_process.php",
                {
                    no: no,
                    case: "room_image_del"
                },
                function (data, status) {
                    room_up_layer(r_no,"img");
                    console.log(data);
                });
        }
    }
</script>

<div style="margin-top: 20px;">
    <div style="margin-top: 20px;margin-bottom: 20px;">

        <input type="button" id="mod_btn" value="선택수정"><input type="button" id="del_btn" value="선택삭제"><input type="button" id="room_add_btn" value="객실등록">

        <select name="lodging_no" id="lodging_no">
            <?php
            foreach ($result_list as $lodging){
                if($lodging['no']== $lodging_no){$sel="selected";}else{$sel="";}
                echo "<option value='{$lodging['no']}' $sel>{$lodging['lodging_name']}</option>";
            }
            ?>
        </select>
    </div>

    <div id="room_list">
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>객실명</th>
                <th>기준인원</th>
                <th>공개</th>
            </tr>
            <form id="room_up_frm">
            <?php
            $i=0;
            if(is_array($result_room)) {
                foreach ($result_room as $data){
                ?>
                <tr>
                    <td class="con"><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                    <td class="con"><input type="text" name="lodging_room_sort[]" size="3" value="<?=$data['lodging_room_sort']?>"></td>
                    <td class="con"><a href="javascript:room_up_layer('<?=$data['no']?>');" id="room_up"><?=$data['lodging_room_name']?></a></td>
                    <td class="con"><?=$data['lodging_room_min']?>/<?=$data['lodging_room_max']?></td>
                    <td class="con"><input type="checkbox" name="lodging_room_open[]" value="Y" <?if($data['lodging_room_open']=="Y"){?>checked<?}?>></td>
                </tr>
                <?php
                    $i++;
                }
            }else{
            ?>
                <tr>
                    <th colspan="8" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
                <input type="hidden" name="case" id="case" >
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_room">
    <div class="layer_room">
        <table class="tbl_com">
            <tr>
                <th>객실명</th>
                <td><input type="text" name="lodging_room_name" id="lodging_room_name"></td>
            </tr>
            <tr>
                <th>기준인원</th>
                <td><input type="text" name="lodging_room_min" id="lodging_room_min" size="3">/<input type="text" name="lodging_room_max" id="lodging_room_max" size="3"></td>
            </tr>
            <tr>
                <th>객실구조</th>
                <td><input type="text" name="lodging_room_structure" id="lodging_room_structure"></td>
            </tr>
            <tr>
                <th>객실구비사항</th>
                <td><input type="text" name="lodging_room_satisfy" id="lodging_room_satisfy"></td>
            </tr>
            <tr>
                <th>객실뷰</th>
                <td><input type="text" name="lodging_room_view" id="lodging_room_view"></td>
            </tr>
            <tr>
                <th>이미지</th>
                <td>
                    <div>
                        <div class="input_wrap">
                            <a href="javascript:" onclick="fileUploadAction();" class="up_btn">이미지등록</a>
                            <input type="file" id="input_imgs" multiple/>
                        </div>
                    </div>
                    <div>
                        <div class="imgs_room">
                            <img id="img" />이미지를 등록해주세요
                        </div>
                    </div>
                </td>
            </tr>

        </table>
        <p style="text-align: center;"><input type="button" onclick="submitAction();" value="객실등록"></p>
    </div>
</div>
<div id="layer_room_up">
    <div class="layer_room_up"></div>
</div>
<script>
    sel_files = [];
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })
        $("#room_add_btn").click(function () {
            overlays_view("overlay","layer_room")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_room")
            $("#layer_room_up").hide();
        });
        $("#input_imgs").on("change", handleImgFileSelect);

        $("#mod_btn").click(function () {

            $("#case").val("room_all_update");
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#room_up_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    window.location.reload();
                }
            });

        });
        $("#del_btn").click(function () {
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $("#case").val("room_delete");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#room_up_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        // console.log(data); // show response from the php script.
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

        });
        $("#lodging_no").on("change",function () {
            $("#lodging_no option:selected").each(function () {
                window.location.href="?linkpage=tel&subpage=room&lodging_no="+$(this).val();
            });
        });
        $("#add_btn").click(function () {

            if($("#lodging_name").val()==""){
                alert("숙소명 입력해주세요");
                return false;
            }


            $.post("tel/lodging_process.php",
                {
                    lodging_name:$("#lodging_name").val(),
                    lodging_no:$("select[name=lodging_no]").val(),
                    lodging_area:$("select[name=lodging_area").val(),
                    lodging_type:$("select[name=lodging_type").val(),
                    case : "room_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("객실를 등록하셨습니다.");
                    overlays_close("overlay","layer_room")
                    window.location.reload();

                });


        });


    });



    function handleImgFileSelect(e,mode) {

        // 이미지 정보들을 초기화

        $(".img_room").empty();

        var files = e.target.files;

        var filesArr = Array.prototype.slice.call(files);
        var index_len = $("#img_m").length;

        var index = 0;

        filesArr.forEach(function(f) {
            if(!f.type.match("image.*")) {
                alert("확장자는 이미지 확장자만 가능합니다.");
                return;
            }

            sel_files.push(f);

            var reader = new FileReader();
            reader.onload = function(e) {

                var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\">X</a><img id='img_m' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'>";
                if(mode=="up"){
                    $(".img_room").append(html);
                }else{
                    $(".imgs_room").append(html);
                }
                index++;
            }
            reader.readAsDataURL(f);

        });
    }





    function deleteImageAction(index) {
       // console.log("index : "+index);
       // console.log("sel length : "+sel_files.length);

        sel_files.splice(index, 1);

        var img_id = "#img_id_"+index;
        $(img_id).remove();
    }

    function fileUploadAction() {
       // console.log("fileUploadAction");
        $("#input_imgs").trigger('click');
    }


    function submitAction() {
        console.log("업로드 파일 갯수 : "+sel_files.length);
        var fd = new FormData();

        for(var i=0, len=sel_files.length; i<len; i++) {
            var name = "image_"+i;
            fd.append(name, sel_files[i]);
        }
        fd.append("image_count", sel_files.length);
        fd.append("lodging_no", $("select[name=lodging_no]").val());
        fd.append("lodging_room_name", $("#lodging_room_name").val());
        fd.append("lodging_room_min", $("#lodging_room_min").val());
        fd.append("lodging_room_max", $("#lodging_room_max").val());
        fd.append("lodging_room_structure", $("#lodging_room_structure").val());
        fd.append("lodging_room_satisfy", $("#lodging_room_satisfy").val());
        fd.append("lodging_room_view", $("#lodging_room_view").val());
        fd.append("case", "room_insert");


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