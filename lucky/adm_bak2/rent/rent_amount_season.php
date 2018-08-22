<?php
$com_no = $_GET['rent_company'];
$sea_no = $_GET['season_no'];
$rent = new rent();

if($com_no==""){
    $main_com_no = get_rentcar_company("","대표");
    $com_sql = "and rent_com_no='{$main_com_no[0]}'";
    $com_no = $main_com_no[0];

}else{
    $main_com_no = get_rentcar_company($com_no,"협력");
    $com_sql = "and rent_com_no='{$com_no}'";
}
if(!$sea_no){$sea_no=get_rentcar_season_no($com_no);}else{$sea_no=$sea_no;}

$sql = "select rent_season_list.no as list_no,
                rent_season_amount.no as amt_no, 
                rent_com_no,
                rent_car_no,
                rent_season_name,
                rent_season_start_date,
                rent_season_end_date,
                rent_season_amount_6hour,
                rent_season_amount_12hour,
                rent_season_amount_24hour,
                rent_season_sale_car,
                rent_season_sale_aircar,
                rent_season_sale_aircartel,
                rent_season_sale_car_week,
                rent_season_sale_aircar_week,
                rent_season_sale_aircartel_week,
                rent_season_sale_deposit,
                rent_season_sale_deposit_week,
                rent_season_sale_additional, 
                rent_season_week
         from rent_season_amount,rent_season_list where rent_season_list.no=rent_season_amount.rent_season_no and  rent_season_no='{$sea_no}' $com_sql   order by rent_season_amount.no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$sql_season = "select no,rent_season_name,rent_season_start_date,rent_season_end_date from rent_season_list where rent_com_no='{$com_no}'  order by no";
//echo $sql_season;
$rs_season  = $db->sql_query($sql_season);
if(!$rs_season) {
    echo "";
}else{
    while ($row_season = $db->fetch_array($rs_season)) {
        $result_season[] = $row_season;
    }
}

$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}

?>
<script>
    function season_up_pop(no) {

        var url = "rent/rent_season_up.php"; // the script where you handle the form input.

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
    function season_del(no) {

      var url = "rent/rent_process.php"; // the script where you handle the form input.
        if(confirm("정말삭제 하시겠습니다?") == false) {
            return false;
        }else {
            $.ajax({
                type: "POST",
                url: url,
                data: "no=" + no + "&case=season_del", // serializes the form's elements.
                success: function (data) {
                    console.log(data);

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
    }

</script>
<div class="rent_season">
    <select name="rent_company" id="rent_company">

        <?php

        foreach ($result_com as $com) { ?>
            <option value="<?= $com['no'] ?>" <?
            if ($com_no == $com['no']){
            ?>selected<?
            } ?>><?= $com['rent_com_name'] ?></option>
            <?
        }

        ?>
    </select>
    <div class="season">

        <?php
        if(is_array($result_season)) {
            foreach ($result_season as $season){?>
                <div><a href="?linkpage=rent&subpage=season&rent_company=<?=$com_no?>&season_no=<?=$season['no']?>"><?=$season['rent_season_name']?>(<?=$season['rent_season_start_date']?>~<?=$season['rent_season_end_date']?>)</a> <input type="button" id="season_up_btn" value="수정" onclick="season_up_pop(<?=$season['no']?>);"><input type="button" id="season_del_btn" value="삭제" onclick="season_del(<?=$season['no']?>);"></div>
                <?
            }
        }else{
            echo "<div>등록된 기간이없습니다.</div>";
        }?>

    </div>
    <table>
        <tr>
            <td colspan="13"> <input type="button" id="amt_up_btn" value="선택수정"> <input type="button" id="amt_del_btn" value="선택삭제"> <input type="button" id="season_in_btn" value="기간등록"></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="allsel"></td>
            <td>차량명(연료)</td>
            <td>차종</td>
            <td>기간명<br>시작일<br>종료일</td>
            <td>6시간요금</td>
            <td>12시간요금</td>
            <td>24시간요금</td>
            <td>단품주중<br>단품주말</td>
            <td>카텔/에어텔주중<br>카텔/에어텔주말</td>
            <td>에어카텔주중<br>에어카텔주말</td>
            <td>입금주중<br>입금주말</td>
            <td>추가요금</td>
            <td>주말설정<br>(일월화수목금토)</td>
        </tr>
        <form id="car_season_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
                    $car = get_rentcar_name($data['rent_car_no']);
                    $rent_fuel_name = $rent->rent_code_name($car[1]);
                    $rent_type_name = $rent->rent_code_name($car[2]);
                    $rent_amount_6hour    = set_comma($data['rent_season_amount_6hour']);
                    $rent_amount_12hour   = set_comma($data['rent_season_amount_12hour']);
                    $rent_amount_24hour   = set_comma($data['rent_season_amount_24hour']);
                    $rent_sale_additional = set_comma($data['rent_season_sale_additional']);
                    //echo $data['rent_sale_week'];
                    ?>
                    <tr>
                        <td><input type="checkbox" id="sel" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['amt_no']?>"</td>
                        <td><?=$car[0]?>(<?=$rent_fuel_name?>)</td>
                        <td><?=$rent_type_name?></td>
                        <td><?=$data['rent_season_name']?><br><?=$data['rent_season_start_date']?><br><?=$data['rent_season_end_date']?></td>
                        <td><input type="text" name="rent_season_amount_6hour[]" size="8" value="<?=$rent_amount_6hour?>">원</td>
                        <td><input type="text" name="rent_season_amount_12hour[]" size="8" value="<?=$rent_amount_12hour?>">원</td>
                        <td><input type="text" name="rent_season_amount_24hour[]" size="8" value="<?=$rent_amount_24hour?>">원</td>
                        <td><input type="text" name="rent_season_sale_car[]" size="3" value="<?=$data['rent_season_sale_car']?>">%<br><input type="text" name="rent_season_sale_car_week[]" size="3" value="<?=$data['rent_season_sale_car_week']?>">%</td>
                        <td><input type="text" name="rent_season_sale_aircar[]" size="3" value="<?=$data['rent_season_sale_aircar']?>">%<br><input type="text" name="rent_season_sale_aircar_week[]" size="3" value="<?=$data['rent_season_sale_aircar_week']?>">%</td>
                        <td><input type="text" name="rent_season_sale_aircartel[]" size="3" value="<?=$data['rent_season_sale_aircartel']?>">%<br><input type="text" name="rent_season_sale_aircartel_week[]" size="3" value="<?=$data['rent_season_sale_aircartel_week']?>">%</td>
                        <td><input type="text" name="rent_season_sale_deposit[]" size="3" value="<?=$data['rent_season_sale_deposit']?>">%<br><input type="text" name="rent_season_sale_deposit_week[]" size="3" value="<?=$data['rent_season_sale_deposit_week']?>">%</td>
                        <td><input type="text" name="rent_season_sale_additional[]" size="8" value="<?=$rent_sale_additional?>">원</td>
                        <td>
                            <?php
                            for($w=0;$w <= 6;$w++){
                                // echo $data['rent_sale_week']."==".$w;
                                if(strpos($data['rent_season_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
                                echo "<input type='checkbox' name='rent_season_sale_week[$i][]' value='{$w}' {$chk}> ";
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
                    <th colspan="13" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
            <input type="hidden" name="case" id="case" value="">
        </form>
    </table>


</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table>
            <tr>
                <td>업체명</td>
                <td>
                    <select name="rent_company" id="rent_company">
                        <?php
                        foreach ($result_com as $com){  ?>
                            <option value="<?=$com['no']?>" <?if($com_no == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>기간명</td>
                <td><input type="text" id="rent_season_name"></td>
            </tr>
            <tr>
                <td>기간일자</td>
                <td>시작일 : <input type="text" name="rent_season_start_date" id="rent_season_start_date" class="rent_sdate"> <br>
                    종료일 : <input type="text" name="rent_season_end_date" id="rent_season_end_date" class="rent_edate"></td>
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
        $("#rent_company").on('change',function () {
            window.location.href ="?linkpage=rent&subpage=season&rent_company="+$("select[name=rent_company]").val();
        });
        $("#amt_up_btn").click(function () {

            $("#case").val("season_all_up");
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#car_season_frm").serialize(), // serializes the form's elements.
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
            var url = "rent/rent_process.php"; // the script where you handle the form input.
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

            $.post("rent/rent_process.php",
                {
                    rent_com_no:"<?=$com_no?>",
                    rent_season_name:$("#rent_season_name").val(),
                    rent_season_start_date:$("#rent_season_start_date").val(),
                    rent_season_end_date:$("#rent_season_end_date").val(),
                    case : "season_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("기간명를 등록하셨습니다.");
                    overlays_close("overlay","layer_d")
                    window.location.reload();

                });


        });



    });
    $(function() {
        var dates = $( "#rent_season_start_date, #rent_season_end_date " ).datepicker({
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
                var option = this.id == "rent_season_start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>