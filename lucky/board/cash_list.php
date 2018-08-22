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

$sql_cnt = "select count(no) as total from cash {$cnt_sql}";
//echo $sql_cnt;
$rs_cnt  = $db->sql_query($sql_cnt);
$row_cnt = $db->fetch_array($rs_cnt);

$total = $row_cnt['total']; // 전체글수

$total_page = ceil ($total / $page_set); // 총페이지수(올림함수)
$total_block = ceil ($total_page / $block_set); // 총블럭수(올림함수)

if (!$page) $page = 1; // 현재페이지(넘어온값)
$block = ceil ($page / $block_set); // 현재블럭(올림함수)

$limit_idx = ($page - 1) * $page_set; // limit시작위치



$sql = "select * from cash {$cnt_sql}  order by no desc limit {$limit_idx},{$page_set}";
$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result[] = $row;
}

$basic_url = "bd_no={$bd_no}&board_table={$bd_id}";
$url = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url;

?>

<div class="rcon">
    <p>현금영수증</p><p>현금영수증 신청란입니다.</p>
    <div class="search">
        <form id="sch_frm" method="post" action="<? echo $_SERVER['PHP_SELF']."?".$adm_url.$basic_url."&board=cash";?>">
            <select class="lsel" name="sub">
                <option value="name" <?if($sub=="name"){?>selected<?}?>>신청인</option>
            </select>
            <input type="text" name="search" value="<?=$search?>" />
            <img type="button" src="../sub_img/small_search_btn.png" style="cursor: pointer;" id="search_btn" />
        </form>
    </div>
    <div class="tbl_wrap">
        <table>
          <tr>
              <th class="no">차례</th><th class="subject">제목</th><th class="author">신청인</th><th class="date">신청일</th><th class="count">상태</th>
          </tr>
            <?php

            $i=0;
            if(is_array($result)) {
                foreach ($result as $data){
             ?>
                    <tr>
                       <td><?=$data['no']?></td>
                        <td  class="ntc"><?=$data['cash_subject']?></td>
                        <td><?=$data['cash_name']?></td>
                        <td><?=substr($data['indate'],0,10)?></td>
                        <td><?=$data['state']?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }else{
                ?>
                <tr>

                   <td colspan="5" align="center"><p>등록된 정보가 없습니다.</p></td>

                </tr>
            <?}?>
        </table>
    </div>
    <p class="write"><img type="button" src="../sub_img/write_btn.png" id="add_btn" /></p>
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
<script>


    $(document).ready(function () {

        $("#add_btn").click(function () {
            window.location.href = "<?=$url?>&board=cash_write";
        });
        $("#search_btn").click(function () {
            $("#sch_frm").submit();
        });
    });
</script>