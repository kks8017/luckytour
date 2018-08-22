<?php
$sql = "select no,bustour_tour_name,bustour_tour_type,bustour_tour_stay,bustour_open,bustour_sort_no from bustour_tour  order by bustour_sort_no asc";
$rs  = $db->sql_query($sql);

while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>
<div style="margin-top: 20px;">
    <div>
       <p style="margin-top: 10px;margin-bottom: 10px;"><input type="button" id="mod_btn" value="선택수정">  <input type="button" id="del_btn" value="선택삭제"> <input type="button" id="com_btn" value="버스투어등록"></p>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순서</th>
                <th>버스투어명</th>
                <th>일정</th>
                <th>공개</th>
            </tr>
            <form id="bustour_frm">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
            ?>
            <tr>
                <td class="con"><input type="checkbox"  name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                <td class="con"><input type="text" name="bustour_sort_no[]" size="3" value="<?=$data['bustour_sort_no']?>"></td>
                <td class="con"><a href="?linkpage=bustour&subpage=detail&no=<?=$data['no']?>"><?=$data['bustour_tour_name']?></a></td>
                <td class="con"><?=$data['bustour_tour_stay']?>박<?=$data['bustour_tour_stay']+1?>일</td>
                <td class="con"><input type="checkbox" name="bustour_open[]" value="Y" <?if($data['bustour_open']=="Y"){?>checked<?}?>></td>
            </tr>
                <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <th colspan="7" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
                <input type="hidden" name="case" id="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d">
        <table class="tbl_com">
            <tr>
                <th>버스투어명</th>
                <td><input type="text" id="bustour_tour_name"></td>
            </tr>
            <tr>
                <th>일정</th>
                <td><input type="radio" name="bustour_tour_stay" id="bustour_tour_stay"  value="2" >1박2일 <input type="radio" name="bustour_tour_stay" id="bustour_tour_stay"  value="2" >2박3일  <input type="radio" name="bustour_tour_stay" id="bustour_tour_stay" value="3" >3박4일</td>
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

            $("#case").val("all_update");
            var url = "bustour/bustour_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bustour_frm").serialize(), // serializes the form's elements.
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
            var url = "bustour/bustour_process.php"; // the script where you handle the form input.
            $("#case").val("all_delete");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#bustour_frm").serialize(), // serializes the form's elements.
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

            if($("#bustour_tour_name").val()==""){
                alert("거래처명를 입력해주세요");
                return false;
            }


            $.post("bustour/bustour_process.php",
                {
                    bustour_tour_name:$("#bustour_tour_name").val(),
                    bustour_tour_stay:$(":input:radio[name=bustour_tour_stay]:checked").val(),
                    case : "insert"
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