<?php
class main{
    var $db;
    public $sdate,$total,$used,$pack_type;

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
        echo "<option value='00'>00분</option>";
        for($i=0;$i <=55;$i++){
            if($i< 10){$i="0".$i;}else{$i= $i;}
            if($sel==$i){$select="selected";}else{$select="";}
            if($i%5 ==0) {
                echo "<option value='{$i}' {$select}>$i 분</option>";
            }
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
            echo "<option value='{$date}' {$select}>{$date}년</option>";
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
    public function pack_text(){
        switch($this->pack_type){
            case "ACT" :
                $type = "에어카텔";
                break;
            case "AT" :
                $type = "에어텔";
                break;
            case "AC" :
                $type = "에어카";
                break;
            case "CT" :
                $type = "카텔";
                break;
            case "ABT" :
                $type = "에어버스텔";
                break;
            case "AB" :
                $type = "에어버스";
                break;
            case "BT" :
                $type = "버스텔";
                break;
            case "ACTG" :
                $type = "에어카텔골프";
                break;
            case "ATG" :
                $type = "에어텔골프";
                break;
            case "ACG" :
                $type = "에어카골프";
                break;
            case "AG" :
                $type = "항공골프";
                break;
            case "CG" :
                $type = "렌트골프";
                break;
            case "TG" :
                $type = "숙박골프";
                break;
            case "A" :
                $type = "항공";
                break;
            case "C" :
                $type = "렌트";
                break;
            case "T" :
                $type = "숙박";
                break;
            case "B" :
                $type = "버스";
                break;
            case "P" :
                $type = "버스투어";
                break;
            case "G" :
                $type = "골프";
                break;
        }

        return $type;
    }
    function user_ip (){
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
        {    //공용 IP 확인
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            // 프록시 사용하는지 확인
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
       }else{
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        //진짜 IP 정보
        return $ip;
    }
    function best_list(){
        $sql = "select * from best_list order by best_sort";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function mobile_best_list_main(){
        $sql = "select * from best_list order by best_sort limit 0, 1";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
    function mobile_best_list_sub(){
        $sql = "select * from best_list order by best_sort limit 1, 4";
        $rs  = $this->db->sql_query($sql);
        while($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;
    }
}
?>