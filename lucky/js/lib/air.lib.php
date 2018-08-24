<?php
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

class air{
    var $db;
    public $air_name;
    public function __construct()
    {
        $this->db = new tour_db();
    }

    function air_sale_price($adult_price,$child_price,$adult_sale,$child_sale){

        $adult_price_normal = ($adult_price - 8000);
        $child_price_normal = ($child_price - 4000);

        $adult_price = ($adult_price_normal * ($adult_sale /100))+8000;
        $child_price = ($child_price_normal * ($child_sale /100))+4000;


        return array($adult_price,$child_price);
    }
    function air_deposit_price($adult_price,$child_price,$adult_sale,$child_sale){

        $adult_price_normal = ($adult_price - 8000);
        $child_price_normal = ($child_price - 4000);
        if($adult_sale > 0) {
            $adult_deposit_sale = ($adult_sale + 5);
            $child_deposit_sale = ($child_sale + 5);
            $adult_price_a = ($adult_price_normal * ($adult_deposit_sale /100))+8000;
            $child_price_a = ($child_price_normal * ($child_deposit_sale /100))+4000;
            $adult_price = $adult_price - $adult_price_a;
            $child_price = $child_price - $child_price_a;
        }else{
            $adult_deposit_sale = $adult_sale ;
            $child_deposit_sale = $child_sale ;
            $adult_price = $adult_price_normal + 8000;
            $child_price = $child_price_normal + 4000;
        }

        return array($adult_price,$adult_deposit_sale,$child_price,$child_deposit_sale);
    }
    function oil($start_date){
        $SQL = "select a_oil_oil_price from air_oil_comm where a_oil_start_date <= '{$start_date}' and a_oil_end_date > '{$start_date}' ";
        $rs  = $this->db->sql_query($SQL);
        $row = $this->db->fetch_array($rs);

        return $row['a_oil_oil_price'];
    }
    function comm($start_date){
        $SQL = "select a_oil_com_price from air_oil_comm where a_oil_start_date <= '{$start_date}' and a_oil_end_date > '{$start_date}' ";
        $rs  = $this->db->sql_query($SQL);
        $row = $this->db->fetch_array($rs);

        return $row['a_oil_com_price'];
    }
    function air_company(){
        $sql  = "select * from air_company where air_name='{$this->air_name}' and air_type='S' ";

        $rs   = $this->db->sql_query($sql);
        $row  = $this->db->fetch_array($rs);

        return $row;
    }
    function air_line_img(){
        switch ($this->air_name){
            case "대한항공" :
                $airline_img = "/sub_img/big_korean.png";
                break;
            case "아시아나" :
                $airline_img = "/sub_img/big_asiana.png";
                break;
            case "제주항공" :
                $airline_img = "/sub_img/big_jeju.png";
                break;
            case "진에어" :
                $airline_img = "/sub_img/big_jinair.png";
                break;
            case "티웨이항공" :
                $airline_img = "/sub_img/big_tway.png";
                break;
            case "이스타항공" :
                $airline_img = "/sub_img/big_estar.png";
                break;
            case "에어부산" :
                $airline_img = "/sub_img/big_airbusan.png";
                break;
        }

        return $airline_img;
    }


}
?>