<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$lodging_no = $_REQUEST['lodging_no'];
$season_no  = $_REQUEST['season_no'];
$mode       = $_REQUEST['mode'];










$sql_lod = "select no,lodging_name,lodging_type,lodging_area  from lodging_list order by binary(lodging_name)";
$rs_lod  = $db->sql_query($sql_lod);
while($row_lod = $db->fetch_array($rs_lod)) {
    $result_lod[] = $row_lod;
}
if(!$lodging_no){$lodging_no=$result_lod[0]['no'];}

if($mode=="season") {
    $sql = "select lodging_season_amount.no as amt_no,
                lodging_room.no as room_no,
                lodging_room_name,
                lodging_room_min,
                lodging_room_max,
                lodging_season_open,
                lodging_season_amount.lodging_no as lod_no,
                lodging_season_basic,
                lodging_season_basic_week,
                lodging_season_tel,
                lodging_season_airtel,
                lodging_season_aircartel,
                lodging_season_tel_week,
                lodging_season_airtel_week,
                lodging_season_aircartel_week,
                lodging_season_deposit,
                lodging_season_deposit_week,
                lodging_season_adult_add,
                lodging_season_child_add,
                lodging_season_week 
             from lodging_room,lodging_season_amount where lodging_season_amount.lodging_room_no=lodging_room.no and lodging_season_amount.lodging_season_no='{$season_no}' and lodging_room.lodging_no='{$lodging_no}' ";

    $sql_margin = "select no,lodging_no,lodging_amount_margin_basic,lodging_amount_margin_tel,lodging_amount_margin_airtel,lodging_amount_margin_aircartel from lodging_amount_margin where lodging_no='{$lodging_no}' and lodging_season_no='{$season_no}' and lodging_margin_mode='season'";

//echo  $sql;

}else{
    $sql = "select lodging_amount.no as amt_no,
                lodging_room.no as room_no,
                lodging_room_name,
                lodging_room_min,
                lodging_room_max,
                lodging_amount.lodging_no as lod_no,
                lodging_amount_basic,
                lodging_amount_basic_week,
                lodging_amount_tel,
                lodging_amount_airtel,
                lodging_amount_aircartel,
                lodging_amount_tel_week,
                lodging_amount_airtel_week,
                lodging_amount_aircartel_week,
                lodging_amount_deposit,
                lodging_amount_deposit_week,
                lodging_amount_adult_add,
                lodging_amount_child_add,
                lodging_week 
             from lodging_room,lodging_amount where lodging_amount.lodging_room_no=lodging_room.no and lodging_amount.lodging_no='{$lodging_no}'";
    $sql_margin = "select no,lodging_no,lodging_amount_margin_basic,lodging_amount_margin_tel,lodging_amount_margin_airtel,lodging_amount_margin_aircartel from lodging_amount_margin where lodging_no='{$lodging_no}' and lodging_margin_mode!='season' ";

}
//echo $sql_margin;
$rs = $db->sql_query($sql);

if(!$rs) {
    echo "";
}else{

    while($row = $db->fetch_array($rs)) {
        $result_list[] = $row;
    }
}
$rs_margin = $db->sql_query($sql_margin);

if(!$rs_margin) {
    echo "";
}else{

    $row_margin = $db->fetch_array($rs_margin);

}
$sql_season = "select no,lodging_season_name,lodging_season_start_date,lodging_season_end_date from lodging_season_list where lodging_no='{$lodging_no}'  order by no";
//echo $sql_season;
$rs_season  = $db->sql_query($sql_season);
if(!$rs_season) {
    echo "";
}else{
    while ($row_season = $db->fetch_array($rs_season)) {
        $result_season[] = $row_season;
    }
}
?>
<script>
    function season_up_pop(no) {

        var url = "tel/lodging_season_up.php"; // the script where you handle the form input.

        $(".overlay" ).show();
        $(".layer_d_m" ).show();
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no, // serializes the form's elements.
            success: function (data) {
                $("#layer_d_m").html(data); // show response from the php script.
                console.log(data);

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function season_del (no) {
        var url = "tel/lodging_process.php"; // the script where you handle the form input.

        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else{
            $.post("tel/lodging_process.php",
                {
                        no:no,
                        case : "season_del"
                },
                function(data,status) {
                    console.log(data);
                    alert("기간명를 삭제하셨습니다..");

                    window.location.reload();

                });

        }

    }
</script>
<div class="tel_amount">
    <div id="tel_amount">
        <select name="lodging_no" id="lodging_no">
            <?php
            foreach ($result_lod as $lodging){
                if($lodging['no']== $lodging_no){$sel="selected";}else{$sel="";}
                echo "<option value='{$lodging['no']}' {$sel}>{$lodging['lodging_name']}</option>";
            }
            ?>
        </select>

<div>전체마진적용</div>
<form id="margin_frm">
<table>
    <tr>
        <td>기본</td>
        <td>판매</td>
        <td>에어텔</td>
        <td>에어카텔</td>
        <td>적용</td>
    </tr>
    <tr>
        <td><input type="text" name="margin_basic" value="<?=$row_margin['lodging_amount_margin_basic']?>"></td>
        <td><input type="text" name="margin_tel" value="<?=$row_margin['lodging_amount_margin_tel']?>"></td>
        <td><input type="text" name="margin_airtel" value="<?=$row_margin['lodging_amount_margin_airtel']?>"></td>
        <td><input type="text" name="margin_aircartel" value="<?=$row_margin['lodging_amount_margin_aircartel']?>"></td>
        <td><input type="button" id="margin_btn" value="적용"><input type="hidden" name="no" value="<?=$row_margin['no']?>">
            <input type="hidden" name="season_no" value="<?=$season_no?>">
            <input type="hidden" name="case" value="margin_insert"><input type="hidden" name="mode" value="<?=$mode?>"></td>
    </tr>
</table>
</form>
<div>기간리스트</div>
<div class="season">
    <div <?if(!$season_no){?>class="div_bule"<?}?>><a href="?linkpage=tel&subpage=amount&lodging_no=<?=$lodging_no?>">비수기</a></div>
    <?php
    if(is_array($result_season)) {
        foreach ($result_season as $season){
            if($season['no']==$season_no){$class = "class='div_bule'";}else{$class="";}
            ?>
            <div <?=$class?>><a href="?linkpage=tel&subpage=amount&lodging_no=<?=$lodging_no?>&mode=season&season_no=<?=$season['no']?>"><?=$season['lodging_season_name']?>(<?=$season['lodging_season_start_date']?>~<?=$season['lodging_season_end_date']?>)</a> <input type="button" id="season_up_btn" value="수정" onclick="season_up_pop(<?=$season['no']?>);"><input type="button" id="season_del_btn" value="삭제" onclick="season_del(<?=$season['no']?>);"></div>
            <?
        }
    }else{
        echo "";
    }?>
</div>
<table>
    <tr>
        <td colspan="8"> <input type="button" id="amt_up_btn" value="선택수정"> <input type="button" id="amt_del_btn" value="선택삭제"> <input type="button" id="season_in_btn" value="기간등록"></td>
    </tr>
    <tr>
        <td><input type="checkbox" id="allsel"></td>
        <td>객실명</td>
        <td>기준인원</td>
        <?if($mode=="season"){?>
        <td>공개여부</td>
        <?}?>
        <td>기본주중<br>기본주말</td>
        <td>판매주중<br>판매주말</td>
        <td>에어텔주중<br>에어텔주말</td>
        <td>에어카텔주중<br>에어카텔주말</td>
        <td>입금가주중<br>입금가주말</td>
        <td>성인요금<br>소아요금</td>
        <td>주말적용<br>(일월화수목금토)</td>
    </tr>
    <form id="amt_up_frm">
    <?php
    $i=0;
    if(is_array($result_list)) {
        foreach ($result_list as $data){
            if($mode =="season"){
                $lodging_amount_basic = set_comma($data['lodging_season_basic']);
                $lodging_amount_basic_week = set_comma($data['lodging_season_basic_week']);
                $lodging_amount_tel = set_comma($data['lodging_season_tel']);
                $lodging_amount_tel_week = set_comma($data['lodging_season_tel_week']);
                $lodging_amount_airtel = set_comma($data['lodging_season_airtel']);
                $lodging_amount_airtel_week = set_comma($data['lodging_season_airtel_week']);
                $lodging_amount_aircartel = set_comma($data['lodging_season_aircartel']);
                $lodging_amount_aircartel_week = set_comma($data['lodging_season_aircartel_week']);
                $lodging_amount_deposit = set_comma($data['lodging_season_deposit']);
                $lodging_amount_deposit_week = set_comma($data['lodging_season_deposit_week']);
                $lodging_amount_adult_add = set_comma($data['lodging_season_adult_add']);
                $lodging_amount_child_add = set_comma($data['lodging_season_child_add']);
                $open_chk ="";
                if($data['lodging_season_open']=="Y"){
                    $open_chk = "checked";
                }
           //     echo $open_chk;
            }else {
                $lodging_amount_basic = set_comma($data['lodging_amount_basic']);
                $lodging_amount_basic_week = set_comma($data['lodging_amount_basic_week']);
                $lodging_amount_tel = set_comma($data['lodging_amount_tel']);
                $lodging_amount_tel_week = set_comma($data['lodging_amount_tel_week']);
                $lodging_amount_airtel = set_comma($data['lodging_amount_airtel']);
                $lodging_amount_airtel_week = set_comma($data['lodging_amount_airtel_week']);
                $lodging_amount_aircartel = set_comma($data['lodging_amount_aircartel']);
                $lodging_amount_aircartel_week = set_comma($data['lodging_amount_aircartel_week']);
                $lodging_amount_deposit = set_comma($data['lodging_amount_deposit']);
                $lodging_amount_deposit_week = set_comma($data['lodging_amount_deposit_week']);
                $lodging_amount_adult_add = set_comma($data['lodging_amount_adult_add']);
                $lodging_amount_child_add = set_comma($data['lodging_amount_child_add']);

            }
            ?>
            <tr>
                <td><input type="checkbox" id="sel" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['amt_no']?>"></td>
                <td><?=$data['lodging_room_name']?></td>
                <td><?=$data['lodging_room_min']?>/<?=$data['lodging_room_max']?></td>
                <?if($mode=="season"){?>
                <td><input type="checkbox"  name="lodging_season_open[]" value="Y" <?=$open_chk?>></td>
                <?}?>
                <td><input type="text" name="lodging_amount_basic[]" value="<?=$lodging_amount_basic?>" size="8"><br><input type="text" name="lodging_amount_basic_week[]" value="<?=$lodging_amount_basic_week?>" size="8"></td>
                <td><input type="text" name="lodging_amount_tel[]" value="<?=$lodging_amount_tel?>" size="8"><br><input type="text" name="lodging_amount_tel_week[]" value="<?=$lodging_amount_tel_week?>" size="8"></td>
                <td><input type="text" name="lodging_amount_airtel[]" value="<?=$lodging_amount_airtel?>" size="8"><br><input type="text" name="lodging_amount_airtel_week[]" value="<?=$lodging_amount_airtel_week?>" size="8"></td>
                <td><input type="text" name="lodging_amount_aircartel[]" value="<?=$lodging_amount_aircartel?>" size="8"><br><input type="text" name="lodging_amount_aircartel_week[]" value="<?=$lodging_amount_aircartel_week?>" size="8"></td>
                <td><input type="text" name="lodging_amount_deposit[]" value="<?=$lodging_amount_deposit?>" size="8"><br><input type="text" name="lodging_amount_deposit_week[]" value="<?=$lodging_amount_deposit_week?>" size="8"></td>
                <td><input type="text" name="lodging_amount_adult_add[]" value="<?=$lodging_amount_adult_add?>" size="8"><br><input type="text" name="lodging_amount_child_add[]" value="<?=$lodging_amount_child_add?>" size="8"></td>
                <td>
                    <?for($w=0;$w < 7;$w++) {
                        if($mode=="season"){
                            if(strpos($data['lodging_season_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
                        }else{
                            if(strpos($data['lodging_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
                        }
                        echo "<input type='checkbox' name='week[{$i}][]' {$chk} value='{$w}'> ";
                    }
                    ?>
                </td>
            </tr>
    <?php
            $i++;
        }
    }else{
    ?>
        <tr>
            <th colspan="8" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
        </tr>
    <?}?>
        <input type="hidden" id="case" name="case" value="">
        <input type="hidden" name="mode" value="<?=$mode?>">
    </form>
</table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table>
            <tr>
                <td>업체명</td>
                <td>
                    <select name="lodging_no">
                        <?php
                        foreach ($result_lod as $lodging){
                            echo "<option value='{$lodging['no']}'>{$lodging['lodging_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>기간명</td>
                <td><input type="text" id="lodging_season_name"></td>
            </tr>
            <tr>
                <td>기간일자</td>
                <td>시작일 : <input type="text" id="lodging_season_start_date" class="rent_date"> <br>
                    종료일 : <input type="text" id="lodging_season_end_date" class="rent_date"></td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="기간등록"></p>
    </div>
</div>
<form id="season_up_frm">
    <div class="layer_d_m">
        <div id="layer_d_m"></div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })
        $("#season_in_btn").click(function () {
            overlays_view("overlay","layer_d")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_d")
            $(".layer_d_m" ).hide();
        });

        $("#lodging_no").on("change",function () {
            $("#lodging_no option:selected").each(function () {
                window.location.href="?linkpage=tel&subpage=amount&lodging_no="+$(this).val();
            });
        });
        $("#amt_up_btn").click(function () {

            $("#case").val("season_all_up");
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#amt_up_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    window.location.reload();
                }
            });

        });

        $("form#season_up_frm").submit(function(event) {
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            if($("#rent_season_name_up").val()==""){
                alert("기간명를 입력해주세요");
                return false;
            }
            //disable the default form submission
            event.preventDefault();

            var fd = new FormData($(this)[0]);

            $.ajax({
                url: url,
                type: "POST",
                data: fd,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    /* alert(data); if json obj. alert(JSON.stringify(data));*/
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    window.location.reload();
                }
            });
        });


        $("#amt_del_btn").click(function () {
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $("#case").val("season_all_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#car_season_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        console.log(data); // show response from the php script.
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                        window.location.reload();
                    }
                });

            }

        });

        $("#add_btn").click(function () {

            if($("#rent_season_name").val()==""){
                alert("기간명를 입력해주세요");
                return false;
            }

            $.post("tel/lodging_process.php",
                {
                    lodging_no:$("select[name=lodging_no]").val(),
                    lodging_season_name:$("#lodging_season_name").val(),
                    lodging_season_start_date:$("#lodging_season_start_date").val(),
                    lodging_season_end_date:$("#lodging_season_end_date").val(),
                    case : "season_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("기간명를 등록하셨습니다.");
                    overlays_close("overlay","layer_d")
                    window.location.reload();

                });


        });
        $("#margin_btn").click(function () {


            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#margin_frm").serialize()+"&lodging_no="+$("select[name=lodging_no]").val(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    window.location.reload();
                }
            });

        });



    });
    $( function() {
        $(function() {
            var dates = $( "#lodging_season_start_date, #lodging_season_end_date " ).datepicker({
                prevText: '이전 달',
                nextText: '다음 달',
                monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                dayNames: ['일','월','화','수','목','금','토'],
                dayNamesShort: ['일','월','화','수','목','금','토'],
                dayNamesMin: ['일','월','화','수','목','금','토'],
                dateFormat: 'yy-mm-dd',
                showMonthAfterYear: true,
                yearSuffix: '년',
                numberOfMonths : 2,
                maxDate:'+1095d',
                onSelect: function( selectedDate ) {
                    var option = this.id == "lodging_season_start_date" ? "minDate" : "maxDate",
                        instance = $( this ).data( "datepicker" ),
                        date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                }
            });
        });
    });
</script>