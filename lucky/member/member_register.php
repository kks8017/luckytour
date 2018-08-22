<?php include_once ("../header.sub.php");?>
    <link rel="stylesheet" href="../css/member.css" />
<div id="content">
    <div class="regist">
        <p class="tit">회원가입 <span class="txt">제주럭키투어 회원이 되시고 회원만의 다양한 혜택을 받아가세요</span></p>
        <div class="tit_bar">
            <ul>
                <li class="bselect">약관동의</li>
                <li class="select">정보입력</li>
            </ul>
        </div>
        <div class="input_area">
            <form id="member_frm" method="POST" >
                <div class="round"><input type="text" name="user_id" id="user_id" placeholder="아이디" /><span id="id_chk_echo"></span></div>
                <div class="round">
                    <input type="password" placeholder="비밀번호" name="passwd" id="passwd" class="pw"/>
                    <input type="password" placeholder="비밀번호 확인" id="passwd_re" />
                    <span id="passwd_echo"></span>
                </div>
                <div class="round">
                    <input type="text" placeholder="이름" name="name" id="name" class="name"/></p>
                    <input type="text" placeholder="생년월일(예:19880505)" name="birthday" id="birthday" class="birth"/></p>
                    <select name="city" class="lsel">
                        <option value="">거주지 선택(시/도)</option>
                        <option value="1">서울</option>
                        <option value="2">부산</option>
                        <option value="3">대구</option>
                        <option value="4">인천</option>
                        <option value="5">광주</option>
                        <option value="6">대전</option>
                        <option value="7">울산</option>
                        <option value="8">세종시</option>
                        <option value="9">경기</option>
                        <option value="10">강원</option>
                        <option value="11">충북</option>
                        <option value="12">충남</option>
                        <option value="13">전북</option>
                        <option value="14">전남</option>
                        <option value="15">경북</option>
                        <option value="16">경남</option>
                        <option value="17">제주</option>
                    </select>
                </div>
                <div class="none_ar">
                    <span class="tit_tel">전화번호</span>
                    <input type="text" name="phone1" id="phone1" maxlength="4"/> -
                    <input type="text" name="phone2" id="phone2"maxlength="4"/> -
                    <input type="text" name="phone3" id="phone3"maxlength="4"/>
                </div>
                <div class="none_ar">
                    <span  class="tit_email">이&nbsp;메&nbsp;일</span>
                    <input type="text" class="email" name="email" id="email"  placeholder="이메일(jejuluckytour@damain.com)"/>
                </div>
                <div class="none_ar_ck">
                    <input type="checkbox" name="user_sms_chk" value="Y"/>SMS수신(이벤트)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="user_email_chk" value="Y"/>이메일수신(이벤트)
                </div>
                <div class="none_ar">
                    <span  class="tit_spam">스팸코드</span>
                    <a href="javascript:img_change();"><img id="imgs" src="../SpamCode.php" style="vertical-align: middle"></a> <input type="text" name="s_code" id="s_code" class="s_code" maxlength="4"> <span class="tit_code">왼쪽에보이는글를 넣어주세요</span>
                </div>
                <div class="none_ar">
                    <input type="button" id="member_btn" value="가입하기" />
                </div>
            </form>
        </div>
    </div>
</div><!-- content 끝 -->
<div id="id_cont"></div>
<div id="err"></div>
    <script>
        function img_change() {
            $("#imgs").attr("src","/SpamCode.php?img="+new Date().getTime()); // show response from the php script.
        }
        $(document).ready(function () {
            $("#user_id").keyup(function () {
                var url = "id_chk.php"; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "user_id="+$("#user_id").val(), // serializes the form's elements.
                    success: function (data) {
                        $("#id_cont").html(data); // show response from the php script.
                        console.log(data);
                    },
                    beforeSend: function () {

                    },
                    complete: function () {
                        if ($("#id_chk").val() == "YES") {

                            $("#id_chk_echo").html("사용할수있는아이디 입니다.");
                        }else if($("#id_chk").val() == "NO_CHK"){
                            $("#id_chk_echo").html("6글자이상 입니다.확인해주세요");
                        }else{
                            $("#id_chk_echo").html("동일한 아이디가 존재합니다.");
                        }
                    }
                });
            });
            $("#passwd_re").keyup(function () {

                if ($("#passwd").val() == $("#passwd_re").val()) {
                    $("#passwd_echo").html("비밀번호가 동일합니다.");
                }else if($("#passwd").val().length < 6){
                    $("#passwd_echo").html("6글자이상 입니다.확인해주세요");
                }else {
                    $("#passwd_echo").html("비밀번호가 같지않습니다.");
                }
            });
            $("#member_btn").click(function () {
                var url = "member_process.php";
                var email = $('#email').val();
                if($("#user_id").val()==""){
                    alert('아이디을 입력해주세요');
                    $('#user_id').focus();
                    return false;
                }else if($("#name").val()==""){
                    alert('이름을 입력해주세요');
                    $('#name').focus();
                    return false;
                }else if($("#passwd").val()==""){
                    alert('비밀번호을 입력해주세요');
                    $('#passwd').focus();
                    return false;
                }else if($("#passwd").val() != $("#passwd_re").val()){
                    alert('비밀번호가 같지않습니다. 확인해주세요');
                    $('#passwd').focus();
                    return false;
                }else if ($("#id_chk").val() == "NO") {
                    alert('동일한 아이디가존재합니다. 확인해주세요');
                    $('#user_id').focus();
                    return false;
                }else if ($("#id_chk").val() == "NO_CHK") {
                    alert('6글자 이상입니다. 확인해주세요');
                    $('#user_id').focus();
                    return false;
                }

                var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
                if(regex.test(email) === false){
                    alert('잘못된 이메일 형식입니다.');
                    $('#email').focus();
                    return false;
                }
                var phonenum = $('#phone1').val()+"-"+$('#phone2').val()+"-"+$('#phone3').val();
                var regPhone = /(01[0|1|6|9|7])[-](\d{3}|\d{4})[-](\d{4}$)/g;
                if(!regPhone.test(phonenum)){
                    alert('잘못된 휴대폰 번호입니다.');
                    $('#phone').focus();
                    return false;
                }


                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#member_frm").serialize()+"&case=insert", // serializes the form's elements.
                    success: function (data) {
                        $("#err").html(data); // show response from the php script.
                        console.log(data);
                    },
                    beforeSend: function () {

                    },
                    complete: function () {
                        if ($("#er_code").val() == "wrong") {
                            alert("스팸코드를 입력해주세요");
                            return false;
                        }else{
                            window.location.href ="/index.html";
                        }
                    }
                });

            });
        });
    </script>
<?php include_once ("../footer.php");?>