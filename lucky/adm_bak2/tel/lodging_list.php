<?php



$sql = "select no,lodging_name,lodging_type,lodging_area,lodging_event,lodging_open,lodging_recomm,lodging_sort  from lodging_list  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$lodging = new lodging();

$lodging_list_area = $lodging->lodging_code('A');
$lodging_list_type = $lodging->lodging_code('C');

?>
<script>
    function room_location(no) {
        window.location.href ="?linkpage=tel&subpage=room&lodging_no="+no
    }
    function amount_location(no) {
        window.location.href ="?linkpage=tel&subpage=amount&lodging_no="+no
    }
</script>
<div class="tel_list">
    <div>
        <div>위치</div><div>타입</div><div>비공개</div><div>추천</div>
    </div>
    <div>
        <table>
            <tr>
                <td colspan="8"><input type="button" id="mod_btn" value="선택수정"><input type="button" id="del_btn" value="선택삭제"><input type="button" id="lod_add_btn" value="숙소등록"> </td>
            </tr>
            <tr>
                <td class="sele"><input type="checkbox" id="allsel"></td>
                <td class="sort">순서</td>
                <td class="name">숙소명</td>
                <td class="title">숙소위치</td>
                <td class="title">숙소타입</td>
                <td class="title">공개</td>
                <td class="title">추천</td>
                <td class="title">객실</td>
                <td class="title">요금표</td>
                <td class="title">이벤트문구</td>
            </tr>
            <form id="tel_up_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
                foreach ($result_list as $data){
                   $area =  $lodging->lodging_code_name($data['lodging_area']);
                   $type =  $lodging->lodging_code_name($data['lodging_type']);
            ?>
                <tr>
                    <td class="cont"><input type="checkbox" name="sel[]" value="<?=$i?>" ><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                    <td class="cont"><input type="text" name="lodging_sort[]" value="<?=$data['lodging_sort']?>" size="3"></td>
                    <td class="cont"><a href="?linkpage=<?=$_REQUEST['linkpage']?>&subpage=detail&no=<?=$data['no']?>"><?=$data['lodging_name']?></a></td>
                    <td class="cont"><?=$area?></td>
                    <td class="cont"><?=$type?></td>
                    <td class="cont"><input type="checkbox" name="lodging_open[]" value="Y" <?if($data['lodging_open']=="Y"){?>checked<?}?>></td>
                    <td class="cont"><input type="checkbox" name="lodging_recomm[]" value="Y" <?if($data['lodging_recomm']=="Y"){?>checked<?}?>></td>
                    <td class="cont"><input type="button" id="room_btn" value="객실" onclick="room_location('<?=$data['no']?>');" ></td>
                    <td class="cont"><input type="button" id="amt_btn" value="요금표" onclick="amount_location('<?=$data['no']?>')"></td>
                    <td class="cont"><input type="text" name="lodging_event[]" value="<?=$data['lodging_event']?>"></td>
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
                <input type="hidden" name="case" id="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_tel">
    <div class="layer_tel">
        <table>
            <tr>
                <td>숙소명</td>
                <td><input type="text" id="lodging_name"></td>
            </tr>
            <tr>
                <td>숙소위치</td>
                <td>
                    <select name="lodging_area">
                        <?foreach ($lodging_list_area as $area){
                            echo "<option value='{$area['no']}'>{$area['lodging_config_name']}</option>";
                        }
                        ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td>숙소타입</td>
                <td>
                    <select name="lodging_type">
                        <?foreach ($lodging_list_type as $type){
                            echo "<option value='{$type['no']}'>{$type['lodging_config_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

        </table>
        <p><input id="add_btn" type="button" value="숙소등록"></p>
    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })

        $("#lod_add_btn").click(function () {
            overlays_view("overlay","layer_tel")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_tel")
        });
        $("#mod_btn").click(function () {

            $("#case").val("tel_all_update");
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#tel_up_frm").serialize(), // serializes the form's elements.
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
            var url = "tel/lodging_process.php"; // the script where you handle the form input.
            $("#case").val("tel_delete");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#tel_up_frm").serialize(), // serializes the form's elements.
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

            if($("#lodging_name").val()==""){
                alert("숙소명 입력해주세요");
                return false;
            }


            $.post("tel/lodging_process.php",
                {
                    lodging_name:$("#lodging_name").val(),
                    lodging_area:$("select[name=lodging_area").val(),
                    lodging_type:$("select[name=lodging_type").val(),
                    case : "tel_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("숙소를 등록하셨습니다.");
                    overlays_close("overlay","layer_tel")
                    window.location.reload();

                });


        });
        

    });
</script>