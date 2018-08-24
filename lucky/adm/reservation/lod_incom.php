<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];
$reserv_lod_no = $_REQUEST['reserv_lod_no'];
$main = new main();
$main_company =  $main->tour_config();

$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$res->res_no = $no;
$lod = $res->sms_tel($reserv_lod_no);

?>
<style type="text/css">
    <!--
    .style1 {
        font-size: 35px;
        font-weight: bold;
    }
    .style3 {
        font-size: 18px;
        font-weight: bold;
    }
    .style4 {
        font-size: 18px;
        font-weight: bold;
    }
    .style6 {font-size: 24px;font-weight: bold;}
    -->
</style>

<table width="574" border="0" align="center">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><div align="center" class="style1">객실예약신청서</div></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><span class="style3">◎ 여행사명 : <?=$main_company['tour_name']?> </span></td>
    </tr>
    <tr>
        <td colspan="2"><span class="style3">◎ TEL : <?=$main_company['tour_phone']?>/FAX : <?=$main_company['tour_fax']?></span></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><span class="style3">◆ 예약내용 </span></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="574" border="1" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="150" height="39"><div align="center">고객정보</div></td>
        <td width="377">&nbsp;<strong><?=$row['reserv_name']?></strong> / <strong><?=$row['reserv_phone']?></strong></td>
    </tr>
    <tr>
        <td height="43"><div align="center">숙소명</div></td>
        <td>&nbsp;<strong><?=$lod['reserv_tel_name']?></strong></td>
    </tr>
    <tr>
        <td height="43"><div align="center">객실/객실수</div></td>
        <td>&nbsp;<strong><?=$lod['reserv_tel_room_name']?></strong> / <strong><?=$lod['reserv_tel_few']?>객실</strong></td>
    </tr>
    <tr>
        <td height="46"><div align="center">입실일/박수</div></td>
        <td>&nbsp;<strong><?=$lod['reserv_tel_date']?></strong> / <strong><?=$lod['reserv_tel_stay']?>박</strong></td>
    </tr>
    <tr>
        <td height="108"><div align="center">비고</div></td>
        <td><textarea name="text" cols="52" rows="6" style="border:0;OVERFLOW-Y: hidden;"><?=$row['reserv_tel_bigo']?></textarea></td>
    </tr>
</table>
<table width="574" border="0" align="center">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><div align="center"><span class="style4"><?=date("Y년m월d일",time())?></span></div></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><div align="center"><strong><span class="style6"><?=$main_company['tour_name']?></span></strong></div></td>
    </tr>
</table>
<table width="474" border="0">
    <tr>
        <td colspan="2"><font color="#FFFFFF"><a href="javascript:window.print()">인쇄하기</a></font></td>
    </tr>
</table>

