<?php include_once ("../header.sub.php");?>
<?php
//print_r($_REQUEST);
?>
    <link rel="stylesheet" href="../css/member.css" />

    <form id="login_frm" method="post" action="../reservation/reservation.php">
    <div id="content">
        <div class="login">
            <div class="lcon">
                <p class="tit">로그인</p>

                    <input type="text" name="user_id" id="user_id" class="id" placeholder="아이디"/>
                    <input type="password" name="user_passwd" class="pw" placeholder="비밀번호"/>
                    <img type="button" id="login_btn" src="../sub_img/login_btn.png" />

                <div class="find">
                    <p ><a href="idfind.php"><span>아이디 찾기</span></a>
                        <span>|</span>
                        <a href="./pwfind.html"><span>비밀번호 찾기</span></a>
                        <span>|</span>
                        <a href="/member/agree.php"><span>회원가입</span></a>
                    </p>
                </div>
            </div>
            <div class="bar"></div>
            <div class="rcon">
                <p class="tit">비회원 예약</p>
                <p class="tit_con"> 비회원으로 예약을 원하시면 비회원예약 버튼을 클릭하세요.</p>
                <p class="tit_con"> <img id="no_member_btn" type="button" src="../sub_img/login_reserv_btn.gif" style="cursor: pointer;" /></p>
            </div>
        </div>
    </div><!-- content 끝 -->
    <input type="hidden" name="start_date" value="<?=$_REQUEST['start_date']?>">
    <input type="hidden" name="end_date" value="<?=$_REQUEST['end_date']?>">
    <input type="hidden" name="air_no" value="<?=$_REQUEST['air_no']?>">
    <input type="hidden" name="air_company_no" value="<?=$_REQUEST['air_company_no']?>">
    <input type="hidden" name="car_no" value="<?=$_REQUEST['car_no']?>">

    <input type="hidden" name="bus_no" value="<?=$_REQUEST['bus_no']?>">
     <input type="hidden" name="bustour_no" value="<?=$_REQUEST['bustour_no']?>">

    <input type="hidden" name="adult_number" value="<?=$_REQUEST['adult_number']?>">
    <input type="hidden" name="child_number" value="<?=$_REQUEST['child_number']?>">
    <input type="hidden" name="baby_number" value="<?=$_REQUEST['baby_number']?>">
    <input type="hidden" name="package" value="<?=$_REQUEST['package_type']?>">
    <input type="hidden" name="air_type" value="<?=$_REQUEST['air_type']?>">
    <input type="hidden" name="car_sdate" value="<?=$_REQUEST['car_sdate']?>">
    <input type="hidden" name="car_edate" value="<?=$_REQUEST['car_edate']?>">
    <input type="hidden" name="car_stime" value="<?=$_REQUEST['car_stime']?>">
    <input type="hidden" name="car_etime" value="<?=$_REQUEST['car_etime']?>">
    <input type="hidden" name="car_vehicle" value="<?=$_REQUEST['car_vehicle']?>">

    <input type="hidden" name="bus_date" value="<?=$_REQUEST['bus_date']?>">
    <input type="hidden" name="bus_stay" value="<?=$_REQUEST['bus_stay']?>">
    <input type="hidden" name="bus_vehicle" value="<?=$_REQUEST['bus_vehicle']?>">
    <input type="hidden" name="bustour_no" value="<?=$_REQUEST['bustour_no']?>">
        <input type="hidden" name="tel_t" value="<?=$_REQUEST['tel_t']?>">
    <?if(is_array($_REQUEST['tel_no'])) {
         for ($i = 0; $i < count($_REQUEST['tel_no']); $i++) {
        ?>
        <input type="hidden" name="tel_no[]" value="<?=$_REQUEST['tel_no'][$i]?>">
        <input type="hidden" name="room_no[]" value="<?=$_REQUEST['room_no'][$i]?>">
        <input type="hidden" name="tel_start_date[]" value="<?=$_REQUEST['tel_date'][$i]?>">
        <input type="hidden" name="tel_vehicle[]" value="<?=$_REQUEST['tel_vehicle'][$i]?>">
        <input type="hidden" name="tel_stay[]" value="<?=$_REQUEST['tel_stay'][$i]?>">
        <?}?>
    <?}else{?>
        <input type="hidden" name="tel_no" value="<?=$_REQUEST['tel_no']?>">
        <input type="hidden" name="room_no" value="<?=$_REQUEST['room_no']?>">
        <input type="hidden" name="tel_start_date" value="<?=$_REQUEST['tel_start_date']?>">
        <input type="hidden" name="tel_vehicle" value="<?=$_REQUEST['tel_vehicle']?>">
        <input type="hidden" name="tel_stay" value="<?=$_REQUEST['tel_stay']?>">
     <?}?>
    <?
    if(is_array($_REQUEST['golf_no'])) {
        for ($i = 0; $i < count($_REQUEST['golf_no']); $i++) {
            ?>
            <input type="hidden" name="golf_no[]" value="<?= $_REQUEST['golf_no'][$i] ?>">
            <input type="hidden" name="hole_no[]" value="<?= $_REQUEST['hole_no'][$i] ?>">
            <input type="hidden" name="golf_date[]" value="<?= $_REQUEST['golf_date'][$i] ?>">
            <input type="hidden" name="golf_time[]" value="<?= $_REQUEST['golf_time'][$i] ?>">
        <?
        }
    }
     ?>
    </form>
    <div id="id_hidden"></div>
    <script>

        $(document).ready(function () {

            $("#login_btn").click(function () {
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
<?php include_once ("../footer.php");?>