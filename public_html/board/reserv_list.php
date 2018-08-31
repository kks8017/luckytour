<?php
$name  = $_REQUEST['name'];
$phone = $_REQUEST['phone'];

$res = new reservation();
$res->name = $name;
$res->phone = $phone;
$reserv_list = $res->reservation_comfirm();
?>
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
                            <a href="/board/board.php?board=reserv_view&reserv_no=<?=$reserv['no']?>"><?=$pack?></a>
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
