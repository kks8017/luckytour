<?php include "../inc/header.sub.php"; ?>
<div class="member-join">
    <form id="member_frm" method="POST" >
	<div class="member-join-form">
		<table>
			<tr>
				<td class="join-title">
					아이디
				</td>
				<td class="join-text-id">
					<input type="text" name="user_id" id="user_id" placeholder="아이디">  <span id="id_chk_echo"></span>

				</td>
			</tr>
			<tr>
				<td class="join-title">
					비밀번호
				</td>
				<td class="join-text-main">
					<input type="password" name="passwd" id="passwd" placeholder="비밀번호">
				</td>
			</tr>
			<tr>
				<td class="join-title">
					비밀번호 확인
				</td>			
				<td class="join-text-id">
					<input type="password" id="passwd_re" placeholder="비밀번호  확인"> <span id="passwd_echo"></span>
				</td>
			</tr>
		</table>
	</div>
	<div class="member-join-form">		
			<table>
				<tr>
					<td class="join-title"> 
						이름
					</td>
					<td colspan="2" class="join-text"> 
						<input type="text" name="name" id="name" placeholder="이름">
					</td>
				</tr>
				<tr>
					<td class="join-title">
					생년월일 
					</td>
					<td class="join-text">
						<input type="text" name="birthday" id="birthday" placeholder="생년월일">
					</td>
					<td class="join-text-radio">

					</td>
				</tr>
				<tr>
					<td class="join-title">
					거주지 선택
					</td>
					<td class="join-text-radio">
						<select name="city">
                            <option value="">거주지 선택(시/도)</option>
                            <option value="서울">서울</option>
                            <option value="부산">부산</option>
                            <option value="대구">대구</option>
                            <option value="인천">인천</option>
                            <option value="광주">광주</option>
                            <option value="대전">대전</option>
                            <option value="울산">울산</option>
                            <option value="세종시">세종시</option>
                            <option value="경기">경기</option>
                            <option value="강원">강원</option>
                            <option value="충북">충북</option>
                            <option value="충남">충남</option>
                            <option value="전북">전북</option>
                            <option value="전남">전남</option>
                            <option value="경북">경북</option>
                            <option value="경남">경남</option>
                            <option value="제주">제주</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="join-title">
					휴대폰번호
					</td>
					<td class="join-text">
                        <input type="text" name="phone" id="phone" />
					</td>
					<td class="join-text">

					</td>
				</tr>

				<tr>
					<td class="join-title">
					이메일
					</td>
					<td class="join-text">
						<input type="text"  name="email" id="email" placeholder="이메일(jejuluckytour@damain.com)">
					</td>
					<td class="join-text-radio">

					</td>
				</tr>
			</table>
	</div>
    </form>
	<div class="member-join-form">
		<div class="res-rule-list">
			<dl>
				<dt class="res-rule-total">
				<input type="checkbox" name="all_chk" id="all_chk" value="">
				전제동의
				</dt>
				<dt>
				<input type="checkbox" name="privacy" id="privacy" value="" class="chk"> 개인정보 수집 및 이용동의 (필수)
				</dt>
					<dd><?=$main_company['tour_privacy']?></dd>
				<dt><input type="checkbox" name="commerce" id="commerce" value="" class="chk"> 전자상거래 표준약관 (필수)
				</dt>
					<dd><?=$main_company['tour_commerce']?></dd>
				<dt><input type="checkbox" name="average" id="average" value="" class="chk"> 국내여행표준약관 (필수)</dt>
					<dd><?=$main_company['tour_average']?></dd>
				<dt><input type="checkbox" name="provide" id="provide" value="" class="chk"> 개인정보 제3자 제공(선택)</dt>
					<dd><?=$main_company['tour_privacy_provide']?></dd>
			</dl>
		</div>

		<div class="button-summit-area">
			<button class="button-summit-blue"  id="member_btn">가입하기</button>
		</div>
	</div>


</div>


<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
var acodian = {

  click: function(target) {
    var _self = this,
      $target = $(target);
    $target.on('click', function() {
      var $this = $(this);
      if ($this.next('dd').css('display') == 'none') {
        $('dd').slideUp();
        _self.onremove($target);

        $this.addClass('on');
        $this.next().slideDown();
      } else {
        $('dd').slideUp();
        _self.onremove($target);

      }
    });
  },
  onremove: function($target) {
    $target.removeClass('on');
  }

};
acodian.click('dt');
</script>
    <div id="id_cont"></div>
    <div id="err"></div>
    <script>
        $(document).ready(function () {
            $("#all_chk").click(function () {
                $(".chk").prop("checked", function () {
                    return !$(this).prop("checked");
                });
            });
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



                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#member_frm").serialize()+"&case=insert", // serializes the form's elements.
                    success: function (data) {
                    //    console.log(data);
                    },
                    beforeSend: function () {

                    },
                    complete: function () {

                            window.location.href ="../index.php";

                    }
                });

            });
        });
        function phone_chk(str){
            str = str.replace(/[^0-9]/g, '');
            var tmp = '';
            if( str.length < 4){
                return str;
            }else if(str.length < 7){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3);
                return tmp;
            }else if(str.length < 11){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 3);
                tmp += '-';
                tmp += str.substr(6);
                return tmp;
            }else{
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 4);
                tmp += '-';
                tmp += str.substr(7);
                return tmp;
            }
            return str;
        }

        var phone = document.getElementById('phone');
        phone.onkeyup = function(event){
            event = event || window.event;
            var _val = this.value.trim();
            this.value = phone_chk(_val) ;
        }
    </script>
<?php include "../inc/footer.php"; ?>