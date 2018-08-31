<?php
class golf{
    var $db;
    public $golf_no,$hole_no,$start_date,$stay,$adult_number;

    public function __construct()
    {
        $this->db = new tour_db();
    }
    public function golf_code($type){
        $sql = "select no,golf_config_name,golf_config_chk from golf_config where  golf_config_type='{$type}' order by golf_config_sort_no";
        $rs  = $this->db->sql_query($sql);
        while( $row = $this->db->fetch_array($rs)) {
            $result[] = $row;
        }
        return $result;
    }
    //숙소코드명 가져오는 함수
    public function golf_code_name($no){
        $sql = "select no,golf_config_name from golf_config where  no='{$no}'";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['golf_config_name'];
    }

    public  function golf_main_image(){
        $sql = "select golf_image_file_m from golf_image where golf_no='{$this->golf_no}' order by no desc";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['golf_image_file_m'];

    }
    public  function golf_sub_image(){
        $sql = "select golf_image_file_m from golf_image where golf_no='{$this->golf_no}' order by no desc limit 6";
      //  echo $sql;
        $rs  = $this->db->sql_query($sql);
        while( $row = $this->db->fetch_array($rs)) {
            $result[] = $row;
        }

        return $result;

    }
    public function golf_list(){
        $sql = "select * from golf_list where golf_open_chk='Y' order by no ";
       // echo $sql;
        //exit-1;
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    public function hole_list(){
        $sql = "select * from golf_hole_list where golf_no='{$this->golf_no}' order by no ";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    public function golf_name(){
        $sql ="select golf_name,hole_name from golf_list,golf_hole_list where golf_list.no=golf_hole_list.golf_no and golf_list.no= '{$this->golf_no}' and golf_hole_list.no='{$this->hole_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return array($row['golf_name'],$row['hole_name']);
    }
    function golf_basic_price(){
        $sql = "select * from golf_hole_amount where golf_no='{$this->golf_no}' and  hole_no='{$this->hole_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
        $start_this_date = $this->start_date;
        // $stay = $this->stay;

        $start_week = date('w', strtotime($start_this_date));

        if(strpos($row['hole_week'],$start_week)!==false) {
            $basic_price = $row['hole_amount_basic_week'];
            $amount_price = $row['hole_amount_week'];
            $deposit_price = $row['hole_amount_deposit_week'];

        }else{
            $basic_price = $row['hole_amount_basic'];
            $amount_price = $row['hole_amount'];
            $deposit_price = $row['hole_amount_deposit'];

        }

        //  echo "$tel_price === $airtel_price === $aircartel_price ==== $add_price  ==== $deposit_price";
        return array($basic_price,$amount_price,$deposit_price);
    }
    function golf_season_list(){
        // $end_date = $end_date = date("Y-m-d",strtotime($this->start_date."+{$this->stay} days"));

        $sql = "select * from golf_season_list where  golf_no='{$this->golf_no}' and  golf_season_start_date <='{$this->start_date}' and  golf_season_end_date > '{$this->start_date}'";
        $rs  = $this->db->sql_query($sql);
        $num = $this->db->num_rows($rs);

        if($num >1){
            $sql_season = "select * from golf_season_list where  golf_no='{$this->golf_no}' and  golf_season_start_date <='{$this->start_date}' and  golf_season_end_date > '{$this->start_date}' order by  golf_season_start_date desc limit 1";
        }else{
            $sql_season = "select * from golf_season_list where  golf_no='{$this->golf_no}' and  golf_season_start_date <='{$this->start_date}' and  golf_season_end_date > '{$this->start_date}' order by  golf_season_start_date asc limit 1";
        }
        // echo $sql_season."<br>";
        $rs_season  = $this->db->sql_query($sql_season);
        $row_season = $this->db->fetch_array($rs_season);

        return $row_season['no'];
    }
    function golf_season_price($golf_season_no){


        $sql = "select * from golf_hole_amount_season where golf_no='{$this->golf_no}' and  hole_no='{$this->hole_no}' and golf_season_no='{$golf_season_no}'";
        //  echo $sql."<br>";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
        $start_this_date = $this->start_date;
        // $stay = $this->stay;

        $start_week = date('w', strtotime($start_this_date));

        if(strpos($row['golf_season_week'],$start_week)!==false) {
            echo "주말";
            $basic_price = $row['hole_season_amount_basic_week'];
            $amount_price = $row['hole_season_amount_week'];
            $deposit_price = $row['hole_season_amount_deposit_week'];

        }else{
            echo "주중";
            $basic_price = $row['hole_season_amount_basic'];
            $amount_price = $row['hole_season_amount'];
            $deposit_price = $row['hole_season_amount_deposit'];
        }


        return array($basic_price,$amount_price,$deposit_price);
    }
    public function golf_main_price(){
        $basic_price = $amount_price = $deposit_price = 0;
        $golf_season_no = $this->golf_season_list();
        for($i=0;$i < $this->stay ;$i++) {
            $this->start_date = date("Y-m-d",strtotime($this->start_date."+{$i} days"));
            if($golf_season_no){
                $golf_price =  $this->golf_season_price($golf_season_no);
                $basic_price += $golf_price[0] * $this->adult_number;
                $amount_price += $golf_price[1] * $this->adult_number;
                $deposit_price += $golf_price[2] * $this->adult_number;
            }else{
                $golf_price =  $this->golf_basic_price();
                $basic_price += $golf_price[0] * $this->adult_number;
                $amount_price += $golf_price[1] * $this->adult_number;
                $deposit_price += $golf_price[2] * $this->adult_number;
            }
        }
        return array($basic_price,$amount_price,$deposit_price);
    }
}
?>