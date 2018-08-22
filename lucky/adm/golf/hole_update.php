<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$no = $_REQUEST['no'];

$sql_hole = "select no,golf_no,hole_name from  golf_hole_list where no='{$no}'";

$rs_hole  = $db->sql_query($sql_hole);
$row_hole = $db->fetch_array($rs_hole);

?>
<script>


    function hole_update() {


        var url = "golf/golf_process.php"; // the script where you handle the form input.
        $.ajax({
            url: url,
            type: "POST",
            data: "no=<?=$no?>&hole_name="+$("#hole_name_up").val()+"&case=hole_update",

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
    }

</script>
<style>
   .tbl_hole{width:200px;border:1px solid #d5d5d5;}
   .tbl_hole input[type="checkbox"]{width:14px;height:14px;border:1px solid #b0b0b0}
   .tbl_hole th{height:30px;background-color:#cdd3e0;padding-top:20px;font-weight:bold;font-size:12px}
   .tbl_hole tr:hover{background-color:#fffff3}
   .tbl_hole td{height:50px;font-size:12px; padding-left: 5px; border-bottom:1px solid #d5d5d5; vertical-align: middle}
   .tbl_hole tr:hover{background-color:#fffff3}
   .tbl_hole td img{vertical-align: middle}
   .tbl_hole td span{color:#f40d0d}
</style>
<table class="tbl_hole" style="width: 220px;">
    <tr>
        <th>홀명</th>
        <td><input type="text" name="hole_name" id="hole_name_up" value="<?=$row_hole['hole_name']?>"></td>
    </tr>
</table>
<p style="text-align: center;"><input type="button" onclick="hole_update();" value="홀변경"></p>