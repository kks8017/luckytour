<?php include_once ("../header.sub.php");?>
<?php
$user_id  = $_SESSION['user_id'];
$res = new reservation();

$board = new board();
$res->user_id = $user_id;
$reserv_list = $res->reservation_id();
$reserv_cnt  = $res->reservation_id_cnt();
$board->user_id = $user_id;
$board->table = "board_latter";
$board_latter_cnt = $board->board_cnt();
$board->table = "board_inquire";
$board_inquire_cnt = $board->board_cnt();
?>
    <link rel="stylesheet" href="../css/customer.css" />
<div id="content">
    <div class="search">
        <div class="search_tit">
            <span class="bar mar"></span>
            <h3>마이페이지</h3>
            <span class="bar"></span>
        </div>
    </div>
    <div class="faq">
        <div class="mypage_tit">
            <table>
                <tr>
                    <td>

                    </td>
                    <td style="text-align: center">
                        <img src="../sub_img/res_con.png">
                    </td>
                    <td>
                        여행상담문의(<span class="res-info-text-num"><?=$board_inquire_cnt?></span>)
                    </td>
                    <td>

                    </td>
                    <td style="text-align: center">
                        <img src="../sub_img/res.png">
                    </td>
                    <td>
                        예약확인(<span class="res-info-text-num"><?=$reserv_cnt?></span>)
                    </td>
                    <td>

                    </td>
                    <td style="text-align: center">
                        <img src="../sub_img/restell.png">
                    </td>
                    <td>
                        여행후기(<span class="res-info-text-num"><?=$board_latter_cnt?></span>)
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </div>
        <div class="lmenu">
            <ul>
                <li><a href="/board/board.php?board_table=inquire&user_id=<?=$user_id?>">여행상담문의<img src="../sub_img/off_left_arrow.png" /></a></li>
                <li><a href="/board/board.php?board_table=latter&user_id=<?=$user_id?>">여행후기<img src="../sub_img/off_left_arrow.png" /></a></li>

            </ul>
        </div>
        <div class="rcon">
            <p>예약확인</p><p>고객님이 예약하신 내역을 확인하실 수있습니다. </p>
            <div class="tbl_wrap">
                <table>
                    <tr>
                        <th style="width: 30%;">예약일자</th>
                        <th style="width: 20%;">예약자</th>
                        <th style="width: 30%;">상품명</th>
                        <th style="width: 20%;">예약상태</th>
                    </tr>
                    <?php
                    if(is_array($reserv_list)){
                        foreach ($reserv_list as $reserv){

                            switch ($reserv['reserv_state']){
                                case "WT" :
                                    $type = " 예약 접수 중입니다.";
                                    break;
                                case "BL" :
                                    $type = " 예약 보류 중입니다.";
                                    break;
                                case "OK" :
                                    $type = " 예약 확정되었습니다.";
                                    break;
                                case "CL" :
                                    $type = " 예약 취소되었습니다.";
                                    break;
                            }
                            $pack = $res->package_type($reserv['reserv_type']);
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    echo substr($reserv['indate'],0,10);
                                    ?>
                                </td>
                                <td>
                                    <?=$reserv['reserv_name']?>
                                </td>
                                <td>
                                    <a href="/board/mypage_view.php?reserv_no=<?=$reserv['no']?>"><?=$pack?></a>
                                </td>
                                <td>
                                    <?=$type?>
                                </td>
                            </tr>
                        <?}
                    }
                    ?>
                </table>
            </div>
          </div>


    </div> <!-- faq 끝 -->
</div><!-- content 끝 -->
<?php include_once ("../footer.php");?>