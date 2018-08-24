<?php
$realurl = $_SERVER['REQUEST_URI'];
$tmpurl  = explode("?",$realurl);
$tmpurl2 = explode("&",$tmpurl[1]);
if($_SESSION["member_id"]!="") {
    $adm_d = "../board/";
    $adm_url = "linkpage={$linkpage}&";
}else{
    $adm_d ="";
    $adm_url = "";
}
$basic_url = "bd_no={$bd_no}&board_table={$bd_id}";
$url_list = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url. "&board=list";

$board_set = new board();
$board_set->bd_no = $bd_no;
$config = $board_set->board_config();
$member = new member();
if($_SESSION['user_id']) {
    $member->user_id = $_SESSION['user_id'];
    $info = $member->user_info();
}

?>
<form id="board_frm" enctype="multipart/form-data">
    <div class="rcon">
        <p>글쓰기</p><p>고객님들의 여행담을 나누는 공간입니다.</p>

        <div class="tbl_wrap">
            <form action="" method="">
                <table>
                    <tr>
                        <th>글쓴이</th>
                        <td><input type="text" name="author" id="author" value="<?=$info['user_name']?>" /></td>
                    </tr>
                    <tr>
                        <th>제목</th>
                        <td><input type="text" name="subject" id="subject" class="subject"><?if($_SESSION['member_id']!=""){?><input type="checkbox" name="notice" value="Y"><span class="subscribe">공지</span><?}?> <?if($config['bd_secret']=="Y"){?><input type="checkbox" name="secret" value="Y"><span class="subscribe">&nbsp;비밀글 (비밀글일경우 체크)</span><?}?></td>
                    </tr>
                    <tr>
                        <th>내용</th>
                        <!-- 에디터 비워둠 -->
                        <td><textarea  id="cont" rows="15" cols="83" ></textarea></td>
                    </tr>

                    <tr>
                        <th>비밀번호</th>
                        <td><input type="password" name="passwd" id="passwd" class="passwd">
                            <span class="subscribe">글 확인/수정/삭제시 필요합니다.</span>
                        </td>
                    </tr>
                    <tr>
                        <th>스팸방지코드</th>
                        <td><span class="auth_num"><a href="javascript:img_change();"><img id="imgs" src="/SpamCode.php" style="vertical-align: middle"></a></span><input type="text" name="s_code" id="s_code" class="s_code" maxlength="4">
                            <span class="subscribe">왼쪽에 보이는 숫자를 입력해주세요</span></td>
                    </tr>
                </table>
                <p class="submit"><input type="button" class="btn"  value="확인" onclick="submitContents(this);" /> <input class="btn" type="button" id="list_btn"   value="목록으로"  /></p>
            </form>
        </div>
    </div>
<!--<div class="board_write">
    <div>
        <table>
            <tr>
                <td colspan="2" align="center">글쓰기</td>
            </tr>
            <tr>
                <td class="title">글쓴이</td>
                <td ><input type="text" name="author" id="author" class="author"></td>
            </tr>
            <tr>
                <td class="title">제목</td>
                <td ><input type="text" name="subject" id="subject" class="subject"><?if($_SESSION['member_id']!=""){?><input type="checkbox" name="notice" value="Y">공지<?}?> <?if($config['bd_secret']=="Y"){?><input type="checkbox" name="secret" value="Y"><span class="subscribe">&nbsp;비밀글 (비밀글일경우 체크)</span><?}?></td>
            </tr>
            <tr>
                <td class="title">내용</td>
                <td ><textarea  id="cont" rows="15" cols="100" ></textarea></td>
            </tr>
            <tr>
                <td class="title">파일업로드</td>
                <td ><input type="file" name="files" id="files" ></td>
            </tr>
            <tr>
                <td class="title">비밀번호</td>
                <td ><input type="password" name="passwd" id="passwd" class="passwd"></td>
            </tr>
            <tr>
                <td class="title">스팸코드</td>
                <td ><a href="javascript:img_change();"><img id="imgs" src="/SpamCode.php" style="vertical-align: middle"></a> <input type="text" name="s_code" id="s_code" class="s_code" maxlength="4"> 왼쪽에 보이는글를 넣어주세요</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="button" value="글쓰기" onclick="submitContents(this);"><input type="button" id="list_btn" value="목록으로" ></td>
            </tr>
        </table>
    </div>
</div>-->
    <input type="hidden" name="board_table" id="board_table" value="<?=$table?>">
</form>
<div id="err" style="display: none;">

</div>
<script>
    $(document).ready(function(){
        $("#list_btn").click(function () {
            window.location.href = "<?=$url_list?>";
        });
    });

    function img_change() {
        $("#imgs").attr("src","/SpamCode.php?img="+new Date().getTime()); // show response from the php script.
    }
    var oEditors = [];

    nhn.husky.EZCreator.createInIFrame({

        oAppRef: oEditors,
        elPlaceHolder: "cont",
        sSkinURI: "/smarteditor/SmartEditor2Skin.html",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            fOnBeforeUnload : function(){

            }
        }, //boolean
        fOnAppLoad : function(){
            //예제 코드
            //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
        },
        fCreator: "createSEditor2"
    });

    function pasteHTML() {
        var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
        oEditors.getById["cont"].exec("PASTE_HTML", [sHTML]);
    }

    function showHTML() {
        var sHTML = oEditors.getById["cont"].getIR();
        alert(sHTML);
    }

    function submitContents(elClickedObj) {

        oEditors.getById["cont"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

        if ($("#author").val() == ""){
            alert("글쓴이을 적어주세요");
            return false;
        }else if ( $("#subject").val() == ""){
            alert("제목을 적어주세요 ");
            return false;
        }else if ( $("#cont").val() == ""){
            alert("내용을 적어주세요 ");
            return false;
        }else if ($("#passwd").val() == ""){
            alert("비밀번호을 적어주세요 ");
            return false;
        }else if ($("#s_code").val() == ""){
            alert("스팸코드을 적어주세요 ");
            return false;    
        }else{
            board_write();
            return true;
        }

    }

    function setDefaultFont() {
        var sDefaultFont = '궁서';
        var nFontSize = 24;
        oEditors.getById["cont"].setDefaultFont(sDefaultFont, nFontSize);
    }

    function board_write() {
        var url = "<?=$adm_d?>board_real_process.php"; // the script where you handle the form input.
        var content = oEditors.getById["cont"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
        var fd = new FormData();

        
        fd.append("author", $("#author").val());
        fd.append("subject", $("#subject").val());
        fd.append("passwd", $("#passwd").val());
        fd.append("content", $("#cont").val());
        fd.append("s_code", $("#s_code").val());
        fd.append("board_table", $("#board_table").val());
        fd.append("notice", $("input:checkbox[name='notice']:checked").val());
        fd.append("secret", $("input:checkbox[name='secret']:checked").val());
        fd.append("content", content);
        fd.append("case", "insert");

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
                $("#err").html(data);
                if($("#er_code").val() == "wrong"){
                    alert("스팸코드가 일치하지 않습니다. 확인해주세요");
                    $("#imgs").attr("src","/SpamCode.php?img="+new Date().getTime());
                    return;
                }else{
                      window.location.href = "<?=$url_list?>";
                }
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
</script>
