<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$company = set_company();
$no = $_REQUEST['no'];
$lodging  = new lodging();

$lodging_list_area = $lodging->lodging_code('A');
$lodging_list_type = $lodging->lodging_code('C');
$lodging_list_thema = $lodging->lodging_code('T');



$sql = "select no,
                lodging_name,
                lodging_type,
                lodging_area,
                lodging_address,
                lodging_manager_phone,
                lodging_real_phone,
                lodging_manager_fax,
                lodging_real_fax,
                lodging_manager_email,
                lodging_real_email,
                lodging_account,
                lodging_theme,
                lodging_content,
                lodging_additional,
                lodging_facility,
                lodging_timestamp,
                lodging_key
         from lodging_list where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$sql_img = "select no,lodging_no,lodging_image_sort,lodging_image_name,lodging_image_file_s,lodging_image_file_m from lodging_image where lodging_no='{$no}'";
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

               $.post("tel/lodging_process.php",
                {
                    img_no: no,
                    case: "tel_image_del"
                },
                function (data, status) {
                    img_list();
                    console.log(data);
                });
        }
    }
</script>

<div style="margin-top: 20px;">
    <div >
        <form id="tel_up_frm">
<table class="tbl">
    <tr >
        <th class="title" >숙소명</th>
        <td ><input type="text" name="lodging_name"  id="lodging_name" value="<?=$row['lodging_name']?>" size="70"></td>
        <th class="title">계좌번호</th>
        <td><input type="text" name="lodging_account" id="lodging_account" value="<?=$row['lodging_account']?>" size="70"></td>
    </tr>
    <tr>
        <th >예약실전화번호</th>
        <td><input type="text" name="lodging_manager_phone" id="lodging_manager_phone" value="<?=$row['lodging_manager_phone']?>" size="70"></td>
        <th >숙소전화번호</th>
        <td ><input type="text" name="lodging_real_phone" id="lodging_real_phone" value="<?=$row['lodging_real_phone']?>" size="70"></td>

    </tr>
    <tr>
        <th>예약실팩스</th>
        <td><input type="text" name="lodging_manager_fax" id="lodging_manager_fax" value="<?=$row['lodging_manager_fax']?>" size="70"></td>
        <th >숙소팩스</th>
        <td><input type="text" name="lodging_real_fax" id="lodging_real_fax" value="<?=$row['lodging_real_fax']?>" size="70"></td>

    </tr>
    <tr>
        <th >예약실이메일</th>
        <td><input type="text" name="lodging_manager_email" id="lodging_manager_email" value="<?=$row['lodging_manager_email']?>" size="70"></td>
        <th >숙소이메일</th>
        <td><input type="text" name="lodging_real_email" id="lodging_real_email" value="<?=$row['lodging_real_email']?>" size="70"></td>

    </tr>
    <tr>
        <th >주소</th>
        <td colspan="3"><input type="text" name="lodging_address" id="lodging_address" value="<?=$row['lodging_address']?>" size="70"></td>
    </tr>
    <tr>
        <th>숙소위치</th>
        <td colspan="3" >
            <?foreach ($lodging_list_area as $area){
                if($row['lodging_area']==$area['no']){$sel="checked";}else{$sel="";}
                echo " <input style='vertical-align: middle;' type='radio' name='lodging_area' value='{$area['no']}' {$sel}> {$area['lodging_config_name']} &nbsp;";
            }
            ?>
        </td>
    </tr>
    <tr>
        <th >숙소지도설정</th>
        <td colspan="3">
            timestamp : <input type="text" name="lodging_timestamp" id="lodging_timestamp" value="<?=$row['lodging_timestamp']?>"> key : <input type="text" name="lodging_key" id="lodging_key" value="<?=$row['lodging_key']?>">
            <input type="button" value="지도설정" onclick="window.open('http://map.daum.net/')">
        </td>
    </tr>
    <tr>
        <th class="title">숙소타입</th>
        <td colspan="3">
            <?foreach ($lodging_list_type as $type){
                if($row['lodging_type']==$type['no']){$sel="checked";}else{$sel="";}
                echo "&nbsp;<input type='radio' style='vertical-align: middle;' name='lodging_type' value='{$type['no']}' {$sel}> {$type['lodging_config_name']} &nbsp;";
            }
            ?>
          </td>
    </tr>
    <tr>
        <th class="title">숙소테마</th>
        <td colspan="3">
            <?foreach ($lodging_list_thema as $thema){
                if(strpos($row['lodging_theme'], $thema['no']) !== false) {
                    $sel = "checked";
                }else{
                    $sel="";
                }
                echo "&nbsp;<input type='checkbox' style='vertical-align: middle;' name='lodging_thema' value='{$thema['no']}' {$sel}> {$thema['lodging_config_name']}&nbsp;";
            }
            ?>
        </td>
    </tr>
    <tr>
        <th class="title">1인추가요금</th>
        <td colspan="3">
            <textarea  id="lodging_additional" cols="130" rows="5"><?=$row['lodging_additional']?></textarea>
        </td>
    </tr>
    <tr>
        <th class="title">숙소기본설명</th>
        <td colspan="3">
            <textarea  id="lodging_content" cols="130" rows="20"><?=$row['lodging_content']?></textarea>
        </td>
    </tr>
    <tr>
        <th class="title">숙소부대시설</th>
        <td colspan="3"><textarea  id="lodging_facility" cols="130" rows="5"><?=$row['lodging_facility']?></textarea></td>
    </tr>
    <tr>
        <th class="title">숙소이미지<br><a href="javascript:" class="up_btn">이미지등록</a></th>
        <td colspan="3">
            <div class="images_add">

            </div>
        </td>
    </tr>
</table>
<p style="padding-top: 10px;padding-bottom: 10px;text-align: center;"><input id="up_btn" type="button" value="숙소수정"></p>
<input type="hidden" name="case" value="tel_update">
<input type="hidden" name="no" id="lodging_no" value="<?=$row['no']?>">
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
            var url = "tel/lodging_img_list.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "lodging_no=" + $("#lodging_no").val(), // serializes the form's elements.
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

                var url = "tel/lodging_process.php"; // the script where you handle the form input.
                var additional = oEditors.getById["lodging_additional"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
                var content = oEditors2.getById["lodging_content"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
                var facility = oEditors3.getById["lodging_facility"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
                var thema = "";
                $(":checkbox[name='lodging_thema']:checked").each(function(i,e){
                    if(thema == ""){
                        thema = e.value;
                    }else{
                        thema += ","+e.value;
                    }
                });


                $.post( "tel/lodging_process.php", {
                    no: "<?=$no?>",
                    lodging_name: $("#lodging_name").val(),
                    lodging_account: $("#lodging_account").val(),
                    lodging_real_phone: $("#lodging_real_phone").val(),
                    lodging_manager_phone: $("#lodging_manager_phone").val(),
                    lodging_real_fax: $("#lodging_real_fax").val(),
                    lodging_manager_fax: $("#lodging_manager_fax").val(),
                    lodging_real_email: $("#lodging_real_email").val(),
                    lodging_manager_email: $("#lodging_manager_email").val(),
                    lodging_address: $("#lodging_address").val(),
                    lodging_area: $("input[name=lodging_area]:checked").val(),
                    lodging_timestamp: $("#lodging_timestamp").val(),
                    lodging_key: $("#lodging_key").val(),
                    lodging_type: $("input[name=lodging_type]:checked").val(),
                    lodging_thema: thema,
                    lodging_additional: additional,
                    lodging_facility: facility,
                    lodging_content: content,
                    case :"tel_update"

                },function( data ) {
                    console.log(data);
                    window.location.reload();
                });

            });


            var oEditors = [];
            var oEditors2 = [];
            var oEditors3 = [];

            nhn.husky.EZCreator.createInIFrame({

                oAppRef: oEditors,
                elPlaceHolder: "lodging_additional",
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
                oEditors.getById["lodging_additional"].exec("PASTE_HTML", [sHTML]);
            }

            function showHTML() {
                var sHTML = oEditors.getById["lodging_additional"].getIR();
                alert(sHTML);
            }

            nhn.husky.EZCreator.createInIFrame({

                oAppRef: oEditors2,
                elPlaceHolder: "lodging_content",
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
                oEditors2.getById["lodging_content"].exec("PASTE_HTML", [sHTML]);
            }

            function showHTML() {
                var sHTML = oEditors2.getById["lodging_content"].getIR();
                alert(sHTML);
            }
            nhn.husky.EZCreator.createInIFrame({

                oAppRef: oEditors3,
                elPlaceHolder: "lodging_facility",
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
                oEditors3.getById["lodging_facility"].exec("PASTE_HTML", [sHTML]);
            }

            function showHTML() {
                var sHTML = oEditors3.getById["lodging_facility"].getIR();
                alert(sHTML);
            }
            function setDefaultFont() {
                var sDefaultFont = '궁서';
                var nFontSize = 24;
                oEditors.getById["lodging_additional"].setDefaultFont(sDefaultFont, nFontSize);
            }

            function setDefaultFont() {
                var sDefaultFont = '궁서';
                var nFontSize = 24;
                oEditors2.getById["lodging_content"].setDefaultFont(sDefaultFont, nFontSize);
            }
            function setDefaultFont() {
                var sDefaultFont = '궁서';
                var nFontSize = 24;
                oEditors3.getById["lodging_facility"].setDefaultFont(sDefaultFont, nFontSize);
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
            fd.append("lodging_no", $("#lodging_no").val());
            fd.append("case", "tel_image");

            if(sel_files.length < 1) {
                alert("한개이상의 파일을 선택해주세요.");
                return;
            }
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

