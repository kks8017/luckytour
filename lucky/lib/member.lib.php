<?php
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
    class member{
        var $db;
        public $user_id,$name,$phone,$email;
        public function __construct()
        {
            $this->db = new tour_db();
        }
        function user_info(){
            $sql  ="select * from user_member where user_id='{$this->user_id}'";
            $rs   = $this->db->sql_query($sql);
            $row  = $this->db->fetch_array($rs);

            return $row;
        }
        function user_id_find(){
            $sql  ="select * from user_member where user_name='{$this->name}' and user_phone='{$this->phone}' and user_email='{$this->email}'";
       //     echo $sql;
            $rs   = $this->db->sql_query($sql);
            $row  = $this->db->fetch_array($rs);

            return $row['user_id'];
        }
        function user_passwd_find(){
            $sql  ="select * from user_member where user_id='{$this->user_id}' and user_name='{$this->name}' and user_phone='{$this->phone}' and user_email='{$this->email}'";
            //     echo $sql;
            $rs   = $this->db->sql_query($sql);
            $row  = $this->db->fetch_array($rs);

            return $row['user_id'];
        }
    }
?>