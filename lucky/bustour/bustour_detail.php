<?php include_once ("../header.sub.php");?>
<?php
$no = $_GET['no'];
$bustour = new bustour();
$main = new main();
$sql = "select * from bustour_tour where no='{$no}'";
$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$image_dir = "../".KS_DATA_DIR."/".KS_BUSTOUR_DIR;

$bustour->bustour_no = $no;
$bustour->start_date = date("Y-m-d",time());
$bustour->number = 1;
$price = $bustour->bustour_price();
$bustour_list = $bustour->bustour_list();


?>
    <link rel="stylesheet" href="../css/mdpackage_detail.css" />
<div id="content">
    <div class="search">
        <div class="search_tit">
            <span class="bar mar"></span>
            <h3>버스투어</h3>
            <span class="bar"></span>
        </div>
    </div>

    <!-- md 추천 상세 시작  -->
    <div class="detail">
        <div class="top">
            <div class="lcon">
                <img src="<?=$image_dir?>/<?=$row['bustour_tour_main_image']?>" />
            </div>
            <div class="rcon">
                <p>>> <?=$row['bustour_tour_name']?>(<?=$row['bustour_tour_stay']?>박<?=($row['bustour_tour_stay']+1)?>일)</p>
                <form  action="../member/login_reservation.php" method="post">
                    <div class="tbl_wrap">
                        <table>
                            <tr>
                                <th>상품선택</th><td>
                                    <select name="bustour_no" onchange=" bustour_detail()" class="lsel">
                                        <?php
                                        if(is_array($bustour_list)){
                                            foreach ($bustour_list as $tour){
                                        ?>
                                            <option value="<?=$tour['no']?>" <?if($no==$tour['no']){?>selected<?}?>><?=$tour['bustour_tour_name']?></option>
                                            <?}?>
                                        <?}?>
                                    </select></td>
                            </tr>
                            <tr>
                                <th>포함내용</th><td><span class="com"><?=$row['bustour_tour_inclusion']?></span></td>
                            </tr>
                            <tr>
                                <th>1인기준 투어비</th><td><span class="price"><?=set_comma($price[0])?>원</span><span class="com">(항공,숙박,차량 불포함 가격)</span></td>
                            </tr>
                            <tr>
                                <th>이용일자/인원</th><td><input type="text" name="start_date" id="start_date" value="<?=date("Y-m-d",time())?>"  style="vertical-align:top" class="date"/>
                                   &nbsp;&nbsp;&nbsp;<select name="adult_number" class="ssel" onchange="bustour_price();">
                                    <?php
                                     $main->number_option("","성인");
                                    ?>
                                    </select>
                                    <select name="child_number" class="ssel" onchange="bustour_price();">
                                     <?php
                                      $main->number_option("","소아");
                                     ?>
                                    </select> <span class="com ma">(소아:만12세이하)</span>
                                </td>
                            </tr>
                            <tr>
                                <th>총요금</th><td><span class="total_price">0원</span></td>
                            </tr>
                        </table>
                    </div>
                    <input type="image" src="../sub_img/reserve_btn.png" />
                    <input type="hidden" name="package_type" value="P">
                </form>
            </div>
        </div> <!-- top 끝 -->
        <div class="middle"> <!-- middle 시작 -->
            <img src="<?=$image_dir?>/<?=$data['bustour_tour_content_image']?>">
        </div>
    </div>
    <!-- md 추천 상세 끝  -->
</div><!-- content 끝 -->
<div id="price_t"></div>
<script>
    function bustour_price() {
        var url = "bustour_price.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no=<?=$no?>&start_date="+$("#start_date").val()+"&adult_number="+$("select[name=adult_number]").val()+"&child_number="+$("select[name=child_number]").val(), // serializes the form's elements.
            success: function (data) {
                $("#price_t").html(data)
                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
               // alert($("#total_price").val());
                $(".total_price").html(set_comma($("#total_price").val())+"원");
            }
        });
    }
    function bustour_detail() {
        window.location.href = "bustour_detail.php?no="+$("select[name=bustour_no]").val();
    }

    $( function() {
        $( "#start_date" ).datepicker({
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            numberOfMonths: 2,
            dateFormat : "yy-mm-dd",
            showOn : "both",
            buttonImage : "<?=KS_SUB_DIR?>sub_img/calender2.png",
            buttonImageOnly : true,
            onSelect:function(dateText, inst) {
                bustour_price();
            }
        });
    });
    bustour_price();
</script>
<?php include_once ("../footer.php");?>