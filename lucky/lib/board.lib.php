<?php
class board{
    var $db;
    public $block, $block_set,$total_page,$page,$total_block,$sch_url,$basic_url,$adm_url ;
    public $bd_id,$bd_no,$sub_no,$table,$user_id;

    public function __construct()
    {
        $this->db = new tour_db();
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function pageing(){
        // 페이지번호 & 블럭 설정
        $first_page = (($this->block - 1) * $this->block_set) + 1; // 첫번째 페이지번호
        $last_page = min ($this->total_page, $this->block * $this->block_set); // 마지막 페이지번호

        $prev_page = $this->page - 1; // 이전페이지
        $next_page = $this->page + 1; // 다음페이지

        $prev_block = $this->block - 1; // 이전블럭
        $next_block = $this->block  + 1; // 다음블럭

// 이전블럭을 블럭의 마지막으로 하려면...
        $prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호
// 이전블럭을 블럭의 첫페이지로 하려면...
//$prev_block_page = $prev_block * $block_set - ($block_set - 1);
        $next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호

// 페이징 화면
        echo ($prev_page > 0) ? "<a href='{$_SERVER['PHP_SELF']}?page={$prev_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src='../sub_img/page_prev_btn.png' /></a> " : "<img src='../sub_img/page_prev_btn.png' /> ";
        echo ($prev_block > 0) ? "<a href='{$_SERVER['PHP_SELF']}?page={$prev_block_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src='../sub_img/page_prev_btn2.png' /></a> " : "<img src='../sub_img/page_prev_btn2.png' />";

        for ($i=$first_page; $i<=$last_page; $i++) {
            if($last_page==$i){$bar = "";}else{$bar = "<img src='../sub_img/bar.png' />";}
            echo ($i != $this->page) ? "<a href='{$_SERVER['PHP_SELF']}?page={$i}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><span>$i</span></a> " : "<span class='select'>$i</span> ";
            echo "{$bar}";
        }

        echo ($next_block <= $this->total_block) ? "<a href='{$_SERVER['PHP_SELF']}?page={$next_block_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src='../sub_img/page_next_btn2.png' /></a> " : "<img src='../sub_img/page_next_btn2.png' />";
        echo ($next_page <= $this->total_page) ? "<a href='{$_SERVER['PHP_SELF']}?page={$next_page}&{$this->adm_url}{$this->basic_url}{$this->sch_url}'><img src='../sub_img/page_next_btn.png' /></a>" : "<img src='../sub_img/page_next_btn.png' />";

    }
    function file_uplod($file){
        if(isset($file) && $file['name'] != "") {

            $upload_directory = '../data/board_file/';
            $ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,gif,png,txt,ppt,pptx";
            $allowed_extensions = explode(',', $ext_str);
            $max_file_size = 5242880;
            $ext = substr($file['name'], strrpos($file['name'], '.') + 1);

            // 확장자 체크
            if(!in_array($ext, $allowed_extensions)) {
                $err = "업로드할 수 없는 확장자 입니다.";
            }
            // 파일 크기 체크
            if($file['size'] >= $max_file_size) {
                $err = "5MB 까지만 업로드 가능합니다.";
            }

            $path = md5(microtime()) . '.' . $ext;
            move_uploaded_file($file['tmp_name'], $upload_directory.$path);


        } else {

            $err = "<h3>파일이 업로드 되지 않았습니다.</h3>";

        }
        return array($path,$err);
    }
    function board_config(){
        $sql = "select * from board_list,board_config where board_list.no=board_config.bd_no and bd_no='{$this->bd_no}'  ";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row;
    }
    function board_reply_cnt(){
        $sql = "select count(no) as cnt from board_reply where bd_no='{$this->bd_no}' and sub_no='{$this->sub_no}' and name='관리자'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);
        
        return $row['cnt'];
        
    }
    function board_cnt(){
        $sql = "select count(no) as cnt from {$this->table} where id='{$this->user_id}'";
        $rs  = $this->db->sql_query($sql);
        $row = $this->db->fetch_array($rs);

        return $row['cnt'];
    }
}
?>