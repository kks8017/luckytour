<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/member.css" />
<div id="content">
    <div class="idfind">
        <p class="tit">아이디 찾기</p>
        <p class="txt">회원가입시 등록한 정보로 아이디를 찾을 수 있습니다.</p>
        <form method="post" action="idfind_step2.php">
            <input type="text" name="user_name" class="id" placeholder="이름"/>
            <input type="text" name="user_email" class="email" placeholder="이메일(jejuluckytour@damain.com)"/>
            <input type="text" name="user_phone" class="tel" id="phone" placeholder="연락처(010-1234-1234 또는 01012341234)"/>
            <input type="submit" value="아이디 찾기" />
        </form>
        <p class="subtxt">문제가 있을 경우 고객센터로 연락 주시면 신속히 해결해 드리겠습니다.<br>
            <span class="b">고객센터</span> : 064)746-2727 (09:00~18:00) 토.일요일 및 국공휴일 휴무</p>
    </div>
</div><!-- content 끝 -->
<script>
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
<?php include_once ("../footer.php");?>