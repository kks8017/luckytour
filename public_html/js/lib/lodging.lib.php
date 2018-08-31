<?php
class lodging {
    var $db;
    public $lodno;
    public $roomno;
    public $start_date;
    public $stay;
    public $adult_number,$child_number,$baby_number;
    public $lodging_vehicle;

    public function __construct()
    {
        $this->db = new tour_db();
    }
    public function price_date(){
        $sql = "select lodging_season_end_date from lodging_season_list where lodging_no='{$this->lodno}' order by lodging_season_end_date desc";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['lodging_season_end_date'];
    }
    public  function lodging_main_image(){
        $sql = "select lodging_image_file_m from lodging_image where lodging_no='{$this->lodno}' order by no asc";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['lodging_image_file_m'];

    }
    public function lodging_sub_image(){
        $sql = "select lodging_image_file_m from lodging_image where lodging_no='{$this->lodno}' order by no asc";
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    public function lodging_code($type){
        $sql = "select no,lodging_config_name,lodging_config_chk from lodging_config where  lodging_config_type='{$type}' order by lodging_config_sort_no";
        $rs  = $this->db->sql_query($sql);
        while( $row = $this->db->fetch_array($rs)) {
            $result[] = $row;
        }
        return $result;
    }
    public function lodging_detail(){
        $sql = "select * from lodging_list where no='{$this->lodno}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row;
    }
    public function lodging_room_name(){
        $sql ="select lodging_name,lodging_room_name from lodging_list,lodging_room where lodging_list.no=lodging_room.lodging_no and lodging_list.no= '{$this->lodno}' and lodging_room.no='{$this->roomno}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return array($row['lodging_name'],$row['lodging_room_name']);
    }
    //숙소코드명 가져오는 함수
    public function lodging_code_name($no){
        $sql = "select no,lodging_config_name from lodging_config where  no='{$no}' order by lodging_config_sort_no";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['lodging_config_name'];
    }
    public function lodging_list(){
        $sql = "select * from lodging_list  order by lodging_name ";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    public function room_list(){
        $sql = "select * from lodging_room where lodging_no='{$this->lodno}' order by lodging_room_sort ";
    //    echo $sql;
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    public  function room_main_image(){
        $sql = "select lodging_room_image_file_m from lodging_room_image where lodging_room_no='{$this->roomno}' order by no asc";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['lodging_room_image_file_m'];

    }
    public function room_sub_image(){
        $sql = "select lodging_room_image_file_m from lodging_room_image where lodging_room_no='{$this->roomno}' and  order by no asc";
        echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    public function lodging_add_price($adult_add,$child_add){

        $sql = "select lodging_room_min,lodging_room_max from lodging_room where no='{$this->roomno}'";
       // echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);



        if($this->adult_number < 1){
            $total_number = 2;
        }else {
            $total_number = $this->adult_number + $this->child_number + $this->baby_number;
        }
        $tmp_child_number = $this->child_number + $this->baby_number;
        $tmp_basic_number = $row['lodging_room_min'] * $this->lodging_vehicle;
        $tmp_add_number   = $total_number - $tmp_basic_number;

        if($this->adult_number == $row['lodging_room_min']){
            $add_adult_number = 0;
            $add_child_number = $tmp_add_number;
        }else{
            if($this->adult_number < $row['lodging_room_min']) {
                $add_adult_number = 0;
                $add_child_number = $tmp_add_number;
            }else{
                $add_adult_number = $tmp_add_number - $tmp_child_number;
                if($tmp_child_number >0) {
                    $add_child_number = $tmp_add_number - $row['lodging_room_min'];
                }else{
                    $add_child_number = 0;
                }
            }

        }

      //  echo " $add_adult_number = $adult_number - ({$row['lodging_room_min']} * $this->lodging_vehicle)";
      //  echo "$add_adult_number = $add_number -($this->child_number + $this->baby_number)<br>";


     //   echo $add_adult_number."====".$add_child_number;
       // echo "$add_child_number =  ($this->child_number + $this->baby_number) - $add_number";
       // echo "$add_child_number = $total_number - $this->adult_number";
        if($row['lodging_room_min'] < $total_number){
            $add_adult_price = $adult_add *  $add_adult_number;

            $add_child_price = $child_add *  $add_child_number;
            $total_price = $add_adult_price + $add_child_price;
        }else{

            $total_price = 0;
        }
       // echo $total_price;
        return $total_price;

    }
    function lodging_basic_price(){
        $sql = "select * from lodging_amount where lodging_no='{$this->lodno}' and  lodging_room_no='{$this->roomno}'";
       // echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
        $start_this_date = $this->start_date;
       // $stay = $this->stay;

        $start_week = date('w', strtotime($start_this_date));

        if(strpos($row['lodging_week'],$start_week)!==false) {
            $tel_price = $row['lodging_amount_tel_week'];
            $airtel_price = $row['lodging_amount_airtel_week'];
            $aircartel_price = $row['lodging_amount_aircartel_week'];
            $deposit_price = $row['lodging_amount_deposit_week'];
            $basic_price = $row['lodging_amount_basic_week'];

        }else{
            $tel_price = $row['lodging_amount_tel'];
            $airtel_price = $row['lodging_amount_airtel'];
            $aircartel_price = $row['lodging_amount_aircartel'];
            $deposit_price = $row['lodging_amount_deposit'];
            $basic_price = $row['lodging_amount_basic'];

        }
        $add_price = $this->lodging_add_price($row['lodging_amount_adult_add'],$row['lodging_amount_child_add']);
      // echo "$tel_price === $airtel_price === $aircartel_price ==== $add_price  ==== $deposit_price";
        return array($tel_price,$airtel_price,$aircartel_price,$add_price,$deposit_price,$basic_price);
    }
    function lodging_season_list(){
       // $end_date = $end_date = date("Y-m-d",strtotime($this->start_date."+{$this->stay} days"));

        $sql = "select * from lodging_season_list where  lodging_no='{$this->lodno}' and  lodging_season_start_date <='{$this->start_date}' and  lodging_season_end_date > '{$this->start_date}'";
        $rs  = $this->db->sql_query($sql);
        $num = $this->db->num_rows($rs);

        if($num >1){
            $sql_season = "select * from lodging_season_list where  lodging_no='{$this->lodno}' and  lodging_season_start_date <='{$this->start_date}' and  lodging_season_end_date > '{$this->start_date}' order by  lodging_season_start_date desc limit 1";
        }else{
            $sql_season = "select * from lodging_season_list where  lodging_no='{$this->lodno}' and  lodging_season_start_date <='{$this->start_date}' and  lodging_season_end_date > '{$this->start_date}' order by  lodging_season_start_date asc limit 1";
        }
       // echo $sql_season."<br>";
        $rs_season  = $this->db->sql_query($sql_season);
        $row_season = $this->db->fetch_array($rs_season);

        return $row_season['no'];
    }
    function lodging_season_price($lodging_season_no){

       // $lodging_season_no = $this->lodging_season_list();

        $sql = "select * from lodging_season_amount where lodging_no='{$this->lodno}' and  lodging_room_no='{$this->roomno}' and  lodging_season_no='{$lodging_season_no}'";
      //  echo $sql."<br>";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
        $start_this_date = $this->start_date;
        // $stay = $this->stay;

        $start_week = date('w', strtotime($start_this_date));

        if(strpos($row['lodging_season_week'],$start_week)!==false) {

            $tel_price = $row['lodging_season_tel_week'];
            $airtel_price = $row['lodging_season_airtel_week'];
            $aircartel_price = $row['lodging_season_aircartel_week'];
            $deposit_price = $row['lodging_season_deposit_week'];

        }else{

            $tel_price = $row['lodging_season_tel'];
            $airtel_price = $row['lodging_season_airtel'];
            $aircartel_price = $row['lodging_season_aircartel'];
            $deposit_price = $row['lodging_season_deposit'];
        }
        $add_price = $this->lodging_add_price($row['lodging_season_adult_add'],$row['lodging_season_child_add']);

        return array($tel_price,$airtel_price,$aircartel_price,$add_price,$deposit_price);
    }
    public function lodging_main_price(){
        $tel_price = $airtel_price = $aircartel_price = $add_price =  $deposit_price = 0;
        $lodging_season_no = $this->lodging_season_list();
        for($i=0;$i < $this->stay ;$i++) {
            $this->start_date = date("Y-m-d",strtotime($this->start_date."+{$i} days"));
            if ($lodging_season_no) {
               $lodging_price =  $this->lodging_season_price($lodging_season_no);
                $tel_price += $lodging_price[0];
                $airtel_price += $lodging_price[1];
                $aircartel_price += $lodging_price[2];
                $add_price += $lodging_price[3];
                $deposit_price += $lodging_price[4];

            } else {
                $lodging_price =  $this->lodging_basic_price();
                $tel_price += $lodging_price[0];
                $airtel_price += $lodging_price[1];
                $aircartel_price += $lodging_price[2];
                $add_price += $lodging_price[3];
                $deposit_price += $lodging_price[4];
                //echo "$tel_price === $airtel_price === $aircartel_price ==== $add_price  ==== $deposit_price";

            }
        }

        return array($tel_price,$airtel_price,$aircartel_price,$add_price,$deposit_price);
    }
}
?>