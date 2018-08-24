<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$company = set_company();
$no = $_REQUEST['no'];
$golf = new golf();

$golf_area = $golf->golf_code("A");


$sql = "select no,
                golf_name,
                golf_area,
                golf_address,
                golf_phone,
                golf_content,
                golf_note,
                golf_timestamp,
                golf_key,
                golf_fax,
                golf_email
         from golf_list where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$sql_img = "select no,golf_no,golf_image_sort,golf_image_name,golf_image_file_s,golf_image_file_m from golf_image where golf_no='{$no}'";
$rs_img  = $db->sql_query($sql_img);
while($row_img = $db->fetch_array($rs_img)) {
    $result_img[] = $row_img;
}

$image_dir = "/".KS_DATA_DIR."/".KS_LOD_DIR;
?>
<script>
    function image_del(no) {
        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else {

            $.post("golf/golf_process.php",
                {
                    img_no: no,
                    case: "golf_image_del"
                },
                function (data, status) {
                    img_list();
                    console.log(data);
                });
        }
    }
</script>

<div style="margin-top: 20px;">
    <div id="tel_detail">
        <form id="golf_up_frm">
            <table class="tbl" >
                <tr >
                    <th class="title" >골프장명</th>
                    <td ><input type="text" name="golf_name" value="<?=$row['golf_name']?>"></td>
                    <th >전화번호</th>
                    <td ><input type="text" name="golf_phone" value="<?=$row['golf_phone']?>"></td>
                </tr>
                <tr>
                    <th >팩스</th>
                    <td><input type="text" name="golf_fax" value="<?=$row['golf_fax']?>"></td>
                    <th >이메일</th>
                    <td><input type="text" name="golf_email" value="<?=$row['golf_email']?>"></td>
                </tr>
                <tr>
                    <th >주소</th>
                    <td colspan="3"><input type="text" name="golf_address" value="<?=$row['golf_address']?>"></td>
                </tr>
                <tr>
                    <th>숙소위치</th>
                    <td colspan="3">
                        <?foreach ($golf_area as $area){
                            if($row['golf_area']==$area['no']){$sel="checked";}else{$sel="";}
                            echo " <input type='radio' name='golf_area' value='{$area['no']}' {$sel}>{$area['golf_config_name']}";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th >지도설정</th>
                    <td colspan="3">
                        timestamp : <input type="text" name="golf_timestamp" value="<?=$row['golf_timestamp']?>"> key : <input type="text" name="golf_key" value="<?=$row['golf_key']?>">
                    </td>
                </tr>
                <tr>
                    <th class="title">기본설명</th>
                    <td colspan="3">
                        <textarea  id="golf_content" cols="112" rows="20"><?=$row['golf_content']?></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="title">유의사항</th>
                    <td colspan="3"><textarea  id="golf_note" cols="112" rows="5"><?=$row['golf_note']?></textarea></td>
                </tr>
                <tr>
                    <th class="title">이미지<br><a href="javascript:" class="up_btn">이미지등록</a></th>
                    <td colspan="3">
                        <div class="images_add">

                        </div>
                    </td>
                </tr>
            </table>
            <p style="text-align: center;margin-top: 20px;"><input id="up_btn" type="button" value="수정"></p>
            <input type="hidden" name="case" value="golf_update">
            <input type="hidden" name="no" id="golf_no" value="<?=$row['no']?>">
        </form>
    </div>
</div>

<div class="overlay"></div>
<div id="photo_upload">
    <div class="photo_upload">
        <div>
            <div class="input_wrap">
                <a href="javascript:" onclick="fileUploadAction();" class="my_button">이미지등록</a>
                <input type="file" id="input_imgs" multiple/>
            </div>
        </div>

        <div>
            <div class="imgs_wrap">
                <img id="img" />이미지를 등록해주세요
            </div>
        </div>
        <a href="javascript:" class="my_button" onclick="submitAction();">이미지업로드</a>
    </div>
</div>

<script type="text/javascript">

    // 이미지 정보들을 담을 배열
    var sel_files = [];
    window.onload = function () {
        img_list();
    }
    function img_list() {
        var url = "golf/golf_img_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "golf_no=" + $("#golf_no").val(), // serializes the form's elements.
            success: function (data) {
                $(".images_add").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    $(document).ready(function() {
        $("#input_imgs").on("change", handleImgFileSelect);

        $(".up_btn").click(function () {
            overlays_view("overlay","photo_upload")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","photo_upload")
        });
        $("#up_btn").click(function () {
            var url = "golf/golf_process.php"; // the script where you handle the form input.
           var content = oEditors.getById["golf_content"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
            var note = oEditors2.getById["golf_note"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#golf_up_frm").serialize()+"&golf_content="+content+"&golf_note="+note, // serializes the form's elements.
                success: function (data) {
                    console.log(data); // show response from the php script.
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

        var oEditors = [];
        var oEditors2 = [];


        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors,
            elPlaceHolder: "golf_content",
            sSkinURI: "/smarteditor/SmartEditor2Skin.html",
            htParams: {
                bUseToolbar: true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseVerticalResizer: true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseModeChanger: true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                fOnBeforeUnload: function () {

                }
            }, //boolean
            fOnAppLoad: function () {
                //예제 코드
                //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
            },
            fCreator: "createSEditor2"
        });

        function pasteHTML() {
            var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
            oEditors.getById["golf_content"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors.getById["golf_content"].getIR();
            alert(sHTML);
        }

        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors2,
            elPlaceHolder: "golf_note",
            sSkinURI: "/smarteditor/SmartEditor2Skin.html",
            htParams: {
                bUseToolbar: true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseVerticalResizer: true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseModeChanger: true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                fOnBeforeUnload: function () {

                }
            }, //boolean
            fOnAppLoad: function () {
                //예제 코드
                //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
            },
            fCreator: "createSEditor2"
        });

        function pasteHTML() {
            var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
            oEditors2.getById["golf_note"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors2.getById["golf_note"].getIR();
            alert(sHTML);
        }
        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors2.getById["golf_note"].setDefaultFont(sDefaultFont, nFontSize);
        }
        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors.getById["golf_content"].setDefaultFont(sDefaultFont, nFontSize);
        }

    });

    function fileUploadAction() {
        //console.log("fileUploadAction");
        $("#input_imgs").trigger('click');
    }

    function handleImgFileSelect(e) {

        // 이미지 정보들을 초기화
        sel_files = [];
        $(".imgs_wrap").empty();

        var files = e.target.files;
        console.log(files);
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

                var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\"><img id='img_m' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'></a>";
                $(".imgs_wrap").append(html);
                index++;

            }
            reader.readAsDataURL(f);

        });
    }



    function deleteImageAction(index) {
        console.log("index : "+index);
        console.log("sel length : "+sel_files.length);

        sel_files.splice(index, 1);

        var img_id = "#img_id_"+index;
        $(img_id).remove();
    }

    function fileUploadAction() {
        console.log("fileUploadAction");
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
        fd.append("golf_no", $("#golf_no").val());
        fd.append("case", "golf_image");

        if(sel_files.length < 1) {
            alert("한개이상의 파일을 선택해주세요.");
            return;
        }
        var url = "golf/golf_process.php"; // the script where you handle the form input.
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

