<?php
$sql = "select no,a_oil_name,a_oil_start_date,a_oil_end_date,a_oil_oil_price,a_oil_com_price from air_oil_comm  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>

<div>
    <div>
        <p class="del_btn"></p>
        <table class="tbl">
            <tr>
                <th>할증료명</th>
                <th>시작일</th>
                <th>종료일</th>
                <th>유류할증료</th>
                <th>수수료</th>
                <th></th>
            </tr>
            <tr>
                <td><input type="text" id="a_oil_name"></td>
                <td><input type="text" id="a_oil_start_date" class="air_date"></td>
                <td><input type="text" id="a_oil_end_date"   class="air_date"></td>
                <td><input type="text" id="a_oil_oil_price"  class="NumbersOnly"></td>
                <td><input type="text" id="a_oil_com_price"  class="NumbersOnly"></td>
                <td><input type="button" id="add_btn" value="추가"></td>
            </tr>

        </table>
        <p class="del_btn"> <img src="./image/sel_mod.gif"  id="mod_btn" style="cursor: pointer;" /> <img src="./image/sel_del.gif"  id="del_btn" style="cursor: pointer;" /></p>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel" value=""></th>
                <th>순서</th>
                <th>할증료명</th>
                <th>시작일</th>
                <th>종료일</th>
                <th>유류할증료</th>
                <th>수수료</th>
            </tr>
            <form id="oil_frm">
            <?php
            $i=0;

            foreach ($result_list as $data){
            ?>
            <tr>
                <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                <td><?=$i+1?></td>
                <td><input type="text" name="a_oil_name[]" value="<?=$data['a_oil_name']?>"></td>
                <td><input type="text" name="a_oil_start_date[]" class="air_date" value="<?=$data['a_oil_start_date']?>"></td>
                <td><input type="text" name="a_oil_end_date[]" class="air_date" value="<?=$data['a_oil_end_date']?>"></td>
                <td><input type="text" name="a_oil_oil_price[]" class="NumbersOnly" value="<?=number_format($data['a_oil_oil_price'])?>"></td>
                <td><input type="text" name="a_oil_com_price[]" class="NumbersOnly" value="<?=number_format($data['a_oil_com_price'])?>"></td>
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

            $("#case").val("oil_up");
            var url = "air/air_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#oil_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    //console.log(data); // show response from the php script.
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
            $("#case").val("oil_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#oil_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        //console.log(data); // show response from the php script.
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
            wrapWindowByMask();

            $.post("air/air_process.php",
                {
                    a_oil_name:$("#a_oil_name").val(),
                    a_oil_start_date:$("#a_oil_start_date").val(),
                    a_oil_end_date:$("#a_oil_end_date").val(),
                    a_oil_oil_price:$("#a_oil_oil_price").val(),
                    a_oil_com_price:$("#a_oil_com_price").val(),
                    case : "oil_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("거래처를 등록하셨습니다.");
                    closeWindowByMask();
                    // overlays_close("overlay","layer_d")
                    window.location.reload();

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
    $( function() {
        $( ".air_date" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
    });
</script>