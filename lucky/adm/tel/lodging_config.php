<?php

$sql = "select no,lodging_config_type,lodging_config_sort_no,lodging_config_name,lodging_config_chk  from lodging_config  order by lodging_config_sort_no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>

<div style="margin-top: 20px;" >
    <p style="margin-top: 20px;margin-bottom: 10px;"><input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제">  <input type="button" id="com_btn" value="코드등록"></p>
    <form id="com_frm">
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>코드타입</th>
                <th>코드명</th>
                <th>기본체크</th>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
                    ?>
                    <tr>
                        <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]"  value="<?=$data['no']?>"></td>
                        <td><input type="text" name="lodging_config_sort_no[]"  value="<?=$data['lodging_config_sort_no']?>" size="3"></td>
                        <td>
                            <select name="lodging_config_type[]">
                                <option value="A" <?if($data['lodging_config_type']=="A"){?>selected<?}?>>지역</option>
                                <option value="C" <?if($data['lodging_config_type']=="C"){?>selected<?}?>>숙소타입</option>
                                <option value="T" <?if($data['lodging_config_type']=="T"){?>selected<?}?>>숙소테마</option>
                            </select>
                        </td>
                        <td><input type="text" name="lodging_config_name[]"  value="<?=$data['lodging_config_name']?>"></td>
                        <td><input type="checkbox" name="lodging_config_chk[<?=$i?>]" value="Y" <?if($data['lodging_config_chk']=="Y"){?>checked<?}?>></td>
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

</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table class="tbl_com">
            <tr>
                <th>코드명</th>
                <td><input type="text" id="lodging_config_name"></td>
            </tr>
            <tr>
                <th>코드타입</th>
                <td>
                    <select name="lodging_config_type">
                        <option value="A" >지역</option>
                        <option value="C" >숙소타입</option>
                        <option value="T" >숙소테마</option>
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
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
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
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
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

            if($("#lodging_config_name").val()==""){
                alert("코드명를 입력해주세요");
                return false;
            }


            $.post("tel/lodging_process.php",
                {
                    lodging_config_name:$("#lodging_config_name").val(),
                    lodging_config_type:$("select[name=lodging_config_type]").val(),
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