<?php
$sql = "select no,bus_taxi_name,bus_taxi_phone,bus_taxi_fax,bus_taxi_email,bus_taxi_content from bus_taxi_company  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>
<div style="margin-top: 20px;">
    <div>
       <p style="margin-top: 10px;margin-bottom: 10px;"><input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제"><input type="button" id="com_btn" value="거래처등록"></p>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"> </th>
                <th>순서</th>
                <th>업체명</th>
                <th>전화번호</th>
                <th>팩스</th>
                <th>이메일</th>
                <th>공지사항</th>
            </tr>
            <form id="bus_com_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
            ?>
            <tr>
                <td class="con"><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>" ></td>
                <td class="con"></td>
                <td class="con"><input type="text" name="bus_taxi_name[]" value="<?=$data['bus_taxi_name']?>"></td>
                <td class="con"><input type="text" name="bus_taxi_phone[]" value="<?=$data['bus_taxi_phone']?>"></td>
                <td class="con"><input type="text" name="bus_taxi_fax[]" value="<?=$data['bus_taxi_fax']?>"></td>
                <td class="con"><input type="text" name="bus_taxi_email[]" value="<?=$data['bus_taxi_email']?>"></td>
                <td class="con"><textarea name="bus_taxi_content[]" rows="5" cols="30" ><?=$data['bus_taxi_content']?></textarea></td>
            </tr>
           <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <td colspan="7" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
            <?}?>
                <input type="hidden" id="case" name="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_com">
    <div class="layer_com">
        <table class="tbl_cpy">
            <tr>
                <th>거래처명</th>
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
            overlays_view("overlay","layer_com")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_com")
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
                    overlays_close("overlay","layer_com")
                    window.location.reload();

                });


        });

    });
</script>