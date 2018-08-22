<?php
$sql = "select no,bus_taxi_name,bus_taxi_phone,bus_taxi_fax,bus_taxi_email,bus_taxi_content from bus_taxi_company  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>
<div class="bus_company">
    <div>
        <input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제"><input type="button" id="com_btn" value="거래처등록">
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"> </td>
                <td>순서</td>
                <td>업체명</td>
                <td>전화번호</td>
                <td>팩스</td>
                <td>이메일</td>
                <td>공지사항</td>
            </tr>
            <form id="bus_com_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
            ?>
            <tr>
                <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>" ></td>
                <td></td>
                <td><input type="text" name="bus_taxi_name[]" value="<?=$data['bus_taxi_name']?>"></td>
                <td><input type="text" name="bus_taxi_phone[]" value="<?=$data['bus_taxi_phone']?>"></td>
                <td><input type="text" name="bus_taxi_fax[]" value="<?=$data['bus_taxi_fax']?>"></td>
                <td><input type="text" name="bus_taxi_email[]" value="<?=$data['bus_taxi_email']?>"></td>
                <td><textarea name="bus_taxi_content[]" rows="5" cols="30" ><?=$data['bus_taxi_content']?></textarea></td>
            </tr>
           <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <th colspan="7" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
                <input type="hidden" id="case" name="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table>
            <tr>
                <td>거래처명</td>
                <td><input type="text" id="bus_taxi_name"></td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="사이트등록"></p>
    </div>

<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })
        $("#com_btn").click(function () {
            overlays_view("overlay","layer_d")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_d")
        });
        $("#mod_btn").click(function () {

            $("#case").val("com_up");
            var url = "bus/bus_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bus_com_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    //window.location.reload();
                }
            });

        });
        $("#del_btn").click(function () {
            var url = "bus/bus_process.php"; // the script where you handle the form input.
            $("#case").val("com_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#bus_com_frm").serialize(), // serializes the form's elements.
                    success: function (data) {
                        // console.log(data); // show response from the php script.
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

            if($("#bus_taxi_name").val()==""){
                alert("거래처명를 입력해주세요");
                return false;
            }


            $.post("bus/bus_process.php",
                {
                    bus_taxi_name:$("#bus_taxi_name").val(),
                    case : "com_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("거래처를 등록하셨습니다.");
                    overlays_close("overlay","layer_d")
                    window.location.reload();

                });


        });

    });
</script>