<?php
$no = $_GET['no'];
$sql = "select * from tour_config where tour_com_no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

?>
<div id="basic">
    <p class="title">기본설정</p>
    <div>
        <form id="config_frm">
         <table class="basic_config">
             <tr>
                 <td>시작일 설정</td>
                 <td><input type="text" name="start_date" id="start_date" value="<?=$row['start_date']?>" class="d_box"></td>
             </tr>
             <tr>
                 <td>회원가입 설정</td>
                 <td><input type="radio" name="join_type" value="Y" <?if($row['tour_member_type']=="Y"){?>checked<?}?> >사용 <input type="radio" name="join_type" value="N" <?if($row['tour_member_type']=="N"){?>checked<?}?>>미사용</td>
             </tr>
             <tr>
                 <td>카드결제 설정</td>
                 <td><input type="radio" name="card_type" value="Y" <?if($row['tour_card']=="Y"){?>checked<?}?>>사용 <input type="radio" name="card_type" value="N" <?if($row['tour_card']=="N"){?>checked<?}?>>미사용</td>
             </tr>
             <tr>
                 <td>자유패키지 설정</td>
                 <td><input type="radio" name="free_type" value="A" <?if($row[
                     'tour_type']=="A"){?>checked<?}?>>항공(자유패키지 예약시 항공 먼저 표시됩니다) <input type="radio" name="free_type" value="T" <?if($row[
                     'tour_type']=="T"){?>checked<?}?>>숙소(자유패키지 예약시 숙소 먼저 표시됩니다)</td>
             </tr>
             <tr>
                 <td>항공지역 설정</td>
                 <td><input type="text" name="air_area" id="air_area" class="a_box" value="<?=$row['tour_air_area']?>" ></td>
             </tr>

             <tr>
                 <td>숙소지역권 설정</td>
                 <td><input type="text" name="tel_area" id="tel_area" class="t_box"  value="<?=$row['tour_tel_code']?>" ></td>
             </tr>
             <tr>
                 <td>숙소타입 설정</td>
                 <td><input type="text" name="tel_type" id="tel_type" class="t_box"  value="<?=$row['tour_tel_type_code']?>" ></td>
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

            $.post("basic_process.php",
                {
                    start_date:$("#start_date").val(),
                    join_type: $(':radio[name="join_type"]:checked').val(),
                    card_type:$(':radio[name="card_type"]:checked').val(),
                    free_type:$(':radio[name="free_type"]:checked').val(),
                    air_area:$("#air_area").val(),
                    car_type:$("#car_type").val(),
                    fuel_type:$("#fuel_type").val(),
                    tel_area:$("#tel_area").val(),
                    tel_type:$("#tel_type").val(),
                    rent_option :$("#rent_option").val(),
                    no:"<?=$no?>",
                    case : "update"
                },
                function(data,status){
                    alert("기본정보를 변경하셨습니다.");
                    closeWindowByMask();
                    window.location.reload();
             });
          });
    });
    $( function() {
        $( "#start_date" ).datepicker({
            dateFormat : "yy-mm-dd",
        });

    } );
</script>