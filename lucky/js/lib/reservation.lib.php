<?php
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

class reservation{
  var $db;
  public $block, $block_set,$total_page,$page,$total_block,$sch_url,$basic_url,$adm_url ;
  public $res_no,$staff_no,$equip_no,$equip_stay,$equip_number,$equip_vehicle;
  public function __construct()
  {
      $this->db = new tour_db();
  }
  function reserv_type_change($reserv_no){
      $sql = "select reserv_type from reservation_user_content where no='{$reserv_no}'";
      $rs  = $this->db->sql_query($sql);

      $row = $this->db->fetch_array($rs);

      $sql_num = "select  air_cnt ,rent_cnt ,lod_cnt ,bus_cnt ,taxi_cnt ,bustour_cnt ,golf_cnt 
                  from  (select count(no) as air_cnt from reservation_air where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y') as a,
                         (select count(no) as rent_cnt from reservation_rent where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y') as b,
                         (select count(no) as lod_cnt from reservation_lodging where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y') as c,
                         (select count(no) as bus_cnt from reservation_bus where reserv_user_no='{$reserv_no}' and reserv_bus_type='B' and reserv_del_mark!='Y') as d,
                         (select count(no) as taxi_cnt from reservation_bus where reserv_user_no='{$reserv_no}' and reserv_bus_type='X' and reserv_del_mark!='Y') as e,
                         (select count(no) as bustour_cnt from reservation_bustour where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y') as f,
                         (select count(no) as golf_cnt from reservation_golf where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y') as g
                  ";

    //  echo $sql_num;
      $rs_num  = $this->db->sql_query($sql_num);
      $row_num = $this->db->fetch_array($rs_num);

      $change_type = "";
      if($row_num['air_cnt'] > 0){$change_type .="A"; }else{$change_type .="";}
      if($row_num['rent_cnt'] > 0){ $change_type .="C";}else{$change_type .="";}
      if($row_num['lod_cnt'] > 0){  $change_type .="T";}else{$change_type .="";}
      if($row_num['bus_cnt'] > 0){  $change_type .="B";}else{$change_type .="";}
      if($row_num['taxi_cnt'] > 0){ $change_type .="X";}else{$change_type .="";}
      if($row_num['bustour_cnt'] > 0){$change_type .="P";}else{$change_type .="";}
      if($row_num['golf_cnt'] > 0){$change_type .="G";}else{$change_type .="";}

      $sql_change = "update reservation_user_content set reserv_type='{$change_type}' where no='{$reserv_no}'";

      $this->db->sql_query($sql_change);
  }
  function reserv_price_change($reserv_no,$plus_price,$minus_price){
      $sql = "select no,reserv_total_price,reserv_balance_state,reserv_deposit_price from reservation_amount where reserv_user_no='{$reserv_no}'";
      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);
      $total_price   = (($row['reserv_total_price'] - $minus_price) + $plus_price);
      echo "$total_price   = (({$row['reserv_total_price']} - $minus_price) + $plus_price);";
      if($total_price < 0){
          $total_price=0;
          $deposit_price = 0;
          $balance_price =  0;
          $sql_deposit = ",reserv_deposit_price='0'";
      }else{
          $deposit_price =  $total_price * 0.3;
          $balance_price =  $total_price - $deposit_price;
          $sql_deposit   = ",reserv_deposit_price='{$deposit_price}'";
      }
      if(is_array($row)){
          if($row['reserv_balance_state'] =="Y") {
              $sql_price = "update reservation_amount set reserv_total_price='{$total_price}' where reserv_user_no='{$reserv_no}'";
              $this->db->sql_query($sql_price);
              if($plus_price > 0 and $minus_price == 0) {
                  $sql_price_add = "insert into reservation_amount_etc set reserv_amount_no='{$row['no']}',reserv_etc_type='추가금액',reserv_etc_price='{$plus_price}' ";
                  $this->db->sql_query($sql_price_add);
              }

          }else{
              $sql_price = "update reservation_amount set reserv_total_price='{$total_price}',reserv_balance_price='{$balance_price}' {$sql_deposit} where reserv_user_no='{$reserv_no}'";
              echo $sql_price ;
              $this->db->sql_query($sql_price);
          }
      }else{
          $sql_price = "insert into reservation_amount set reserv_user_no='{$reserv_no}',reserv_deposit_price='{$deposit_price}',reserv_balance_price='{$balance_price}', reserv_total_price='{$total_price}'";
          $this->db->sql_query($sql_price);
      }
  }
  function reserv_date($reserv_no){
      $sql = "select reserv_type,reserv_tour_start_date,reserv_tour_end_date from reservation_user_content where no='{$reserv_no}'";
      //echo $sql;
      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);



      if(strpos($row['reserv_type'],"A")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"A");
          $start_date1 = explode(" ",$date_start[0]);
          $end_date1  = explode(" ",$date_start[1]);
          $start_date = $start_date1[0];
          $end_date   = $end_date1[0];
          $start_time = $start_date1[1];
          $end_time   = $end_date1[1];
      }else if(strpos($row['reserv_type'],"C")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"C");
          $start_date1 = explode(" ",$date_start[0]);
          $end_date1 = explode(" ",$date_start[1]);
          $start_date = $start_date1[0];
          $end_date   = $end_date1[0];
          $start_time = $start_date1[1];
          $end_time   = $end_date1[1];
      }else if(strpos($row['reserv_type'],"T")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"T");
          $start_date = $date_start[0];
          $lod_stay = $date_start[1] +1;
          $end_date = date("Y-m-d",strtotime($date_start[1]."+{$lod_stay} days"));
          $start_time = "00:00";
          $end_time   = "00:00";
      }else if(strpos($row['reserv_type'],"B")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"B");
          $start_date = $date_start[0];
          $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));
          $start_time = "00:00";
          $end_time   = "00:00";
      }else if(strpos($row['reserv_type'],"X")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"X");
          $start_date = $date_start[0];
          $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));
          $start_time = "00:00";
          $end_time   = "00:00";
      }else if(strpos($row['reserv_type'],"P")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"P");
          $start_date = $date_start[0];
          $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));
          $start_time = "00:00";
          $end_time   = "00:00";
      }else if(strpos($row['reserv_type'],"G")!==false){
          $date_start = $this->reserv_start_date($reserv_no,"G");
          $start_date = $date_start[0];
          $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));
          $start_time = "00:00";
          $end_time   = "00:00";
      }else{
          $start_date = $row['reserv_tour_start_date'];
          $end_date = $row['reserv_tour_end_date'];
          $start_time = "08:00";
          $end_time   = "08:00";
      }

      return array($start_date,$start_time,$end_date,$end_time);

  }
  function reserv_start_date($reserv_no,$type){
      if($type=="A") {
          $sql = "select reserv_air_departure_date as start_date,reserv_air_arrival_date as end_date  from reservation_air where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y' order by reserv_air_departure_date";
      }else if($type=="C"){
          $sql ="select reserv_rent_start_date as start_date,reserv_rent_end_date as end_date  from reservation_rent where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y' order by reserv_rent_start_date";
      }else if($type=="T"){
          $sql ="select reserv_tel_date as start_date,sum(reserv_tel_stay) as end_date from reservation_lodging where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y' order by reserv_tel_date";
      }else if($type=="B") {
          $sql = "select reserv_bus_date as start_date, sum(reserv_bus_stay) as end_date from reservation_bus where reserv_user_no='{$reserv_no}' and reserv_bus_type='B' and  reserv_del_mark!='Y' order by reserv_bus_date";
      }else if($type=="X"){
            $sql ="select reserv_bus_date as start_date,sum(reserv_bus_stay) as end_date from reservation_bus where reserv_user_no='{$reserv_no}' and reserv_bus_type='X'  and reserv_del_mark!='Y' order by reserv_taxi_date";
      }else if($type=="P"){
            $sql ="select reserv_bustour_date as start_date,sum(reserv_bustour_stay) as end_date  from reservation_bustour where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y' order by reserv_bustour_date";
          //  echo $sql;
      }else if($type=="G") {
          $sql = "select reserv_golf_date as start_date, reserv_golf_stay as golf_stay from reservation_golf where reserv_user_no='{$reserv_no}' and reserv_del_mark!='Y' order by reserv_golf_date";
      }

      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);

      return array($row['start_date'],$row['end_date']);
  }
  function reserv_deposit_price(){
      $sql = "select  air_price ,rent_price ,lod_price ,bus_price ,taxi_price ,bustour_price ,golf_price ,eq_price 
                  from  (select sum(reserv_air_total_deposit_price) as air_price from reservation_air where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as a,
                         (select sum(reserv_rent_total_deposit_price) as rent_price from reservation_rent where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as b,
                         (select sum(reserv_tel_total_dposit_price) as lod_price from reservation_lodging where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as c,
                         (select sum(reserv_bus_total_deposit_price) as bus_price from reservation_bus where reserv_user_no='{$this->res_no}'  and reserv_bus_type='B' and reserv_del_mark!='Y') as d,
                         (select sum(reserv_bus_total_deposit_price) as taxi_price from reservation_bus where reserv_user_no='{$this->res_no}' and reserv_bus_type='X' and reserv_del_mark!='Y') as e,
                         (select sum(reserv_bustour_total_deposit_price) as bustour_price from reservation_bustour where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as f,
                         (select sum(reserv_golf_total_dposit_price) as golf_price from reservation_golf where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as g,
                         (select sum(reserv_equip_total_deposit_price) as eq_price from reservation_equip where reserv_user_no='{$this->res_no}' and reserv_del_mark!='Y') as h
                  ";

      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);

      $total_price = $row['air_price'] + $row['rent_price'] + $row['lod_price'] + $row['bus_price'] + $row['taxi_price'] + $row['bustour_price'] + $row['golf_price'] + $row['eq_price'];

      return $total_price;

  }
    function deposit_price($reserv_no,$plus_price,$minus_price){

        $sql = "select * from reservation_amount where reserv_user_no='{$reserv_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $deposit_price = (($row['reserv_deposit_price'] - $minus_price) + $plus_price);

        $sql_price = "update reservation_amount set reserv_deposit_price='{$deposit_price}'  where reserv_user_no='{$reserv_no}'";
        echo $sql_price ;
        $this->db->sql_query($sql_price);
    }
  function payment_price($reserv_no,$plus_price,$minus_price){

      $sql = "select * from reservation_amount where reserv_user_no='{$reserv_no}'";
      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);

      $payment_price = (($row['reserv_payment_price'] - $minus_price) + $plus_price);

      $sql_price = "update reservation_amount set reserv_payment_price='{$payment_price}'  where reserv_user_no='{$reserv_no}'";
      echo $sql_price ;
      $this->db->sql_query($sql_price);
  }
    function balance_price($reserv_no,$plus_price,$minus_price){

        $sql = "select * from reservation_amount where reserv_user_no='{$reserv_no}'";
        echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $balance_price = (($row['reserv_balance_price'] - $minus_price) + $plus_price);
        //echo " $balance_price = (({$row['reserv_balance_price']} - $minus_price) + $plus_price);";


        $sql_price = "update reservation_amount set reserv_balance_price='{$balance_price}'  where reserv_user_no='{$reserv_no}'";
        //echo $sql_price ;
        $this->db->sql_query($sql_price);
    }
    function reserv_content($reserv_no,$subject,$content,$person){

      $indate = date("Y-m-d H:i:s", time());
      $ip =  $_SERVER["REMOTE_ADDR"];
      $sql = "insert into reservation_content(reserv_user_no,reserv_title,reserv_content,person,ip,indate) values ('{$reserv_no}','{$subject}','{$content}','{$person}','{$ip}','{$indate}')";
      $this->db->sql_query($sql);
    }
    function start_date_change($reserv_no){
        $sql = "select reserv_type,reserv_tour_start_date,reserv_tour_end_date from reservation_user_content where no='{$reserv_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);



        if(strpos($row['reserv_type'],"A")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"A");
            $start_date1 = explode(" ",$date_start[0]);
            $end_date1  = explode(" ",$date_start[1]);
            $start_date = $start_date1[0];
            $end_date   = $end_date1[0];

        }else if(strpos($row['reserv_type'],"C")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"C");
            $start_date1 = explode(" ",$date_start[0]);
            $end_date1 = explode(" ",$date_start[1]);
            $start_date = $start_date1[0];
            $end_date   = $end_date1[0];

        }else if(strpos($row['reserv_type'],"T")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"T");
            $start_date = $date_start[0];
            $lod_stay = $date_start[1] +1;
            $end_date = date("Y-m-d",strtotime($date_start[1]."+{$lod_stay} days"));

        }else if(strpos($row['reserv_type'],"B")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"B");
            $start_date = $date_start[0];
            $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));

        }else if(strpos($row['reserv_type'],"X")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"X");
            $start_date = $date_start[0];
            $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));

        }else if(strpos($row['reserv_type'],"P")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"P");
            $start_date = $date_start[0];
            $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));

        }else if(strpos($row['reserv_type'],"G")!==false){
            $date_start = $this->reserv_start_date($reserv_no,"G");
            $start_date = $date_start[0];
            $end_date = date("Y-m-d",strtotime($start_date."+{$date_start[1]} days"));

        }else{
            $start_date = $row['reserv_tour_start_date'];
            $end_date = $row['reserv_tour_end_date'];

        }

        $sql = "update reservation_user_content set reserv_tour_start_date='{$start_date}', reserv_tour_end_date='{$end_date}' where no='{$reserv_no}'";
        $this->db->sql_query($sql);
    }
    function pageing(){
        // 페이지번호 & 블럭 설정
        $first_page = (($this->block - 1) * $this->block_set) + 1; // 첫번째 페이지번호
        $last_page = min ($this->total_page, $this->block * $this->block_set); // 마지막 페이지번호

        $prev_page = $this->page - 1; // 이전페이지
        $next_page = $this->page + 1; // 다음페이지

        $prev_block = $this->block - 1; // 이전블럭
        $next_block = $this->block  + 1; // 다음블럭

// 이전블럭을 블럭의 마지막으로 하려면...
        $prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호
// 이전블럭을 블럭의 첫페이지로 하려면...
//$prev_block_page = $prev_block * $block_set - ($block_set - 1);
        $next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호

// 페이징 화면
        echo ($prev_page > 0) ? "<a href='{$_SERVER['PHP_SELF']}?page_no={$prev_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src=\"./image/prev_btn.png\" /></a> " : "<img src=\"./image/prev_btn.png\" /> ";
        echo ($prev_block > 0) ? "<a href='{$_SERVER['PHP_SELF']}?page_no={$prev_block_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src=\"./image/prev_btn2.png\" /></a> " : "<img src=\"./image/prev_btn2.png\" />&nbsp;";

        for ($i=$first_page; $i<=$last_page; $i++) {
            if($last_page==$i){$bar = "";}else{$bar = "<img src=\"./image/bar.png\" />";}
            echo ($i != $this->page) ? "<span><a href='{$_SERVER['PHP_SELF']}?page_no={$i}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'>$i</a></span>" : "</span><a href=\"#none\"  class=\"current\">$i</a></span> ";
            echo "{$bar}";
        }

        echo ($next_block <= $this->total_block) ? "&nbsp;<a href='{$_SERVER['PHP_SELF']}?page_no={$next_block_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src=\"./image/next_btn2.png\" /></a>&nbsp;" : " <img src=\"./image/next_btn2.png\" /> ";
        echo ($next_page <= $this->total_page) ? " <a href='{$_SERVER['PHP_SELF']}?page_no={$next_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src=\"./image/next_btn.png\" /></a>" : "<img src=\"./image/next_btn.png\" />";

    }
    function reserv_state(){
      $sql = "select reserv_state from reservation_user_content where no='{$this->res_no}'";
      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);

      switch ($row['reserv_state']){
          case "WT" :
            $state = "접수";
            break;
          case "BL" :
            $state = "보류";
            break;
          case "OK" :
            $state = "완료";
            break;
          case "CL" :
            $state = "취소";
            break;
          case "GL" :
            $state = "결항";
            break;
          case "BJ" :
            $state = "결항";
            break;
      }

      return $state;

    }
    function air_basic_list(){
      $sql = "select * from reservation_air_basic where reserv_user_no='{$this->res_no}'";
      $rs  = $this->db->sql_query($sql);
      while($row = $this->db->fetch_array($rs)){
          $result[] = $row;
      }

      return $result;
    }
    function rent_basic_list(){
        $sql = "select * from reservation_rent_basic where reserv_user_no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function tel_basic_list(){
        $sql = "select * from reservation_lodging_basic where reserv_user_no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function bus_basic_list(){
        $sql = "select * from reservation_bus_basic where reserv_user_no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function bustour_basic_list(){
        $sql = "select * from reservation_bustour_basic where reserv_user_no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function golf_basic_list(){
        $sql = "select * from reservation_golf_basic where reserv_user_no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function reservation_user(){
        $sql = "select * from reservation_user_content where no='{$this->res_no}'";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function staff_name(){
        $sql = "select ad_name from ad_member where no='{$this->staff_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['ad_name'];
    }
    function equip_price(){
      $total_price =0;
      $total_deposit_price = 0;
      $sql = "select * from equipment_list where no='{$this->equip_no}'";

      $rs  = $this->db->sql_query($sql);
      $row = $this->db->fetch_array($rs);
      if($this->equip_stay > 0 ) {
          $total_price = $row['equip_amount'] * $this->equip_stay;
          $total_deposit_price = $row['equip_amount_deposit'] * $this->equip_stay;
      }else{
          $total_price = $row['equip_amount'];
          $total_deposit_price = $row['equip_amount_deposit'];
      }
      if($this->equip_number > 0) {
          $total_price = $total_price * $this->equip_number;
          $total_deposit_price = $total_deposit_price * $this->equip_number;
      }else{
          $total_price = $row['equip_amount'];
          $total_deposit_price = $row['equip_amount_deposit'];
      }
      if($this->equip_vehicle > 0) {
          $total_price = $total_price * $this->equip_vehicle;
          $total_deposit_price = $total_deposit_price * $this->equip_vehicle;
      }else{
          $total_price = $row['equip_amount'];
          $total_deposit_price = $row['equip_amount_deposit'];
      }
      return array($total_price,$total_deposit_price,$row['equip_name']);
    }

}
?>