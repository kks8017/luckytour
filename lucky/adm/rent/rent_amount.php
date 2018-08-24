<?php
$com_no = $_GET['rent_company'];
$rent_car_type2 = $_GET['rent_car_type'];

$rent = new rent();
if($com_no==""){
    $main_com_no = get_rentcar_company("","대표");
    $com_sql = "and rent_amount.rent_com_no='{$main_com_no[0]}'";

}else{
    $main_com_no = get_rentcar_company($com_no,"협력");
    $com_sql = "and rent_amount.rent_com_no='{$com_no}'";

}
if($main_com_no[1]=="협력"){
    $company_sql = "and rent_amount.rent_car_no=rent_car_detail.rent_car_no";
}else{
    $company_sql = "and rent_amount.rent_car_no=rent_car_detail.no";
}
if($rent_car_type2!=""){
    $type_sql = "and rent_car_detail.rent_car_type='{$rent_car_type2}'";
}
$sql = "select rent_amount.no,
                rent_amount.rent_com_no,
                rent_amount.rent_car_no,
                rent_car_type,
                rent_amount_6hour,
                rent_amount_12hour,
                rent_amount_24hour,
                rent_sale_car,
                rent_sale_aircar,
                rent_sale_aircartel,
                rent_sale_car_week,
                rent_sale_aircar_week,
                rent_sale_aircartel_week,
                rent_sale_deposit,
                rent_sale_deposit_week,
                rent_sale_additional,
                rent_sale_week
         from rent_amount,rent_car_detail where rent_amount.rent_com_no=rent_car_detail.rent_com_no {$company_sql} {$com_sql} {$type_sql} group by rent_amount.rent_car_no   order by rent_amount.no asc";

$rs  = $db->sql_query($sql);
if(!$rs){
    echo "";
}else {
    while ($row = $db->fetch_array($rs)) {
        $result_list[] = $row;
    }
}

$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}
$rent_list_type = $rent->rent_code('T');
?>

<p style="margin-top: 20px;">
<table class="tbl">
    <tr>
        <th>차량타입</th>
        <th>단품</th>
        <th>카텔/에어카텔</th>
        <th>에어카텔</th>
        <th>입금</th>
        <th>수정</th>
    </tr>
    <form id="rent_all_frm">
        <tr>
            <td class="con">
                <select name="rent_car_type">
                    <option value="">전체</option>
                    <?
                    foreach ($rent_list_type as $rent_type){
                        echo "<option value='{$rent_type['no']}'>{$rent_type['rent_config_name']}</option>";
                    }
                    ?>
                </select>
            </td>
            <td class="con"><input type="text" name="rent_sale_car" size="3" value="<?=$data['rent_sale_car']?>">%<br><input type="text" name="rent_sale_car_week" size="3" value="<?=$data['rent_sale_car_week']?>">%</td>
            <td class="con"><input type="text" name="rent_sale_aircar" size="3" value="<?=$data['rent_sale_aircar']?>">%<br><input type="text" name="rent_sale_aircar_week" size="3" value="<?=$data['rent_sale_aircar_week']?>">%</td>
            <td class="con"><input type="text" name="rent_sale_aircartel" size="3" value="<?=$data['rent_sale_aircartel']?>">%<br><input type="text" name="rent_sale_aircartel_week" size="3" value="<?=$data['rent_sale_aircartel_week']?>">%</td>
            <td class="con"><input type="text" name="rent_sale_deposit" size="3" value="<?=$data['rent_sale_deposit']?>">%<br><input type="text" name="rent_sale_deposit_week" size="3" value="<?=$data['rent_sale_deposit_week']?>">%</td>
            <td class="con"><input type="button" id="rent_all_btn" value="변경"></td>
        </tr>
    </form>
</table>
<p style="margin-top:10px;margin-bottom: 10px;"><img src="./image/sel_mod.gif"  id="up_amt_btn" style="cursor: pointer;" />
    <select name="rent_company" id="rent_company">

        <?php
        foreach ($result_com as $com){  ?>
            <option value="<?=$com['no']?>" <?if($com_no == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
        <?}?>
    </select>
    <select name="rent_car_type" id="rent_car_type">
        <option value="">전체</option>
        <?
        foreach ($rent_list_type as $rent_type){
            ?>
            <option value='<?=$rent_type['no']?>' <?if($rent_car_type2 == $rent_type['no']){?>selected<?}?>><?=$rent_type['rent_config_name']?></option>
            <?
        }
        ?>
    </select>
</p>

<table class="tbl">
    <tr>
        <th><input type="checkbox" id="allsel"></th>
        <th>차량명(연료)</th>
        <th>차종</th>
        <th>6시간요금</th>
        <th>12시간요금</th>
        <th>24시간요금</th>
        <th>단품주중<br>단품주말</th>
        <th>카텔/에어텔주중<br>카텔/에어텔주말</th>
        <th>에어카텔주중<br>에어카텔주말</th>
        <th>입금주중<br>입금주말</th>
        <th>추가요금</th>
        <th>주말설정<br>(일월화수목금토)</th>
    </tr>
    <form id="car_amt_frm">
        <?php
        $i=0;
        if(is_array($result_list)) {
            foreach ($result_list as $data){
                $car = get_rentcar_name($data['rent_car_no']);
                $rent_fuel_name = $rent->rent_code_name($car[1]);
                $rent_type_name = $rent->rent_code_name($car[2]);
                $rent_amount_6hour    = set_comma($data['rent_amount_6hour']);
                $rent_amount_12hour   = set_comma($data['rent_amount_12hour']);
                $rent_amount_24hour   = set_comma($data['rent_amount_24hour']);
                $rent_sale_additional = set_comma($data['rent_sale_additional']);
                //echo $data['rent_sale_week'];
                ?>
                <tr>
                    <td class="con"><input type="checkbox" id="sel" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"</td>
                    <td class="con"><?=$car[0]?>(<?=$rent_fuel_name?>)</td>
                    <td class="con"><?=$rent_type_name?></td>
                    <td class="con"><input type="text" name="rent_amount_6hour[]" size="7" value="<?=$rent_amount_6hour?>">원</td>
                    <td class="con"><input type="text" name="rent_amount_12hour[]" size="7" value="<?=$rent_amount_12hour?>">원</td>
                    <td class="con"><input type="text" name="rent_amount_24hour[]" size="7" value="<?=$rent_amount_24hour?>">원</td>
                    <td class="con"><input type="text" name="rent_sale_car[]" size="3" value="<?=$data['rent_sale_car']?>">%<br><input type="text" name="rent_sale_car_week[]" size="3" value="<?=$data['rent_sale_car_week']?>">%</td>
                    <td class="con"><input type="text" name="rent_sale_aircar[]" size="3" value="<?=$data['rent_sale_aircar']?>">%<br><input type="text" name="rent_sale_aircar_week[]" size="3" value="<?=$data['rent_sale_aircar_week']?>">%</td>
                    <td class="con"><input type="text" name="rent_sale_aircartel[]" size="3" value="<?=$data['rent_sale_aircartel']?>">%<br><input type="text" name="rent_sale_aircartel_week[]" size="3" value="<?=$data['rent_sale_aircartel_week']?>">%</td>
                    <td class="con"><input type="text" name="rent_sale_deposit[]" size="3" value="<?=$data['rent_sale_deposit']?>">%<br><input type="text" name="rent_sale_deposit_week[]" size="3" value="<?=$data['rent_sale_deposit_week']?>">%</td>
                    <td class="con"><input type="text" name="rent_sale_additional[]" size="8" value="<?=$rent_sale_additional?>">원</td>
                    <td class="con">
                        <?php
                        for($w=0;$w <= 6;$w++){
                            // echo $data['rent_sale_week']."==".$w;
                            if(strpos($data['rent_sale_week'],"{$w}")!== false){$chk="checked";}else{$chk="";}
                            echo "<input type='checkbox' name='rent_sale_week[$i][]' value='{$w}' {$chk}> ";
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
                <td colspan="12" align="center"><p>등록된 정보가 없습니다.</p></td>
            </tr>
        <?}?>
        <input type="hidden" name="case" id="case" value="">
    </form>
</table>


</div>
<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        });

        $("#rent_company").on('change',function () {
            window.location.href ="?linkpage=rent&subpage=amount&rent_company="+$("select[name=rent_company]").val()+"&rent_car_type="+$("select[name=rent_car_type]").val();
        });
        $("#rent_car_type").on('change',function () {
            window.location.href ="?linkpage=rent&subpage=amount&rent_company="+$("select[name=rent_company]").val()+"&rent_car_type="+$("#rent_car_type").val();
        });
        $("#up_amt_btn").click(function () {

            $("#case").val("car_amt_up");
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#car_amt_frm").serialize(), // serializes the form's elements.
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
        $("#rent_all_btn").click(function () {

            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#rent_all_frm").serialize()+"&rent_com_no="+$('select[name=rent_company]').val()+"&case=car_all_sale", // serializes the form's elements.
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
</script>