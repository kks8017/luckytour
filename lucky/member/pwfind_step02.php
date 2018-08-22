<?php include_once ("../header.sub.php");?>
<link rel="stylesheet" href="../css/member.css" />
<?php
$user = new member();
$user->user_id = $_REQUEST['user_id'];
$user->name = $_REQUEST['user_name'];
$user->phone = $_REQUEST['user_phone'];
$user->email = $_REQUEST['user_email'];

$user_id = $user->user_passwd_find();
if(!$user_id){
   echo "<script>
            alert('입력하신정보가 틀립니다. 다시 확인해주세요 ');
            window.history.back(-1);
         </script>   
    ";
}else{
?>
<div id="content">
    <div class="pwfind">
        <p class="tit">비밀번호 재설정</p>
        <br>
        <form method="post" id="pass_frm" action="passwd_process.php">
            <input type="password" name="passwd" class="passwd" placeholder="새 비밀번호"/>
            <input type="password" name="re_passwd" class="repasswd" placeholder="비밀번호확인"/>
            <input type="button" value="재설정하기" onclick="pass();" class="auth_confirm">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
        </form>
        <p class="subtxt">문제가 있을 경우 고객센터로 연락 주시면 신속히 해결해 드리겠습니다.<br>
            <span class="b">고객센터</span> : 064)746-2727 (09:00~18:00) 토.일요일 및 국공휴일 휴무</p>
    </div>
</div><!-- content 끝 -->
<script>
    function pass() {
        $("#pass_frm").submit();
    }
</script>
<?}?>
<?php include_once ("../footer.php");?>