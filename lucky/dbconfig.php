<?php
class tour_db {
    public $db;
    public $result;
    public $host = HOST ;
    public $user = USER;
    public $passwd = PASSWD;
    public $db_name = DBNAME;


    function tour_db_connect(){
        $this->db = mysqli_connect($this->host,$this->user,$this->passwd,$this->db_name);
        return $this->db;
    }

    function sql_query($sql){
        // Blind SQL Injection 취약점 해결
      //  echo $sql;
       // exit-1;
        $sql = trim($sql);
        // union의 사용을 허락하지 않습니다.
        //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
        $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
        // `information_schema` DB로의 접근을 허락하지 않습니다.
        $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);
        //echo $sql;
        $this->result = mysqli_query($this->tour_db_connect() ,$sql);
        //echo $this->result;
        return $this->result;
    }
    function multi_query($sql){
        $sql = trim($sql);
        // union의 사용을 허락하지 않습니다.
        //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
        $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
        // `information_schema` DB로의 접근을 허락하지 않습니다.
        $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);
        //echo $sql;
        $this->result = mysqli_multi_query($this->tour_db_connect() ,$sql);

    }
    function fetch_array($rs){
        $this->array = mysqli_fetch_array($rs);
        return $this->array;
    }
    function fetch_assoc($rs){
        $this->array = mysqli_fetch_assoc($rs);
        return $this->array;
    }
    function insert_id(){
        $this->array = mysqli_insert_id($this->db);
        return $this->array;
    }
    function num_rows($rs){
        $this->array = mysqli_num_rows($rs);
        return $this->array;
    }


}
$db = new tour_db();
?>