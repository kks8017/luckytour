<?php
include_once("./_common.php");
$sql = "select no,rent_com_name,rent_com_type,rent_com_manager,rent_com_phone,rent_com_fax,rent_com_email,rent_com_content  from rent_company  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$sql_type ="select count(no) as cnt from  rent_company where rent_com_type='대표'";
$rs_type  = $db->sql_query($sql_type);
$row_type = $db->fetch_array($rs_type);
if($row_type['cnt']>0){
    $sel = "disabled ";
    $chk = "checked";
}else{
    $sel = "checked";
    $chk = "";

}
?>

<div class="rent_company" >
    <p class="del_btn"><img src="./image/sel_mod.gif"  id="mod_btn" style="cursor: pointer;" />  <img src="./image/sel_del.gif"  id="del_btn" style="cursor: pointer;" /> <img src="./image/company_add.gif"  id="com_btn" style="cursor: pointer;" /></p>

    <form id="com_frm">
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>거래처명</th>
                <th>거래처타입</th>
                <th>담당자</th>
                <th>전화번호</th>
                <th>팩스</th>
                <th>안내내용</th>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
            ?>
                    <tr>
                        <td class="con"><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]"  value="<?=$data['no']?>"></td>
                        <td class="con"><?=$i+1?></td>
                        <td class="con"><input type="text" name="rent_com_name[]"  value="<?=$data['rent_com_name']?>"></td>
                        <td class="con"><input type="radio" name="rent_com_type_<?=$i?>"  value="대표" <?php if($data['rent_com_type']=="대표"){?>checked<?}?>>대표렌트카 <br> <input type="radio" name="rent_com_type_<?=$i?>"  value="협력" <?php if($data['rent_com_type']=="협력"){?>checked<?}?>>협력업체</td>
                        <td class="con"><input type="text" name="rent_com_manager[]"  value="<?=$data['rent_com_manager']?>"></td>
                        <td class="con"><input type="text" name="rent_com_phone[]"  value="<?=$data['rent_com_phone']?>"></td>
                        <td class="con"><input type="text" name="rent_com_fax[]"  value="<?=$data['rent_com_fax']?>"></td>
                        <td class="con"><textarea name="rent_com_content[]" rows="4" cols="30"><?=$data['rent_com_content']?></textarea></td>
                    </tr>
            <?php
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <td colspan="8" align="center"><p>등록된 정보가 없습니다.</p></td>
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
                <td><input type="text" id="rent_com_name"></td>
            </tr>
            <tr>
                <th>거래처타입</th>
                <td><input type="radio" name="rent_com_type" id="rent_com_type"  value="대표" <?=$sel?> <?=$chk?> >대표렌트카  <input type="radio" name="rent_com_type" id="rent_com_type" value="협력" <?=$chk?>>협력업체</td>
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
              overlays_view("overlay","layer_d");
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_d");
        });
        $("#mod_btn").click(function () {

            $("#case").val("com_up");
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

            if($("#rent_com_name").val()==""){
                alert("거래처명를 입력해주세요");
                return false;
            }


            $.post("rent/rent_process.php",
                {
                    rent_com_name:$("#rent_com_name").val(),
                    rent_com_type:$(":radio[name=rent_com_type]:checked").val(),
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