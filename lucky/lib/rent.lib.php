<?php
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

class rent{
    var $db;
    public $carno;
    public $comno;
    public $start_date;
    public $end_date;

    public function __construct()
    {
        $this->db = new tour_db();
    }
    //렌트카코드타입별 리스트가져오는 함수
    public function rent_code($type){
        $sql = "select no,rent_config_name,rent_config_chk from rent_config where  rent_config_type='{$type}' order by rent_config_sort_no";
        $rs  = $this->db->sql_query($sql);
        while( $row = $this->db->fetch_array($rs)) {
            $result[] = $row;
        }
        return $result;
    }
    //렌트카코드명 가져오는 함수
    public function rent_code_name($no){
        $sql = "select no,rent_config_name from rent_config where  no='{$no}' order by rent_config_sort_no";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['rent_config_name'];
    }
    public function rent_list(){

        $sql = "select * from rent_car_detail where rent_com_no='{$this->comno}' order by rent_car_name asc";
      //  echo $sql;
        $rs  = $this->db->sql_query($sql);
        while( $row = $this->db->fetch_array($rs)) {
            $result[] = $row;
        }
        return $result;

    }
    public function car_list(){

        $sql = "select * from rent_car_detail where no='{$this->carno}' order by rent_car_name asc";
         // echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row;

    }
    //렌트카업체리스트 가져오는 함수
    public function company_list(){
        $sql = "select rent_car_detail.no,rent_car_no,rent_com_no,rent_com_name from rent_car_detail,rent_company where rent_company.no=rent_car_detail.rent_com_no and (rent_car_detail.rent_car_no='{$this->carno}' or  rent_car_detail.no='{$this->carno}') ";
       // echo $sql;
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] =$row;
        }

        return $result;
    }
    //렌트카업체명 가져오는 함수
    public function company_name(){
        $sql = "select rent_com_name from rent_company where no='{$this->comno}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['rent_com_name'];
    }
    public function company_phone(){
        $sql = "select rent_com_phone from rent_company where no='{$this->comno}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['rent_com_phone'];
    }
    public function company_all(){
        $sql = "select * from rent_company ";
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    //렌트카 시간계산 함수
    public function rent_time(){
        $time24 = $time12 = $time6 = $time_add = 0;

        $time = round(( strtotime($this->end_date) - strtotime($this->start_date) ) / 3600);
       // echo $time;

        $time24 = floor($time/24);
        $tmp = ($time - ($time24*24));
        if($tmp >= 12){
            $time12 = sprintf('%d',$tmp / 12) ;
            $tmp = ($time - (($time24*24) + ($time12 * 12) ));
        }
        if($tmp >= 6){
            $time6 = sprintf('%d',$tmp / 6) ;
            $tmp = ($time - (($time24*24) + ($time12 * 12) + ($time6 * 6) ));
        }
        if($tmp < 6){
            $time_add =  sprintf('%d',$tmp / 1) ;
            $tmp = ($time - (($time24*24) + ($time12 * 12) + ($time6 * 6) + ($time_add*1)));
        }

        return array($time,$time24,$time12,$time6,$time_add);

    }
    //렌트카 기본 요금 계산 함수
    public function rent_basic_price(){
        $sql = "select * from rent_amount where rent_com_no='{$this->comno}' and rent_car_no='{$this->carno}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $use_time = $this->rent_time();
        if($use_time[0] < 24){
            $amt24 = $row['rent_amount_24hour'];
            $total_basic_price = $amt24;
        }else {
            if ($use_time[4] > 1) {
                $amt24 = $row['rent_amount_24hour'] * $use_time[1];
                $amt12 = $row['rent_amount_12hour'] * $use_time[2];
                $amt6 = $row['rent_amount_6hour'] * ($use_time[3] + 1);
                $amt_add = 0;

            } else {
                $amt24 = $row['rent_amount_24hour'] * $use_time[1];
                $amt12 = $row['rent_amount_12hour'] * $use_time[2];
                $amt6 = $row['rent_amount_6hour'] * $use_time[3];
                $amt_add = $row['rent_sale_additional'] * $use_time[4];
            }
            $total_basic_price = $amt24+$amt12+$amt6+$amt_add;
        }




        return $total_basic_price;
    }
    //렌트카 기본할인요금 계산 함수
    public function rent_basic_sale_price(){
        $sql = "select * from rent_amount where rent_com_no='{$this->comno}' and rent_car_no='{$this->carno}'";
       // echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $basic_price = $this->rent_basic_price();
        $start_this_date = $this->start_date;
        $start_week = date('w', strtotime($start_this_date));

        if(strpos($row['rent_sale_week'],$start_week)!==false){
            $sale_car       = $row['rent_sale_car_week'];
            $sale_aircar    = $row['rent_sale_aircar_week'];
            $sale_aircartel = $row['rent_sale_aircartel_week'];
            $sale_deposit   = $row['rent_sale_deposit_week'];

            $sale_car_price       = $basic_price * ($row['rent_sale_car_week']/100);
            $sale_aircar_price     = $basic_price * ($row['rent_sale_aircar_week']/100);
            $sale_aircartel_price = $basic_price * ($row['rent_sale_aircartel_week']/100);
            $sale_deposit_price   = $basic_price * ($row['rent_sale_deposit_week']/100);

            $sale_car_price       = $basic_price - $sale_car_price;
            $sale_aircar_price    = $basic_price - $sale_aircar_price;
            $sale_aircartel_price = $basic_price - $sale_aircartel_price;
            $sale_deposit_price   = $basic_price - $sale_deposit_price;
        }else{
            $sale_car       = $row['rent_sale_car'];
            $sale_aircar    = $row['rent_sale_aircar'];
            $sale_aircartel = $row['rent_sale_aircartel'];
            $sale_deposit   = $row['rent_sale_deposit'];

            $sale_car_price       = $basic_price * ($row['rent_sale_car']/100);
            $sale_aircar_price    = $basic_price * ($row['rent_sale_aircar']/100);
            $sale_aircartel_price = $basic_price * ($row['rent_sale_aircartel']/100);
            $sale_deposit_price   = $basic_price * ($row['rent_sale_deposit']/100);

            $sale_car_price       = $basic_price - $sale_car_price;
            $sale_aircar_price    = $basic_price - $sale_aircar_price;
            $sale_aircartel_price = $basic_price - $sale_aircartel_price;
            $sale_deposit_price   = $basic_price - $sale_deposit_price;
        }
        //0판매가,1에어카가,2에어카텔가,3입금가,4판매할인율,5에어카할인율,6에어카텔할인율,7입금할인율
        return array($sale_car_price,$sale_aircar_price,$sale_aircartel_price,$sale_deposit_price,$sale_car,$sale_aircar,$sale_aircartel,$sale_deposit);
    }
    //렌트카 기간리스트 가져오는 함수
    public function rent_season_list(){
        $season_start_date = explode(" ",$this->start_date);
        $sql = "select no from rent_season_list where rent_com_no='{$this->comno}' and rent_season_start_date <= '{$season_start_date[0]}' and  rent_season_end_date  > '{$season_start_date[0]}'  ";

        $rs  = $this->db->sql_query($sql);
        $num = $this->db->num_rows($rs);
        if($num >1) {
            $sql_season = "select no from rent_season_list where rent_com_no='{$this->comno}' and rent_season_start_date <= '{$season_start_date[0]}' and  rent_season_end_date  > '{$season_start_date[0]}' order by rent_season_start_date desc limit 1";
        }else{
            $sql_season = "select no from rent_season_list where rent_com_no='{$this->comno}' and rent_season_start_date <= '{$season_start_date[0]}' and  rent_season_end_date  > '{$season_start_date[0]}' order by rent_season_start_date limit 1 ";
        }
        $rs_season  = $this->db->sql_query($sql_season);
        $row_season = $this->db->fetch_array($rs_season);

        return $row_season['no'];
    }
    //렌트카 기간 요금계산 함수
    public function  rent_season_price(){
        $season = $this->rent_season_list();

        $sql = "select * from rent_season_amount where rent_season_no='{$season}'  and rent_car_no='{$this->carno}'";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
      //  print_r($row);
       // echo $row['rent_season_amount_24hour'];
        $use_time = $this->rent_time();
        if($use_time[0] < 24) {
            $amt24 = $row['rent_season_amount_24hour'];
            $total_basic_price = $amt24;
        }else {
            if ($use_time[4] > 1) {
                $amt24 = $row['rent_season_amount_24hour'] * $use_time[1];
                $amt12 = $row['rent_season_amount_12hour'] * $use_time[2];
                $amt6 = $row['rent_season_amount_6hour'] * ($use_time[3] + 1);
                $amt_add = 0;
                //    echo $row['rent_season_amount_24hour']."===".$amt12."===".$amt6;
            } else {
                $amt24 = $row['rent_season_amount_24hour'] * $use_time[1];
                $amt12 = $row['rent_season_amount_12hour'] * $use_time[2];
                $amt6 = $row['rent_season_amount_6hour'] * $use_time[3];
                $amt_add = $row['rent_season_sale_additional'] * $use_time[4];
            }
            $total_basic_price = $amt24+$amt12+$amt6+$amt_add;
        }

        //echo $total_basic_price;

        return $total_basic_price;
    }
    //렌트카 기간 할인요금 계산 함수
    public function  rent_season_sale_price(){
        $season = $this->rent_season_list();


        $sql = "select * from rent_season_amount where rent_season_no='{$season}'  and rent_car_no='{$this->carno}'";
      //  echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $start_this_date = $this->start_date;
        $start_week = date('w', strtotime($start_this_date));

        $season_price = $this->rent_season_price();
     //   echo $season_price;
        if(strpos($row['rent_sale_week'],$start_week)!==false){
          //  echo "주말";
            $sale_car       = $row['rent_season_sale_car_week'];          //판매
            $sale_aircar    = $row['rent_season_sale_aircar_week'];      //에어카
            $sale_aircartel = $row['rent_season_sale_aircartel_week'];  //에어카텔
            $sale_deposit   = $row['rent_season_sale_deposit_week'];    //입금

            $sale_car_price       = $season_price * ($row['rent_season_sale_car_week']/100);
            $sale_aircar_price    = $season_price * ($row['rent_season_sale_aircar_week']/100);
            $sale_aircartel_price = $season_price * ($row['rent_season_sale_aircartel_week']/100);
            $sale_deposit_price   = $season_price * ($row['rent_season_sale_deposit_week']/100);

            $sale_car_price       = $season_price - $sale_car_price;
            $sale_aircar_price    = $season_price - $sale_aircar_price;
            $sale_aircartel_price = $season_price - $sale_aircartel_price;
            $sale_deposit_price   = $season_price - $sale_deposit_price;
        }else{
            //echo "주중";
            $sale_car       = $row['rent_season_sale_car'];
            $sale_aircar    = $row['rent_season_sale_aircar'];
            $sale_aircartel = $row['rent_season_sale_aircartel'];
            $sale_deposit   = $row['rent_season_sale_deposit'];

            $sale_car_price       = $season_price * ($row['rent_season_sale_car']/100);
            $sale_aircar_price    = $season_price * ($row['rent_season_sale_aircar']/100);
            $sale_aircartel_price = $season_price * ($row['rent_season_sale_aircartel']/100);
            $sale_deposit_price   = $season_price * ($row['rent_season_sale_deposit']/100);

            $sale_car_price       = $season_price - $sale_car_price;
            $sale_aircar_price    = $season_price - $sale_aircar_price;
            $sale_aircartel_price = $season_price - $sale_aircartel_price;
            $sale_deposit_price   = $season_price - $sale_deposit_price;
        }
        //0판매가,1에어카가,2에어카텔가,3입금가,4판매할인율,5에어카할인율,6에어카텔할인율,7입금할인율
        return array($sale_car_price,$sale_aircar_price,$sale_aircartel_price,$sale_deposit_price,$sale_car,$sale_aircar,$sale_aircartel,$sale_deposit);

    }
    //렌트카 요금 불러오는 메인함수
    public function rent_price_main(){
        $season = $this->rent_season_list();
        if($season){

            $price = $this->rent_season_sale_price();
           // echo  "시즌".$price[0]."===".$price[1]."===".$price[2];
        }else{

            $price = $this->rent_basic_sale_price();
          //  echo  $price[0]."===".$price[1]."===".$price[2];
        }

        return $price;

    }

}
?>