<?php
$realurl = $_SERVER['REQUEST_URI'];
$tmpurl  = explode("?",$realurl);
$tmpurl2 = explode("&",$tmpurl[1]);
if($_SESSION["member_id"]!="") {
    $adm_url = "linkpage={$linkpage}&";
}else{
    $adm_url = "";
}
$basic_url = "bd_no={$bd_no}&board_table={$bd_id}";
$url_list = $_SERVER['PHP_SELF'] . "?".$adm_url.$basic_url. "&board=list";

$board_set = new board();
$board_set->bd_no = $bd_no;
$config = $board_set->board_config();
$member = new member();
if($_SESSION['user_id']) {
    $member->user_id = $_SESSION['user_id'];
    $info = $member->user_info();
}

?>
<form id="cash_frm" action="cash_process.php" method="post">
    <div class="rcon">
        <p>현금영수정 신청</p>

        <div class="tbl_wrap">

                <table>
                    <tr>
                        <th>신청인</th>
                        <td><input type="text" name="name" id="name" onclick="name_search();" /></td>
                    </tr>
                    <tr>
                        <th>발급종류</th>
                        <td><input type="radio" name="use" value="개인" checked><span>개인</span> <input type="radio" name="use" value="사업자"><span>사업자</span> </td>
                    </tr>
                    <tr>
                        <th>발급번호</th>
                        <!-- 에디터 비워둠 -->
                        <td><input type="text" name="phone" value=""></td>
                    </tr>
                </table>
                <p class="submit"><input type="button" class="btn"  value="신청" onclick="board_write();" /> <input class="btn" type="button" id="list_btn"   value="목록으로"  /></p>

        </div>
    </div>

    <input type="hidden" name="board_table" id="board_table" value="<?=$table?>">
    <input type="hidden" name="reserv_no" id="reserv_no" value="">
</form>
<div id="err" style="display: none;">

</div>
<script>
    function name_search() {
        window.open("name_search.php","res_name","width=520,height=360");
    }
    $(document).ready(function(){
        $("#list_btn").click(function () {
            window.location.href = "<?=$url_list?>";
        });
    });


    function board_write() {
            $("#cash_frm").submit();
    }
</script>
