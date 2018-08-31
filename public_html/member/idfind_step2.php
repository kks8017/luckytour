<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/member.css" />
<?php
$user = new member();
$user->name = $_REQUEST['user_name'];
$user->phone = $_REQUEST['user_phone'];
$user->email = $_REQUEST['user_email'];

$user_id = $user->user_id_find();

if($user_id){
?>
<div id="content">
    <div class="idfind">
        <p class="tit">아이디 찾기</p>
        <br>
        <br>
        찾은신 아이디는 &nbsp;&nbsp; <span style="color: red;font-weight: bold;"><?=substr($user_id,0,4)?>**** </span>  &nbsp;&nbsp;입니다.
        <br>
        <br>
        <button type="button" class="login_go" onclick="window.location.href='login.php'">로그인</button> <br>
        <button type="button" class="main_go" onclick="window.location.href='../index.php'">메인으로</button>
        <p class="subtxt">문제가 있을 경우 고객센터로 연락 주시면 신속히 해결해 드리겠습니다.<br>
            <span class="b">고객센터</span> : 064)746-2727 (09:00~18:00) 토.일요일 및 국공휴일 휴무</p>
    </div>
</div><!-- content 끝 -->
<?}else{?>
    <div id="content">
        <div class="idfind">
            <p class="tit">아이디 찾기</p>
            <br>
            <br>
            <p>등록된아이디가 없습니다. 다시확인해주세요</p>
            <br>
            <br>
            <button type="button" class="main_go" onclick="window.location.href='../index.php'">메인으로</button>
            <p class="subtxt">문제가 있을 경우 고객센터로 연락 주시면 신속히 해결해 드리겠습니다.<br>
                <span class="b">고객센터</span> : 064)746-2727 (09:00~18:00) 토.일요일 및 국공휴일 휴무</p>
        </div>
    </div><!-- content 끝 -->
<?}?>
<?php include_once ("../footer.php");?>