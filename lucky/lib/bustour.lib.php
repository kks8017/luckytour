<?php
class bustour{
    var $db;
    public $start_date;
    public $number;
    public $bustour_no;

    public function __construct()
    {
        $this->db = new tour_db();
    }
    public function bustour_name(){
        $sql = "select * from bustour_tour where no='{$this->bustour_no}'";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row;
    }
    public function bustour_list(){
        $sql = "select * from bustour_tour where bustour_open='Y' order by bustour_sort_no";
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;
    }
    public function bustour_price(){
        $sql = "select bustour_tour_amount,bustour_tour_amount_receive from bustour_tour where no='{$this->bustour_no}'";
    //    echo $sql;
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $bustour_price = $row['bustour_tour_amount'] * $this->number;
        $bustour_price_deposit = $row['bustour_tour_amount_receive'] * $this->number;

        return array($bustour_price,$bustour_price_deposit);
    }
}
?>