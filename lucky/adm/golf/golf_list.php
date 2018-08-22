<?php



$sql = "select no,golf_name,golf_area,golf_phone,golf_sort_no,golf_open_chk  from golf_list  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$golf = new golf();

$golf_area = $golf->golf_code("A");

?>
<script>
    function room_location(no) {
        window.location.href ="?linkpage=golf&subpage=hole&lodging_no="+no
    }
    function amount_location(no) {
        window.location.href ="?linkpage=golf&subpage=amount&lodging_no="+no
    }
</script>
<div style="margin-top: 20px;">
    <div>
        <p style="margin-top: 10px;margin-bottom: 10px;"><input type="button" id="mod_btn" value="선택수정"><input type="button" id="del_btn" value="선택삭제"><input type="button" id="golf_add_btn" value="골프장등록"></p>
        <table class="tbl">

            <tr>
                <th class="sele"><input type="checkbox" id="allsel"></th>
                <th class="sort">순서</th>
                <th class="name">골프장명</th>
                <th class="title">위치</th>
                <th class="title">공개</th>
                <th class="title">요금표</th>
            </tr>
            <form id="golf_up_frm">
                <?php
                $i=0;
                if(is_array($result_list)) {
                    foreach ($result_list as $data){
                        $area = $golf->golf_code_name($data['golf_area']);
                       ?>
                        <tr>
                            <td class="con"><input type="checkbox" name="sel[]" value="<?=$i?>" ><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                            <td class="con"><input type="text" name="golf_sort_no[]" value="<?=$data['golf_sort_no']?>" size="3"></td>
                            <td class="con"><a href="?linkpage=<?=$_REQUEST['linkpage']?>&subpage=detail&no=<?=$data['no']?>"><?=$data['golf_name']?></a></td>
                            <td class="con"><?=$area?></td>

                            <td class="con"><input type="checkbox" name="golf_open_chk[]" value="Y" <?if($data['golf_open_chk']=="Y"){?>checked<?}?>></td>
                            <td class="con"><input type="button" id="amt_btn" value="요금표" onclick="amount_location('<?=$data['no']?>')"></td>

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
                <input type="hidden" name="case" id="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_golf">
    <div class="layer_golf">
        <table class="tbl">
            <tr>
                <th>골프장명</th>
                <td><input type="text" id="golf_name"></td>
            </tr>
            <tr>
                <th>숙소위치</th>
                <td>
                    <select name="golf_area">
                        <?foreach ($golf_area as $area){
                            echo "<option value='{$area['no']}'>{$area['golf_config_name']}</option>";
                        }
                        ?>
                    </select>

                </td>
            </tr>
        </table>
        <p><input id="add_btn" type="button" value="골프장등록"></p>
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

        $("#golf_add_btn").click(function () {
            overlays_view("overlay","layer_golf")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_golf")
        });
        $("#mod_btn").click(function () {

            $("#case").val("golf_all_update");
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
                    //window.location.reload();
                }
            });

        });
        $("#del_btn").click(function () {
            var url = "golf/golf_process.php"; // the script where you handle the form input.
            $("#case").val("golf_delete");
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
        $("#add_btn").click(function () {

            if($("#golf_name").val()==""){
                alert("골프장명 입력해주세요");
                return false;
            }


            $.post("golf/golf_process.php",
                {
                    golf_name:$("#golf_name").val(),
                    golf_area:$("select[name=golf_area").val(),
                    case : "golf_insert"
                },
                function(data,status) {
                    console.log(data);
                    alert("골프를 등록하셨습니다.");
                    overlays_close("overlay","layer_golf")
                    window.location.reload();

                });


        });


    });
</script>