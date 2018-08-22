<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['reserv_user_no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";

$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);

$sql_amount = "select * from reservation_amount where reserv_user_no='{$no}'";
$rs_amount  = $db->sql_query($sql_amount);
$row_amount = $db->fetch_array($rs_amount);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 입금정보</title>
    <meta charset="utf-8">
    <link href="../css/popup.css" rel="stylesheet">
    <link href="../css/normalize.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
    <script type="text/javascript" src="/lib/common.lib.js" ></script>
</head>
<script>

    function wrapWindowByMask() {

        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();
//      var maskWidth = $(document).width();
        var maskWidth = window.document.body.clientWidth;
        var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";

        var loadingImg = '';
        loadingImg += "<div id='loadingImg' style='position:absolute; left:50%; top:40%; display:none; z-index:10000;'>";
        loadingImg += " <img src='/com/img/viewLoading.gif'/>";
        loadingImg += "</div>";
        //화면에 레이어 추가
        $('body')
            .append(mask)
            .append(loadingImg)
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $('#mask').css({
            'width' : maskWidth
            , 'height': maskHeight
            , 'opacity' : '0.3'
        });

        //마스크 표시
        $('#mask').show();
        //로딩중 이미지 표시
        $('#loadingImg').show();
    }
    function closeWindowByMask() {
        $('#mask, #loadingImg').hide();
        $('#mask, #loadingImg').remove();
    }

    function card_update(i) {
        var url = "reserv_amount_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+$("#no_"+i).val()+"&reserv_user_no=<?=$no?>&card_subject="+$("#card_subject_"+i).val()+"&card_name="+$("#card_name_"+i).val()+"&card_price="+$("#card_price_"+i).val()+"&card_old_price="+$("#card_old_price_"+i).val()+"&card_date="+$("#card_date_"+i).val()+"&card_state="+$("#card_state_"+i).val()+"&card_bigo="+$("#card_bigo_"+i).val()+"&case=card_update", // serializes the form's elements.
            success: function(data)
            {
                console.log(data); // show response from the php script.
            },
            beforeSend : function (){
                wrapWindowByMask();
            },
            complete : function (){
                closeWindowByMask();
                card_list();
                $(opener.location).attr("href", "javascript:user_amount();");
            }
        });

    }
    function card_delete(i) {
        var url = "reserv_amount_process.php"; // the script where you handle the form input.
        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else {
            $.ajax({
                type: "POST",
                url: url,
                data: "no=" + $("#no_" + i).val()+"&card_subject="+$("#card_subject_"+i).val()+"&card_name="+$("#card_name_"+i).val()+"&card_price="+$("#card_price_"+i).val() + "&reserv_user_no=<?=$no?>&case=card_delete", // serializes the form's elements.
                success: function (data) {
                    console.log(data); // show response from the php script.
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    card_list();
                    total_list();
                    $(opener.location).attr("href", "javascript:user_amount();");
                }
            });
        }

    }
   function etc_update(i) {
        var url = "reserv_amount_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+$("#etc_no_"+i).val()+"&etc_subject="+$("#etc_subject_"+i).val()+"&etc_name="+$("#etc_name_"+i).val()+"&etc_price="+$("#etc_price_"+i).val()+"&etc_old_price="+$("#etc_old_price_"+i).val()+"&etc_date="+$("#etc_date_"+i).val()+"&etc_state="+$("#etc_state_"+i).val()+"&etc_bigo="+$("#etc_bigo_"+i).val()+"&reserv_user_no=<?=$no?>&case=etc_update", // serializes the form's elements.
            success: function(data)
            {
                console.log(data); // show response from the php script.
            },
            beforeSend : function (){
                wrapWindowByMask();
            },
            complete : function (){
                closeWindowByMask();
                etc_list();
                total_list();

                $(opener.location).attr("href", "javascript:user_amount();");
            }
        });

    }
    function etc_delete(i) {
        var url = "reserv_amount_process.php"; // the script where you handle the form input.
        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else {
            $.ajax({
                type: "POST",
                url: url,
                data: "no=" + $("#etc_no_" + i).val()+"&etc_subject="+$("#etc_subject_"+i).val()+"&etc_price="+$("#etc_price_"+i).val() + "&reserv_user_no=<?=$no?>&case=etc_delete", // serializes the form's elements.
                success: function (data) {
                    console.log(data); // show response from the php script.
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    etc_list();
                    total_list();
                    $(opener.location).attr("href", "javascript:user_amount();");
                }
            });
        }

    }
    function update() {
        var url = "reserv_amount_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>&reserv_deposit_depositor="+$("#reserv_deposit_depositor").val()
                   +"&reserv_deposit_price="+$("#reserv_deposit_price").val()
                   +"&reserv_deposit_date="+$("#reserv_deposit_date").val()
                   +"&reserv_deposit_state="+$("input:checkbox[name='reserv_deposit_state']:checked").val()
                   +"&reserv_payment_depositor="+$("#reserv_payment_depositor").val()
                   +"&reserv_payment_price="+$("#reserv_payment_price").val()
                   +"&reserv_payment_date="+$("#reserv_payment_date").val()
                   +"&reserv_payment_state="+$("input:checkbox[name='reserv_payment_state']:checked").val()
                   +"&reserv_balance_depositor="+$("#reserv_balance_depositor").val()
                   +"&reserv_balance_price="+$("#reserv_balance_price").val()
                   +"&reserv_balance_date="+$("#reserv_balance_date").val()
                   +"&reserv_balance_state="+$("input:checkbox[name='reserv_balance_state']:checked").val()
                   +"&total_amount="+$("#total_amount").val()
                   +"&case=update", // serializes the form's elements.
            success: function(data)
            {
                console.log(data); // show response from the php script.
            },
            beforeSend : function (){
                wrapWindowByMask();
            },
            complete : function (){
                closeWindowByMask();
                etc_list();
                $(opener.location).attr("href", "javascript:user_amount();");
                window.close();
            }
        });

    }
</script>
<body>
<div id="wrapair">
    <div class="inbody">

        <div id="amt">
        </div>
        <br>




        <form id="etc_frm">
            <table class="conbox">
                <tr>
                    <td class="titbox">추가요금관리</td>
                    <td>
                        <select name="etc_subject">
                            <option value="중도금">중도금</option>
                            <option value="현금영수증">현금영수증</option>
                            <option value="현지입금">현지입금</option>
                            <option value="할인">할인</option>
                            <option value="부분환불">부분환불</option>
                            <option value="전액환불">전액환불</option>
                            <option value="환불요청금">환불요청금</option>
                            <option value="거래처보관금">거래처보관금</option>
                            <option value="취소수수료">취소수수료</option>
                            <option value="기타">기타</option>
                        </select>
                    </td>
                    <td><input type="text" name="etc_price" value="" size="13"></td>
                    <td><input type="button" id="etc_add_btn" value="추가"></td>
                </tr>
            </table>
            <input type="hidden" name="reserv_amount_no" value="<?=$row_amount['no']?>">
            <input type="hidden" name="reserv_user_no" value="<?=$no?>">
        </form>
        <form id="etc_list_frm">
            <div id="etc_list">
            </div>
        </form>
        <form id="card_frm">
            <table class="conbox">
                <tr>
                    <td class="titbox" >카드결제추가</td>
                    <td>
                        <select name="card_subject">
                            <option value="계약금">계약금</option>
                            <option value="중도금">중도금</option>
                            <option value="잔금">잔금</option>
                            <option value="항공">항공</option>
                            <option value="렌트카">렌트카</option>
                            <option value="숙박">숙박</option>
                            <option value="버스/택시">버스택시</option>
                            <option value="버스투어">버스투어</option>
                            <option value="기타">기타</option>
                        </select>
                    </td>
                    <td><input type="text" name="reserv_amount_card_price" value="" size="13"></td>
                    <td><input type="button" id="card_add_btn" value="추가"> <input type="hidden" name="reserv_user_no" value="<?=$no?>"></td>
                </tr>
            </table>
            <input type="hidden" name="reserv_amount_no" value="<?=$row_amount['no']?>">
        </form>
        <form id="card_list_frm">
            <div id="card_list">
            </div>
        </form>
        <br>
    </div>
</div>
<script>

    $( function() {
        $('.NumbersOnly').keyup(function () {
            if( $(this).val() != null && $(this).val() != '' ) {
                var tmps = parseInt($(this).val().replace(/[^0-9]/g, '')) || 0;
                var tmps2 = tmps.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).val(tmps2);
            }
        });

        $("#card_add_btn").click(function () {

            var url = "reserv_amount_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#card_frm").serialize()+"&case=card_insert", // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    card_list();
                    total_list();
                    $(opener.location).attr("href", "javascript:user_amount();");
                }
            });

        });
        $("#etc_add_btn").click(function () {

            var url = "reserv_amount_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#etc_frm").serialize()+"&case=etc_insert", // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    etc_list();
                    total_list();
                    $(opener.location).attr("href", "javascript:user_amount();");
                }
            });

        });
        $("#update_btn").click(function () {

            var url = "reserv_amount_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#amt_frm").serialize()+"&case=update", // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    etc_list();
                    total_list();
                    $(opener.location).attr("href", "javascript:user_amount();");
                }
            });

        });

        card_list();
        etc_list();
        total_list();
    });
    function card_list() {
        var url = "reserv_amount_card_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_amount_no=<?=$row_amount['no']?>", // serializes the form's elements.
            success: function (data) {
                $("#card_list").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
            }
        });
    }
    function etc_list() {
        var url = "reserv_amount_etc_list.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_amount_no=<?=$row_amount['no']?>", // serializes the form's elements.
            success: function (data) {
                $("#etc_list").html(data); // show response from the php script.
              //   console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
            }
        });
    }
    function total_list() {
        var url = "reserv_amount_total.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "reserv_user_no=<?=$no?>", // serializes the form's elements.
            success: function (data) {
                $("#amt").html(data); // show response from the php script.
                //console.log(data);
            },
            beforeSend: function () {
                wrapWindowByMask();
            },
            complete: function () {
                closeWindowByMask();
            }
        });
    }
</script>
</body>
</html>
