<?php
class report{
    var $db;
    var $res;
    public $reserv_user_no,$start_date,$end_date,$airline,$area,$company;
    public $staff;
    public $rent_no;
    public $lod_no;
    public $bus_no;
    public $bustour_no;
    public $golf_no;
    public $reserv_state,$search_date,$reserv_price_state,$reserv_deposit_state,$reserv_deposit_state_schedule;
    public $all_price,$refund;

    public function __construct()
    {
        $this->db = new tour_db();
        $this->res =  new reservation();
    }
    function air_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and {$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
            }else{
                $sch_sql .= "and reserv_air_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->airline){
            $sch_sql .= "and reserv_air_departure_airline='{$this->airline}'";
        }
        if($this->area){
            $sch_sql .= "and reserv_air_departure_area='{$this->area}'";
        }
        if($this->company){
            $sch_sql .= "and reserv_air_departure_company='{$this->company}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        if($this->reserv_user_no){
            $sch_sql .= "and reservation_air.reserv_user_no='{$this->reserv_user_no}'";
        }
        $sql = "select * from reservation_air,reservation_user_content  where reservation_user_content.no=reservation_air.reserv_user_no and  reservation_air.reserv_del_mark!='Y' and reserv_state='OK' {$sch_sql} order by reserv_air_departure_date asc,reserv_air_arrival_date asc";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function rent_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and reserv_rent_start_date between '{$this->start_date}' and '{$this->end_date}' ";
            }else{
                $sch_sql .= "and reserv_rent_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->rent_no){
            $sch_sql .= "and reserv_rent_carno='{$this->rent_no}'";
        }
        if($this->company){
            $sch_sql .= "and reserv_rent_com_no='{$this->company}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        if($this->reserv_user_no){
            $sch_sql .= "and reservation_user_content.no='{$this->reserv_user_no}'";
        }
        $sql = "select * from reservation_rent,reservation_user_content where reservation_user_content.no=reservation_rent.reserv_user_no and  reservation_rent.reserv_del_mark!='Y' and  reserv_state='OK' {$sch_sql} order by reserv_rent_start_date asc";
     //   echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function lodging_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and reserv_tel_date between '{$this->start_date}' and '{$this->end_date}' ";
            }else{
                $sch_sql .= "and reserv_tel_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->lod_no){
            $sch_sql .= "and reserv_tel_lodno='{$this->lod_no}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        if($this->reserv_user_no){
            $sch_sql .= "and reservation_user_content.no='{$this->reserv_user_no}'";
        }
        $sql = "select * from reservation_lodging,reservation_user_content where reservation_user_content.no=reservation_lodging.reserv_user_no and  reservation_lodging.reserv_del_mark!='Y' and  reserv_state='OK' {$sch_sql} order by reserv_tel_date asc";
        // echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function bus_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and reserv_bus_date between '{$this->start_date}' and '{$this->end_date}' ";
            }else{
                $sch_sql .= "and reserv_bus_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->bus_no){
            $sch_sql .= "and reserv_bus_no='{$this->bus_no}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_bus,reservation_user_content where reservation_user_content.no=reservation_bus.reserv_user_no and  reservation_bus.reserv_del_mark!='Y' and  reserv_state='OK' {$sch_sql} order by reserv_bus_date asc";
        // echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function bustour_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and reserv_bustour_date between '{$this->start_date}' and '{$this->end_date}' ";
            }else{
                $sch_sql .= "and reserv_bustour_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->bustour_no){
            $sch_sql .= "and reserv_bustour_no='{$this->bustour_no}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_bustour,reservation_user_content where reservation_user_content.no=reservation_bustour.reserv_user_no and  reservation_bustour.reserv_del_mark!='Y' and  reserv_state='OK' {$sch_sql} order by reserv_bustour_date asc";
        // echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function golf_report(){
        $sch_sql = "";
        if($this->start_date){
            if($this->search_date !="deposit") {
                $sch_sql .= "and reserv_golf_date between '{$this->start_date}' and '{$this->end_date}' ";
            }else {
                $sch_sql .= "and reserv_golf_deposit_date between '{$this->start_date}' and '{$this->end_date}' ";
            }
        }
        if($this->golf_no){
            $sch_sql .= "and reserv_golf_name='{$this->golf_no}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_golf,reservation_user_content where reservation_user_content.no=reservation_golf.reserv_user_no and  reservation_golf.reserv_del_mark!='Y' and  reserv_state='OK' {$sch_sql} order by reserv_golf_date asc";
        // echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }

        return $result;

    }
    function reservation_report(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and reservation_user_content.{$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_amount,reservation_user_content where reservation_user_content.no=reservation_amount.reserv_user_no  {$sch_sql} order by reservation_user_content.{$this->search_date} asc";
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;

    }
    function reservation_collect_report(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and {$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->reserv_deposit_state!="" and $this->reserv_deposit_state_schedule!=""){
            $sch_sql .= "and {$this->reserv_deposit_state}='{$this->reserv_deposit_state_schedule}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_amount,reservation_user_content where reservation_user_content.no=reservation_amount.reserv_user_no  {$sch_sql} order by {$this->search_date} asc";
   //     echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;

    }
    function reservation_collect_card_report(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and {$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->reserv_deposit_state_schedule!=""){
            $sch_sql .= " and reserv_amount_card_state='{$this->reserv_deposit_state_schedule}'";
        }
        if($this->staff){
            $sch_sql .= " and reserv_person='{$this->staff}'";
        }
        $sql = "select * from reservation_amount,reservation_user_content,reservation_amount_card where reservation_user_content.no=reservation_amount.reserv_user_no and reservation_amount.no=reservation_amount_card.reserv_amount_no   {$sch_sql} order by {$this->search_date} asc";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;

    }

    function reservation_sell_state(){
        $sql = "select {$this->reserv_price_state} from reservation_amount where  reserv_user_no='{$this->reserv_user_no}'";
        // echo $sql."<br>";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        switch ($row["{$this->reserv_price_state}"]){
            case "Y" :
                $state = "입금완료";
                break;
            default :
                $state = "입금요청";

        }

        return $state;
    }
    function reservation_state_number(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and reservation_user_content.{$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select cnt_wt,cnt_bl,cnt_ok,cnt_cl,cnt_gl,cnt_bj,total_sum from 
                (select count(no) as cnt_wt from reservation_user_content where reserv_del_mark!='Y' and reserv_state='WT' {$sch_sql}) as a,
                (select count(no) as cnt_bl from reservation_user_content where reserv_del_mark!='Y' and reserv_state='BL' {$sch_sql}) as b,
                (select count(no) as cnt_ok from reservation_user_content where reserv_del_mark!='Y' and reserv_state='OK' {$sch_sql}) as c,
                (select count(no) as cnt_cl from reservation_user_content where reserv_del_mark!='Y' and reserv_state='CL' {$sch_sql}) as d,
                (select count(no) as cnt_gl from reservation_user_content where reserv_del_mark!='Y' and reserv_state='GL' {$sch_sql}) as e,
                (select count(no) as cnt_bj from reservation_user_content where reserv_del_mark!='Y' and reserv_state='BJ' {$sch_sql}) as f,
                (select sum(reserv_total_price) as total_sum from reservation_amount,reservation_user_content where reservation_user_content.no=reservation_amount.reserv_user_no and reserv_del_mark!='Y' {$sch_sql}) as g
                
                ";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);



        return $row;
    }
    function reserv_deposit_price(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and reservation_user_content.{$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select  air_price ,rent_price ,lod_price ,bus_price ,bustour_price ,golf_price 
                  from  (select sum(reserv_air_total_deposit_price) as air_price from reservation_air,reservation_user_content where reservation_user_content.no=reservation_air.reserv_user_no and   reservation_air.reserv_del_mark!='Y'{$sch_sql}) as a,
                         (select sum(reserv_rent_total_deposit_price) as rent_price from reservation_rent,reservation_user_content where reservation_user_content.no=reservation_rent.reserv_user_no and  reservation_rent.reserv_del_mark!='Y' {$sch_sql}) as b,
                         (select sum(reserv_tel_total_dposit_price) as lod_price from reservation_lodging,reservation_user_content where reservation_user_content.no=reservation_lodging.reserv_user_no and   reservation_lodging.reserv_del_mark!='Y' {$sch_sql}) as c,
                         (select sum(reserv_bus_total_deposit_price) as bus_price from reservation_bus,reservation_user_content where reservation_user_content.no=reservation_bus.reserv_user_no  and reservation_bus.reserv_del_mark!='Y' {$sch_sql}) as d,
                         (select sum(reserv_bustour_total_deposit_price) as bustour_price from reservation_bustour,reservation_user_content where reservation_user_content.no=reservation_bustour.reserv_user_no and  reservation_bustour.reserv_del_mark!='Y' {$sch_sql}) as f,
                         (select sum(reserv_golf_total_dposit_price) as golf_price from reservation_golf,reservation_user_content where reservation_user_content.no=reservation_golf.reserv_user_no and reservation_golf.reserv_del_mark!='Y' {$sch_sql}) as g
                  ";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $total_price = (int)$row['air_price'] + (int)$row['rent_price'] + (int)$row['lod_price'] + (int)$row['bus_price'] + (int)$row['bustour_price'] +(int) $row['golf_price'];

        return array($total_price,(int)$row['air_price'],(int)$row['rent_price'],(int)$row['lod_price'],(int)$row['bus_price'],(int)$row['bustour_price'],(int) $row['golf_price']);

    }
    function reserv_price(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and reservation_user_content.{$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }
        if($this->staff){
            $sch_sql .= "and reserv_person='{$this->staff}'";
        }
        $sql = "select  air_price ,rent_price ,lod_price ,bus_price  ,bustour_price ,golf_price 
                  from  (select sum(reserv_air_total_price) as air_price from reservation_air,reservation_user_content where reservation_user_content.no=reservation_air.reserv_user_no and   reservation_air.reserv_del_mark!='Y'  {$sch_sql}) as a,
                         (select sum(reserv_rent_total_price) as rent_price from reservation_rent,reservation_user_content where reservation_user_content.no=reservation_rent.reserv_user_no and  reservation_rent.reserv_del_mark!='Y' {$sch_sql}) as b,
                         (select sum(reserv_tel_total_price) as lod_price from reservation_lodging,reservation_user_content where reservation_user_content.no=reservation_lodging.reserv_user_no and   reservation_lodging.reserv_del_mark!='Y' {$sch_sql}) as c,
                         (select sum(reserv_bus_total_price) as bus_price from reservation_bus,reservation_user_content where reservation_user_content.no=reservation_bus.reserv_user_no and reservation_bus.reserv_del_mark!='Y' {$sch_sql}) as d,
                         (select sum(reserv_bustour_total_price) as bustour_price from reservation_bustour,reservation_user_content where reservation_user_content.no=reservation_bustour.reserv_user_no and  reservation_bustour.reserv_del_mark!='Y' {$sch_sql}) as f,
                         (select sum(reserv_golf_total_price) as golf_price from reservation_golf,reservation_user_content where reservation_user_content.no=reservation_golf.reserv_user_no and reservation_golf.reserv_del_mark!='Y' {$sch_sql}) as g
                  ";

        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        $total_price = (int)$row['air_price'] + (int)$row['rent_price'] + (int)$row['lod_price'] + (int)$row['bus_price']  + (int)$row['bustour_price'] +(int) $row['golf_price'];

        return array($total_price,(int)$row['air_price'],(int)$row['rent_price'],(int)$row['lod_price'],(int)$row['bus_price'],(int)$row['bustour_price'],(int) $row['golf_price']);

    }
    function reservation_profit(){
        $total_amount = $this->reservation_state_number();
        $total_profit = $this->reserv_deposit_price();

        $total =  $total_amount['total_sum'] - $total_profit[0];

        return $total;
    }
    function reservation_tax(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and {$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }
        if($this->reserv_state){
            $sch_sql .= "and reserv_state='{$this->reserv_state}'";
        }


        $sql = "select *,reservation_user_content.no as user_no from reservation_user_content,reservation_equip where reservation_equip.reserv_user_no=reservation_user_content.no and  reserv_equip_name='세금계산서' and reservation_equip.reserv_del_mark!='Y'  {$sch_sql} order by {$this->search_date} asc";
      //  echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;
    }
    function reservation_refund_report(){
        $sch_sql = "";
        if($this->start_date){
            $sch_sql .= "and {$this->search_date} between '{$this->start_date}' and '{$this->end_date}' ";
        }

       if($this->refund == "part"){
            $sch_sql .="and reserv_etc_type='부분환불'";
       }
        if($this->refund == "all"){
            $sch_sql .="and reserv_etc_type='전액환불'";
        }

        $sql = "select *,reservation_user_content.no as user_no from reservation_amount,reservation_user_content,reservation_amount_etc where reservation_user_content.no=reservation_amount.reserv_user_no and reservation_amount.no=reservation_amount_etc.reserv_amount_no   {$sch_sql} order by {$this->search_date} asc";
        //echo $sql;
        $rs  = $this->db->sql_query($sql);
        while ($row = $this->db->fetch_array($rs)){
            $result[] = $row;
        }
        return $result;

    }

}
?>