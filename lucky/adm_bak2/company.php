<?php
$no = $_GET['no'];
$sql = "select * from tour_company where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);
?>
<div class="company">
    <div>
        <table class="company_t">
            <tr>
                <td class="title">사이트설정</td>
                <td class="content"><input type="radio" name="site_main" value="Y" <?if($row[tour_main]=="Y"){?>checked<?}?> >메인 <input type="radio" name="site_main" value="N" <?if($row[tour_main]=="N"){?>checked<?}?>>서브</td>
            </tr>
            <tr>
                <td class="title">사이트명</td>
                <td class="content"><input type="text" name="site_name" id="site_name" value="<?=$row['tour_name']?>"></td>
            </tr>
            <tr>
                <td class="title">사이트아이디</td>
                <td class="content"><input type="text" name="site_id" id="site_id" value="<?=$row['tour_id']?>"></td>
            </tr>
            <tr>
                <td class="title">사이트타이틀</td>
                <td class="content"><input type="text" name="site_title" id="site_title" value="<?=$row['tour_title']?>" size="50"></td>
            </tr>
            <tr>
                <td class="title">도메인</td>
                <td class="content"><input type="text" name="site_domain" id="site_domain" value="<?=$row['tour_domain']?>"></td>
            </tr>
            <tr>
                <td class="title">대표자</td>
                <td class="content"><input type="text" name="site_ceo" id="site_ceo" value="<?=$row['tour_ceo']?>"></td>
            </tr>
            <tr>
                <td class="title">사업자번호</td>
                <td class="content"><input type="text" name="site_com_number" id="site_com_number" value="<?=$row['tour_com_number']?>"></td>
            </tr>
            <tr>
                <td class="title">전화번호</td>
                <td class="content"><input type="text" name="site_phone" id="site_phone" value="<?=$row['tour_phone']?>"></td>
            </tr>
            <tr>
                <td class="title">팩스</td>
                <td class="content"><input type="text" name="site_fax" id="site_fax" value="<?=$row['tour_fax']?>"></td>
            </tr>
            <tr>
                <td class="title">보증보험</td>
                <td class="content"><input type="text" name="site_insurance" id="site_insurance" value="<?=$row['tour_insurance']?>" size="50"></td>
            </tr>
            <tr>
                <td class="title">관광사업등록번호</td>
                <td class="content"><input type="text" name="site_tourism" id="site_tourism" value="<?=$row['tour_tourism']?>" size="50"></td>
            </tr>
            <tr>
                <td class="title">통신판매업신고</td>
                <td class="content"><input type="text" name="site_online" id="site_online" value="<?=$row['tour_online_number']?>" size="50"></td>
            </tr>
            <tr>
                <td class="title">주소</td>
                <td class="content"><input type="text" name="site_address" id="site_address" value="<?=$row['tour_address']?>" size="50"></td>
            </tr>
            <tr>
                <td class="title">취소수수료</td>
                <td ><textarea name="site_cancel" id="site_cancel" ><?=$row['tour_cancel']?></textarea>

                </td>
            </tr>
            <tr>
                <td class="title">개인정보취급방침</td>
                <td ><textarea name="site_privacy" id="site_privacy" ><?=$row['tour_privacy']?></textarea>

                </td>
            </tr>
        </table>
        <p><input id="up_btn" type="button" value="수정"> <input id="re_btn" type="button" value="뒤로가기"> </p>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var oEditors = [];
        var oEditors2 = [];

        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors,
            elPlaceHolder: "site_cancel",
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
            oEditors.getById["site_cancel"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors.getById["site_cancel"].getIR();
            alert(sHTML);
        }

        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors2,
            elPlaceHolder: "site_privacy",
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
            oEditors2.getById["site_privacy"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors2.getById["site_privacy"].getIR();
            alert(sHTML);
        }

        $("#up_btn").click(function () {
            wrapWindowByMask();
            if ($("#site_name").val() == "") {
                alert("사이트명을 입력해주세요");
                closeWindowByMask();
                return false;
            }
            var cancel = oEditors.getById["site_cancel"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.

            var privacy = oEditors2.getById["site_privacy"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.

            $.post("company_process.php",
                {
                    tour_name: $("#site_name").val(),
                    tour_title: $("#site_title").val(),
                    tour_domain: $("#site_domain").val(),
                    tour_ceo: $("#site_ceo").val(),
                    tour_com_number: $("#site_com_number").val(),
                    tour_phone: $("#site_phone").val(),
                    tour_fax: $("#site_fax").val(),
                    tour_insurance: $("#site_insurance").val(),
                    tour_tourism: $("#site_tourism").val(),
                    tour_online: $("#site_online").val(),
                    tour_main: $(':radio[name="site_main"]:checked').val(),
                    tour_cancel: cancel,
                    tour_privacy: privacy,
                    no: "<?=$no?>",
                    case: "update"
                },
                function (data, status) {
                    console.log(data);
                if(data=="NO"){
                        alert("메인사이트가 한개이상 될수가 없습니다.");
                        closeWindowByMask();
                    }else {
                        alert("회사정보 수정을 하셨습니다.");
                        closeWindowByMask();
                        window.location.reload();
                    }
                });


        });

        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors.getById["site_cancel"].setDefaultFont(sDefaultFont, nFontSize);
        }

        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors2.getById["site_privacy"].setDefaultFont(sDefaultFont, nFontSize);
        }
        $("#re_btn").click(function () {
            window.history.back(-1);
        });

        $(function () {
            $("#incom_in").datepicker({
                dateFormat: "yy-mm-dd",
            });
            $(".incom").datepicker({
                dateFormat: "yy-mm-dd",
            });
        });

    });
</script>