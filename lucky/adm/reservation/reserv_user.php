<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['reserv_user_no'];
$sql = "select * from reservation_user_content where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);
$main = new main();
?>
<script>
    function sms_send(type) {
        window.open("../SMS/mms.php?reserv_no=<?=$no?>&c="+type,"sms","width=254,height=460");
    }
</script>
<header><p>고객정보 <img type="button" src="../image/upd_btn.png" onclick="user_update();" style="cursor: pointer;vertical-align: middle;"/></p></header>
<table style="width:100%">
    <tr>
        <th ><span>예약자명</span></th>
        <td><input type="text" class="txt" name="reserv_name" id="reserv_name" value="<?=$row['reserv_name']?>"></td>
        <th><span>연락처</span></th>
        <td><input type="text" class="txt" name="reserv_phone" id="reserv_phone"  value="<?=$row['reserv_phone']?>"></td>
    </tr>
    <?if($row['reserv_group']=="Y"){?>
        <tr>
            <th ><span>단체명</span></th>
            <td><input type="text" class="txt" name="reserv_group_name" id="reserv_group_name" value="<?=$row['reserv_group_name']?>"></td>
            <th><span>팩스</span></th>
            <td><input type="text" class="txt" name="reserv_fax" id="reserv_fax"  value="<?=$row['reserv_fax']?>"></td>
        </tr>
        <tr>
            <th ><span>연락가능시간</span></th>
            <td><input type="text" class="txt" name="reserv_time" id="reserv_time" value="<?=$row['reserv_time']?>"></td>
            <th><span>상담방법</span></th>
            <td><input type="radio"  name="reserv_counsel"   value="전화" <?if($row['reserv_counsel']=="전화"){?>checked<?}?>>전화 <input type="radio"  name="reserv_counsel"   value="이메일" <?if($row['reserv_counsel']=="이메일"){?>checked<?}?>>이메일</td>
        </tr>
        <tr>
            <th ><span>출발지</span></th>
            <td colspan="3" ><input type="text" class="txt" name="reserv_departure_area" id="reserv_departure_area" value="<?=$row['reserv_departure_area']?>"></td>
        </tr>

    <?}?>
    <tr>
        <th class="title"><span>사용자명</span></th>
        <td><input type="text" name="reserv_real_name" class="txt" id="reserv_real_name" value="<?=$row['reserv_real_name']?>"></td>
        <th class="title"><span>사용자연락처</span></th>
        <td><input type="text" name="reserv_real_phone" class="txt" id="reserv_real_phone" value="<?=$row['reserv_real_phone']?>"></td>
    </tr>
    <tr>
        <th ><span>이메일</span></th>
        <td colspan="3" class="mail"><input type="text" class="mail"  name="reserv_email" id="reserv_email" value="<?=$row['reserv_email']?>" ></td>
    </tr>

    <tr>
        <th ><span>여행인원</span></th>
        <td colspan="3"><span class="person"><select name="reserv_adult_number" >
                                                        <?php
                                                        $main->number_option($row['reserv_adult_number'],"성인");
                                                        ?>
                                                        </select>
                                                <?if($row['reserv_group']=="Y"){?>
                                                <select name="reserv_young_number" >
                                                        <?php
                                                        $main->number_option($row['reserv_young_number'],"청소년");
                                                        ?>
                                                        </select>
                                                  <?}?>          
                                                   <select name="reserv_child_number" >
                                                        <?php
                                                        $main->number_option($row['reserv_child_number'],"소아");
                                                        ?>
                                                        </select>
                                                  <select name="reserv_baby_number" >
                                                        <?php
                                                        $main->number_option($row['reserv_baby_number'],"유아");
                                                        ?>
                                                        </select>
                </span></td>
    </tr>
    <tr>
        <th ><span>문자발송</span></th>
        <td colspan="3"><img type="button" src="../image/res_ok.gif" style="cursor: pointer;vertical-align: middle;" onclick="sms_send('res_ok')" /> <img type="button" src="../image/no_call.gif" style="cursor: pointer;vertical-align: middle;" onclick="sms_send('absence')" /> <img type="button" src="../image/cancel_sms.gif" style="cursor: pointer;vertical-align: middle;" onclick="sms_send('cancel')" /> <img type="button" src="../image/person_chk.gif" style="cursor: pointer;vertical-align: middle;" onclick="sms_send('person')" /></td>
    </tr>
    <tr>
        <th ><span>문의사항</span></th>
        <td colspan="3"><textarea  ><?=$row['reserv_inquiry']?></textarea></td>
    </tr>

</table>
<script>
    function phone_chk(str){
        str = str.replace(/[^0-9]/g, '');
        var tmp = '';
        if( str.length < 4){
            return str;
        }else if(str.length < 7){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3);
            return tmp;
        }else if(str.length < 11){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 3);
            tmp += '-';
            tmp += str.substr(6);
            return tmp;
        }else{
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 4);
            tmp += '-';
            tmp += str.substr(7);
            return tmp;
        }
        return str;
    }

    var phone = document.getElementById('reserv_phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }
    var phone = document.getElementById('reserv_real_phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }
</script>