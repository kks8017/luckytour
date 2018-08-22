<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/member.css" />
<div id="content">
    <div class="login">
        <div class="lcon">
            <p class="tit">로그인</p>
            <form id="login_frm">
                <input type="text" name="user_id" id="user_id" class="id" placeholder="아이디" value=""/>
                <input type="password" name="user_passwd" id="user_passwd" class="pw" placeholder="비밀번호" value=""/>
                <img type="button" id="login_btn" src="../sub_img/login_btn.png" />
            </form>
            <div class="find">
                <p ><a href="idfind.php"><span>아이디 찾기</span></a>
                    <span>|</span>
                    <a href="pwfind.php"><span>비밀번호 찾기</span></a>
                    <span>|</span>
                    <a href="/member/agree.php"><span>회원가입</span></a>
                </p>
            </div>
        </div>
        <div class="bar"></div>
        <div class="rcon">
            <p class="tit">비회원 로그인</p>
            <form >
                <input type="text" name="name" class="id" placeholder="예약자명"/>
                <input type="text" name="phone" class="pw" placeholder="휴대폰 번호"/>
                <input type="image" src="../sub_img/login_btn.png" />
            </form>
        </div>
    </div>
</div><!-- content 끝 -->
<div id="id_hidden"></div>
    <script>

        $(document).ready(function () {

            $("#login_btn").click(function () {
                if($("#user_id").val() == ""){
                    alert("아이디를 넣어주세요 ");
                    return false;
                }else if($("#user_passwd").val()=="") {
                    alert("비밀번호를 넣어주세요 ");
                    return false;
                }

                var url = "login_chk.php";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#login_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        $("#id_hidden").html(data);
                        console.log(data);
                    },
                    beforeSend: function () {

                    },
                    complete: function () {
                        if($("#id_chk").val()=="NO") {
                            alert("비밀번호가 틀렸습니다. 다시 확인해주세요.");
                            return false;
                        }else if($("#id_chk").val()=="ID"){
                            alert($("#user_id").val()+'는 존재하지 않는 아이디 입니다. 다시 확인해주세요.');
                        }else{
                           // window.location.href ="/index.html";
                        }
                        //    window.location.href ="/index.html";

                    }
                });

            });
        });
    </script>
<?php include_once ("../footer.php");?>