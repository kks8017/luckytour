<?php
$sql = "select no,a_oil_name,a_oil_start_date,a_oil_end_date,a_oil_oil_price,a_oil_com_price from air_oil_comm  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>

<div>
    <div>
        <table>
            <tr>
                <td>할증료명</td>
                <td>시작일</td>
                <td>종료일</td>
                <td>유류할증료</td>
                <td>수수료</td>
                <td></td>
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
        <p><input type="button" id="mod_btn" value="선택수정"> <input type="button" id="del_btn" value="선택삭제"></p>
        <table>
            <tr>
                <td><input type="checkbox" id="allsel" value=""></td>
                <td>순서</td>
                <td>할증료명</td>
                <td>시작일</td>
                <td>종료일</td>
                <td>유류할증료</td>
                <td>수수료</td>
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