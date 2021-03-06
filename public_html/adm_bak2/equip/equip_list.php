<?php

$sql = "select *  from equipment_list  order by equip_sort_no asc";
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
                <td>편의장비명</td>
                <td>가격</td>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
                    ?>
                    <tr>
                        <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]"  value="<?=$data['no']?>"></td>
                        <td><input type="text" name="equip_sort_no[]"  value="<?=$data['equip_sort_no']?>" size="3"></td>
                        <td><input type="text" name="equip_name[]"  value="<?=$data['equip_name']?>"></td>
                        <td>판매가 : <input type="text" name="equip_amount[]"  value="<?=set_comma($data['equip_amount'])?>">  입금가 : <input type="text" name="equip_amount_deposit[]"  value="<?=set_comma($data['equip_amount_deposit'])?>"></td>
                    </tr>
                    <?php
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <th colspan="4" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>

        </table>
        <input type="hidden" name="case" id="case" value="">
    </form>
    <input type="button" id="com_btn" value="편의장비등록">
</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table>
            <tr>
                <td>편의장비명</td>
                <td><input type="text" id="equip_name"></td>
            </tr>
            <tr>
                <td>판매가</td>
                <td>
                     <input type="text" id="equip_amount" size="10">원
                </td>
            </tr>
            <tr>
                <td>
                    입금가
                </td>
                <td>
                     <input type="text" id="equip_amount_deposit" size="10">원
                </td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="편의장비등록"></p>
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

            $("#case").val("all_update");
            var url = "equip/equip_process.php"; // the script where you handle the form input.
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
            var url = "equip/equip_process.php"; // the script where you handle the form input.
            $("#case").val("all_delete");
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

            if($("#equip_name").val()==""){
                alert("코드명를 입력해주세요");
                return false;
            }


            $.post("equip/equip_process.php",
                {
                    equip_name:$("#equip_name").val(),
                    equip_amount:$("#equip_amount").val(),
                    equip_amount_deposit:$("#equip_amount_deposit").val(),
                    case : "insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("편의장비를 등록하셨습니다.");
                    overlays_close("overlay","layer_d")
                    window.location.reload();

                });


        });

    });
</script>