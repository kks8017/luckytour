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
<table>
    <tr>
        <td>홀명</td>
        <td><input type="text" name="hole_name" id="hole_name_up" value="<?=$row_hole['hole_name']?>"></td>
    </tr>
    <tr>
        <td colspan="2">
            <p><input type="button" onclick="hole_update();" value="홀변경"></p>
        </td>
    </tr>
</table>