<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['no'];

$sql_reserv = "select no,reserv_type,reserv_name,reserv_tour_start_date,reserv_tour_end_date,reserv_adult_number,reserv_child_number,reserv_baby_number from reservation_user_content where no='{$no}' ";
$rs_reserv  = $db->sql_query($sql_reserv);
$row_reserv = $db->fetch_array($rs_reserv);


$company = set_company();
$reserv_date = $res->reserv_date($no);

$sql_content = "select * from reservation_content where reserv_user_no='{$no}'";
$rs_content = $db->sql_query($sql_content);
while ($row_content = $db->fetch_array($rs_content)){
    $result[] = $row_content;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$row_reserv['reserv_name']?>님 렌트추가</title>
    <meta charset="utf-8">
    <link href="../css/admin.css" rel="stylesheet">
    <link href="../css/normalize.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
    <script type="text/javascript" src="/lib/common.lib.js" ></script>
</head>
<script>

    function wrapWindowByMask() {

        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();
//      var maskWidth = $(document).width();
        var maskWidth = window.document.body.clientWidth;
        var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";

        var loadingImg = '';
        loadingImg += "<div id='loadingImg' style='position:absolute; left:50%; top:40%; display:none; z-index:10000;'>";
        loadingImg += " <img src='/com/img/viewLoading.gif'/>";
        loadingImg += "</div>";
        //화면에 레이어 추가
        $('body')
            .append(mask)
            .append(loadingImg)
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $('#mask').css({
            'width' : maskWidth
            , 'height': maskHeight
            , 'opacity' : '0.3'
        });

        //마스크 표시
        $('#mask').show();
        //로딩중 이미지 표시
        $('#loadingImg').show();
    }
    function closeWindowByMask() {
        $('#mask, #loadingImg').hide();
        $('#mask, #loadingImg').remove();
    }

    function rent_update(no,start_date,end_date,rent_vehicle,rent_option,rent_com_no){
        var url = "rent_reserv_process.php"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: "no="+no+"&start_date="+start_date+"&end_date="+end_date+"&rent_vehicle="+rent_vehicle+"&rent_option="+rent_option+"&rent_com_no="+rent_com_no+"&reserv_type=<?=$row_reserv['reserv_type']?>&reserv_rent_no=<?=$reserv_rent_no?>&reserv_user_no=<?=$no?>&case=sch_update", // serializes the form's elements.
            success: function (data) {

                console.log(data);
            },
            beforeSend: function () {

            },
            complete: function () {
                $(opener.location).attr("href", "javascript:rent();");
                window.close();
            }
        });
    }
    function content(i) {
        $("#content_"+i).slideToggle();
    }
</script>
<body>
<div class="reserv_content">
    <div >
        <table>
            <tr>
                <td>변경자</td>
                <td>제목</td>
                <td>변경일시</td>
                <td>아이피</td>
            </tr>
            <?php
            $i=0;
            if(is_array($result)) {
            foreach ($result as $data){

            ?>
            <tr>
                <td><?=$data['person']?></td>
                <td><a href="javascript:content(<?=$i?>);"><?=$data['reserv_title']?></a></td>
                <td><?=$data['indate']?></td>
                <td><?=$data['ip']?></td>
            </tr>
                <tr id="content_<?=$i?>" style="display:none;">
                    <td colspan="4" ><?=$data['reserv_content']?></td>
                </tr>
                <?php
                $i++;
            }
            }else{
                ?>
            <tr>
                <td colspan="4">변경내역이 없습니다.</td>
            </tr>
            <?}?>
        </table>
    </div>
</div>
<script>

</script>

</body>
</html>