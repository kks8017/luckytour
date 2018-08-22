<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['reserv_user_no'];
$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);
?>
<table>
    <tr>
        <td colspan="4">고객 정보 <input type="button" value="수정" onclick="user_update();"></td>
    </tr>
    <tr>
        <td class="title">예약자명</td>
        <td><input type="text" name="reserv_name" value="<?=$row['reserv_name']?>"></td>
        <td class="title">연락처</td>
        <td><input type="text" name="reserv_phone" value="<?=$row['reserv_phone']?>"></td>
    </tr>
    <tr>
        <td class="title">이메일</td>
        <td colspan="3"><input type="text" name="reserv_email" value="<?=$row['reserv_email']?>"></td>
    </tr>
    <tr>
        <td class="title">사용자명</td>
        <td><input type="text" name="reserv_real_name" value="<?=$row['reserv_real_name']?>"></td>
        <td class="title">사용자연락처</td>
        <td><input type="text" name="reserv_real_phone" value="<?=$row['reserv_real_phone']?>"></td>
    </tr>
    <tr>
        <td class="title">여행인원</td>
        <td colspan="3">성인 : <input type="text" name="reserv_adult_number" size="3" value="<?=$row['reserv_adult_number']?>"> 소아 : <input type="text" name="reserv_child_number" size="3" value="<?=$row['reserv_child_number']?>"> 유아 : <input type="text" name="reserv_baby_number" size="3" value="<?=$row['reserv_baby_number']?>"></td>
    </tr>
    <tr>
        <td class="title">성인명단</td>
        <td colspan="3"><textarea name="reserv_adult_list" rows="3" cols="60"><?=$row['reserv_adult_list']?></textarea></td>
    </tr>
    <tr>
        <td class="title">소아명단</td>
        <td colspan="3"><textarea name="reserv_child_list" rows="3" cols="60"><?=$row['reserv_child_list']?></textarea></td>
    </tr>
    <tr>
        <td class="title">유아명단</td>
        <td colspan="3"><textarea name="reserv_baby_list" rows="3" cols="60"><?=$row['reserv_baby_list']?></textarea></td>
    </tr>
    <tr>
        <td class="title">문의사항</td>
        <td colspan="3"><textarea name="reserv_inquiry" rows="3" cols="60"><?=$row['reserv_inquiry']?></textarea></td>
    </tr>
</table>