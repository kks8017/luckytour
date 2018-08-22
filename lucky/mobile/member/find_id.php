<?php include "../inc/header.sub.php"; ?>
	<div class="res-check">
		<div class="res-member" style="margin-top : 80px;">
			<form id="find_id_frm" method="post">
            <table>
				<tr>
					<td class="res-member-title">
						아이디 찾기<br>
						<span class="sub-title">회원가입시 등록한 정보로 아이디를 찾을 수 있습니다. </span>
					</td>
				</tr>	
				<tr>
					<td class="res-member-text">
						<input type="text" name="user_name" id="id_name" placeholder="이름">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="text" name="user_email" id="id_email" placeholder="이메일(test@test.com)">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="text" name="user_phone" id="id_phone" placeholder="연락처">
					</td>
				</tr>				
				<tr>
					<td class="res-member-text"> 
						<a href="#layer2" class="btn-example"><button type="button">아이디찾기</button></a>
					</td>
				</tr>
			</table>
            </form>
		</div>

		<div class="res-member" style="margin-top : 100px; margin-bottom: 100px;">
            <form method="post" id="passwd_frm" action="set_pass.php">
			<table>
				<tr>
					<td class="res-member-title">
						비밀번호 찾기<br>
						<span class="sub-title">회원가입시 등록한 정보로 아이디를 찾을 수 있습니다.</span> 
					</td>
				</tr>
				<tr>
					<td class="res-member-text"> 
						<input type="text" name="user_id" id="passwd_id" placeholder="아이디">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="text" name="user_name" id="passwd_name" placeholder="이름">
					</td>
				</tr>
				<tr>
					<td class="res-member-text"> 
						<input type="text" name="user_email" id="passwd_email" placeholder="이메일(test@test.com)">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="text" name="user_phone"  id="passwd_phone" placeholder="연락처(- 없이 숫자만)">
					</td>
				</tr>

				<tr>
					<td class="res-member-text">
						<button id="passwd_btn"  >비밀번호찾기 </button>
					</td>
				</tr>
			</table>
            </form>
		</div>
	</div>


<div class="dim-layer">
    <div class="dimBg"></div>
    <div id="layer2" class="pop-layer">
        <div class="pop-container">
            <div class="pop-conts">
                <!--content //-->
                <p id="layer_chk" class="ctxt mb20">
                </p>

                <div class="btn-r">
                    <a href="#" class="btn-layerClose">확인</a>
                </div>
                <!--// content-->
            </div>
        </div>
    </div>
</div>

<?php include "../inc/footer.php"; ?>

<script type="text/javascript">
    function find_id() {
        var url = "find_id_chk.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#find_id_frm").serialize(), // serializes the form's elements.
            success: function (data) {
                $("#layer_chk").html(data); // show response from the php script.
                console.log(data);
            },
            beforeSend: function () {
                //  wrapWindowByMask();
            },
            complete: function () {
                //   closeWindowByMask();
            }
        });
    }
	$('.btn-example').click(function(){
	    if($("#id_name").val()==""){
	        alert("이름을 입력해주세요");
	        return false;
        }else if($("#id_email").val()==""){
            alert("이메일을 입력해주세요");
            return false;
        }else if($("#id_phone").val()==""){
            alert("휴대폰번호을 입력해주세요");
            return false;
        }

        var $href = $(this).attr('href');
        layer_popup($href);
        find_id();

    });
    $('#passwd_btn').click(function() {
        if($("#passwd_id").val()==""){
            alert("아이디을 입력해주세요");
            return false;
        }else if($("#passwd_name").val()==""){
            alert("이름을 입력해주세요");
            return false;
        }else if($("#passwd_email").val()==""){
            alert("이메일을 입력해주세요");
            return false;
        }else if($("#passwd_phone").val()==""){
            alert("휴대폰번호을 입력해주세요");
            return false;
        }else{
            $("#passwd_frm").submit();
        }
    });
    function layer_popup(el){

        var $el = $(el);        //레이어의 id를 $el 변수에 저장
        var isDim = $el.prev().hasClass('dimBg');   //dimmed 레이어를 감지하기 위한 boolean 변수

        isDim ? $('.dim-layer').fadeIn() : $el.fadeIn();

        var $elWidth = ~~($el.outerWidth()),
            $elHeight = ~~($el.outerHeight()),
            docWidth = $(document).width(),
            docHeight = $(document).height();

        // 화면의 중앙에 레이어를 띄운다.
        if ($elHeight < docHeight || $elWidth < docWidth) {
            $el.css({
                marginTop: -$elHeight /2,
                marginLeft: -$elWidth/2
            })
        } else {
            $el.css({top: 0, left: 0});
        }

        $el.find('a.btn-layerClose').click(function(){
            isDim ? $('.dim-layer').fadeOut() : $el.fadeOut(); // 닫기 버튼을 클릭하면 레이어가 닫힌다.
            return false;
        });

        $('.layer .dimBg').click(function(){
            $('.dim-layer').fadeOut();
            return false;
        });

    }
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

    var phone = document.getElementById('id_phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }
    var phone = document.getElementById('passwd_phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }

</script>