<?php
$com_no = $_GET['rent_company'];
$rent = new rent();
if($com_no==""){
    $main_com_no = get_rentcar_company("","대표");
    $com_sql = "where rent_com_no='{$main_com_no[0]}'";
}else{
    $main_com_no = get_rentcar_company($com_no,"협력");
    $com_sql = "where rent_com_no='{$com_no}'";
}

$sql = "select no,
                rent_com_no,
                rent_car_no,
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
         from rent_amount  $com_sql   order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}

?>

<div class="rent_amount">
    <select name="rent_company" id="rent_company">

        <?php
        foreach ($result_com as $com){  ?>
            <option value="<?=$com['no']?>" <?if($com_no == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
        <?}?>
    </select><br>
    <input type="button" id="up_amt_btn" value="선택수정">
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"></td>
                <td>차량명(연료)</td>
                <td>차종</td>
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
                <td><input type="checkbox" id="sel" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"</td>
                <td><?=$car[0]?>(<?=$rent_fuel_name?>)</td>
                <td><?=$rent_type_name?></td>
                <td><input type="text" name="rent_amount_6hour[]" size="8" value="<?=$rent_amount_6hour?>">원</td>
                <td><input type="text" name="rent_amount_12hour[]" size="8" value="<?=$rent_amount_12hour?>">원</td>
                <td><input type="text" name="rent_amount_24hour[]" size="8" value="<?=$rent_amount_24hour?>">원</td>
                <td><input type="text" name="rent_sale_car[]" size="3" value="<?=$data['rent_sale_car']?>">%<br><input type="text" name="rent_sale_car_week[]" size="3" value="<?=$data['rent_sale_car_week']?>">%</td>
                <td><input type="text" name="rent_sale_aircar[]" size="3" value="<?=$data['rent_sale_aircar']?>">%<br><input type="text" name="rent_sale_aircar_week[]" size="3" value="<?=$data['rent_sale_aircar_week']?>">%</td>
                <td><input type="text" name="rent_sale_aircartel[]" size="3" value="<?=$data['rent_sale_aircartel']?>">%<br><input type="text" name="rent_sale_aircartel_week[]" size="3" value="<?=$data['rent_sale_aircartel_week']?>">%</td>
                <td><input type="text" name="rent_sale_deposit[]" size="3" value="<?=$data['rent_sale_deposit']?>">%<br><input type="text" name="rent_sale_deposit_week[]" size="3" value="<?=$data['rent_sale_deposit_week']?>">%</td>
                <td><input type="text" name="rent_sale_additional[]" size="8" value="<?=$rent_sale_additional?>">원</td>
                <td>
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
                    <th colspan="8" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
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
            window.location.href ="?linkpage=rent&subpage=amount&rent_company="+$("select[name=rent_company]").val();
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




    });
</script>