<?php
class main{
    var $db;
    public $sdate,$total,$used;
    public function __construct()
    {
        $this->db = new tour_db();
        $this->rent = new rent();
        $this->lodging = new lodging();
        $this->golf = new golf();
    }
    function tour_config(){
        $SQL = "select * from tour_company where tour_main='Y'";
        $rs  = $this->db->sql_query($SQL);
        $row = $this->db->fetch_array($rs);

        $SQL_config = "select * from tour_config,tour_company where tour_company.no = tour_config.tour_com_no  and  tour_com_no='{$row['no']}'";
        $rs_config  = $this->db->sql_query($SQL_config);
        $row_config = $this->db->fetch_array($rs_config);


        return $row_config;
    }
    function week(){
        $week = date("w",strtotime($this->sdate));
        switch ($week){
            case 0 :
                $weekly = "일";
                break;
            case 1 :
                $weekly = "월";
                break;
            case 2 :
                $weekly = "화";
                break;
            case 3 :
                $weekly = "수";
                break;
            case 4 :
                $weekly = "목";
                break;
            case 5 :
                $weekly = "금";
                break;
            case 6 :
                $weekly = "토";
                break;

        }

        return $weekly;
    }
    function hour_option($sel=""){
        for($i=5;$i <=20;$i++){
            if($i< 10){$i="0".$i;}else{$i=$i;}
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>$i 시</option>";
        }
    }
    function golf_hour_option($sel=""){
        for($i=6;$i <=18;$i++){
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>$i:00</option>";
        }
    }
    function minute_option($sel=""){
        for($i=0;$i <=59;$i++){
            if($i< 10){$i="0".$i;}else{$i=$i;}
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>$i 분</option>";
        }
    }
    function vehicle_option($sel="",$type=""){
        for($i=1;$i <= 10;$i++){

            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$i} {$type}</option>";
        }
    }
    function number_option($sel="",$type=""){
        if($type=="성인"){$num=1;}else{$num=0;}
        for($i=$num;$i <= 100;$i++){

            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$type}{$i}명</option>";
        }
    }
    function stay_option($sel=""){
        for($i=1;$i <= 10;$i++){

            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$i}박 ".($i+1)."일</option>";
        }
    }
    function rent_type_list($sel=""){
        $rent_type = $this->rent->rent_code("T");
        echo "<option value=''>전체보기</option>";
        foreach ($rent_type as $type){
            if($type['no']==$sel){$select="selected";}else{$select="";}
            echo "<option value='{$type['no']}' {$select}>{$type['rent_config_name']}</option>";
        }
    }

    function lodging_area_list($sel=""){
        $lod_type = $this->lodging->lodging_code("A");
        echo "<option value=''>전체보기</option>";
        foreach ($lod_type as $type){
            if($type['no']==$sel){$select="selected";}else{$select="";}
            echo "<option value='{$type['no']}' {$select}>{$type['lodging_config_name']}</option>";
        }
    }
    function lodging_type_list($sel=""){
        $lod_type = $this->lodging->lodging_code("C");
        echo "<option value=''>전체보기</option>";
        foreach ($lod_type as $type){
            if($type['no']==$sel){$select="selected";}else{$select="";}
            echo "<option value='{$type['no']}' {$select}>{$type['lodging_config_name']}</option>";
        }
    }
    function golf_list_option($sel=""){
        $golf_list = $this->golf->golf_list();
        foreach ($golf_list as $golf){
            if($golf['no']==$sel){$select="selected";}else{$select="";}
            echo "<option value='{$golf['no']}' {$select}>{$golf['golf_name']}</option>";
        }
    }
    function year_option($sel=""){
        $start_date = date("Y");
        for($i=0;$i <= 3;$i++){
            $date   =  date("Y", strtotime($start_date." +{$i} year"));
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$date}</option>";
        }
    }
    function month_option($sel=""){
        for($i=1;$i <= 12;$i++){
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$i}월</option>";
        }
    }
    function day_option($sel=""){
        for($i=1;$i <= 31;$i++){
            if($sel==$i){$select="selected";}else{$select="";}
            echo "<option value='{$i}' {$select}>{$i}일</option>";
        }
    }


}
?>