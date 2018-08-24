<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

$res = new reservation();
$reserv_user_no = $_REQUEST['reserv_user_no'];

$sql = "select * from reservation_user_content where no='{$reserv_user_no}'  and reserv_del_mark!='Y'  order by no ";

$rs  = $db->sql_query($sql);
$row = $db->fetch_array($rs);

$res->reserv_no = $reserv_user_no;
$air_list = $res->reserv_air();


?>
<?php
if(strpos($row['reserv_type'],'A')!==false){
    if($air_list[0]['reserv_air_type']=="S") {
?>
     <input type="hidden" id="air_type" value="A">
<?
    }else{
?>
     <input type="hidden" id="n_air_type" value="A">
<?
    }
}
 if(strpos($row['reserv_type'],'C')!==false){?>
    <input type="hidden" id="rent_type" value="C">
<?}
if(strpos($row['reserv_type'],'T')!==false){?>
    <input type="hidden" id="tel_type" value="T">
<?}
if(strpos($row['reserv_type'],'B')!==false){?>
    <input type="hidden" id="bus_type" value="B">
<?}
if(strpos($row['reserv_type'],'P')!==false){?>
    <input type="hidden" id="bustour_type" value="P">
<?}
if(strpos($row['reserv_type'],'G')!==false){?>
    <input type="hidden" id="golf_type" value="G">
<?}?>
