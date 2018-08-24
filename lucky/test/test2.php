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
<html>

<form method="post" action="<?=$PHP_SELF?>">
    <table border=0 width="649" cellspacing="0" cellpadding="0">
    <tr>
     <td width="100"><img src="test.php"</td>
<td width="100"class="darkgreen" align="center">scode.</td>
<td width="60" align="center"><input type="text" name="user_scode" size="8" style="border-width:1px; border-color:#CCCCCC; border-style:solid;"></td>
<td width="3"></td>
<td colspan="1" align="center"><input type="submit" name="submit" value="POST IT" style="width:427px; background-color: #EFEFEF;color:#11AE5B;"></td>
</tr>
</table>
</form>

</html>


