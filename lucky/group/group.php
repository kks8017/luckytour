<?php include_once ("../header.sub.php");?>
<?php
$main = new main();
$tour_air_area = explode(",",$main_company['tour_air_area']);
?>
    <link rel="stylesheet" href="../css/group_tour.css" />
<div id="content">
    <div class="search">
        <div class="search_tit">
            <span class="bar mar"></span>
            <h3>단체여행문의</h3>
            <span class="bar"></span>
        </div>
    </div>

    <div class="group_tour">
        <form id="group_frm" action="group_process.php" method="post">
            <table>
                <tr>
                    <th class="person">성함</th><td class="data"><input type="text" name="name" id="name" /></td>
                    <th class="person">이메일</th><td class="data"><input type="text" name="email" /></td>
                </tr>
                <tr>
                    <th class="person">연락처</th><td class="data"><input type="text" name="phone" id="phone" /></td>
                    <th class="person">연락가능시간</th><td class="data"><input type="text" name="time" /></td>
                </tr>
                <tr>
                    <th class="person">팩스</th><td class="data"><input type="text" name="fax"  /></td>
                    <th class="person">상담방법</th><td class="data">
                        <input type="radio" name="advice" value="전화" checked="checked"/>전화
                        <input type="radio" name="advice" value="이메일" />이메일
                    </td>
                </tr>
                <tr>
                    <th class="cont">단체종류</th>
                    <td colspan="3" class="data">
                        <select name="group" class="ssel">
                            <option value="일반단체(친목등)">일반단체(친목등)</option>
                            <option value="학생단체(졸업여행)">학생단체(졸업여행)</option>
                            <option value="기업연수/세미나">기업연수/세미나</option>
                            <option value="워크샵">워크샵</option>
                            <option value="기타">기타</option>
                        </select>
                        <input type="text" name="group_detail" /> <span class="ex">(예 : OO  대학교 / OO친목계 등)</span>
                    </td>
                </tr>
                <tr>
                    <th class="cont">여행인원</th>
                    <td colspan="3" class="data">
                        <span class="b">성인</span> <input type="text" name="adult_number" class="inwon"/>명,&nbsp;&nbsp;<span class="b">중고생</span> <input type="text" name="yong_number" class="inwon"/>명,&nbsp;&nbsp;&nbsp;&nbsp;<span class="b">소아</span>
                        <input type="text" name="child_number" class="inwon"/>명,&nbsp;&nbsp;
                        <span class="b">유아</span> <input type="text" name="baby_number" class="inwon"/>명&nbsp;&nbsp;<span class="ex">만24세미만</span>
                    </td>
                </tr>
                <tr>
                    <th class="cont">여행일정</th>
                    <td colspan="3" class="data">
                        <select name="area" class="sel">
                            <?php
                            foreach ($tour_air_area as $area){
                                $area_name = explode("|",$area);
                                if($area_name[0]=="김포"){$sel="selected";}else{$sel="";}
                                echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}출발</option>";
                            }
                            ?>
                        </select>
                        <select name="start_year"  class="sel">
                            <?php
                                $main->year_option(date("Y",time()));
                            ?>
                        </select>
                        <select name="start_month" class="sel">
                            <?php
                                $main->month_option(date("m",time()));
                            ?>
                        </select>
                        <select name="start_day"  class="sel">
                            <?php
                                $main->day_option(date("d",time()));
                            ?>
                        </select>부터
                        <select  name="start_stay" class="sel">
                            <?php

                                $main->stay_option();
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th class="cont">기타요청사항</th>
                    <td colspan="3" class="data"><textarea name="inquiry"></textarea></td>
                </tr>
                <tr>
                    <th class="cont">취소수수료</th>
                    <td colspan="3" class="data">
                        <div style="width:1040px;height:200px;overflow-y: scroll;"><?=$main_company['tour_cancel']?></div>
                        <div style="margin-top: 10px;margin-bottom: 10px;text-align: center;font-size: 14px;"><input type="radio" name="cancel" value="Y">동의합니다  &nbsp;&nbsp;&nbsp; <input type="radio" name="cancel" value="N" checked>동의하지않습니다 </div>
                    </td>
                </tr>
                <tr>
                    <th class="cont">개인정보취급방침</th>
                    <td colspan="3" class="data">
                        <div style="width:1040px;height:200px;overflow-y: scroll;"><?=$main_company['tour_privacy']?></div>
                        <div style="margin-top: 10px;margin-bottom: 10px;text-align: center;font-size: 14px;"><input type="radio" name="privacy" value="Y">동의합니다  <input type="radio" name="privacy" value="N" checked>동의하지않습니다 </div>
                    </td>
                </tr>
                <tr>
                    <td><img type="button" id="submit_btn"  src="../sub_img/request_btn.png" style="cursor: pointer;"  /></td>
                </tr>
            </table>
        </form>
    </div><!-- group_tour 끝 -->


</div><!-- content 끝 -->
<script>
    $("#submit_btn").click(function () {
        if($("#name").val() ==""){
            alert("이름을 넣어주세요");
            return false;
        }else if($("#phone").val()==""){
            alert("연락처를 넣어주세요");
            return false;
        }else if($(":radio[name='cancel']:checked").val()=="N"){
            alert("취소 및 환불규정에 동의를 하셨야지만 접수가 가능합니다.");
            return false;
        }else if($(":radio[name='privacy']:checked").val()=="N"){
            alert("개인정보취급방침에 동의를 하셨야지만 접수가 가능합니다.");
            return false;
        }else{
            $("#group_frm").submit();
        }

    });
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

    var phone = document.getElementById('phone');
    phone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = phone_chk(_val) ;
    }
</script>
<?php include_once ("../footer.php");?>