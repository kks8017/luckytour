<?php

$sql = "select no,golf_name,golf_area  from golf_list order by binary(golf_name)";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$golf_no = $_REQUEST['golf_no'];
if(!$golf_no){$golf_no=$result_list[0]['no'];}

$sql_hole = "select no,golf_no,hole_name,hole_sort_no from golf_hole_list  where golf_no='{$golf_no}'  order by hole_sort_no asc";
$rs_hole  = $db->sql_query($sql_hole);
while($row_hole = $db->fetch_array($rs_hole)) {
    $result_hole[] = $row_hole;
}
?>
<script>
    function room_up_layer(no,mode) {
        var url = "golf/hole_update.php"; // the script where you handle the form input.
        if(mode =="img") {

        }else{
            $(".overlay").show();
            $("#layer_hole_up").show();
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no, // serializes the form's elements.
            success: function (data) {
                $(".layer_hole_up").html(data); // show response from the php script.
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }

</script>
<div id="layer_hole_up">
    <div class="layer_hole_up"></div>
</div>
<div class="hole_list">
    <div>
        <select name="golf_no" id="golf_no">
            <?php
            foreach ($result_list as $golf){
                if($golf['no']== $golf_no){$sel="selected";}else{$sel="";}
                echo "<option value='{$golf['no']}' $sel>{$golf['golf_name']}</option>";
            }
            ?>
        </select>
    </div>
    <input type="button" id="mod_btn" value="선택수정"><input type="button" id="del_btn" value="선택삭제"><input type="button" id="room_add_btn" value="홀등록">
    <div id="hole_list">
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"></td>
                <td>순서</td>
                <td>홀명</td>
                <td>공개</td>
            </tr>
            <form id="golf_up_frm">
                <?php
                $i=0;
                if(is_array($result_hole)) {
                    foreach ($result_hole as $data){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                            <td><input type="text" name="lodging_room_sort[]" size="3" value="<?=$data['hole_sort_no']?>"></td>
                            <td><a href="javascript:room_up_layer('<?=$data['no']?>');" id="room_up"><?=$data['hole_name']?></a></td>

                            <td><input type="checkbox" name="lodging_room_open[]" value="Y" <?if($data['lodging_room_open']=="Y"){?>checked<?}?>></td>
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
                <input type="hidden" name="case" id="case" >
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_hole">
    <div class="layer_hole">
        <table>
            <tr>
                <td>홀명</td>
                <td><input type="text" name="hole_name" id="hole_name"></td>
            </tr>

            <tr>
                <td colspan="2">
                    <p><input type="button" id="add_btn" value="홀등록"></p>
                </td>
            </tr>
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
        $("#room_add_btn").click(function () {
            overlays_view("overlay","layer_hole")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_hole")
            overlays_close("overlay","layer_hole_up")
        });


        $("#mod_btn").click(function () {

            $("#case").val("hole_all_update");
            var url = "golf/golf_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#golf_up_frm").serialize(), // serializes the form's elements.
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
            var url = "golf/golf_process.php"; // the script where you handle the form input.
            $("#case").val("hole_delete");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#golf_up_frm").serialize(), // serializes the form's elements.
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
        $("#golf_no").on("change",function () {
            $("#golf_no option:selected").each(function () {
                window.location.href="?linkpage=<?=$linkpage?>&subpage=<?=$subpage?>&golf_no="+$(this).val();
            });
        });
        $("#add_btn").click(function () {

            if($("#hole_name").val()==""){
                alert("홀명 입력해주세요");
                return false;
            }


            $.post("golf/golf_process.php",
                {
                    golf_no:"<?=$golf_no?>",
                    hole_name:$("#hole_name").val(),
                    case : "hole_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("홀를 등록하셨습니다.");
                    overlays_close("overlay","layer_hole")
                   window.location.reload();

                });


        });


    });



</script>