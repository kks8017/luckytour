<?php
$no = $_GET['no'];
$sql = "select * from tour_company where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);
?>
<div style="margin-top: 20px;">
    <div>
        <table class="tbl">
            <tr>
                <th class="title">사이트설정</th>
                <td class="content"><input type="radio" name="site_main" value="Y" <?if($row['tour_main']=="Y"){?>checked<?}?> >메인 <input type="radio" name="site_main" value="N" <?if($row['tour_main']=="N"){?>checked<?}?>>서브</td>
            </tr>
            <tr>
                <th class="title">사이트명</th>
                <td class="content"><input type="text" name="site_name" id="site_name" value="<?=$row['tour_name']?>"></td>
            </tr>
            <tr>
                <th class="title">사이트아이디</th>
                <td class="content"><input type="text" name="site_id" id="site_id" value="<?=$row['tour_id']?>"></td>
            </tr>
            <tr>
                <th class="title">사이트타이틀</th>
                <td class="content"><input type="text" name="site_title" id="site_title" value="<?=$row['tour_title']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">도메인</th>
                <td class="content"><input type="text" name="site_domain" id="site_domain" value="<?=$row['tour_domain']?>"></td>
            </tr>
            <tr>
                <th class="title">대표자</th>
                <td class="content"><input type="text" name="site_ceo" id="site_ceo" value="<?=$row['tour_ceo']?>"></td>
            </tr>
            <tr>
                <th class="title">사업자번호</th>
                <td class="content"><input type="text" name="site_com_number" id="site_com_number" value="<?=$row['tour_com_number']?>"></td>
            </tr>
            <tr>
                <th class="title">전화번호</th>
                <td class="content"><input type="text" name="site_phone" id="site_phone" value="<?=$row['tour_phone']?>"></td>
            </tr>
            <tr>
                <th class="title">팩스</th>
                <td class="content"><input type="text" name="site_fax" id="site_fax" value="<?=$row['tour_fax']?>"></td>
            </tr>
            <tr>
                <th class="title">보증보험</th>
                <td class="content"><input type="text" name="site_insurance" id="site_insurance" value="<?=$row['tour_insurance']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">관광사업등록번호</th>
                <td class="content"><input type="text" name="site_tourism" id="site_tourism" value="<?=$row['tour_tourism']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">통신판매업신고</th>
                <td class="content"><input type="text" name="site_online" id="site_online" value="<?=$row['tour_online_number']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">계좌번호</th>
                <td class="content"><input type="text" name="tour_account" id="tour_account" value="<?=$row['tour_account']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">문자계좌번호</th>
                <td ><textarea name="tour_sms_account" rows="5" cols="20" id="tour_sms_account" ><?=$row['tour_sms_account']?></textarea>

                </td>
            </tr>
            <tr>
                <th class="title">주소</th>
                <td class="content"><input type="text" name="site_address" id="site_address" value="<?=$row['tour_address']?>" size="50"></td>
            </tr>
            <tr>
                <th class="title">취소수수료</th>
                <td ><textarea name="site_cancel" id="site_cancel" rows="20" cols="100" ><?=$row['tour_cancel']?></textarea>

                </td>
            </tr>
            <tr>
                <th class="title">개인정보취급방침</th>
                <td ><textarea name="site_privacy" id="site_privacy" rows="20" cols="100" ><?=$row['tour_privacy']?></textarea>

                </td>
            </tr>
            <tr>
                <th class="title">국내여행표준약관</th>
                <td ><textarea name="site_average" id="site_average" rows="20" cols="100" ><?=$row['tour_average']?></textarea>

                </td>
            </tr>

            <tr>
                <th class="title">전자상거래표준약관</th>
                <td ><textarea name="site_commerce" id="site_commerce" rows="20" cols="100" ><?=$row['tour_commerce']?></textarea></td>
            </tr>
            <tr>
                <th class="title">개인정보 제3자제공 동의</th>
                <td ><textarea name="site_privacy_provide" id="site_privacy_provide" rows="20" cols="100" ><?=$row['tour_privacy_provide']?></textarea>

                </td>
            </tr>
        </table>
        <p style="text-align: center;"><input id="up_btn" type="button" value="수정"> <input id="re_btn" type="button" value="뒤로가기"> </p>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var oEditors = [];
        var oEditors2 = [];
        var oEditors3 = [];
        var oEditors4 = [];
        var oEditors5 = [];

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
        }

        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors3,
            elPlaceHolder: "site_average",
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
            oEditors3.getById["site_average"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors3.getById["site_average"].getIR();
        }
        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors4,
            elPlaceHolder: "site_commerce",
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
            oEditors4.getById["site_commerce"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors4.getById["site_commerce"].getIR();
            alert(sHTML);
        }
        nhn.husky.EZCreator.createInIFrame({

            oAppRef: oEditors5,
            elPlaceHolder: "site_privacy_provide",
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
            oEditors5.getById["site_privacy_provide"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors5.getById["site_privacy_provide"].getIR();
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
            var average = oEditors3.getById["site_average"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
            var commerce = oEditors4.getById["site_commerce"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.
            var provide = oEditors5.getById["site_privacy_provide"].getIR();	// 에디터의 내용이 textarea에 적용됩니다.

            $.post("company_process.php",
                {
                    tour_name: $("#site_name").val(),
                    tour_title: $("#site_title").val(),
                    tour_domain: $("#site_domain").val(),
                    tour_ceo: $("#site_ceo").val(),
                    tour_com_number: $("#site_com_number").val(),
                    tour_phone: $("#site_phone").val(),
                    tour_address: $("#site_address").val(),
                    tour_fax: $("#site_fax").val(),
                    tour_insurance: $("#site_insurance").val(),
                    tour_tourism: $("#site_tourism").val(),
                    tour_online: $("#site_online").val(),
                    tour_sms_account: $("#tour_sms_account").val(),
                    tour_account: $("#tour_account").val(),
                    tour_main: $(':radio[name="site_main"]:checked').val(),
                    tour_cancel: cancel,
                    tour_privacy: privacy,
                    tour_average: average,
                    tour_commerce: commerce,
                    tour_privacy_provide: provide,
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
        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors3.getById["site_average"].setDefaultFont(sDefaultFont, nFontSize);
        }
        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors4.getById["site_commerce"].setDefaultFont(sDefaultFont, nFontSize);
        }
        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors5.getById["site_privacy_provide"].setDefaultFont(sDefaultFont, nFontSize);
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