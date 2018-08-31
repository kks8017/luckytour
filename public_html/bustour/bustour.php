<?php include_once ("../header.sub.php");?>
<?php
$bustour = new bustour();
$sql = "select * from bustour_tour where bustour_open='Y' order by bustour_sort_no";
$rs  = $db->sql_query($sql);
while ($row = $db->fetch_array($rs)){
    $result[] = $row;
}
$image_dir = "../".KS_DATA_DIR."/".KS_BUSTOUR_DIR;
?>
<link rel="stylesheet" href="../css/mdpackage.css" />
    <div id="content">
        <div class="search">
            <div class="search_tit">
                <span class="bar mar"></span>
                <h3>버스투어</h3>
                <span class="bar"></span>
            </div>
        </div>

        <div class="mdpackage">
            <ul>
                <?php
               if(is_array($result)) {
                   foreach ($result as $data) {
                       $bustour->bustour_no = $data['no'];
                       $bustour->start_date = date("Y-m-d",time());
                       $bustour->number =1;
                       $price = $bustour->bustour_price();

                       ?>
                       <li class="li">
                           <p class="head"><span><?=$data['bustour_tour_name']?></span><span>제주 <?=$data['bustour_tour_stay']?>박<?=($data['bustour_tour_stay']+1)?>일</span><span><?=set_comma($price[0])?>원</span></p>
                           <p><a href="bustour_detail.php?no=<?=$data['no']?>"><img src="<?=$image_dir?>/<?=$data['bustour_tour_main_image']?>" class="pic" width="361" height="179"/></a></p>
                           <p><span class="hide">포함내역</span><img src="../sub_img/include_list.png"/></p>
                           <p><?=$data['bustour_tour_inclusion']?></p>
                           <a href="bustour_detail.php?no=<?=$data['no']?>" class="view"><span class="hide">자세히보기</span><img src="../sub_img/detail_view.png"/></a>
                       </li>
                <?
                   }
                 }
                ?>
            </ul>
        </div> <!-- mdpackage 끝-->



    </div><!-- content 끝 -->

<?php include_once ("../footer.php");?>