<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$no = $_REQUEST['lodging_no'];

$sql_img = "select no,lodging_no,lodging_image_sort,lodging_image_name,lodging_image_file_s,lodging_image_file_m from lodging_image where lodging_no='{$no}'";
$rs_img  = $db->sql_query($sql_img);
while($row_img = $db->fetch_array($rs_img)) {
    $result_img[] = $row_img;
}

$image_dir = "/".KS_DATA_DIR."/".KS_LOD_DIR;
$i=0;
if(is_array($result_img)) {
    foreach ($result_img as $data){
        ?>
        <div class="photo_d">
            <div><a id="img_del" href="javascript:image_del('<?=$data['no']?>');">X</a></div>
            <img src="<?=$image_dir."/".$data['lodging_image_file_m']?>" class="photo" >
        </div>
        <?php
        $i++;
    }
}else{
?>
<?}?>