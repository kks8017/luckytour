<?php
$tel = new lodging();
$rent = new rent();

$sql = "select * from best_list  order by best_sort asc ";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
$main_com_no  = get_rentcar_company("","대표");
$rent->comno = $main_com_no[0];
$rent_list = $rent->rent_list();

$image_dir = "/".KS_DATA_DIR."/".KS_BEST_DIR;
?>
<div style="margin-top: 20px;">
    <div>
        <p class="del_btn">베스트상품</p>
        <p class="del_btn"><img src="./image/sel_mod.gif"  id="update_btn" style="cursor: pointer;" /><img src="./image/sel_del.gif"  id="delete_btn" style="cursor: pointer;" /><input type="button" id="best_btn" value="상품등록"></p>
        <table class="tbl">
            <tr>
                <th><input type="checkbox" id="allsel"></th>
                <th>순번</th>
                <th>사진</th>
                <th>숙소/차량선택</th>
                <th>항공선택</th>
                <th>이벤트문구</th>
            </tr>
            <form id="best_up_frm"  enctype="multipart/form-data">
            <?php
            $i=0;
            if(is_array($result_list)) {
            foreach ($result_list as $data){

            ?>

            <tr>
                <td class="con"> <input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                <td class="con"><input type="text" name="best_sort[]" size="3" value="<?=$data['best_sort']?>"></td>
                <td class="con">  <img src="<?=$image_dir?>/<?=$data['best_img']?>" width="80" height="50"><input type="hidden" name="old_photo[]" value="<?=$data['best_img']?>">
                    <br><input type="file" name="photo[]"></td>
                <td class="con">
                    <select style="width: 250px;" name="tel_no_<?=$i?>" id="tel_no_<?=$i?>" onchange="room_list<?=$i?>()">
                        <option value="">숙소를선택하세요</option>
                        <?php
                        $tel_list = $tel->lodging_list();
                        foreach ($tel_list as $lod) {
                        ?>
                            <option value="<?=$lod['no']?>" <?if($lod['no']==$data['tel_no']){?>selected<?}?>><?=$lod['lodging_name']?></option>
                        <?
                        }
                        ?>
                    </select><br>
                    <select style="width: 250px;" name="room_no_<?=$i?>" id="room_no_<?=$i?>"></select>
                    <input type="hidden" id="roomno_<?=$i?>" value="<?=$data['room_no']?>">
                    <br>
                    <select style="width: 250px;" name="rent_no_<?=$i?>">
                        <option value="">렌트카를선택하세요</option>
                        <?php

                        foreach ($rent_list as $car){
                            if($car['no']==$data['rent_no']){$sel="selected";}else{$sel="";}
                            echo "<option value='{$car['no']}' {$sel} >{$car['rent_car_name']}</option>";
                        }
                        ?>
                    </select><br>
                    링크 <input type="text" size="30" name="best_link[]" value="<?=$data['best_link']?>">
                </td>
                <td class="con"><input type="radio" name="air_<?=$i?>" value="N" checked>항공선택안함<br><input type="radio" name="air_<?=$i?>" value="Y">항공선택</td>
                <td class="con">
                    상품명<input type="text" name="best_title[]" value="<?=$data['best_title']?>"><br>
                    이벤트<input type="text" name="best_event[]" value="<?=$data['best_event']?>"><br>
                    할인율<input type="text" size="3" name="best_sale[]" value="<?=$data['best_sale']?>">%<br>
                    판매 <input type="text" name="best_sale_amount[]" size="10" value="<?=$data['best_sale_amount']?>">원<br>
                    정상 <input type="text" name="best_normal_amount[]" size="10" value="<?=$data['best_normal_amount']?>">원
                </td>
            </tr>


                <script>
                    function room_list<?=$i?>(){

                        no = $("#tel_no_<?=$i?> option:selected").val();

                        $('#room_no_<?=$i?> option').remove();
                        $.post('best_room_list.php',{
                            "lodging_no":no
                        },function(oJson){
                            //	alert(oJson['query']);

                            console.log(oJson);
                                $.each(oJson,function(nIdx,item){

                                    if($("#roomno_<?=$i?>").val() ==item['no']){
                                        $("#room_no_<?=$i?>").append("<option  value="+item['no']+" selected >"+item['lodging_room_name']+"</option>");
                                    }else{
                                        $("#room_no_<?=$i?>").append("<option  value="+item['no']+">"+item['lodging_room_name']+"</option>");
                                    }
                                });


                        },'json');
                    }
                    room_list<?=$i?>();
                </script>

            <?php
                $i++;
            }
            }else{
                ?>
                <tr>
                    <td colspan="9" align="center"><p>등록된 정보가 없습니다.</p></td>
                </tr>
            <?}?>
                <input type="hidden" name="case" id="case" value="">
            </form>
        </table>
    </div>
</div>
<div class="overlay"></div>
<div id="layer_best">
    <div class="inbody">
        <form id="best_frm" enctype="multipart/form-data">
        <table class="conbox6">
            <tr>
                <td class="titbox">순번</td>
                <td><input type="text" name="best_sort" size="3" ></td>
            </tr>
            <tr>
                <td class="titbox">사진</td>
                <td><input type="file" name="photo"></td>
            </tr>
            <tr>
                <td class="titbox">숙소선택</td>
                <td>
                    <select  name="lodging_no" id="lodging_no" onchange="room_list();">
                        <option value="">숙소를선택하세요</option>
                        <?php
                        $tel_list = $tel->lodging_list();
                        foreach ($tel_list as $lod){

                            echo "<option value='{$lod['no']}' {$sel} >{$lod['lodging_name']}</option>";
                        }
                        ?>
                    </select><br>
                    <select name="room_no" id="room_no" class="room_no"></select>
                </td>
            </tr>
            <tr>
                <td class="titbox">렌트카선택</td>
                <td>
                    <select name="rent_no">
                        <option value="">렌트카를선택하세요</option>
                        <?php

                        foreach ($rent_list as $car){

                            echo "<option value='{$car['no']}' {$sel} >{$car['rent_car_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="titbox">항공</td>
                <td><input type="radio" name="air" value="N" checked>항공선택안함<br><input type="radio" name="air" value="Y">항공선택</td>
            </tr>
            <tr>
                <td class="titbox">링크</td>
                <td><input type="text" name="best_link" size="35"></td>
            </tr>
            <tr>
                <td class="titbox">제목</td>
                <td> <input type="text" name="best_title" id="best_title" size="35"></td>
            </tr>
            <tr>
                <td class="titbox">이벤트</td>
                <td> <input type="text" name="best_event" size="35"></td>
            </tr>
            <tr>
                <td class="titbox">가격</td>
                <td>
                    할인율<input type="text" size="3" name="best_sale" >%<br>
                    판매 <input type="text" name="best_sale_amount" size="10" >원<br>
                    정상 <input type="text" name="best_normal_amount" size="10" >원
                </td>
            </tr>
        </table>
         <table style="width: 100%;margin-top: 10px;">
            <tr>
                <td  align="center"><input type="submit" value="상품등록"></td>
            </tr>
         </table>
            <input type="hidden" name="case" value="insert">
        </form>
    </div>
</div>

<script>

    function room_list(){

        no = $("#lodging_no option:selected").val();
        $('#room_no option').remove();
        $.post('best_room_list.php',{
            "lodging_no":no
        },function(oJson){
            $.each(oJson,function(nIdx,item){
                console.log(item['lodging_room_name']);
                if($("#room_no").val() ==item['no']){
                    $("#room_no").append("<option  value="+item['no']+" selected >"+item['lodging_room_name']+"</option>");
                }else{
                    $("#room_no").append("<option  value="+item['no']+">"+item['lodging_room_name']+"</option>");
                }
            });


        },'json');
    }
    $(document).ready(function () {


        $("#allsel").click(function () {
            $("input[name='sel[]']").prop("checked", function () {
                return !$(this).prop("checked");
            });
        });
        $("#best_btn").click(function () {
            overlays_view("overlay","layer_best")
        });

        $(".overlay").click(function () {
            overlays_close("overlay","layer_best")
        });


        $("#delete_btn").click(function () {

            $("#case").val("delete");
            var url = "best_process.php"; // the script where you handle the form input.
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#best_up_frm").serialize(), // serializes the form's elements.
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
        });
        $("#update_btn").click(function () {


                $("#case").val("update");
                var url = "best_process.php"; // the script where you handle the form input.
                var form = $('#best_up_frm')[0];
                var fd = new FormData(form);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: fd,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        /* alert(data); if json obj. alert(JSON.stringify(data));*/
                    },
                    beforeSend: function () {
                        wrapWindowByMask();
                    },
                    complete: function () {
                        closeWindowByMask();
                       window.location.reload();
                    }
                });
        });

        $("#sch_btn").click(function () {
            $("#sch_frm").submit();
        });
        $("form#best_frm").submit(function(event) {
            var url = "best_process.php"; // the script where you handle the form input.
            if($("#best_title").val()==""){
                alert("베스트상품명를 입력해주세요");
                return false;
            }
            //disable the default form submission
            event.preventDefault();

            var fd = new FormData($(this)[0]);

            $.ajax({
                url: url,
                type: "POST",
                data: fd,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    /* alert(data); if json obj. alert(JSON.stringify(data));*/
                },
                beforeSend: function () {
                    wrapWindowByMask();
                },
                complete: function () {
                    closeWindowByMask();
                   window.location.reload();
                }
            });
        });
    });

</script>