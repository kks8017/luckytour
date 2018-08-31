<?php
$res = new reservation();
$report  = new report();

$page_no = $_REQUEST['page_no'];
$reserv_name = $_REQUEST['reserv_name'];
$search_price = $_REQUEST['search_price'];


$report->all_price= $search_price;

?>

<div class="reservation_report">
    <div>

        <form id="sch_frm" method="post" action="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>">
            <table class="search_frm">
                <tr>
                    <td>
                        <input type="text" name="search_price" id="search_price" value="<?=$start_date_a?>" class="air_date">
                        <input type="button" id="sch_btn" value="검색">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr>

                <td class="title">No.</td>
                <td class="title">접수일</td>
                <td class="title">예약상태</td>
                <td class="title">예약자</td>
                <td class="title">연락처</td>
                <td class="title">입금구분</td>
                <td class="title">입금일</td>
                <td class="title">금액</td>
                <td class="title">상태</td>
                <td class="title">예약대장</td>
            </tr>
            <?php

            $i=0;
            $reservation_price = $report->reservation_price_search();
            if(is_array($reservation_price)) {
                foreach ($reservation_price as $price){
                    $res->res_no = $price['no'];
                    $report->reserv_user_no = $price['no'];
                    $state = $res->reserv_state();

                    ?>
                    <tr>
                        <td class="content"><?= $i + 1 ?></td>
                        <td class="content"><?= substr($price['indate'], 0, 10) ?></td>
                        <td class="content"><?= $price['reserv_name'] ?></td>
                        <td class="content"><?= $price['reserv_phone'] ?></td>
                        <td class="content"><?=$state?></td>
                        <td class="content"><?= $price['reserv_amount_card_name'] ?></td>
                        <td class="content"><?=set_comma($card['reserv_total_price'])?></td>
                        <td class="content"><?=set_comma($card['reserv_amount_card_price']) ?></td>
                        <td class="content"><?=$card['reserv_amount_card_date']?></td>
                        <td class="content"><?=$card_state?></td>
                        <td class="content"><input type="button" value="예약대장" onclick="ledger('<?= $reservation['no'] ?>')"></td>
                    </tr>
                    <?php
                    $total_card_price += $card['reserv_amount_card_price'];
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <th colspan="10" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
                <?
            }

            ?>
        </table>
        <br>
        <table>
            <tr>
                <td class="content">카드수금액 : <?=set_comma($total_card_price)?>원</td>
            </tr>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#allsel").click(function () {
            $("input[name='sel[]']").prop("checked", function () {
                return !$(this).prop("checked");
            });
        });
        $("#sch_btn").click(function () {
            $("#sch_frm").submit();
        });
    });
    $( function() {
        $( ".air_date" ).datepicker({
            numberOfMonths: 3,
            dateFormat : "yy-mm-dd",
        });
    });
</script>