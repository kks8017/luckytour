<?php



$sql = "select no,bus_name,bus_type,bus_open,bus_image,bus_sort_no from bus_taxi_car     order by bus_sort_no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_BUS_DIR;

?>
<script>
    function car_pop(no) {
        var url = "bus/bus_up_pop.php"; // the script where you handle the form input.

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

</script>

<div class="rent_car">

    <div>
        <table>
            <tr>
                <td align="left"><input type="button" id="car_up_btn" value="선택수정"> <input type="button" id="car_del_btn" value="선택삭제">  </td>
                <td align="right"><input type="button" id="car_btn" value="차량등록"></td>
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

            </tr>
            <form id="car_up_frm">
                <?php
                $i=0;
                if(is_array($result_list)) {
                    foreach ($result_list as $data){
                        if($data['bus_type']=="B"){$type="버스";}else{$type="택시";}
                        ?>
                        <tr>
                            <td><input type="checkbox" name="sel[]" id="sel" value="<?=$i?>"><input type="hidden" name="no[]" value="<?=$data['no']?>"></td>
                            <td><input type="text" name="bus_sort_no[]" value="<?=$data['bus_sort_no']?>" size="3"></td>
                            <td><input type="checkbox" name="bus_open[]" value="Y" <?if($data['bus_open']=="Y"){?>checked<?}?>></td>
                            <td><img src="<?=$image_dir."/thumbnail_".$data['bus_image']?>" class="photo"><input type="hidden" name="old_image[]" id="old_image" value="<?=$data['bus_image']?>"></td>
                            <td><a href="javascript:;" onclick="car_pop(<?=$data['no']?>);" ><?=$data['bus_name']?></a></td>
                            <td><?=$type?></td>

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
    <div id="layer_bus">
        <div class="layer_bus">
            <form id="car_frm" enctype="multipart/form-data">
                <table>

                    <tr>
                        <td>차량명</td>
                        <td><input type="text" name="bus_name" id="bus_name"></td>
                    </tr>
                    <tr>
                        <td>차량이미지</td>
                        <td><input type="file" name="car_image"></td>
                    </tr>
                    <tr>
                        <td>차량종류</td>
                        <td>
                            <select name="bus_type">
                               <option value="B" >버스</option>
                                <option value="X">택시</option>
                            </select>
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

<script>
    $(document).ready(function () {
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })

        $("#car_btn").click(function () {
            overlays_view("overlay","layer_bus")
        });
        $(".overlay").click(function () {
            overlays_close("overlay","layer_bus")
            $(".car_up_tb" ).hide();
            $(".cp_tb" ).hide();

        });
        $("#rent_company").on('change',function () {
            window.location.href ="?linkpage=rent&subpage=car&rent_company="+$("select[name=rent_company]").val();
        });
        $("#car_up_btn").click(function () {

            $("#case").val("car_all_up");
            var url = "bus/bus_process.php"; // the script where you handle the form input.
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
            var url = "bus/bus_process.php"; // the script where you handle the form input.
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
            var url = "bus/bus_process.php"; // the script where you handle the form input.
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
            var url = "bus/bus_process.php"; // the script where you handle the form input.
            if($("#bus_name").val()==""){
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