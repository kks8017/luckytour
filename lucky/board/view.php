<?php
$no = $_REQUEST['no'];
$board_set = new board();
$board_set->bd_no = $bd_no;
$config = $board_set->board_config();
if(!empty($no) && empty(get_session("board_".$no))) {
    $sql_cnt = "update {$table} set hits = hits + 1 where no ='{$no}'";
   // echo $sql_cnt;
    $rs_cnt  = $db->sql_query($sql_cnt);
    if(empty($rs_cnt)) {
        echo "
         <script>
            alert('오류가 발생했습니다.');
            history.back();
        </script>
        ";
    } else {
        set_session("board_".$no, TRUE);
    }
}


$sql = "select * from {$table} where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$sql_reply = "select * from board_reply where bd_no='{$bd_no}' and sub_no='{$no}'";
//echo $sql_reply;
$rs_reply  = $db->sql_query($sql_reply);
$num_reply = $db->num_rows($rs_reply);
while ($row_reply = $db->fetch_array($rs_reply)){
    $result_reply[]  = $row_reply;
}
//print_r($result_reply);

if($_SESSION["member_id"]!="") {
    $adm_url = "linkpage={$linkpage}&";
}else{
    $adm_url = "";
}
$realurl = $_SERVER['REQUEST_URI'];
$tmpurl  = explode("?",$realurl);
$tmpurl2 = explode("&board=view",$tmpurl[1]);

$search_url = $tmpurl2[1];

$basic_url = "bd_no={$bd_no}&board_table={$bd_id}";
$url_list = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url. "&board=list".$search_url;
$url_mod = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url;

?>
<div class="rcon">
    <p><?=$config['bd_name']?></p><p>고객님들의 여행담을 나누는 공간입니다.</p>
    <div class="tbl_wrap">
        <table>
            <tr>
                <th>
                    <p><span><?=$row['subject']?></span></p>
                    <p><span>작성자:&nbsp;</span><span><?=$row['author']?></span><span>|</span>
                        <span>조회수:&nbsp;</span><span><?=$row['hits']?></span></p>
                </th>
            </tr>
            <tr>

                <td>
                    <div class="content">
                        <?=$row['content']?>
                    </div>
                </td>
            </tr>
            <?php
            if($config['bd_reply']=="Y"){
            ?>
            <tr>
                <td>
                    <div class="reply"> <!-- 댓글 시작 -->
                        <p class="re_num"><span>댓글(<?=$num_reply?>)</span></p>
                        <ul>
                            <?php
                            $i=0;
                            if(is_array($result_reply)) {
                            foreach ($result_reply as $data){
                            ?>
                            <li>
                                <p><span><?=$data['name']?></span><span>(<?=$data['indate']?>)</span>
                                    <?if($_SESSION["member_id"]!="") {?>
                                      <a href="javascript:reply_delete(<?=$data['no']?>)">
                                    <?}else{?>
                                       <a href="javascript:reply_layer(<?=$data['no']?>)">
                                    <?}?>
                                          <img src="../sub_img/del_btn.png" /></a></p>

                                <p> <?=$data['content']?></p>
                            </li>
                                <?php
                                $i++;
                            }
                            }else{
                            ?>
                            <li> <p>등록된 덧글이 없습니다.</p> </li>
                            <?}?>
                        </ul>

                        <div class="reply_input"> <!-- 댓글입력 시작 -->
                            <form id="board_reply">
                                <p><?if($_SESSION["member_id"]==""){?><span>이름</span> <input type="text" name="re_name" /> <span>비밀번호</span> <input type="password" name="passwd" />
                                        <span><a href="javascript:img_change();"><img id="imgs" src="/SpamCode.php" style="vertical-align: middle"></a> <input type="text" name="s_code" id="s_code" class="s_code" maxlength="4"></span>
                                    <?}else{?>
                                        <input type="hidden" name="re_name" size="7" value="관리자"><input type="hidden" name="passwd" size="7" value="2727">
                                        <input type="hidden" name="adm" id="adm" value="admin">
                                    <?}?>
                                    </p>
                                <p><textarea name="re_content"></textarea><img class='add' id="reply_btn" type="button" src="../sub_img/write_submit_btn.png" /> </p>
                                <input type="hidden" name="bd_no" value="<?=$bd_no?>">
                                <input type="hidden" name="sub_no" value="<?=$no?>">
                            </form>

                        </div> <!-- 댓글입력 끝 -->

                    </div> <!-- 댓글 종료 -->


                </td>
            </tr>
            <?}?>

        </table>

    </div>
    <p class="btns">
        <?if($_SESSION["member_id"]!=""){?>
           <img id="update_btn" src="../sub_img/write_upd_btn.png" style="cursor: pointer;"/></a>
           <img id="delete_btn" src="../sub_img/write_del_btn.png"  style="cursor: pointer;"/></a>
        <?}?>
        <?if($config['bd_write']=="Y") {?>
        <img id="update_btn" src="../sub_img/write_upd_btn.png" style="cursor: pointer;"/></a>
        <img id="delete_btn" src="../sub_img/write_del_btn.png"  style="cursor: pointer;"/></a>
        <a href="/board/board.php?board_table=<?=$config['bd_id']?>"><img src="../sub_img/list_view_btn.png" /></a>
        <?}else{?>
            <a href="/board/board.php?board_table=<?=$config['bd_id']?>"><img src="../sub_img/list_view_btn.png" /></a>
        <?}?>


    </p>

</div>
<div id="err"></div>
<!--
<div style="margin-top: 20px;">
    <div>
        <table class="tbl">
            <tr>
                <td class="subject">제목 : <?=$row['subject']?></td>
                <td class="date">날짜 : <?=$row['indate']?></td>
                <td class="hit">조회수 : <?=$row['hits']?></td>
            </tr>
            <tr>
                <td colspan="3">파일 : <?=$row['files']?></td>
            </tr>
            <tr>
                <td colspan="3" class="content" ><?=$row['content']?></td>
            </tr>
        </table>
        <table>
            <tr>
                <th>
                    <input type="button" id="update_btn" value="수정하기"> <input type="button" id="delete_btn" value="삭제하기"> <input id="list_btn" type="button" value="목록으로" >
                </th>
            </tr>
        </table>
        <form id="board_reply">
        <table>
            <tr>
                <td>
                    <?if($_SESSION["member_id"]==""){?>
                    이    름 : <input type="text" name="re_name" size="7"> 비밀번호 : <input type="password" name="passwd" size="7">  스팸코드 : <a href="javascript:img_change();"><img id="imgs" src="/SpamCode.php" style="vertical-align: middle"></a> <input type="text" name="s_code" id="s_code" class="s_code" maxlength="4"> 왼쪽에 보이는글를 넣어주세요<br>
                    <?}else{?>
                       <input type="hidden" name="re_name" size="7" value="관리자"><input type="hidden" name="passwd" size="7" value="2727">
                        <input type="hidden" name="adm" id="adm" value="admin">
                    <?}?>
                    내    용 : <textarea name="re_content" rows="5" cols="80" style="vertical-align: middle;"></textarea>  <input type="button" id="reply_btn" style="height: 70px; vertical-align: middle;" value="덧글달기">
                </td>
            </tr>
        </table>
        <table >
            <?php
            $i=0;
            if(is_array($result_reply)) {
                foreach ($result_reply as $data){
            ?>
                    <tr>
                        <td><?=$data['name']?> <?=$data['indate']?><br>
                            <?=$data['content']?> <input type="button" onclick="reply_delete(<?=$data['no']?>)" value="삭제">

                        </td>
                    </tr>

            <?php
                    $i++;
                }
            }else{
                ?>
                <tr>
                    <th ><p>등록된 덧글이 없습니다.</p></th>
                </tr>
            <?}?>
        </table>
            <input type="hidden" name="bd_no" value="<?=$bd_no?>">
            <input type="hidden" name="sub_no" value="<?=$no?>">

        </form>
    </div>
</div>-->
<div class="overlay"></div>
<div id="layer_passwd">
</div>
<div id="ok_passwd">
</div>
<script>
    function img_change() {
        $("#imgs").attr("src","/SpamCode.php?img="+new Date().getTime()); // show response from the php script.
    }
    function reply_layer(no) {
        var url = "reply_passwd.php"; // the script where you handle the form input.
        $(".overlay" ).show();
        $("#layer_passwd" ).show();
         overlays_view("overlay","layer_passwd");
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no, // serializes the form's elements.
            success: function (data) {
                $("#layer_passwd").html(data); // show response from the php script.
                console.log(data);

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });

       /* */
    }
    function reply_del(no) {

        var url = "reply_passwd_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&passwd=" + $("#passwd").val() + "&<?=$basic_url?>&board=view", // serializes the form's elements.
            success: function (data) {
                $("#ok_passwd").html(data);

            },
            beforeSend: function () {

            },
            complete: function () {
                if ($("#pwd").val() == "OK") {
                    reply_delete(no);
                  //  window.location.reload();
                } else {
                    alert("비밀번호가 틀렸습니다. 다시확인해주세요");
                    return false;
                }
            }
        });

    }
    function passwd_process() {
        var url = "board_passwd_process.php"; // the script where you handle the form input.
        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else {
            $.ajax({
                type: "POST",
                url: url,
                data: "no=<?=$no?>&passwd=" + $("#passwd").val() + "&<?=$basic_url?>&board=list", // serializes the form's elements.
                success: function (data) {
                    $("#ok_passwd").html(data);
                    if ($("#pwd").val() == "OK") {
                        var url = "/board/board_real_process.php"; // the script where you handle the form input.

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: "no=<?=$no?>&old_file=<?=$row['files']?>&board_table=<?=$table?>&case=delete", // serializes the form's elements.
                            success: function (data) {
                                console.log(data); // show response from the php script.
                            },
                            beforeSend: function () {
                                wrapWindowByMask();
                            },
                            complete: function () {
                                closeWindowByMask();
                                window.location.href = "<?=$url_list?>";
                            }
                        });

                    } else {
                        alert("비밀번호가 틀렸습니다. 다시확인해주세요");
                        return false;
                    }
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });

        }

    }
    $(document).ready(function(){
        $("#reply_btn").click(function () {
            var url = "/board/board_real_process.php"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#board_reply").serialize()+"&case=reply_insert", // serializes the form's elements.
                success: function (data) {
                    $("#err").html(data);
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                    console.log($("#er_code").val());
                    if($("#er_code").val() == "wrong"){
                        alert("스팸코드가 일치하지 않습니다. 확인해주세요");
                        $("#imgs").attr("src","/SpamCode.php?img="+new Date().getTime());
                        return;
                    }else{
                      //  window.location.reload();
                    }
                }
            });
        });
        $("#delete_btn").click(function () {
            $(".overlay" ).show();
            $(".layer_passwd" ).show();
            overlays_view("overlay","layer_passwd");
            var url = "passwd.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: "no=<?=$no?>", // serializes the form's elements.
                success: function (data) {
                    $("#layer_passwd").html(data); // show response from the php script.
                    // console.log(data);
                },
                beforeSend: function () {

                },
                complete: function () {

                }
            });
        });
        $("#list_btn").click(function () {
            window.location.href = "<?=$url_list?>";
        });
        $("#update_btn").click(function () {

            window.location.href = "<?=$url_mod?>&no=<?=$no?>&board=modify";
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_passwd")
            $(".layer_passwd" ).hide();
            $(".passwd" ).hide();

        });

    });
    function reply_delete(no) {
        var url = "/board/board_real_process.php"; // the script where you handle the form input.
        if(confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        }else {
            $.ajax({
                type: "POST",
                url: url,
                data: "no=" + no + "&adm=" + $("#adm").val() + "&case=reply_delete", // serializes the form's elements.
                success: function (data) {
                    console.log(data); // show response from the php script.
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
    }

</script>