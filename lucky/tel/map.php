<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$lodging = new lodging();
$lodging->lodno = $_POST['tel_no'];
$tel_name = $lodging->lodging_detail();
?>

<div id="daumRoughmapContainer<?=$tel_name['lodging_timestamp']?>" class="root_daum_roughmap root_daum_roughmap_landing"></div>

<!-- 2. 설치 스크립트 -->
<script charset="UTF-8" class="daum_roughmap_loader_script" src="http://dmaps.daum.net/map_js_init/roughmapLoader.js"></script>

<!-- 3. 실행 스크립트 -->
<script charset="UTF-8">
    new daum.roughmap.Lander({
        "timestamp" : "<?=$tel_name['lodging_timestamp']?>",
        "key" : "<?=$tel_name['lodging_key']?>",
        "mapWidth" : "1200",
        "mapHeight" : "545"
    }).render();
</script>
