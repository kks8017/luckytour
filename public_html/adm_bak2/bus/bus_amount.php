<?php

$sql = "select 
              bus_taxi_amount.no as amt_no,
              bus_name,
              bus_taxi_no,
              bus_taxi_amount_1,
              bus_taxi_amount_2,
              bus_taxi_amount_3,
              bus_taxi_amount_4,
              bus_taxi_amount_5,
              bus_taxi_amount_6,
              bus_taxi_amount_7,
              bus_taxi_amount_8,
              bus_taxi_amount_9,
              bus_taxi_amount_10,
              bus_taxi_amount_deposit 
        from bus_taxi_car, bus_taxi_amount where bus_taxi_amount.bus_taxi_no = bus_taxi_car.no   order by bus_sort_no asc";
//echo $sql;
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>
<div class="bus_amount">
    <div>
        <input type="button" id="mod_btn" value="선택수정">
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"></td>
                <td>차량명</td>
                <td>1일요금</td>
                <td>2일요금</td>
                <td>3일요금</td>
                <td>4일요금</td>
                <td>5일요금</td>
                <td>6일요금</td>
                <td>7일요금</td>
                <td>8일요금</td>
                <td>9일요금</td>
                <td>10일요금</td>
                <td>입금가</td>
            </tr>
            <form id="bus_amt_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
                $bus_taxi_amount_1 = set_comma($data['bus_taxi_amount_1']);
                $bus_taxi_amount_2 = set_comma($data['bus_taxi_amount_2']);
                $bus_taxi_amount_3 = set_comma($data['bus_taxi_amount_3']);
                $bus_taxi_amount_4 = set_comma($data['bus_taxi_amount_4']);
                $bus_taxi_amount_5 = set_comma($data['bus_taxi_amount_5']);
                $bus_taxi_amount_6 = set_comma($data['bus_taxi_amount_6']);
                $bus_taxi_amount_7 = set_comma($data['bus_taxi_amount_7']);
                $bus_taxi_amount_8 = set_comma($data['bus_taxi_amount_8']);
                $bus_taxi_amount_9 = set_comma($data['bus_taxi_amount_9']);
                $bus_taxi_amount_10 = set_comma($data['bus_taxi_amount_10']);
                $bus_taxi_amount_deposit = set_comma($data['bus_taxi_amount_deposit']);
            ?>
            <tr>
                <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['amt_no']?>"</td>
                <td><?=$data['bus_name']?></td>
                <td><input type="text" name="bus_taxi_amount_1[]" size="7" value="<?=$bus_taxi_amount_1?>">원</td>
                <td><input type="text" name="bus_taxi_amount_2[]" size="7" value="<?=$bus_taxi_amount_2?>">원</td>
                <td><input type="text" name="bus_taxi_amount_3[]" size="7" value="<?=$bus_taxi_amount_3?>">원</td>
                <td><input type="text" name="bus_taxi_amount_4[]" size="7" value="<?=$bus_taxi_amount_4?>">원</td>
                <td><input type="text" name="bus_taxi_amount_5[]" size="7" value="<?=$bus_taxi_amount_5?>">원</td>
                <td><input type="text" name="bus_taxi_amount_6[]" size="7" value="<?=$bus_taxi_amount_6?>">원</td>
                <td><input type="text" name="bus_taxi_amount_7[]" size="7" value="<?=$bus_taxi_amount_7?>">원</td>
                <td><input type="text" name="bus_taxi_amount_8[]" size="7" value="<?=$bus_taxi_amount_8?>">원</td>
                <td><input type="text" name="bus_taxi_amount_9[]" size="7" value="<?=$bus_taxi_amount_9?>">원</td>
                <td><input type="text" name="bus_taxi_amount_10[]" size="7" value="<?=$bus_taxi_amount_10?>">원</td>
                <td><input type="text" name="bus_taxi_amount_deposit[]" size="7" value="<?=$bus_taxi_amount_deposit?>">원</td>
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
</div>
<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })

        $("#mod_btn").click(function () {

            $("#case").val("all_amount");
            var url = "bus/bus_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bus_amt_frm").serialize(), // serializes the form's elements.
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