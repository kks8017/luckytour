<?php
class bus {
    var $db;
    public $start_date;
    public $stay;
    public $bus_vehicle;
    public $bus_no;

    public function __construct()
    {
        $this->db = new tour_db();
    }
    public function bus_name(){
        $sql = "select * from bus_taxi_car where no='{$this->bus_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['bus_name'];
    }
    public function bus_list(){
        $sql = "select * from bus_taxi_car where no='{$this->bus_no}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row;
    }
    public function bus_price(){
        $sql = "select * from bus_taxi_amount where bus_taxi_no='{$this->bus_no}'";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        switch ($this->stay){
            case 1 :
                $bus_price = $row['bus_taxi_amount_1'] * $this->bus_vehicle;
                break;
            case 2 :
                $bus_price = $row['bus_taxi_amount_2'] * $this->bus_vehicle;
                break;
            case 3 :
                $bus_price = $row['bus_taxi_amount_3'] * $this->bus_vehicle;
                break;
            case 4 :
                $bus_price = $row['bus_taxi_amount_4'] * $this->bus_vehicle;
                break;
            case 5 :
                $bus_price = $row['bus_taxi_amount_5'] * $this->bus_vehicle;
                break;
            case 6 :
                $bus_price = $row['bus_taxi_amount_6'] * $this->bus_vehicle;
                break;
            case 7 :
                $bus_price = $row['bus_taxi_amount_7'] * $this->bus_vehicle;
                break;
            case 8 :
                $bus_price = $row['bus_taxi_amount_8'] * $this->bus_vehicle;
                break;
            case 9 :
                $bus_price = $row['bus_taxi_amount_9'] * $this->bus_vehicle;
                break;
            case 10 :
                $bus_price = $row['bus_taxi_amount_10'] * $this->bus_vehicle;
                break;
        }
        $bus_price_deposit = $row['bus_taxi_amount_deposit'] * $this->stay;
        $bus_price_deposit = $bus_price_deposit * $this->bus_vehicle;
        return array($bus_price,$bus_price_deposit);
    }
}
?>