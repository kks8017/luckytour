<?php include "../inc/header.sub.php"; ?>
<?php
$user = new member();
$user->user_id = $_REQUEST['user_id'];
$user->name = $_REQUEST['user_name'];
$user->phone = $_REQUEST['user_phone'];
$user->email = $_REQUEST['user_email'];

$user_id = $user->user_passwd_find();
if(!$user_id){
   echo "<script>
            alert('입력하신정보가 맞지않습니다. 다시 확인해주세요');
            window.history.back(-1);
          </script>";
}else{
?>
	<div class="res-check">
		<div class="res-member" style="margin-top : 100px; margin-bottom: 100px;">
			<form id="passwd_frm" method="post" action="passwd_process.php">
            <table>
				<tr>
					<td class="res-member-title">
						비밀번호 재설정 하기<br>
						<span class="sub-title">새롭게 사용하실 비밀번호를 작성하시기 바랍니다.</span> 
					</td>
				</tr>
				<tr>
					<td class="res-member-text"> 
						<input type="password" name="passwd" placeholder="새로운 비밀번호를 적어주시기 바랍니다.">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="password" name="re_passwd" placeholder="비밀번호 확인">
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<button id="passwd_btn">확인</button>
					</td>
				</tr>
			</table>
                <input type="hidden" name="user_id" value="<?=$user_id?>">
            </form>
		</div>
	</div>
    <script>
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
    </script>
<?}?>


<?php include "../inc/footer.php"; ?>
