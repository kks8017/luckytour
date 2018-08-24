<?php
class message{
    var $db;
    public $reserv_no,$subject,$content,$phone,$name,$call,$company,$person;
    public function __construct()
    {
        $this->db = new tour_db();
    }
    function sms(){
        $time = date("YmdHim",time());
        $DEST = $this->name."^".$this->phone;
        $SQL = "INSERT INTO SDK_SMS_SEND ( USER_ID,SCHEDULE_TYPE, SUBJECT, SMS_MSG, CALLBACK_URL,NOW_DATE, SEND_DATE, CALLBACK,DEST_INFO,RESERVED1,RESERVED2) 
                 VALUES ( '{$this->reserv_no}',0, '{$this->subject}', '{$this->content}', '' ,'{$time}' ,'{$time}','{$this->call}', '{$DEST}','{$this->company}','{$this->person}')";
        $rs   = $this->db->sql_query($SQL);
        if($rs){
            $send = "OK";
        }else{
            $send = "NO";
        }
        return $send;
    }
    function mms(){
        $time = date("YmdHim");
        $DEST = $this->name."^".$this->phone;

        $SQL = "INSERT INTO SDK_MMS_SEND (USER_ID, SCHEDULE_TYPE, SUBJECT, NOW_DATE, SEND_DATE , CALLBACK, DEST_COUNT, DEST_INFO, MSG_TYPE, MMS_MSG , CONTENT_COUNT, CONTENT_DATA,RESERVED1,RESERVED2)
                VALUES( '{$this->reserv_no}', 0, '{$this->subject}', '{$time}', '{$time}', '{$this->call}', 1, '{$DEST}', 0,'{$this->content}' , 0, '','{$this->company}','{$this->person}')";
        $rs = $this->db->sql_query($SQL);
        if($rs){
            $send = "OK";
        }else{
            $send = "NO";
        }

        return $send;
    }
    function str_len_byte(){
        $data = iconv('UTF-8', 'EUC-KR', $this->content); // EUC-KR
        $a = unpack('C*', $data);
        $i = 0;
        foreach ($a as $v) {
            $h = strtoupper(dechex($v));
            if (strlen($h)<2) $h = '0'.$h;
            ++$i;
        }
        return $i;

    }
    function send(){
        $len = $this->str_len_byte();

        if($len > 90){
            $send = $this->mms();
        }else{
            $send = $this->sms();
        }

        return $send;
    }
    function sms_report(){
        $sql_sms = "select * from SDK_SMS_REPORT where  USER_ID='{$this->reserv_no}' order by NOW_DATE desc";

        $rs_sms = $this->db->sql_query($sql_sms);
        $row_sms = $this->db->fetch_array($rs_sms);

        return $row_sms;
    }
    function mms_report(){
        $sql_mms = "select * from SDK_MMS_REPORT where  USER_ID='{$this->reserv_no}' order by NOW_DATE desc";

        $rs_mms = $this->db->sql_query($sql_mms);
        $row_mms = $this->db->fetch_array($rs_mms);


        return $row_mms;
    }
    function total_report(){
        $sms = $this->sms_report();
        $mms = $this->mms_report();
        $sms_data = array();
        array_push($sms_data,$sms);
        array_push($sms_data,$mms);

        return $sms_data;
    }
}
?>