<?php
/*******************************************************************************
 ** 공통 변수, 상수, 코드
 *******************************************************************************/
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
    'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
    'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}

function path()
{
    $result['path'] = str_replace('\\', '/', dirname(__FILE__));
    $tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
    $document_root = str_replace($tilde_remove, '', $_SERVER['SCRIPT_FILENAME']);
    $pattern = '/' . preg_quote($document_root, '/') . '/i';
    $root = preg_replace($pattern, '', $result['path']);
    $port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
    $http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
    $user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
        $host = preg_replace('/:[0-9]+$/', '', $host);
    $host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
    $result['url'] = $http.$host.$port.$user.$root;
    return $result;
}

$path = path();


include_once($path['path'].'/config.php');   // 설정 파일

unset($path);

// sql_escape_string 함수에서 사용될 패턴

define('ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');

define('ESCAPE_REPLACE',  '');

// multi-dimensional array에 사용자지정 함수적용

function array_map_deep($fn, $array)
{

    if(is_array($array)) {

        foreach($array as $key => $value) {

            if(is_array($value)) {

                $array[$key] = array_map_deep($fn, $value);

            } else {

                $array[$key] = call_user_func($fn, $value);

            }

        }

    } else {

        $array = call_user_func($fn, $array);

    }
    return $array;

}

// SQL Injection 대응 문자열 필터링

function sql_escape_string($str)

{

    if(defined('ESCAPE_PATTERN') && defined('ESCAPE_REPLACE')) {

        $pattern = ESCAPE_PATTERN;
        $replace = ESCAPE_REPLACE;
        if($pattern)
            $str = preg_replace($pattern, $replace, $str);
    }

    $str = call_user_func('addslashes', $str);

    return $str;

}

//==============================================================================

// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용

//------------------------------------------------------------------------------

// magic_quotes_gpc 에 의한 backslashes 제거

if (get_magic_quotes_gpc()) {
    $_POST    = array_map_deep('stripslashes',  $_POST);
    $_GET     = array_map_deep('stripslashes',  $_GET);
    $_COOKIE  = array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}

// sql_escape_string 적용
$_POST    = array_map_deep(ESCAPE_FUNCTION,  $_POST);
$_GET     = array_map_deep(ESCAPE_FUNCTION,  $_GET);
$_COOKIE  = array_map_deep(ESCAPE_FUNCTION,  $_COOKIE);
$_REQUEST = array_map_deep(ESCAPE_FUNCTION,  $_REQUEST);
//print_r($_POST);
//==============================================================================

$dbconfig_file = KS_PATH.'/'.KS_DBCONFIG_FILE;
if (file_exists($dbconfig_file)) {
   // echo $dbconfig_file;
}

include_once($dbconfig_file);
include_once(KS_PATH.'/common.lib.php');    // 공통 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/reservation.lib.php');    // 예약 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/air.lib.php');    // 항공 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/rent.lib.php');    // 렌트 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/lodging.lib.php');    // 숙박 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/bus.lib.php');    // 버스택시 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/bustour.lib.php');    // 버스투어 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/golf.lib.php');    // 골프 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/board.lib.php');    // 게시판 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/report.lib.php');    // 상품현황 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/main.config.lib.php');    // 메인 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/member.lib.php');    // 회원가입 라이브러리
include_once(KS_PATH.'/'.KS_LIB_DIR.'/sms.lib.php');    // SMS 라이브러리


//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)


session_cache_limiter("no-cache, must-revalidate");

ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

session_start();

?>