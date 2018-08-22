<?php include "../inc/header.sub.php"; ?>
<?php
$tour_air_area = explode(",",$main_company['tour_air_area']);
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}

$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));
$air = new air();
$main = new main();


?>
    <br>
    <br>
    <div class="select-table">
        <table>
            <tr>
                <td class="select-title-span">
                    <span class="calendar"></span>

                </td>
                <td class="select-title">
                    출발일 -

                </td>
                <td class="select-text" style="border-right: 1px solid #848484;">
                    <input id="start_date" type="text" name="start_date" value="<?=$start_date?>" >
                    <input type="hidden" id="end_date" value="">
                </td>
                <td class="select-title-span">
                    <span class="calendar"></span>

                </td>
                <td class="select-title">

                    일정

                </td>
                <td class="select-text">
                    <select name="stay">
                        <?php
                            $main->stay_option("");
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="select-title-span">
                    <span class="place"></span>

                </td>
                <td class="select-title">

                    출발지

                </td>
                <td class="select-text" style="border-right: 1px solid #848484;">
                    <select name="start_area">
                        <?php
                        foreach ($tour_air_area as $area){
                            $area_name = explode("|",$area);
                            if($area_name[0]=="김포"){$sel="selected";}else{$sel="";}
                            echo "<option value='{$area_name[0]}' {$sel}>{$area_name[0]}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="select-title-span">
                    <span class="time"></span>

                </td>
                <td class="select-title">

                    항공시간

                </td>
                <td class="select-text">
                    <select>
                        <option value="">전체</option>
                        <option value="">06:00~07:00</option>
                        <option value="">07:00~08:00</option>
                        <option value="">09:00~12:00</option>
                        <option value="">12:00~13:00</option>
                        <option value="">13:00~15:00</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="select-title-span">
                    <span class="person"></span>

                </td>
                <td class="select-title">

                    성인

                </td>
                <td class="select-text-count" style="border-right: 1px solid #848484;">
                    <button id="a_down" class="down"></button>
                    <input type="text" value="1" id="adult_number" name="adult_number"  />
                    <button id="a_up" class="up" ></button>
                </td>
                <td class="select-title-span">
                    <span class="baby"></span>

                </td>
                <td class="select-title">
                    소아
                </td>
                <td class="select-text-count">
                    <button id="c_down" class="down"></button>
                    <input type="text" value="0" id="child_number" name="child_number" />
                    <button id="c_up" class="up" ></button>
                </td>
            </tr>
            <tr>
                <td class="select-title-span">
                    <span class="person"></span>

                </td>
                <td class="select-title">

                    유아

                </td>
                <td class="select-text-count" style="border-right: 1px solid #848484;">
                    <button id="b_down" class="down"></button>
                    <input type="text" value="0" id="baby_number"  name="baby_number" />
                    <button id="b_up" class="up" ></button>
                </td>

            </tr>
        </table>

    </div>
    <div class="button-summit-area">
        <button class="button-summit" id="search_btn" type="summit">항공 검색</button>
    </div>

    <div id="air_schedule" class="select-air-list" style="text-align: center;">

    </div>
    <div class="button-summit-area">
        <button class="button-summit-blue"  id="page" type="summit"> 50개더보기</button>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">

        function schedule(pagenum,re) {
            var url = "../list/list_air.php"; // the script where you handle the form input.
            if(re=="time"){ is_init = true; $(".odd").remove(); pagenum=1;  }
            if(pagenum==1){  var pagenum2 = 0;}else{var pagenum2 = pagenum-1 ;}
            // alert(pagenum2);
            $.ajax({
                type: "POST",
                url: url,
                data: "start_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&stay="+$("select[name=stay]").val()+"&adult_number="+$("#adult_number").val()+"&child_number="+$("#child_number").val()+"&baby_number="+$("#baby_number").val()+"&package="+$("select[name=package]").val()+"&area="+$("select[name=start_area]").val()+"&time="+$("select[name=time]").val()+"&package_type=<?=$package_type?>&pagenum="+pagenum2+"&case=dan", // serializes the form's elements.
                success: function (data) {
                    $("#air_schedule").append(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {
                    //  wrapWindowByMask();
                },
                complete: function () {
                    //   closeWindowByMask();
                }
            });
        }
        var reloadCount = 1;
        var pagenum = 1;
        var is_init = false;
        $(document).ready(function(){
            $("#page").click(function () {

                if (is_init) {
                    is_init = false;
                    pagenum =1;
                    return;
                }
                pagenum += 1;
                schedule(pagenum, '');
            });
            $("#search_btn").click(function () {
                schedule(1,"time");
            })
            $("#a_up").on("click",function(){
                var num = $("#adult_number").val();
                num = Number(num) + 1;
                if(num==100){

                }else {
                    $("#adult_number").val(num);
                }
            });
            $("#a_down").on("click",function(){
                var num = $("#adult_number").val();
                num = Number(num) - 1;
                if(num < 1){

                }else {
                    $("#adult_number").val(num);
                }
            });
            $("#c_up").on("click",function(){
                var num = $("#child_number").val();
                num = Number(num) + 1;
                if(num==100){

                }else {
                    $("#child_number").val(num);
                }

            });
            $("#c_down").on("click",function(){
                var num = $("#adult_number").val();
                num = Number(num) - 1;
                if(num < 0){

                }else {
                    $("#child_number").val(num);
                }

            });
            $("#b_up").on("click",function(){
                var num = $("#baby_unmber").val();
                num = Number(num) + 1;
                if(num==100){

                }else {
                    $("#baby_unmber").val(num);
                }

            });
            $("#b_down").on("click",function(){
                var num = $("#baby_unmber").val();
                num = Number(num) - 1;
                if(num < 0){

                }else {
                    $("#baby_unmber").val(num);
                }

            });
            schedule(1,"");
        });


    </script>


<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>