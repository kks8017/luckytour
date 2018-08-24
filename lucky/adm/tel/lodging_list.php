<?php

$lodge_search = $_REQUEST['lodge_search'];
$lodge_area  = $_REQUEST['lodge_area'];
if($lodge_search!=""){
    $sch_sql = "where lodging_name like '%{$lodge_search}%'";
}else{
    $sch_sql = "";
}
if($lodge_area!=""){
    $str_sql = "where lodging_area like '%{$lodge_area}%'";
}else{
    $str_sql = "";
}
$sql = "select no,lodging_name,lodging_type,lodging_area,lodging_event,lodging_open,lodging_recomm,lodging_sort  from lodging_list {$sch_sql} {$str_sql} order by no asc";

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
    <div id="type_menu">
        <ul>
            <?foreach ($lodging_list_area as $area){?>
                 <li><a href="?linkpage=tel&lodge_area=<?=$area['no']?>"><?=$area['lodging_config_name']?></a></li>
            <?}?>
        </ul>
    </div>
    <div>

        <p style="margin-top: 10px;margin-bottom: 10px;"><img src="./image/sel_mod.gif"  id="mod_btn" style="cursor: pointer;" /> <img src="./image/sel_del.gif"  id="del_btn" style="cursor: pointer;" />  <img src="./image/loding_add.gif"  id="lod_add_btn" style="cursor: pointer;" /></p>
            <table class="tbl">

            <tr>
                <th class="sele"><input type="checkbox" id="allsel"></th>
                <th class="sort">순서</th>
                <th class="name">숙소명</th>
                <th class="title">숙소위치</th>
                <th class="title">숙소타입</th>
                <th class="title">공개</th>
                <th class="title">추천</th>
                <th class="title">객실</th>
                <th class="title">요금표</th>
                <th class="title">이벤트문구</th>
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
                    <td class="con"><input type="checkbox" name="sel[]" value="<?=$i?>" ><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                    <td class="con"><input type="text" name="lodging_sort[]" value="<?=$data['lodging_sort']?>" size="3"></td>
                    <td class="con"><a href="?linkpage=<?=$_REQUEST['linkpage']?>&subpage=detail&no=<?=$data['no']?>"><?=$data['lodging_name']?></a></td>
                    <td class="con"><?=$area?></td>
                    <td class="con"><?=$type?></td>
                    <td class="con"><input type="checkbox" name="lodging_open_<?=$i?>" value="Y" <?if($data['lodging_open']=="Y"){?>checked<?}?>></td>
                    <td class="con"><input type="checkbox" name="lodging_recomm_<?=$i?>" value="Y" <?if($data['lodging_recomm']=="Y"){?>checked<?}?>></td>
                    <td class="con"><img src="./image/room.gif"  id="room_btn" style="cursor: pointer;" onclick="room_location('<?=$data['no']?>');"/></td>
                    <td class="con"><img src="./image/price.gif"  id="amt_btn" style="cursor: pointer;" onclick="amount_location('<?=$data['no']?>');"/></td>
                    <td class="con"><input type="text" name="lodging_event[]" value="<?=$data['lodging_event']?>"></td>
                </tr>
            <?php
                    $i++;
                }
            }else{
            ?>
                <tr>
                    <th colspan="10" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
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
        <table class="tbl_com">
            <tr>
                <th>숙소명</th>
                <td><input type="text" id="lodging_name"></td>
            </tr>
            <tr>
                <th>숙소위치</th>
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
                <th>숙소타입</th>
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
        <p><img src="./image/loding_add.gif"  id="add_btn" style="cursor: pointer;" /></p>
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
                    window.location.reload();
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