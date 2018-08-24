<?php include "../inc/header.sub.php"; ?>

    <div class="res-check">
        <div class="res-member" style="margin-top : 80px;">
            <table>
                <tr>
                    <td class="res-member-title">
                        로그인
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <input type="text" name="user_id" id="user_id" placeholder="아이디">
                        <span id="id_chk_echo"></span>
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <input type="password" name="user_passwd" id="user_passwd" placeholder="비밀번호">
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <img src="<?=KS_DOMAIN?>/sub_img/login_btn.png" id="login_btn" style="cursor: pointer;">
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text-info">
                        <a href="find_id.php">아이디 찾기</a> |
                        <a href="find_id.php">비밀번호 찾기</a> |
                        <a href="../member/member_join.php">회원가입</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="res-member" style="margin-top : 100px; margin-bottom : 100px;">
            <form id="non_frm" method="post" action="mypage.php">
            <table>
                <tr>
                    <td class="res-member-title">
                        비회원 예약확인
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <input type="text" name="name" id="name" placeholder="예약자명">
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <input type="text" name="phone" id="phone" placeholder="휴대폰 번호">
                    </td>
                </tr>
                <tr>
                    <td class="res-member-text">
                        <button class="gray" id="non_btn">예약확인</button>
                    </td>
                </tr>
            </table>
            </form>
        </div>

    </div>

    <div id="id_hidden"></div>
    <script>

        $(document).ready(function () {

            $("#login_btn").click(function () {
                var url = "../member/login_chk.php";
                if($("#user_id").val()=="" ){
                    alert("아이디를 넣어주세요 ");
                    $("#user_id").focus();
                    return false;
                }else if($("#user_passwd").val()==""){
                    alert("비밀번호를 넣어주세요 ");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "user_id="+$("#user_id").val()+"&user_passwd="+$("#user_passwd").val(), // serializes the form's elements.
                    success: function (data) {
                        $("#id_hidden").html(data);

                    },
                    beforeSend: function () {

                    },
                    complete: function () {
                        if($("#id_chk").val()=="NO") {
                            alert("비밀번호가 틀렸습니다. 다시 확인해주세요.");
                            return false;
                        }else if($("#id_chk").val()=="ID"){
                            alert($("#user_id").val()+'는 존재하지 않는 아이디 입니다. 다시 확인해주세요.');
                            return false;
                        }else{
                            //$("#login_frm").submit();
                              window.location.href ="mypage.php";
                        }
                        //    window.location.href ="/index.html";

                    }
                });


            });
            $("#non_btn").click(function () {
                if($("#name").val()==""){
                    alert("이름을 넣어주세요");
                    return false;
                }else if($("#phone").val()==""){
                    alert("휴대폰번호을 넣어주세요");
                    return false;
                }
                $("#non_frm").submit();
            })

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