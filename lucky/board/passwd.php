<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
?>
<div class="header">
    비밀번호 확인
    <!--<div class="b-close">X</div>-->
</div>
<div class="popupContent">

        <input type="password" name="passwd" id="passwd"><img type="button" src="../sub_img/psw_search_btn.png" style="cursor: pointer;" onclick="passwd_process('<?=$no?>');"/>

</div>
<!--
<div  class="layer_passwd">
    <table class="passwd">
        <tr>
            <td>비밀번호</td>
            <td><input type="password" name="passwd" id="passwd"><input type="button" value="확인" onclick="passwd_process('<?=$no?>');"> </td>
        </tr>
    </table>
</div>-->