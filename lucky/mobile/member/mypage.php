<?php include "../inc/header.sub.php"; ?>
<br>
<?php
$user_id  = $_SESSION['user_id'];
$res = new reservation();
$name  = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
if($_SESSION['user_id']=="" ) {
    if(!$name) {
        echo "<script>
            window.location.href = 'login.php';
        </script>";
    }else {

        $res->name = $name;
        $res->phone = $phone;
        $reserv_list = $res->reservation_comfirm();
        ?>
        <div class="mypage-menu">
            <ul>
                <li><a href="#">예약내역</a></li>
            </ul>
        </div>
        <br>
        <br>
        <div class="res-form-end">
            <div class="res-item-list-end">
                <table class="res-list">
                    <tr>
                        <th>예약일자</th>
                        <th>예약자</th>
                        <th>상품명</th>
                        <th>예약상태</th>
                    </tr>
                    <?php
                    if (is_array($reserv_list)) {
                        foreach ($reserv_list as $reserv) {

                            switch ($reserv['reserv_state']) {
                                case "WT" :
                                    $type = " 예약접수";
                                    break;
                                case "BL" :
                                    $type = " 예약보류";
                                    break;
                                case "OK" :
                                    $type = " 예약확정";
                                    break;
                                case "CL" :
                                    $type = " 예약취소";
                                    break;
                            }

                            $pack = $res->package_type($reserv['reserv_type']);
                            ?>
                            <tr>
                                <td> <?php
                                    echo substr($reserv['indate'], 0, 10);
                                    ?> </td>
                                <td> <?= $reserv['reserv_name'] ?></td>
                                <td><a href="javascript:selected_cont(<?= $reserv['no'] ?>)"><?= $pack ?></a></td>
                                <td>
                                    <span class="res-price-list-item"><?= $type ?></span>
                                </td>
                            </tr>
                        <?
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4">검색하신 예약내역이 없습니다</td>
                        </tr>
                    <?
                    } ?>
                </table>
            </div>
            <br>
            <br>
            <br>
            <div id="select_content">


            </div>
            <div class="button-summit-area">
                <button class="button-summit-blue" type="summit" onclick="window.location.href='../index.php'">메인으로
                </button>
            </div>


        </div>


        <?
    }
}else{
$res->user_id = $user_id;
$reserv_list = $res->reservation_id();
$reserv_type_re = $res->reservation_type_cnt("WT");
$reserv_type_ok = $res->reservation_type_cnt("OK");

?>
<div  class="mypage-menu">
	<ul>
		<li><a href="#">예약내역</a></li>
		<li><a href="member_join.php">회원정보수정</a></li>
        <li><a href="logout.php">로그아웃</a></li>

	</ul>
</div>
<div class="mypage-menu-top">
	<table>
		<tr>
			<td class="num" style="border-right: 1px solid #919191;"><?=$reserv_type_re?></td>
			<td class="num"><?=$reserv_type_ok?></td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #919191;">예약접수중</td>
			<td>예약확정</td>
		</tr>
	</table>	
</div>
<br>
<br>
<div class="res-form-end">
		<div class="res-item-list-end">
			<table class="res-list">
				<tr>									
					<th>예약일자</th>
					<th>예약자</th>
					<th>상품명</th>
					<th>예약상태</th>
				</tr>
                <?php
                if(is_array($reserv_list)){
                    foreach ($reserv_list as $reserv){

                        switch ($reserv['reserv_state']){
                            case "WT" :
                                $type = " 예약접수";
                                break;
                            case "BL" :
                                $type = " 예약보류";
                                break;
                            case "OK" :
                                $type = " 예약확정";
                                break;
                            case "CL" :
                                $type = " 예약취소";
                                break;
                        }

                        $pack = $res->package_type($reserv['reserv_type']);
                        ?>
                <tr>
					<td> <?php
                        echo substr($reserv['indate'],0,10);
                        ?> </td>
					<td> <?=$reserv['reserv_name']?></td>
                    <td><a href="javascript:selected_cont(<?=$reserv['no']?>)"><?=$pack?></a></td>
					<td>
						<span class="res-price-list-item"><?=$type?></span>
					</td>
				</tr>
                    <?}
                }
                ?>
			</table>
		</div>
	<br>
	<br>
	<br>
    <div id="select_content">


    </div>
    <div class="button-summit-area">
        <button class="button-summit-blue" type="summit" onclick="window.location.href='../index.php'">메인으로</button>
    </div>


</div>
 <?}?>
<script>
    function selected_cont(no) {
        var url = "mypage_view.php"; // the script where you handle the form input.
        $("#select_content").html("");
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_no="+no, // serializes the form's elements.
            success: function (data) {
                $("#select_content").html(data); // show response from the php script.
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
</script>
<?php include "../inc/footer.php"; ?>