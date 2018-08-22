<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$lodging = new lodging();
$start_date = $_POST['start_date'];

$stay = $_POST['stay']-1;
$tel_no = $_POST['tel_no'];
$room_no = $_POST['room_no'];
$room_vehicle = $_POST['room_vehicle'];
$



$sale_lod_price = (($lodging_price[0] * $lodging_vehicle) + $lodging_price[3]);

$month_array = explode("-",$start_date);
$this_mon =  $month_array[0]."-".$month_array[1];

$lastday = date("t",strtotime($this_mon));
//echo $lastday;
$this_view_mon = $month_array[0].". ".$month_array[1];
$week = array("일","월","화","수","목","금","토");

$start_week = date("w",strtotime($this_mon."-01"));
//echo $start_week;
$totalweek = ceil(($lastday+ $start_week)/7);
//echo $totalweek;

$prev_mon = date("Y-m-d",strtotime($this_mon.' -1 month'));
$next_mon = date("Y-m-d",strtotime($this_mon.' +1 month'));
$now_date = date("Y-m-d",time());
$sele_date = date("Y-m-d",strtotime($start_date.'+'.$stay.' day'));
$adult_number = $_REQUEST['adult_number'] ;
$child_number = $_REQUEST['child_number'];
$baby_number = $_REQUEST['baby_number'];


?>

<table>
    <tr>
        <td  colspan="7" class="date"><p><a href="javascript:cal('<?=$prev_mon?>');"><img src="../sub_img/prev_btn.png" /></a><?=$this_view_mon?> <a href="javascript:cal('<?=$next_mon?>');"><img src="../sub_img/next_btn.png" /><a></p></td>
    </tr>
    <tr>
        <td class="sun">일</td><td class="mon">월</td><td class="tue">화</td><td class="wed">수</td><td class="thr">목</td><td class="fri">금</td><td class="sat">토</td>
    </tr>
    <?php
    $day =1;
    for($i=1;$i<$totalweek+1;$i++){
      ?>
    <tr>
        <?
        for ($m = 0;$m < 7;$m++){


            $this_day = $this_mon."-".$day;
            $lodging->lodno = $tel_no;
            $lodging->start_date = $this_day;
            $lodging->stay = 1;
            $lodging->adult_number = $adult_number;
            $lodging->child_number = $child_number;
            $lodging->baby_number  = $baby_number;
            $lodging->lodging_vehicle = $room_vehicle;
            $lodging->roomno = $room_no;



            $lodging_price = $lodging->lodging_main_price();
           // echo $room_vehicle;
            $sale_lod_price = (($lodging_price[0] * $room_vehicle));

        if(strtotime($now_date) <= strtotime($this_day) ){$else_date="week";$else_price="style='color:#ff5c11'";}else{$else_date="";$else_price="";}
        if(strtotime($now_date) == strtotime($this_day) ){
            if(strtotime($start_date) <= strtotime($this_day) and strtotime($sele_date) >= strtotime($this_day) ){

                $to=" sel";
                $total_price   += $sale_lod_price;
            }else{
                $to=" today";
            }
        }else{
            if(strtotime($start_date) <= strtotime($this_day) and strtotime($sele_date) >= strtotime($this_day) ){

                $to=" sel";
                $total_price   += $sale_lod_price;
            }else{
                $to="";
            }
        }
        if ((!($i == 1 && $m < $start_week) || ($i == $totalweek && $m > $lastweek))) {
            if ($day <= $lastday) {
                if ($day < 10) $day2 = "0" . $day; else $day2 = $day;
            ?>
            <td class='<?=$else_date?><?=$to?>'  <?if(strtotime($now_date) <= strtotime($this_day)){?>onclick="select_day('<?=$this_mon."-".$day2?>');" style="cursor: pointer;"<?}?>>
                <?php



                            ?>
                            <?=$day?><span <?=$else_price?>><?=set_comma($sale_lod_price)?></span>
                            <?php
                            $day++;
                            ?>
               </td>
            <?
                   }
            } else {
             echo "<td></td>";
            }
          }
            echo "<tr>";
      }
      ?>

</table>
<input type="hidden" id="total_price" value="<?=set_comma($total_price)?>">