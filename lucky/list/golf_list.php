<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$golf = new golf();
$j = $_POST['i'];

$start_date = $_REQUEST['start_date'];
$stay = $_REQUEST['golf_stay'];
$end_date = date("Y-m-d",strtotime($start_date."+{$stay} days"));

$golf_area       = $_REQUEST['golf_area'];
$search_name     = $_REQUEST['search_name'];
$adult_number    = $_REQUEST['adult_number'];
$golf_time       = $_REQUEST['golf_time'];

if($reserv_golf_area){
    $sql_area = "and golf_area='{$golf_area}' ";
}else{
    $sql_area = "";
}

if($search_name){
    $sql_name = "and golf_name like '%{$search_name}%' ";
}else{
    $sql_name = "";
}

$sql = "select * 
        from golf_list where  golf_open_chk='Y'   {$sql_area}  {$sql_name}  order by golf_sort_no asc";

$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

$image_dir = "/".KS_DATA_DIR."/".KS_GOLF_DIR;
?>
<h1><img src="../sub_img/num1.png" />원하시는 골프장을 클릭 하세요.</h1>
<ul>
    <?php
    $i=0;
    if(is_array($result_list)) {
    foreach ($result_list as $data){
        $golf_area = $golf->golf_code_name($data['golf_area']);
        $golf->golf_no = $data['no'];
        $golf->start_date = $start_date;
        $golf->stay = $stay;
        $golf->adult_number = $adult_number;
        $main_image = $golf->golf_main_image();
        $price = $golf->golf_main_price();
    ?>
    <li>
        <a href="javascript:hole_detail(<?=$j?>,'<?=$data['no']?>');"><img src="<?=$image_dir?>/<?=$main_image?>"  width="213" height="204"/></a>
        <p class="tit"><?=$data['golf_name']?></p>
        <p class="day"><span>주중요금:</span>&nbsp;<span><?=set_comma($price[0])?>원</span></p>
        <p class="week"><span>주말요금:</span>&nbsp;<span><?=set_comma($price[1])?>원</span></p>
    </li>
        <?php
        $i++;
    }
    }else{
    ?>
    <?}?>
</ul>