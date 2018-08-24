<?php include_once ("../header.sub.php");?>
    <link rel="stylesheet" href="../css/member.css" />
<div id="content">
    <div class="pwfind">
        <p class="tit">비밀번호 찾기</p>
        <p class="txt">비밀번호는 암호화되어 본인확인을 통해 재설정만 가능합니다.</p>
        <form method="post" action="pwfind_step02.php">
            <input type="text" name="user_id" class="id" placeholder="아이디"/>
            <input type="text" name="user_name" class="pw" placeholder="이름"/>
            <input type="text" name="user_email" class="email" placeholder="이메일(jejuluckytour@damain.com)"/>
            <input type="text" name="user_phone" class="tel" placeholder="연락처(010-1234-1234 또는 01012341234)"/>
            <input type="submit" value="비밀번호 찾기" />
        </form>
        <p class="subtxt">문제가 있을 경우 고객센터로 연락 주시면 신속히 해결해 드리겠습니다.<br>
            <span class="b">고객센터</span> : 064)746-2727 (09:00~18:00) 토.일요일 및 국공휴일 휴무</p>
    </div>
</div><!-- content 끝 -->
<?php include_once ("../footer.php");?>