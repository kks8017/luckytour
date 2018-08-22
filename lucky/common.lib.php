<?php
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION[$session_name] = $value;
}


// 세션변수값 얻음
function get_session($session_name)
{
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}
function goto_url($url)
{
    $url = str_replace("&amp;", "&", $url);
    //echo "<script> location.replace('$url'); </script>";

    if (!headers_sent())
        header('Location: '.$url);
    else {
        echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}
function get_comma($number){
    $number = str_replace(",","",$number);
    return $number;
}
function set_comma($number){
    $len = strpos($number,",");
    if(!$len) {
        $number = number_format($number);
    }
    return $number;
}
function set_company(){
    global $db;
    $SQL = "select * from tour_company where tour_main='Y'";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);

    $SQL_config = "select tour_air_area,tour_rent_code,tour_rent_fuel_code,tour_rent_option,tour_tel_code,tour_tel_type_code,tour_tel_thema from tour_config where tour_com_no='{$row['no']}'";
    $rs_config  = $db->sql_query($SQL_config);
    $row_config = $db->fetch_array($rs_config);

    return $row_config;

}
function get_company($id){
    global $db;
    $SQL = "select * from tour_company where tour_id='{$id}'";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);

    return $row;

}
function get_air_deposit_price($adult_price,$child_price,$adult_sale,$child_sale){

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
function get_oil($start_date){
    global $db;
    $SQL = "select a_oil_oil_price from air_oil_comm where a_oil_start_date <= '{$start_date}' and a_oil_end_date > '{$start_date}' ";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);

    return $row['a_oil_oil_price'];
}
function get_comm($start_date){
    global $db;
    $SQL = "select a_oil_com_price from air_oil_comm where a_oil_start_date <= '{$start_date}' and a_oil_end_date > '{$start_date}' ";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);

    return $row['a_oil_com_price'];
}
function get_air($url,$com)
{

    // create curl resource
    $ch = curl_init();

// set url
    curl_setopt($ch, CURLOPT_URL, $url);

//return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($com == "dcjeju") {
          curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
    }
 //   curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
// $output contains the output string
    $output = curl_exec($ch);
   // echo $output;
// close curl resource to free up system resources
    curl_close($ch);

    return $output ;
}
function get_dcjeju($output_data){
    global $db;
    $fields_data = array();


    $sql_a = "INSERT INTO air_schedule (no,
                                      a_sch_company_no, 
                                      a_sch_departure_area_code,
                                      a_sch_arrival_area_code, 
                                      a_sch_departure_airline_code,
                                      a_sch_arrival_airline_code,
                                      a_sch_departure_area_name,
                                      a_sch_arrival_area_name,
                                      a_sch_departure_airline_name,
                                      a_sch_arrival_airline_name,
                                      a_sch_departure_date,
                                      a_sch_departure_time,
                                      a_sch_arrival_date,
                                      a_sch_arrival_time,
                                      a_sch_stay,
                                      a_sch_adult_normal_price,
                                      a_sch_child_normal_price,
                                      a_sch_adult_sale,
                                      a_sch_child_sale,
                                      a_sch_adult_deposit_sale,
                                      a_sch_child_deposit_sale,
                                      a_sch_adult_sale_price,
                                      a_sch_child_sale_price,
                                      a_sch_adult_deposit_price,
                                      a_sch_child_deposit_price,
                                      a_sch_emergency,
                                      a_sch_deadline,
                                      a_sch_bigo,
                                      a_sch_company,
                                      indate
                                      ) VALUES";
    $indate = date("Y-m-d H:i",time());
    $query ="";

    for ($k = 1; $k < count($output_data); $k++) {
        $mod = $k % 1000;
        $fields = iconv("euc-kr", "utf-8", $output_data[$k]);
        $fields = explode("@", $fields);
        //print_r($fields);
        switch ($fields[6]){
            case "대한항공" :
                $airlinename = "대한항공";
                break;
            case "아시아나" :
                $airlinename = "아시아나";
                break;
            case "제주항공" :
                $airlinename = "제주항공";
                break;
            case "진에어" :
                $airlinename = "진에어";
                break;
            case "티웨이항공" :
                $airlinename = "티웨이항공";
                break;
            case "에어부산" :
                $airlinename = "에어부산";
                break;
            case "이스타" :
                $airlinename = "이스타항공";
                break;
        }


        $stay = $fields[13]."박".($fields[13]+1)."일";
        $a_sch_company_no = trim($fields[0]);
        $a_sch_departure_area_code = trim($fields[1]);
        $a_sch_arrival_area_code = trim($fields[3]);
        $a_sch_departure_airline_code = trim($fields[5]);
        $a_sch_arrival_airline_code = trim($fields[7]);
        $a_sch_departure_area_name = trim($fields[2]);
        $a_sch_arrival_area_name = trim($fields[4]);
        $a_sch_departure_airline_name = trim($airlinename);
        $a_sch_arrival_airline_name = trim( $airlinename);
        $a_sch_departure_date = trim($fields[9]);
        $a_sch_departure_time = trim($fields[10]);
        $a_sch_arrival_date = trim($fields[11]);
        $a_sch_arrival_time = trim($fields[12]);
        $a_sch_stay = trim($stay);
        $a_sch_adult_normal_price = trim($fields[16]);
        $a_sch_child_normal_price = trim($fields[17]);
        $a_sch_adult_sale = trim($fields[22]);
        $a_sch_child_sale = trim($fields[23]);
        $a_sch_adult_deposit_sale = trim($fields[18]);
        $a_sch_child_deposit_sale = trim($fields[19]);
        $a_sch_adult_sale_price = trim($fields[24]);
        $a_sch_child_sale_price = trim($fields[25]);
        $a_sch_adult_deposit_price = trim($fields[20]);
        $a_sch_child_deposit_price = trim($fields[21]);
        $a_sch_emergency = trim($fields[26]);
        $a_sch_deadline = trim($fields[27]);
        $a_sch_bigo = addslashes($fields[28]);
        $a_sch_company = "dcjeju";
        if ($fields[0] != "") {
            $query .= '("' . $k .
                '", "' . $a_sch_company_no .
                '", "' . $a_sch_departure_area_code .
                '", "' . $a_sch_arrival_area_code .
                '", "' . $a_sch_departure_airline_code .
                '", "' . $a_sch_arrival_airline_code .
                '", "' . $a_sch_departure_area_name .
                '", "' . $a_sch_arrival_area_name .
                '", "' . $a_sch_departure_airline_name .
                '", "' . $a_sch_arrival_airline_name .
                '", "' . $a_sch_departure_date .
                '", "' . $a_sch_departure_time .
                '", "' . $a_sch_arrival_date .
                '", "' . $a_sch_arrival_time .
                '", "' . $a_sch_stay .
                '", "' . $a_sch_adult_normal_price .
                '", "' . $a_sch_child_normal_price .
                '", "' . $a_sch_adult_sale .
                '", "' . $a_sch_child_sale .
                '", "' . $a_sch_adult_deposit_sale .
                '", "' . $a_sch_child_deposit_sale .
                '", "' . $a_sch_adult_sale_price .
                '", "' . $a_sch_child_sale_price .
                '", "' . $a_sch_adult_deposit_price .
                '", "' . $a_sch_child_deposit_price .
                '", "' . $a_sch_emergency .
                '", "' . $a_sch_deadline .
                '", "' . $a_sch_bigo .
                '", "' . $a_sch_company .
                '", "' . $indate . '")';
        }

        if ($mod == 0) {
            $query_a = $sql_a . $query . ";";
            //echo $query_a;
            $db->multi_query("{$query_a}");
            $query_a = "";
            $query = "";

        } else {
            if ($k == (count($output_data) - 2)) {
                //echo $k."===".(count($output_data)-2);
                $query .= "";
                break;
            } else {
                $query .= ",";
            }
        }
    }
    //echo count($output_data);

    $query_a = $sql_a . $query . ";";

    $db->multi_query("{$query_a}");
}
function get_mrjeju($output_data){
    global $db;
    $fields_data = array();


    $sql_a = "INSERT INTO air_schedule (no,
                                      a_sch_company_no, 
                                      a_sch_departure_area_code,
                                      a_sch_arrival_area_code, 
                                      a_sch_departure_airline_code,
                                      a_sch_arrival_airline_code,
                                      a_sch_departure_area_name,
                                      a_sch_arrival_area_name,
                                      a_sch_departure_airline_name,
                                      a_sch_arrival_airline_name,
                                      a_sch_departure_date,
                                      a_sch_departure_time,
                                      a_sch_arrival_date,
                                      a_sch_arrival_time,
                                      a_sch_stay,
                                      a_sch_adult_normal_price,
                                      a_sch_child_normal_price,
                                      a_sch_adult_sale,
                                      a_sch_child_sale,
                                      a_sch_adult_deposit_sale,
                                      a_sch_child_deposit_sale,
                                      a_sch_adult_sale_price,
                                      a_sch_child_sale_price,
                                      a_sch_adult_deposit_price,
                                      a_sch_child_deposit_price,
                                      a_sch_emergency,
                                      a_sch_deadline,
                                      a_sch_bigo,
                                      a_sch_company,
                                      indate
                                      ) VALUES";
    $indate = date("Y-m-d H:i",time());
    $query ="";
    $SQL = "select count(no) as cnt from air_schedule ";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);
    $i = $row['cnt'];
    for ($k = 1; $k < count($output_data); $k++) {
        $mod = $k % 1000;
        $fields = iconv("euc-kr", "utf-8", $output_data[$k]);
        $fields = explode("@", $fields);
        //print_r($fields);
        switch ($fields[1]) {
            case "대한항공" :
                $airlinecode = "KE";
                break;
            case "아시아나" :
                $airlinecode = "OZ";
                break;
            case "제주항공" :
                $airlinecode = "7C";
                break;
            case "진에어" :
                $airlinecode = "LJ";
                break;
            case "티웨이항공" :
                $airlinecode = "TW";
                break;
            case "에어부산" :
                $airlinecode = "BX";
                break;
            case "이스타항공" :
                $airlinecode = "ZE";
                break;
        }
        switch ($fields[3]) {
            case "김포" :
                $areacode = "GMP";
                break;
            case "인천" :
                $areacode = "ICN";
                break;
            case "부산" :
                $areacode = "PUS";
                break;
            case "청주" :
                $areacode = "CJJ";
                break;
            case "광주" :
                $areacode = "KWJ";
                break;
            case "대구" :
                $areacode = "TAE";
                break;
            case "군산" :
                $areacode = "KUV";
                break;
            case "여수" :
                $areacode = "RSU";
                break;
            case "진주" :
                $areacode = "HIN";
                break;
            case "무안" :
                $areacode = "MWX";
                break;
        }
        $start_date = explode(" ", $fields[5]);
        $end_date = explode(" ", $fields[6]);


        if ($fields[11] > 0){
            $adult_deposit_sale = $fields[11] + 5;
        }else if($fields[16]  > 0) {
            $child_deposit_sale = $fields[16] + 5;
        }

        if($fields[7]=="예약접수"){
            $res_ok = "N";
        }else{
            $res_ok = "Y";
        }
        $bigo = "유류할증류포함";



        $a_sch_company_no = trim($fields[0]);
        $a_sch_departure_area_code = trim($areacode);
        $a_sch_arrival_area_code = trim($areacode);
        $a_sch_departure_airline_code = trim($airlinecode);
        $a_sch_arrival_airline_code = trim($airlinecode);
        $a_sch_departure_area_name = trim($fields[3]);
        $a_sch_arrival_area_name = trim($fields[3]);
        $a_sch_departure_airline_name = trim($fields[1]);
        $a_sch_arrival_airline_name = trim($fields[1]);
        $a_sch_departure_date = trim($start_date[0]);
        $a_sch_departure_time = trim($start_date[1]);
        $a_sch_arrival_date = trim($end_date[0]);
        $a_sch_arrival_time = trim($end_date[1]);
        $a_sch_stay = trim($fields[2]);
        $a_sch_adult_normal_price = trim($fields[9]);
        $a_sch_child_normal_price = trim($fields[14]);
        $a_sch_adult_sale = trim($fields[11]);
        $a_sch_child_sale = trim($fields[16]);
        $a_sch_adult_deposit_sale = trim($adult_deposit_sale);
        $a_sch_child_deposit_sale = trim($child_deposit_sale);
        $a_sch_adult_sale_price = trim($fields[12]);
        $a_sch_child_sale_price = trim($fields[17]);
        $a_sch_adult_deposit_price = trim($fields[19]);
        $a_sch_child_deposit_price = trim($fields[20]);
        $a_sch_emergency = "";
        $a_sch_deadline = trim($res_ok);
        $a_sch_bigo = addslashes($bigo);
        $a_sch_company = "미스터제주";
        if ($fields[0] != "") {
            $query .= '("' . $i .
                '", "' . $a_sch_company_no .
                '", "' . $a_sch_departure_area_code .
                '", "' . $a_sch_arrival_area_code .
                '", "' . $a_sch_departure_airline_code .
                '", "' . $a_sch_arrival_airline_code .
                '", "' . $a_sch_departure_area_name .
                '", "' . $a_sch_arrival_area_name .
                '", "' . $a_sch_departure_airline_name .
                '", "' . $a_sch_arrival_airline_name .
                '", "' . $a_sch_departure_date .
                '", "' . $a_sch_departure_time .
                '", "' . $a_sch_arrival_date .
                '", "' . $a_sch_arrival_time .
                '", "' . $a_sch_stay .
                '", "' . $a_sch_adult_normal_price .
                '", "' . $a_sch_child_normal_price .
                '", "' . $a_sch_adult_sale .
                '", "' . $a_sch_child_sale .
                '", "' . $a_sch_adult_deposit_sale .
                '", "' . $a_sch_child_deposit_sale .
                '", "' . $a_sch_adult_sale_price .
                '", "' . $a_sch_child_sale_price .
                '", "' . $a_sch_adult_deposit_price .
                '", "' . $a_sch_child_deposit_price .
                '", "' . $a_sch_emergency .
                '", "' . $a_sch_deadline .
                '", "' . $a_sch_bigo .
                '", "' . $a_sch_company .
                '", "' . $indate . '")';
        }

        if ($mod == 0) {
            $query_a = $sql_a . $query . ";";
            //echo $query_a;
            $db->multi_query("{$query_a}");
            $query_a = "";
            $query = "";

        } else {
            if ($k == (count($output_data) - 2)) {
                //echo $k."===".(count($output_data)-2);
                $query .= "";
                break;
            } else {
                $query .= ",";
            }
        }
        $i++;
    }
    //echo count($output_data);

    $query_a = $sql_a . $query . ";";


    $db->multi_query("{$query_a}");
}
function get_woori($output_data){
    global $db;
    $fields_data = array();


    $sql_a = "INSERT INTO air_schedule (no,
                                      a_sch_company_no, 
                                      a_sch_departure_area_code,
                                      a_sch_arrival_area_code, 
                                      a_sch_departure_airline_code,
                                      a_sch_arrival_airline_code,
                                      a_sch_departure_area_name,
                                      a_sch_arrival_area_name,
                                      a_sch_departure_airline_name,
                                      a_sch_arrival_airline_name,
                                      a_sch_departure_date,
                                      a_sch_departure_time,
                                      a_sch_arrival_date,
                                      a_sch_arrival_time,
                                      a_sch_stay,
                                      a_sch_adult_normal_price,
                                      a_sch_child_normal_price,
                                      a_sch_adult_sale,
                                      a_sch_child_sale,
                                      a_sch_adult_deposit_sale,
                                      a_sch_child_deposit_sale,
                                      a_sch_adult_sale_price,
                                      a_sch_child_sale_price,
                                      a_sch_adult_deposit_price,
                                      a_sch_child_deposit_price,
                                      a_sch_emergency,
                                      a_sch_deadline,
                                      a_sch_bigo,
                                      a_sch_company,
                                      indate
                                      ) VALUES";
    $indate = date("Y-m-d H:i",time());
    $query ="";
    $SQL = "select count(no) as cnt from air_schedule ";
    $rs  = $db->sql_query($SQL);
    $row = $db->fetch_array($rs);
    $i = $row['cnt'];
    for ($k = 1; $k < count($output_data); $k++) {
        $mod = $k % 1000;
        $fields = iconv("euc-kr", "utf-8", $output_data[$k]);
        $fields = explode("@", $fields);
        //print_r($fields);
        switch ($fields[6]){
            case "대한항공" :
                $airlinename = "대한항공";
                break;
            case "아시아나" :
                $airlinename = "아시아나";
                break;
            case "제주항공" :
                $airlinename = "제주항공";
                break;
            case "진에어" :
                $airlinename = "진에어";
                break;
            case "티웨이항공" :
                $airlinename = "티웨이항공";
                break;
            case "에어부산" :
                $airlinename = "에어부산";
                break;
            case "이스타항공" :
                $airlinename = "이스타항공";
                break;
        }

        $air_deposit_price = get_air_deposit_price($fields[16],$fields[17],$fields[18],$fields[19]);


        $stay = $fields[13]."박".($fields[13]+1)."일";
        $a_sch_company_no = trim($fields[0]);
        $a_sch_departure_area_code = trim($fields[1]);
        $a_sch_arrival_area_code = trim($fields[3]);
        $a_sch_departure_airline_code = trim($fields[5]);
        $a_sch_arrival_airline_code = trim($fields[7]);
        $a_sch_departure_area_name = trim($fields[2]);
        $a_sch_arrival_area_name = trim($fields[4]);
        $a_sch_departure_airline_name = trim($airlinename);
        $a_sch_arrival_airline_name = trim( $airlinename);
        $a_sch_departure_date = trim($fields[9]);
        $a_sch_departure_time = trim($fields[10]);
        $a_sch_arrival_date = trim($fields[11]);
        $a_sch_arrival_time = trim($fields[12]);
        $a_sch_stay = trim($stay);
        $a_sch_adult_normal_price = trim($fields[16]);
        $a_sch_child_normal_price = trim($fields[17]);
        $a_sch_adult_sale = trim($fields[18]);
        $a_sch_child_sale = trim($fields[19]);
        $a_sch_adult_deposit_sale = trim($air_deposit_price[1]);
        $a_sch_child_deposit_sale = trim($air_deposit_price[3]);
        $a_sch_adult_sale_price = trim($fields[20]);
        $a_sch_child_sale_price = trim($fields[21]);
        $a_sch_adult_deposit_price = trim($air_deposit_price[0]);
        $a_sch_child_deposit_price = trim($air_deposit_price[2]);
        $a_sch_emergency = trim($fields[22]);
        $a_sch_deadline = trim($fields[23]);
        $a_sch_bigo = addslashes($fields[24]);
        $a_sch_company = "우리항공";
        if ($fields[0] != "") {
            $query .= '("' . $i .
                '", "' . $a_sch_company_no .
                '", "' . $a_sch_departure_area_code .
                '", "' . $a_sch_arrival_area_code .
                '", "' . $a_sch_departure_airline_code .
                '", "' . $a_sch_arrival_airline_code .
                '", "' . $a_sch_departure_area_name .
                '", "' . $a_sch_arrival_area_name .
                '", "' . $a_sch_departure_airline_name .
                '", "' . $a_sch_arrival_airline_name .
                '", "' . $a_sch_departure_date .
                '", "' . $a_sch_departure_time .
                '", "' . $a_sch_arrival_date .
                '", "' . $a_sch_arrival_time .
                '", "' . $a_sch_stay .
                '", "' . $a_sch_adult_normal_price .
                '", "' . $a_sch_child_normal_price .
                '", "' . $a_sch_adult_sale .
                '", "' . $a_sch_child_sale .
                '", "' . $a_sch_adult_deposit_sale .
                '", "' . $a_sch_child_deposit_sale .
                '", "' . $a_sch_adult_sale_price .
                '", "' . $a_sch_child_sale_price .
                '", "' . $a_sch_adult_deposit_price .
                '", "' . $a_sch_child_deposit_price .
                '", "' . $a_sch_emergency .
                '", "' . $a_sch_deadline .
                '", "' . $a_sch_bigo .
                '", "' . $a_sch_company .
                '", "' . $indate . '")';
        }

        if ($mod == 0) {
            $query_a = $sql_a . $query . ";";
            //echo $query_a;
            $db->multi_query("{$query_a}");
            $query_a = "";
            $query = "";

        } else {
            if ($k == count($output_data)){
                //echo $k."===".(count($output_data)-2);
                $query .= "";
                break;
            } else {
                $query .= ",";
            }
        }
        $i++;
    }
    //echo count($output_data);

    $query_a = $sql_a . $query . ";";

    $db->multi_query("{$query_a}");
}

function image_upload($image,$uploads_dir,$old_image="",$mode="",$best="")
{
    echo $image."===".$uploads_dir."===".$old_image."===".$mode;
    // 설정
    if($best=="") {
        $uploads_dir = '../../' . $uploads_dir;
    }else{
        $uploads_dir = '../' . $uploads_dir;
    }
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    if($mode == "up"){
        unlink($uploads_dir."/thumbnail_".$old_image);
        unlink($uploads_dir."/".$old_image);
    }
    echo $image['name'];
    // 폴더 존재 여부 확인 ( 없으면 생성 )
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir);
    }

    // 변수 정리
    $error = $image['error'];
    $name = $image['name'];

    $ext = array_pop(explode('.', $name));

    // 오류 확인
    if ($error != UPLOAD_ERR_OK) {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "파일이 너무 큽니다. ($error)";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "파일이 첨부되지 않았습니다. ($error)";
                break;
            default:
                echo "파일이 제대로 업로드되지 않았습니다. ($error)";
        }
        exit;
    }

    // 확장자 확인
    if (!in_array($ext, $allowed_ext)) {
        echo "허용되지 않는 확장자입니다.";
        exit;
    }
    $images_name = "thumbnail_".time().uniqid().".".$ext;
    $images_m = time().uniqid().".".$ext;
    $url_t =  $uploads_dir.'/'.$images_name;
    $url =  $uploads_dir.'/'.$images_m;

    $thumbnail = ImageResize("300","200",$url_t,$image);
    $image_big = compress($image['tmp_name'], $url, 100);
    echo $image_big;

    return array($images_name,$images_m);

}
function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

/**
 * Image re-size
 * @param int $width
 * @param int $height
 */
function ImageResize($width, $height, $img_name,$img)
{
    /* Get original file size */
    list($w, $h) = getimagesize($img['tmp_name']);


    /*$ratio = $w / $h;
    $size = $width;

    $width = $height = min($size, max($w, $h));

    if ($ratio < 1) {
        $width = $height * $ratio;
    } else {
        $height = $width / $ratio;
    }*/

    /* Calculate new image size */
    $ratio = max($width/$w, $height/$h);
    $h = ceil($height / $ratio);
    $x = ($w - $width / $ratio) / 2;
    $w = ceil($width / $ratio);
    /* set new file name */
    $path = $img_name;


    /* Save image */
    if($img['type']=='image/jpeg')
    {
        /* Get binary data from image */
        $imgString = file_get_contents($img['tmp_name']);
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
        imagejpeg($tmp, $path, 100);
    }
    else if($img['type']=='image/png')
    {
        $image = imagecreatefrompng($img['tmp_name']);
        $tmp = imagecreatetruecolor($width,$height);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $image,0,0,$x,0,$width,$height,$w, $h);
        imagepng($tmp, $path, 0);
    }
    else if($img['type']=='image/gif')
    {
        $image = imagecreatefromgif($img['tmp_name']);

        $tmp = imagecreatetruecolor($width,$height);
        $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        imagefill($tmp, 0, 0, $transparent);
        imagealphablending($tmp, true);

        imagecopyresampled($tmp, $image,0,0,0,0,$width,$height,$w, $h);
        imagegif($tmp, $path);
    }
    else
    {
        return false;
    }

    return true;
    imagedestroy($image);
    imagedestroy($tmp);
}
function get_rentcar_name($carno){
     global $db;
    $sql = "select rent_car_name,rent_car_fuel,rent_car_type from rent_car_detail where no='{$carno}'";
    $rs  = $db->sql_query($sql);
    $row = $db->fetch_array($rs);
    //차량명,연료,차종
    return array($row['rent_car_name'],$row['rent_car_fuel'],$row['rent_car_type']);
}
function get_rentcar_company($no,$type){
    global $db;
    if($type=="대표"){
        $sql = "select no,rent_com_type from rent_company where rent_com_type='대표'";
    }else {
        $sql = "select no,rent_com_type from rent_company where no='{$no}'";
    }
    $rs  = $db->sql_query($sql);
    $row = $db->fetch_array($rs);

    return array($row['no'],$row['rent_com_type']);
}
function get_rentcar_season_no($com_no){
    global $db;
    $sql = "select no from rent_season_list where rent_com_no='{$com_no}' order by rent_season_start_date ";
    //echo $sql;

    $rs  = $db->sql_query($sql);
    $row = $db->fetch_array($rs);

    return $row['no'];
}

?>

