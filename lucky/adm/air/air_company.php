<?php
$sql = "select no,air_name,air_type,air_content,air_manager,air_phone,air_fax,air_sch_ok from air_company  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>

<div class="air_company" >
    <p class="del_btn"><img src="./image/sel_mod.gif"  id="mod_btn" style="cursor: pointer;" /> <img src="./image/sel_del.gif"  id="del_btn" style="cursor: pointer;" />  <img src="./image/company_add.gif"  id="com_btn" style="cursor: pointer;" /></p>
 <!--   <input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제">-->
    <form id="com_frm">
    <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>거래처명</th>
                <th>거래처타입</th>
                <th>거래처담당자</th>
                <th>전화번호</th>
                <th>팩스</th>
                <th>스케줄</th>
                <th>안내내용</th>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data) {
                    ?>
                    <tr>
                        <td align="center"><input type="checkbox" name="sel[]" value="<?= $i ?>"><input type="hidden" name="no[]"
                                                                                         value="<?= $data['no'] ?>">
                        </td>
                        <td align="center"><?= $i + 1 ?></td>
                        <td align="center"><input type="text" name="air_name[]" value="<?= $data['air_name'] ?>"></td>
                        <td align="center"><input type="radio" name="air_type_<?= $i ?>" value="N"
                                   <?php if ($data['air_type'] == "N"){ ?>checked<?
                            } ?>>항공사 <br> <input type="radio" name="air_type_<?= $i ?>" id="air_type" value="S"
                                                 <?php if ($data['air_type'] == "S"){ ?>checked<?
                            } ?>>에이전시
                        </td>
                        <td align="center"><input type="text" name="air_manager[]" value="<?= $data['air_manager'] ?>"></td>
                        <td align="center"><input type="text" name="air_phone[]" value="<?= $data['air_phone'] ?>"></td>
                        <td align="center"><input type="text" name="air_fax[]" value="<?= $data['air_fax'] ?>"></td>
                        <td align="center"><input type="checkbox" name="air_sch_ok_<?= $i ?>" <?
                            if ($data['air_sch_ok'] == "Y"){
                            ?>checked<?
                            } ?> value="Y"></td>
                        <td align="center"><textarea name="air_content[]" rows="4" cols="30"><?= $data['air_content'] ?></textarea>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }else{
            ?>
                <tr>
                    <td colspan="9" class="tb_center">등록된 정보가 없습니다.</td>
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
                <th>거래처명</th>
                <td><input type="text" id="air_name"></td>
            </tr>
            <tr>
                <th>거래처타입</th>
                <td><input type="radio" name="air_type"  value="N" checked>항공사  <input type="radio" name="air_type" id="air_type" value="S" >에이전시</td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="사이트등록"></p>
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

            $("#case").val("com_up");
            var url = "air/air_process.php"; // the script where you handle the form input.
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
            var url = "air/air_process.php"; // the script where you handle the form input.
            $("#case").val("com_del");
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

            if($("#air_name").val()==""){
                alert("거래처명를 입력해주세요");
                return false;
            }


            $.post("air/air_process.php",
                {
                    air_name:$("#air_name").val(),
                    air_type:$(':radio[name="air_type"]:checked').val(),
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