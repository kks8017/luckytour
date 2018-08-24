<?php
$no = $_GET['no'];
$sql = "select * from board_config,board_list where board_config.bd_no = board_list.no and bd_no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

?>
<div class="inbody">
    <p class="title">게시판설정</p>
    <div>
        <form id="config_frm">
            <table class="conbox5">
                <tr>
                    <td class="titbox">게시판아이디</td>
                    <td><input type="text" name="board_id" id="board_id" value="<?=$row['bd_id']?>" class="d_box" readonly></td>
                </tr>
                <tr>
                    <td class="titbox">게시판 타입설정</td>
                    <td><input type="radio" name="bd_type" value="L" <?if($row['bd_type']=="L"){?>checked<?}?> >리스트 <input type="radio" name="bd_type" value="P" <?if($row['bd_type']=="P"){?>checked<?}?>>포토 <input type="radio" name="bd_type" value="B" <?if($row['bd_type']=="B"){?>checked<?}?>>블로그</td>
                </tr>
                <tr>
                    <td class="titbox">공지설정</td>
                    <td><input type="radio" name="bd_notice" value="Y" <?if($row['bd_notice']=="Y"){?>checked<?}?>>사용 <input type="radio" name="bd_notice" value="N" <?if($row['bd_notice']=="N"){?>checked<?}?>>미사용</td>
                </tr>
                <tr>
                    <td class="titbox">글쓰기설정</td>
                    <td><input type="radio" name="bd_write" value="Y" <?if($row['bd_write']=="Y"){?>checked<?}?>>사용 <input type="radio" name="bd_write" value="N" <?if($row['bd_write']=="N"){?>checked<?}?>>미사용</td>
                </tr>
                <tr>
                    <td class="titbox">업로드설정</td>
                    <td><input type="radio" name="bd_file" value="Y" <?if($row['bd_file']=="Y"){?>checked<?}?>>사용 <input type="radio" name="bd_file" value="N" <?if($row['bd_file']=="N"){?>checked<?}?>>미사용</td>
                </tr>
                <tr>
                    <td class="titbox">비밀글설정</td>
                    <td><input type="radio" name="bd_secret" value="Y" <?if($row['bd_secret']=="Y"){?>checked<?}?>>사용 <input type="radio" name="bd_secret" value="N" <?if($row['bd_secret']=="N"){?>checked<?}?>>미사용</td>
                </tr>

            </table>
        </form>
    </div>
    <p class="bottom"><input id="up_btn" type="button" value="기본설정변경"></p>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#up_btn").click(function () {
            wrapWindowByMask();

            $.post("board_process.php",
                {
                    bd_type: $(':radio[name="bd_type"]:checked').val(),
                    bd_notice:$(':radio[name="bd_notice"]:checked').val(),
                    bd_write:$(':radio[name="bd_write"]:checked').val(),
                    bd_file:$(':radio[name="bd_file"]:checked').val(),
                    bd_secret:$(':radio[name="bd_secret"]:checked').val(),
                    no:"<?=$no?>",
                    case : "update"
                },
                function(data,status){
                    alert("게시판설정을 변경하셨습니다.");
                    closeWindowByMask();
                    window.location.reload();
                });
        });
    });

</script>