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
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<input type="password" name="user_passwd" id="user_passwd" placeholder="비밀번호">
					</td>
				</tr>
				<tr>
					<td class="res-member-text"> 
						<img src="../../sub_img/login_btn.png" id="login_btn" style="cursor: pointer;">
					</td>
				</tr>
				<tr>
					<td class="res-member-text-info">
					    <a href="../../member/find_id.php">아이디 찾기</a> |
					    <a href="../../member/find_id.php">비밀번호 찾기</a> |
						<a href="../../member/member_join.php">회원가입</a>
					</td>
				</tr>
			</table>
		</div>

		<div class="res-member" style="margin-top : 100px; margin-bottom : 100px;">
			<table>
				<tr>
					<td class="res-member-title">
						비회원예약
					</td>
				</tr>
				<tr>
					<td class="res-member-text">
						<button class="gray" id="no_member_btn">비회원예약하기</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
    <form id="login_frm" method="post" action="res.php">
    <input type="hidden" name="start_date" value="<?=$_REQUEST['start_date']?>">
    <input type="hidden" name="end_date" value="<?=$_REQUEST['end_date']?>">
    <input type="hidden" name="air_no" value="<?=$_REQUEST['air_no']?>">
    <input type="hidden" name="car_no" value="<?=$_REQUEST['rent_no']?>">
    <input type="hidden" name="tel_no" value="<?=$_REQUEST['tel_no']?>">
    <input type="hidden" name="room_no" value="<?=$_REQUEST['room_no']?>">
    <input type="hidden" name="bus_no" value="<?=$_REQUEST['bus_no']?>">
    <input type="hidden" name="package" value="<?=$_REQUEST['package_type']?>">

    <input type="hidden" name="adult_number" value="<?=$_REQUEST['adult_number']?>">
    <input type="hidden" name="child_number" value="<?=$_REQUEST['child_number']?>">
    <input type="hidden" name="baby_number" value="<?=$_REQUEST['baby_number']?>">
    <input type="hidden" name="package" value="<?=$_REQUEST['package_type']?>">
    <input type="hidden" name="air_type" value="<?=$_REQUEST['air_type']?>">
    <input type="hidden" name="car_sdate" value="<?=$_REQUEST['rent_start_date']?>">
    <input type="hidden" name="car_edate" value="<?=$_REQUEST['rent_end_date']?>">
    <input type="hidden" name="car_stime" value="<?=$_REQUEST['start_hour']?>:<?=$_REQUEST['start_minute']?>">
    <input type="hidden" name="car_etime" value="<?=$_REQUEST['end_hour']?>:<?=$_REQUEST['end_minute']?>">
    <input type="hidden" name="car_vehicle" value="<?=$_REQUEST['rent_vehicle']?>">
    <input type="hidden" name="tel_start_date" value="<?=$_REQUEST['tel_start_date']?>">
    <input type="hidden" name="tel_vehicle" value="<?=$_REQUEST['room_vehicle']?>">
    <input type="hidden" name="tel_stay" value="<?=$_REQUEST['tel_stay']?>">

    <input type="hidden" name="bus_date" value="<?=$_REQUEST['bus_date']?>">
    <input type="hidden" name="bus_stay" value="<?=$_REQUEST['bus_stay']?>">
    <input type="hidden" name="bus_vehicle" value="<?=$_REQUEST['bus_vehicle']?>">
    </form>
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
                           $("#login_frm").submit();
                            //   window.location.href ="/index.html";
                        }
                        //    window.location.href ="/index.html";

                    }
                });


            });
            $("#no_member_btn").click(function () {
                $("#login_frm").submit();
            });
            <?if($_SESSION['user_id']){?>
            $("#login_frm").submit();
            <?}?>
        });
    </script>
<?php include "../inc/footer.php"; ?>