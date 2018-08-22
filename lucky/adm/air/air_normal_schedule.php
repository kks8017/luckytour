<?php
$sql = "select * from air_normal_schedule  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$sql_airline = "select air_name from air_company  where air_type='N' order by no asc";
$rs_airline  = $db->sql_query($sql_airline);
while($row_airline = $db->fetch_array($rs_airline)) {
    $result_airline[] = $row_airline['air_name'];
}
$tour_air_area = explode(",",$row_config['tour_air_area']);
?>
<div>
    <div>
        <p class="del_btn"></p>
        <table class="tbl">
            <tr>
                <th>출발지<br>리턴도착지</th>
                <th>출발항공사<br>리턴항공사</th>
                <th>출발시간<br>리턴시간</th>
                <th>성인정요금<br>소아정요금</th>
                <th>성인할인율<br>소아할인율</th>
                <th>성인할인요금<br>소아할인요금</th>
                <th>특이사항</th>
                <th>추가</th>
            </tr>
            <tr>
                <td class="con"><select name="sch_departure_area">
                        <?php
                           foreach ($tour_air_area as $area){
                               $area_name = explode("|",$area);
                              echo "<option value='{$area_name[0]}'>{$area_name[0]}</option>";
                           }
                        ?>
                    </select><br>
                    <select name="sch_arrival_area">
                        <?php
                        foreach ($tour_air_area as $area){
                            $area_name = explode("|",$area);
                            echo "<option value='{$area_name[0]}'>{$area_name[0]}</option>";
                        }
                        ?>
                    </select></td>
                <td class="con"><select name="sch_departure_airline">
                        <?php
                        foreach ($result_airline as $airline){

                            echo "<option value='{$airline}'>{$airline}</option>";
                        }
                        ?>
                    </select><br>
                    <select name="sch_arrival_airline">
                        <?php
                        foreach ($result_airline as $airline){

                            echo "<option value='{$airline}'>{$airline}</option>";
                        }
                        ?>
                    </select></td>
                <td class="con"><input type="text" id="hour" size="4">:<input type="text" id="minute" size="4"> <br><input type="text" id="r_hour" size="4">:<input type="text" id="r_minute" size="4"></td>
                <td class="con"><input type="text" id="sch_adult_normal_price"><br><input type="text" id="sch_child_normal_price"></td>
                <td class="con"><input type="text" id="sch_adult_sale" size="4"><br><input type="text" id="sch_child_sale" size="4"></td>
                <td class="con"><input type="text" id="sch_adult_sale_price"><br><input type="text" id="sch_child_sale_price"></td>
                <td class="con"><input type="text" id="sch_bigo"></td>
                <td class="con"><input type="button" id="add_btn" value="추가"></td>
            </tr>
        </table>
        <p class="del_btn"> <img src="./image/sel_mod.gif"  id="mod_btn" style="cursor: pointer;" /> <img src="./image/sel_del.gif"  id="del_btn" style="cursor: pointer;" /></p>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>출발지<br>리턴도착지</th>
                <th>출발항공사<br>리턴항공사</th>
                <th>출발시간<br>리턴시간</th>
                <th>성인정요금<br>소아정요금</th>
                <th>성인할인율<br>소아할인율</th>
                <th>성인할인요금<br>소아할인요금</th>
                <th>특이사항</th>
            </tr>
            <form id="sch_frm">
            <?php
            $i=0;

            foreach ($result_list as $data){
                $sch_departure_time = explode(":",$data['sch_departure_time']);
                $sch_arrival_time   = explode(":",$data['sch_arrival_time']);
            ?>
            <tr>
                <td class="con"><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                <td class="con"></td>
                <td class="con"><select name="sch_departure_area_<?=$i?>">
                        <?php
                        foreach ($tour_air_area as $area){
                            $area_name = explode("|",$area);
                            if($area_name==$data['sch_departure_area']){$sel="selected";}else{$sel="";}
                            echo "<option value='{$area_name[0]}' $sel>{$area_name[0]}</option>";
                        }
                        ?>
                    </select><br><select name="sch_arrival_area_<?=$i?>">
                        <?php
                        foreach ($tour_air_area as $area){
                            $area_name = explode("|",$area);
                            if($area_name==$data['sch_arrival_area']){$sel="selected";}else{$sel="";}
                            echo "<option value='{$area_name[0]}' $sel>{$area_name[0]}</option>";
                        }
                        ?>
                    </select></td>
                <td class="con"><select name="sch_departure_airline_<?=$i?>">
                        <?php
                        foreach ($result_airline as $airline){
                            if($airline==$data['sch_departure_airline']){$sel="selected";}else{$sel="";}
                            echo "<option value='{$airline}' $sel>{$airline}</option>";
                        }
                        ?>
                    </select><br>
                    <select name="sch_arrival_airline_<?=$i?>">
                        <?php
                        foreach ($result_airline as $airline){
                            if($airline==$data['sch_arrival_airline']){$sel="selected";}else{$sel="";}
                            echo "<option value='{$airline}' $sel>{$airline}</option>";
                        }
                        ?>
                    </select></td>
                <td class="con"><input type="text" name="hour[]" size="4" value="<?=$sch_departure_time[0]?>">:<input type="text" name="minute[]" size="4" value="<?=$sch_departure_time[1]?>"> <br>
                    <input type="text" name="r_hour[]" size="4" value="<?=$sch_arrival_time[0]?>">:<input type="text" name="r_minute[]" size="4" value="<?=$sch_arrival_time[1]?>"></td>
                <td class="con"><input type="text" name="sch_adult_normal_price[]" value="<?=$data['sch_adult_normal_price']?>" class="NumbersOnly"><br><input type="text" name="sch_child_normal_price[]" value="<?=$data['sch_child_normal_price']?>" class="NumbersOnly"></td>
                <td class="con"><input type="text" name="sch_adult_sale[]" size="4" value="<?=$data['sch_adult_sale']?>"><br><input type="text" name="sch_child_sale[]" size="4" value="<?=$data['sch_child_sale']?>"></td>
                <td class="con"><input type="text" name="sch_adult_sale_price[]" value="<?=$data['sch_adult_sale_price']?>" class="NumbersOnly"><br><input type="text" name="sch_child_sale_price[]" value="<?=$data['sch_child_sale_price']?>" class="NumbersOnly"></td>
                <td class="con"><input type="text" name="sch_bigo[]" value="<?=$data['sch_bigo']?>"></td>
            </tr>
           <?php
                $i++;
            }
            ?>
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

            $("#case").val("no_up");
            var url = "air/air_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#sch_frm").serialize(), // serializes the form's elements.
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
        $("#del_btn").click(function () {
            var url = "air/air_process.php"; // the script where you handle the form input.
            $("#case").val("no_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#sch_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                         console.log(data); // show response from the php script.
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                       // window.location.reload();
                    }
                });

            }

        });
        $("#add_btn").click(function () {
            wrapWindowByMask();

            $.post("air/air_process.php",
                {
                    sch_departure_area:$("select[name=sch_departure_area]").val(),
                    sch_arrival_area:$("select[name=sch_arrival_area]").val(),
                    sch_departure_airline:$("select[name=sch_departure_airline]").val(),
                    sch_arrival_airline:$("select[name=sch_arrival_airline]").val(),
                    hour:$("#hour").val(),
                    minute:$("#minute").val(),
                    r_hour:$("#r_hour").val(),
                    r_minute:$("#r_minute").val(),
                    sch_adult_normal_price:$("#sch_adult_normal_price").val(),
                    sch_child_normal_price:$("#sch_child_normal_price").val(),
                    sch_adult_sale:$("#sch_adult_sale").val(),
                    sch_child_sale:$("#sch_child_sale").val(),
                    sch_adult_sale_price:$("#sch_adult_sale_price").val(),
                    sch_child_sale_price:$("#sch_child_sale_price").val(),
                    sch_bigo:$("#sch_bigo").val(),
                    case : "no_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("거래처를 등록하셨습니다.");
                    closeWindowByMask();
                   // overlays_close("overlay","layer_d")
                    //window.location.reload();

                });
         });
        $('.NumbersOnly').keyup(function () {
            if( $(this).val() != null && $(this).val() != '' ) {
                var tmps = parseInt($(this).val().replace(/[^0-9]/g, '')) || 0;
                var tmps2 = tmps.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).val(tmps2);
            }
        });

    });
</script>