<?php
$sql = "select * from board_list  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>
<script>
    function del_b(i) {
        wrapWindowByMask();
        if (confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        } else {
            $.post("board_process.php",
                {
                    no: $("#no_"+i).val(),
                    case: "delete"
                },
                function (data, status) {
                    alert("게시판을 삭제하셨습니다.");
                    //console.log(data);
                    closeWindowByMask();
                    window.location.reload();
                });
        }

    }
</script>

<div style="margin-top: 20px;">
    <p style="margin-top: 10px;margin-bottom: 10px;"><input id="board_btn" type="button" value="게시판등록"></p>
    <div>
        <table class="tbl">
            <tr>
                <th class="title">차례</th>
                <th class="title">게시판명</th>
                <th class="title">등록일</th>
                <th class="title">관리</th>
            </tr>
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){
                ?>
                <tr>
                    <td class="con"><?=$i?></td>
                    <td class="con"><a href="?linkpage=board_list&bd_no=<?=$bd_no?>&board_table=<?=$data['bd_id']?>"><?=$data['bd_name']?></a></td>
                    <td class="con"><?=$data['indate']?></td>
                    <td class="con"><input type="button" value="삭제" onclick="del_b(<?=$i?>)">
                        <input type="hidden" name="no" id="no_<?=$i?>" value="<?=$data[no]?>">
                        <input id="basic_btn" type="button" value="설정" onclick="location.href = '?linkpage=bd_config&no=<?=$data['no']?>';">
                    </td>
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

    </div>


</div>
<div class="overlay"></div>
<div id="board_in">
    <div class="board_in" >
        <form id="tour_frm">
            <table class="tbl_bd">
                <tr>
                    <th>게시판명</th>
                    <td><input type="text" name="board_name" id="board_name"></td>
                </tr>
                <tr>
                    <th>게시판아이디</th>
                    <td><input type="text" name="board_id" id="board_id" style="ime-mode:disabled"></td>
                </tr>
            </table>
        </form>
        <p style="text-align: center;"><input id="add_btn" type="button" value="게시판등록"></p>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#board_btn").click(function () {
            $("#board_in").show();
            $(".overlay").show();

        }) ;
        $(".overlay").click(function () {
            $(".overlay").hide();
            $("#board_in").hide();
        });

        $("#add_btn").click(function () {

            if($("#board_name").val()==""){
                alert("게시판명를 입력해주세요");
                return false;
            }else if($("#board_id").val()==""){
                alert("게시판아이디를 입력해주세요");
                return false;
            }

            var str = $("#board_id").val();
            var regexp = /^[A-Za-z0-9]{4,20}$/i;

            if(!regexp.test(str))
            {
                alert(" 틀렸어요 영어숫자 4-20자만 사용 가능해요");
                return false;
            }

            $.post("board_process.php",
                {
                    board_name:$("#board_name").val(),
                    board_id:$("#board_id").val(),
                    case : "insert"
                },
                function(data,status) {
                    if (data == "NO") {
                        alert("아이디가 중복되었습니다. 다른 아이디로 등록해주세요");
                    } else {
                        console.log(data);
                        alert("게시판를 등록하셨습니다.");
                        $(".overlay").hide();
                        $("#board_in").hide();
                        window.location.reload();
                    }
                });


        });

    });
</script>