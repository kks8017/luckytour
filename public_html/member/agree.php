<?php include_once ("../header.sub.php");?>

<link rel="stylesheet" href="../css/member.css" />
<div id="content">
    <div class="regist">
        <p class="tit">회원가입 <span class="txt">제주럭키투어 회원이 되시고 회원만의 다양한 혜택을 받아가세요</span></p>
        <div class="tit_bar">
            <ul>
                <li class="select">약관동의</li>
                <li class="aselect">정보입력</li>
            </ul>
        </div>
        <div class="contract">
            <div class="agreebox">
                <p>전자상거래 표준약관 <input type="checkbox" id="commerce" value="Y" class="chk"/></p>
                <div class="agree">
                 <?=$main_company['tour_commerce']?>
                </div>
            </div>
            <div  class="agreebox">
                <p>국내여행 표준약관 <input type="checkbox" id="average" value="Y"  class="chk"/></p>
                <div class="agree">
                    <?=$main_company['tour_average']?>
                </div>
            </div>
            <div  class="agreebox">
                <p>개인정보 수집 및 이용동의 <input type="checkbox" id="privacy" value="Y" class="chk" /></p>
                <div class="agree">
                    <?=$main_company['tour_privacy']?>
                </div>
            </div>
            <div  class="agreebox">
                <p>개인정보 제3자제공 동의<input type="checkbox" id="provide" value="Y"  class="chk"/></p>
                <div class="agree">
                    <?=$main_company['tour_privacy_provide']?>
                </div>
            </div>


            <p class="allcheck"><input type="checkbox" id="all_chk" /> 모든 약관에 동의합니다.</p>
            <p class="next"><button type="button" id="next" >다음</button></p>
        </div>
    </div>
</div><!-- content 끝 -->
<script>
    $(document).ready(function () {
        $("#all_chk").click(function () {
            $(".chk").prop("checked", function () {
                return !$(this).prop("checked");
            });
        });
        $("#next").click(function () {

            if(!$('#commerce').is(':checked')) {
                alert("전자상거래표준 약관에 동의해주세요");
                return;
            }else if(!$('#average').is(':checked')) {
                alert("국내여행 표준약관 약관에 동의해주세요");
                return;
            }else if(!$('#privacy').is(':checked')) {
                alert("개인정보 수집 및 이용에 동의해주세요");
                return;
            }else if(!$('#provide').is(':checked')) {
                alert("개인정보 제3자제공에 동의해주세요");
                return;
            }
            window.location.href = "member_register.php";
        });

    });
</script>
<?php include_once ("../footer.php");?>