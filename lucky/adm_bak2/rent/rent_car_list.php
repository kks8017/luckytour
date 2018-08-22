<?php
include_once("./_common.php");
$rent = new rent();
$com_no = $_GET['rent_company'];

if($com_no==""){
    $main_com_no  = get_rentcar_company("","대표");
    $com_sql = "where rent_com_no='{$main_com_no[0]}'";
}else{
    $main_com_no  = get_rentcar_company($com_no,"협력");
    $com_sql = "where rent_com_no='{$com_no}'";
}


$sql = "select no,rent_car_name,rent_car_type,rent_car_fuel,rent_car_year_type,rent_car_option,rent_car_image,rent_car_insurance,rent_car_open,rent_car_sort from rent_car_detail  $com_sql   order by rent_car_sort asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$rent_list_type = $rent->rent_code('T');
$rent_list_fuel = $rent->rent_code('F');
$rent_list_option = $rent->rent_code('O');



$sql_com = "select no,rent_com_name from rent_company order by no";
$rs_com  = $db->sql_query($sql_com);
while($row_com = $db->fetch_array($rs_com)) {
    $result_com[] = $row_com;
}
$sql_com_name = "select rent_com_name from rent_company where no='{$com_no}' order by no";
$rs_com_name  = $db->sql_query($sql_com_name);
$row_com_name = $db->fetch_array($rs_com_name);

$image_dir = "/".KS_DATA_DIR."/".KS_RENT_DIR;

?>
<script>
    function car_pop(no) {
        var url = "rent/rent_up_pop.php"; // the script where you handle the form input.

        $(".overlay" ).show();
        $(".car_up_tb" ).show();
        $.ajax({
            type: "POST",
            url: url,
            data: "no=" + no, // serializes the form's elements.
            success: function (data) {
                $("#car_up_tb").html(data); // show response from the php script.
              //  console.log(data);
              //  console.log($("#car_up_tb").find("#car_mod_frm"));
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
    function car_cp_pop(no) {
        var url = "rent/main_car_copy.php"; // the script where you handle the form input.

        $(".overlay" ).show();
        $(".cp_tb" ).show();
        $.ajax({
            type: "POST",
            url: url,
            data: "com_no=" + no, // serializes the form's elements.
            success: function (data) {
                $("#cp_tb").html(data); // show response from the php script.
                // console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
    }
</script>

<div class="rent_car">
    <select name="rent_company" id="rent_company">

     <?php
    foreach ($result_com as $com){  ?>
        <option value="<?=$com['no']?>" <?if($com_no == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
    <?}?>
    </select>
    <br><br>
    <div>
        <table>
            <tr>
                <td align="left"><input type="button" id="car_up_btn" value="선택수정"> <input type="button" id="car_del_btn" value="선택삭제"> <?if($main_com_no[1]!="대표"){?><input type="button" id="car_del_btn" value="대표차량복사" onclick="car_cp_pop(<?=$com_no?>);"><?}?> </td>
                <td align="right"><?if($main_com_no[1]=="대표"){?><input type="button" id="car_btn" value="차량등록"><?}?></td>
            </tr>
        </table>
        <table>
            <tr>
                <td><input type="checkbox" id="allsel"></td>
                <td>노출순서</td>
                <td>노출</td>
                <td>사진</td>
                <td>차량명</td>
                <td>차량종류</td>
                <td>연료</td>
                <td>연식</td>

            </tr>
            <form id="car_up_frm">
            <?php
            $i=0;

            if(is_array($result_list)) {
                foreach ($result_list as $data){
                    $rent_type_name = $rent->rent_code_name($data['rent_car_type']);
                    $rent_fuel_name = $rent->rent_code_name($data['rent_car_fuel']);

                ?>
                <tr>
                    <td><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"><input type="hidden" name="com_no[]" value="<?=$com_no?>"></td>
                    <td><input type="text" name="rent_car_sort[]" value="<?=$data['rent_car_sort']?>" size="3"></td>
                    <td><input type="checkbox" name="rent_car_open_<?=$i?>" value="Y" <?if($data['rent_car_open']=="Y"){?>checked<?}?>></td>
                    <td><img src="<?=$image_dir."/thumbnail_".$data['rent_car_image']?>" class="photo"><input type="hidden" name="old_image[]" id="old_image" value="<?=$data['rent_car_image']?>"></td>
                    <td><a href="javascript:;" onclick="car_pop(<?=$data['no']?>);" ><?=$data['rent_car_name']?></a></td>
                    <td><?=$rent_type_name?></td>
                    <td><?=$rent_fuel_name?></td>
                    <td><?=$data['rent_car_year_type']?></td>

                </tr>
                <?php
                    $i++;
                }
            }else{
            ?>
                <tr>
                    <th colspan="8" class="tb_center"><p>등록된 정보가 없습니다.</p></th>
                </tr>
            <?}?>
            <input type="hidden" name="case" id="case" value="">
            </form>
        </table>
    </div>
    <div class="overlay"></div>
    <div id="layer_car">
        <div class="layer_car">
            <form id="car_frm" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>업체명</td>

                   <?if($com_no==""){?>
                       <td><select name="rent_company" id="rent_company">
                               <?php
                               foreach ($result_com as $com){  ?>
                                   <option value="<?=$com['no']?>" <?if($com_no == $com['no']){?>selected<?}?>><?=$com['rent_com_name']?></option>
                               <?}?>
                        </select>
                   </td>
                    <?
                    }else{
                    ?>
                    <td><?=$row_com_name['rent_com_name']?><input type="hidden" name="rent_company" value="<?=$com_no?>"></td>
                    <?}?>
                </tr>
                <tr>
                    <td>차량명</td>
                    <td><input type="text" name="rent_name" id="rent_name"></td>
                </tr>
                <tr>
                    <td>차량이미지</td>
                    <td><input type="file" name="car_image"></td>
                </tr>
                <tr>
                    <td>차량종류</td>
                    <td>
                        <select name="rent_car_type">
                         <?
                            foreach ($rent_list_type as $rent_type){
                                echo "<option value='{$rent_type['no']}'>{$rent_type['rent_config_name']}</option>";
                            }
                         ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>연료</td>
                    <td>
                        <select name="rent_car_fuel">
                            <?
                            foreach ($rent_list_fuel as $rent_fuel){
                                echo "<option value='{$rent_fuel['no']}'>{$rent_fuel['rent_config_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>차량년식</td>
                    <td><input type="text" name="rent_car_year_start" size="5"> ~ <input type="text" name="rent_car_year_end" size="5"> </td>
                </tr>
                <tr>
                    <td>옵션</td>
                    <td>
                        <?
                        $k=0;
                        foreach ($rent_list_option as $rent_option){
                            echo "<input type='checkbox' name='rent_option[]' value='{$rent_option['no']}'>{$rent_option['rent_config_name']} ";
                            $k++;
                        }
                        ?>

                    </td>
                </tr>

            </table>
            <p><input id="add_btn" type="submit" value="차량등록"></p>
                <input type="hidden" name="case" value="car_insert">
            </form>
        </div>
    </div>
</div>
<form id="car_mod_frm" enctype="multipart/form-data">
<div class="car_up_tb">
    <div id="car_up_tb"></div>
</div>

</form>
<form id="cp_frm" enctype="multipart/form-data">
<div class="cp_tb">
    <div id="cp_tb"></div>
</div>
</form>
<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })

        $("#car_btn").click(function () {
            overlays_view("overlay","layer_car")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_car")
            $(".car_up_tb" ).hide();
            $(".cp_tb" ).hide();

        });
        $("#rent_company").on('change',function () {
            window.location.href ="?linkpage=rent&subpage=car&rent_company="+$("select[name=rent_company]").val();
        });
        $("#car_up_btn").click(function () {

            $("#case").val("car_all_up");
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#car_up_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                   window.location.reload();
                }
            });

        });

        $("form#car_mod_frm").submit(function(event) {
           // alert("aaa");
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            if($("#rent_name_up").val()==""){
                alert("차량명를 입력해주세요");
                return false;
            }
            //disable the default form submission
            event.preventDefault();

            var fd = new FormData($(this)[0]);
            console.log(fd);

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

                },
                complete: function () {
                    $(".overlay" ).hide();
                    $(".car_up_tb" ).hide();
                    window.location.reload();
                }
            });
        });
        $("form#cp_frm").submit(function(event) {
            // alert("aaa");
            var url = "rent/rent_process.php"; // the script where you handle the form input.

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

                },
                complete: function () {
                    $(".overlay" ).hide();
                    $(".cp_tb" ).hide();
                    window.location.reload();
                }
            });
        });
        $("#car_del_btn").click(function () {
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            $("#case").val("car_del");
            if(confirm("정말삭제 하시겠습니다?") == false) {
                closeWindowByMask();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#car_up_frm").serialize(), // serializes the form's elements.
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

        $("form#car_frm").submit(function(event) {
            var url = "rent/rent_process.php"; // the script where you handle the form input.
            if($("#rent_name").val()==""){
                alert("차량명를 입력해주세요");
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