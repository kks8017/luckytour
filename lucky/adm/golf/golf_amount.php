<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$golf_no = $_REQUEST['golf_no'];
$season_no  = $_REQUEST['season_no'];
$mode       = $_REQUEST['mode'];










$sql_golf = "select no,golf_name,golf_area  from golf_list order by binary(golf_name)";
$rs_golf  = $db->sql_query($sql_golf);
while($row_golf = $db->fetch_array($rs_golf)) {
    $result_golf[] = $row_golf;
}
if(!$golf_no){$golf_no=$result_golf[0]['no'];}

if($mode=="season") {
    $sql = "select golf_hole_amount_season.no as amt_no,
                golf_hole_list.no as hole_no,
                hole_name,
                hole_season_amount_open,
                golf_hole_amount_season.golf_no as go_no,
                hole_season_amount_basic,
                hole_season_amount,
                hole_season_amount_deposit,
                hole_season_amount_basic_week,
                hole_season_amount_week,
                hole_season_amount_deposit_week,
                hole_season_week 
             from golf_hole_list,golf_hole_amount_season where golf_hole_amount_season.hole_no=golf_hole_list.no and golf_hole_amount_season.golf_season_no='{$season_no}' and golf_hole_list.golf_no='{$golf_no}' ";

    $sql_margin = "select no,golf_no,golf_amount_margin_basic,golf_amount_margin_amount from golf_hole_amount_margin where golf_no='{$golf_no}' and season_no={$season_no} and golf_margin_mode='season'";

//echo  $sql;

}else{
    $sql = "select golf_hole_amount.no as amt_no,
                golf_hole_list.no as hole_no,
                hole_name,
                hole_amount,
                hole_amount_basic,
                hole_amount_deposit,
                hole_amount_week,
                hole_amount_basic_week,
                hole_amount_deposit_week,
                hole_week
             from golf_hole_list,golf_hole_amount where golf_hole_amount.hole_no=golf_hole_list.no and golf_hole_list.golf_no='{$golf_no}'";
    $sql_margin = "select no,golf_no,golf_amount_margin_basic,golf_amount_margin_amount from golf_hole_amount_margin where golf_no='{$golf_no}' and golf_margin_mode!='season' ";


}
//echo $sql;
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
$sql_season = "select no,golf_season_name,golf_season_start_date,golf_season_end_date from golf_season_list where golf_no='{$golf_no}'  order by no";
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

        var url = "golf/golf_season_up.php"; // the script where you handle the form input.

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
        var url = "golf/golf_process.php"; // the script where you handle the form input.

        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else{
            $.post("golf/golf_process.php",
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
<div style="margin-top: 20px;">
    <div id="tel_amount">
        <select name="golf_no" id="golf_no">
            <?php
            foreach ($result_golf as $golf){
                if($golf['no']== $golf_no){$sel="selected";}else{$sel="";}
                echo "<option value='{$golf['no']}' {$sel}>{$golf['golf_name']}</option>";
            }
            ?>
        </select>

        <div>전체마진적용</div>
        <form id="margin_frm">
            <table class="tbl">
                <tr>
                    <th>기본</th>
                    <th>판매</th>
                    <th>적용</th>
                </tr>
                <tr>
                    <td class="con"><input type="text" name="margin_basic" value="<?=$row_margin['golf_amount_margin_basic']?>"></td>
                    <td class="con"><input type="text" name="margin_amount" value="<?=$row_margin['golf_amount_margin_amount']?>"></td>
                    <td class="con"><input type="button" id="margin_btn" value="적용"><input type="hidden" name="no" value="<?=$row_margin['no']?>">
                        <input type="hidden" name="season_no" value="<?=$season_no?>">
                        <input type="hidden" name="golf_no" value="<?=$golf_no?>">
                        <input type="hidden" name="case" value="margin_insert"><input type="hidden" name="mode" value="<?=$mode?>"></td>
                </tr>
            </table>
        </form>
        <div>기간리스트</div>
        <div >
            <div class="season<?if(!$season_no){?> div_bule<?}?>"><a href="?linkpage=<?=$linkpage?>&subpage=amount&golf_no=<?=$golf_no?>">비수기</a></div>
            <?php
            if(is_array($result_season)) {
                foreach ($result_season as $season){
                    if($season['no']==$season_no){$class = "class='season div_bule'";}else{$class="class='season'";}
                    ?>
                    <div <?=$class?>><a href="?linkpage=<?=$linkpage?>&subpage=amount&golf_no=<?=$golf_no?>&mode=season&season_no=<?=$season['no']?>"><?=$season['golf_season_name']?></a><input type="button" id="season_up_btn" value="수정" onclick="season_up_pop(<?=$season['no']?>);"><input type="button" id="season_del_btn" value="삭제" onclick="season_del(<?=$season['no']?>);"><br>(<?=$season['golf_season_start_date']?>~<?=$season['golf_season_end_date']?>) </div>
                    <?
                }
            }else{
                echo "";
            }?>
        </div>
        <div style="clear: both;margin-bottom: 10px;"><input type="button" id="amt_up_btn" value="선택수정"> <input type="button" id="amt_del_btn" value="선택삭제"> <input type="button" id="season_in_btn" value="기간등록"></p></div>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>홀명</th>
                <?if($mode=="season"){?>
                    <td>공개여부</td>
                <?}?>
                <th>기본주중<br>기본주말</th>
                <th>판매주중<br>판매주말</th>
                <th>입금가주중<br>입금가주말</th>
                <th>주말적용<br>(일 월 화 수 목 금 토)</th>
            </tr>
            <form id="amt_up_frm">
                <?php
                $i=0;
                if(is_array($result_list)) {
                    foreach ($result_list as $data){
                        if($mode =="season"){
                            $golf_amount_basic = set_comma($data['hole_season_amount_basic']);
                            $golf_amount_basic_week = set_comma($data['hole_season_amount_basic_week']);
                            $golf_amount_amount = set_comma($data['hole_season_amount']);
                            $golf_amount_amount_week = set_comma($data['hole_season_amount_week']);
                            $golf_amount_deposit = set_comma($data['hole_season_amount_deposit']);
                            $golf_amount_deposit_week = set_comma($data['hole_season_amount_deposit_week']);
                            $open_chk ="";
                            if($data['golf_season_open']=="Y"){
                                $open_chk = "checked";
                            }
                            //     echo $open_chk;
                        }else {
                            $golf_amount_basic = set_comma($data['hole_amount_basic']);
                            $golf_amount_basic_week = set_comma($data['hole_amount_basic_week']);
                            $golf_amount_amount = set_comma($data['hole_amount']);
                            $golf_amount_amount_week = set_comma($data['hole_amount_week']);
                            $golf_amount_deposit = set_comma($data['hole_amount_deposit']);
                            $golf_amount_deposit_week = set_comma($data['hole_amount_deposit_week']);


                        }
                        ?>
                        <tr>
                            <td class="con"><input type="checkbox" id="sel" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['amt_no']?>"></td>
                            <td class="con"><?=$data['hole_name']?></td>
                            <?if($mode=="season"){?>
                                <td class="con"><input type="checkbox"  name="golf_season_open[]" value="Y" <?=$open_chk?>></td>
                            <?}?>
                            <td class="con"><input type="text" name="golf_amount_basic[]" value="<?=$golf_amount_basic?>" size="8"><br><input type="text" name="golf_amount_basic_week[]" value="<?=$golf_amount_basic_week?>" size="8"></td>
                            <td class="con"><input type="text" name="golf_amount_amount[]" value="<?=$golf_amount_amount?>" size="8"><br><input type="text" name="golf_amount_amount_week[]" value="<?=$golf_amount_amount_week?>" size="8"></td>
                            <td class="con"><input type="text" name="golf_amount_deposit[]" value="<?=$golf_amount_deposit?>" size="8"><br><input type="text" name="golf_amount_deposit_week[]" value="<?=$golf_amount_deposit_week?>" size="8"></td>

                            <td class="con">
                                <?for($w=0;$w < 7;$w++) {
                                    if($mode=="season"){
                                        if(strpos($data['hole_season_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
                                    }else{
                                        if(strpos($data['hole_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
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
<div id="layer_d_season">
    <div class="layer_d_season">
        <table class="tbl_com">
            <tr>
                <th>업체명</th>
                <td>
                    <select name="golf_no">
                        <?php
                        foreach ($result_golf as $golf){
                            echo "<option value='{$golf['no']}'>{$golf['golf_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>기간명</th>
                <td><input type="text" id="golf_season_name"></td>
            </tr>
            <tr>
                <th>기간일자</th>
                <td>시작일 : <input type="text" id="golf_season_start_date" class="rent_date"> <br>
                    종료일 : <input type="text" id="golf_season_end_date" class="rent_date"></td>
            </tr>
        </table>
        <p style="text-align: center;margin-top: 10px;"><input id="add_btn" type="button" value="기간등록"></p>
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
            overlays_view("overlay","layer_d_season")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_d_season")
            $(".layer_d_m" ).hide();
        });

        $("#golf_no").on("change",function () {
            $("#golf_no option:selected").each(function () {
                window.location.href="?linkpage=tel&subpage=amount&golf_no="+$(this).val();
            });
        });
        $("#amt_up_btn").click(function () {

            $("#case").val("season_all_up");
            var url = "golf/golf_process.php"; // the script where you handle the form input.
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
            var url = "golf/golf_process.php"; // the script where you handle the form input.
            if($("#golf_season_name_up").val()==""){
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

            if($("#golf_season_name").val()==""){
                alert("기간명를 입력해주세요");
                return false;
            }

            $.post("golf/golf_process.php",
                {
                    golf_no:$("select[name=golf_no]").val(),
                    golf_season_name:$("#golf_season_name").val(),
                    golf_season_start_date:$("#golf_season_start_date").val(),
                    golf_season_end_date:$("#golf_season_end_date").val(),
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


            var url = "golf/golf_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#margin_frm").serialize()+"&golf_no="+$("select[name=golf_no]").val(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                   // window.location.reload();
                }
            });

        });



    });
    $( function() {
        $( ".rent_date" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
    });
</script>