<?
//scode.php
session_start();
if( isset($_POST['submit'])) {
    if($_SESSION['scode']==$_POST['user_scode'] && !empty($_SESSION['scode'])){
        echo "correct";
        unset($_SESSION['scode']);
    }else{
        echo "wrong";
    }
}
?>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    function img_change() {
        $("#imgs").attr("src","test.php?img="+new Date().getTime()); // show response from the php script.
    }
</script>
<html>

<form method="post" action="?">
    <table border=0 width="649" cellspacing="0" cellpadding="0">
    <tr>
     <td width="100"><a href="javascript:img_change();"><img id="imgs" src="test.php"></a></td>
<td width="100"class="darkgreen" align="center">scode.</td>
<td width="60" align="center"><input type="text" name="user_scode" size="8" style="border-width:1px; border-color:#CCCCCC; border-style:solid;"></td>
<td width="3"></td>
<td colspan="1" align="center"><input type="submit" name="submit" value="POST IT" style="width:427px; background-color: #EFEFEF;color:#11AE5B;"></td>
</tr>
</table>
</form>

</html>


