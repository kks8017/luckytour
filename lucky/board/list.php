<?php
$board_set = new board();
$board_set->bd_no = $bd_no;
$sub = $_REQUEST['sub'];
$search = $_REQUEST['search'];
$user_id = $_REQUEST['user_id'];
$config = $board_set->board_config();
if($search!=""){
    if($sub=="author or subject"){
        $sch_sql = " and author like '%{$search}%' or subject like '%{$search}%'";
        $cnt_sql = " where author like '%{$search}%' or subject like '%{$search}%'";
    }else if($sub=="content or subject"){
        $sch_sql = " and content like '%{$search}%' or subject like '%{$search}%'";
        $cnt_sql = " where content like '%{$search}%' or subject like '%{$search}%'";
    }else {
        $sch_sql = " and {$sub} like '%{$search}%'";
        $cnt_sql = " where {$sub} like '%{$search}%'";
    }
}

if($user_id){
    $sql_id = "and id='{$user_id}'";
}else{
    $sql_id = "";
}

$sql_cnt = "select count(no) as total from {$table} {$cnt_sql}";
//echo $sql_cnt;
$rs_cnt  = $db->sql_query($sql_cnt);
$row_cnt = $db->fetch_array($rs_cnt);

$total = $row_cnt['total']; // 전체글수

$total_page = ceil ($total / $page_set); // 총페이지수(올림함수)
$total_block = ceil ($total_page / $block_set); // 총블럭수(올림함수)

if (!$page) $page = 1; // 현재페이지(넘어온값)
$block = ceil ($page / $block_set); // 현재블럭(올림함수)

$limit_idx = ($page - 1) * $page_set; // limit시작위치



$sql = "select * from {$table} where notice!='Y' {$sch_sql} {$sql_id} order by no desc limit {$limit_idx},{$page_set}";
$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result[] = $row;
}
$sql_notice = "select * from {$table} where notice='Y' {$sql_id}";

$rs_notice  = $db->sql_query($sql_notice);
while ($row_notice = $db->fetch_array($rs_notice)){
    $result_notice[] = $row_notice;
}
if($search!="") {
    $search_url = "&search=" . $search . "&sub=" . $sub;
}else{
    $search_url = "";
}

$realurl = $_SERVER['REQUEST_URI'];
$tmpurl  = explode("?",$realurl);
$tmpurl2 = explode("&",$tmpurl[1]);

if($_SESSION["member_id"]!="") {
  $adm_url = "linkpage={$linkpage}&";
}else{
  $adm_url = "";
}

$basic_url = "bd_no={$bd_no}&board_table={$bd_id}";
$url = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url;


$board_set->basic_url = $basic_url;
$board_set->sch_url = $search_url;
$board_set->adm_url = $adm_url;


?>

    <div class="rcon">
        <p><?=$config['bd_name']?></p><p>새로운 소식과 공지사항을 알려드립니다.</p>
        <div class="search">
            <form id="sch_frm" method="post" action="<? echo $_SERVER['PHP_SELF']."?".$adm_url.$basic_url."&board=list";?>">
                <select class="lsel" name="sub">
                    <option value="subject" <?if($sub=="subject"){?>selected<?}?>>제목</option>
                    <option value="content" <?if($sub=="content"){?>selected<?}?>>내용</option>
                    <option value="author" <?if($sub=="author"){?>selected<?}?>>글쓴이</option>
                    <option value="author or subject" <?if($sub=="author or subject"){?>selected<?}?>>제목+글쓴이</option>
                    <option value="content or subject" <?if($sub=="content or subject"){?>selected<?}?>>제목+내용</option>
                </select>
                <input type="text" name="search" value="<?=$search?>" />
                <img type="button" src="../sub_img/small_search_btn.png" style="cursor: pointer;" id="search_btn" />
            </form>
        </div>
        <div class="tbl_wrap">
            <form id="list_frm" method="post" action="../board/board_real_process.php">
            <table>
                <tr>
                    <?if($_SESSION["member_id"]!="") {?>
                    <th class="sele">선택</th>
                    <?}?>
                    <th class="no">차례</th><th class="subject">제목</th><th class="author">글쓴이</th><th class="date">등록일</th><th class="count">조회</th>
                    <?if($config['bd_cou']=="Y"){?>
                    <th class="re">답변</th>
                    <?}?>
                </tr>
                <?php
                $i=0;
                if(is_array($result_notice)) {
                    foreach ($result_notice as $data) {
                ?>
                <tr class="ntc_bg"  <?
                if ($_SESSION["member_id"] == "") { ?> colspan="4" <?
                    }else{
                    ?> colspan="5"<?
                } ?>>
                    <td><img src="../sub_img/icon_notic.png" /></td><td  class="ntc"><a href="<?= $url ?>&no=<?= $data['no'] ?>&board=view<?= $search_url ?>"><?= $data['subject'] ?></a></td>
                </tr>
                        <?php
                        $i++;
                    }
                }
                $i=0;
                if(is_array($result)) {
                foreach ($result as $data){
                if($data['secret']=="Y"){$secret="<img src='../sub_img/icon_lock.png' />";}else{$secret="";}
                    $board_set->bd_no = $bd_no;
                    $board_set->sub_no = $data['no'];
                    $reply_cnt = $board_set->board_reply_cnt();
                    if($reply_cnt >0){ $reply = "답변완료";}else{$reply = "답변대기";}
                ?>
                <tr>
                    <?if($_SESSION["member_id"]!="") {?>
                     <td><input type="checkbox" name="sel[]" value="<?=$i?>"><input type="hidden" name="no[]"  value="<?=$data['no']?>"></td>
                    <?}?>
                    <td class="ntc"><?=$data['no']?></td>
                    <?if($data['secret']!="Y" ){?>
                      <td  class="ntc"><a href="<?=$url?>&no=<?=$data['no']?>&board=view<?=$search_url?>"><?=$data['subject']?><?=$secret?></a></td>
                    <?}else{?>
                         <?if($_SESSION["member_id"]!="") {?>
                             <td  class="ntc"><a href="<?=$url?>&no=<?=$data['no']?>&board=view<?=$search_url?>"><?=$data['subject']?><?=$secret?></a></td>
                         <?}else{?>
                             <td  class="ntc"><a href="javascript:passwd_pop('<?=$data['no']?>');"><?=$data['subject']?><?=$secret?></a></td>
                         <?}?>

                    <?}?>
                    <td><?=$data['author']?></td>
                    <td><?=substr($data['indate'],0,10)?></td>
                    <td><?=$data['hits']?></td>
                    <?if($config['bd_cou']=="Y"){?>
                      <td><?=$reply?></td>
                    <?}?>
                </tr>
                    <?php
                    $i++;
                }
                }else{
                ?>
                    <tr>
                        <?if($_SESSION["member_id"]!="") {?>
                            <td colspan="7" align="center"><p>등록된 정보가 없습니다.</p></td>
                        <?}else{?>
                            <td colspan="7" align="center"><p>등록된 정보가 없습니다.</p></td>
                        <?}?>
                    </tr>
                <?}?>
            </table>
                <input type="hidden" name="table" value="<?=$table?>">
                <input type="hidden" name="adm" value="admin">
                <input type="hidden" name="case" value="all_delete">
            </form>
        </div>
        <?if($_SESSION["member_id"]!="") {?>
            <p class="write"><img type="button" id="del_btn" src="../sub_img/sel_del.gif" /> <img type="button" src="../sub_img/write_btn.png" id="add_btn" /></p>
        <?}else{?>
            <?if($config['bd_write']=="Y") {?>
                <p class="write"><img type="button" src="../sub_img/write_btn.png" id="add_btn" /></p>
            <?}?>
        <?}?>

        <div class="paging">
            <?php
            $board_set->page = $page;
            $board_set->block = $block;
            $board_set->block_set = $block_set;
            $board_set->total_block = $total_block;
            $board_set->total_page =  $total_page;

            $board_set->pageing();
            ?>
        </div>
    </div>
<div class="overlay"></div>
<div id="layer_passwd">
</div>
<div id="ok_passwd">
</div>

<script>
    function passwd_pop(no) {
        $(".overlay" ).show();
        $(".layer_passwd" ).show();
        $(".passwd" ).show();
        overlays_view("overlay","layer_passwd");
        var url = "passwd.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no, // serializes the form's elements.
            success: function (data) {
                $("#layer_passwd").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function passwd_process(no) {
        var url = "board_passwd_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no +"&passwd="+$("#passwd").val()+"&<?=$basic_url?>&board=list", // serializes the form's elements.
            success: function (data) {
                $("#ok_passwd").html(data);
              if($("#pwd").val() == "OK"){
                  window.location.href = "<?=$url?>&no=<?=$data['no']?>&board=view<?=$search_url?>";
              }else{
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

    $(document).ready(function () {
        $(".overlay").click(function () {
            overlays_close("overlay","layer_passwd")
            $(".layer_passwd" ).hide();
            $(".passwd" ).hide();

        });

        $("#add_btn").click(function () {
            window.location.href = "<?=$url?>&board=write";
        });
        $("#del_btn").click(function () {
            if(confirm("정말삭제 하시겠습니다?") == false) {

            }else{
                $("#list_frm").submit();
            }
        });
        $("#search_btn").click(function () {
             $("#sch_frm").submit();
        });
    });
</script>