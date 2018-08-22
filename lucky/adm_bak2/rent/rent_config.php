<?php

$sql = "select no,rent_config_type,rent_config_sort_no,rent_config_name,rent_config_chk  from rent_config  order by rent_config_sort_no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>

<div class="rent_company" >
    <input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제">
    <form id="com_frm">
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"></td>
                <td>순서</td>
                <td>코드타입</td>
                <td>코드명</td>
                <td>기본체크</td>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
                    ?>
                    <tr>
                        <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]"  value="<?=$data['no']?>"></td>
                        <td><input type="text" name="rent_config_sort_no[]"  value="<?=$data['rent_config_sort_no']?>" size="3"></td>
                        <td>
                            <select name="rent_config_type[]">
                                <option value="T" <?if($data['rent_config_type']=="T"){?>selected<?}?>>차량유형</option>
                                <option value="F" <?if($data['rent_config_type']=="F"){?>selected<?}?>>차량연료</option>
                                <option value="O" <?if($data['rent_config_type']=="O"){?>selected<?}?>>차량옵션</option>
                                <option value="B" <?if($data['rent_config_type']=="B"){?>selected<?}?>>부가서비스</option>
                            </select>
                        </td>
                        <td><input type="text" name="rent_config_name[]"  value="<?=$data['rent_config_name']?>"></td>
                        <td><input type="checkbox" name="rent_config_chk[<?=$i?>]" value="Y" <?if($data['rent_config_chk']=="Y"){?>checked<?}?>></td>
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

        </table>
        <input type="hidden" name="case" id="case" value="">
    </form>
    <input type="button" id="com_btn" value="코드등록">
</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table>
            <tr>
                <td>코드명</td>
                <td><input type="text" id="rent_config_name"></td>
            </tr>
            <tr>
                <td>코드타입</td>
                <td>
                    <select name="rent_config_type">
                        <option value="T" >차량유형</option>
                        <option value="F" >차량연료</option>
                        <option value="O" >차량옵션</option>
                        <option value="B" >부가서비스</option>
                    </select>
                </td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="코드등록"></p>
    </div>
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

            $("#case").val("code_up");
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#com_frm").serialize(), // serializes the form's elements.
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
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $("#case").val("code_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#com_frm").serialize(), // serializes the form's elements.
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

            if($("#rent_config_name").val()==""){
                alert("코드명를 입력해주세요");
                return false;
            }


            $.post("rent/rent_process.php",
                {
                    rent_config_name:$("#rent_config_name").val(),
                    rent_config_type:$("select[name=rent_config_type]").val(),
                    case : "code_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("코드를 등록하셨습니다.");
                    overlays_close("overlay","layer_d")
                    window.location.reload();

                });


        });

    });
</script>