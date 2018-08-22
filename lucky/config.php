<?php
/********************
상수 선언
 ********************/

define('KS_TOUR', 'KS 1.0');
define('KS_TOUR_VER', '1.0');

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_KSTOUR_', true);

if (PHP_VERSION >= '5.1.0') {
    //if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
    date_default_timezone_set("Asia/Seoul");
}
/********************
 디비정보
 ********************/

define('HOST','localhost');
define('USER','luckytour');
define('PASSWD','lk2727^^');
define('DBNAME','luckytour');
/********************
경로 상수
 ********************/

/*
보안서버 도메인
회원가입, 글쓰기에 사용되는 https 로 시작되는 주소를 말합니다.
포트가 있다면 도메인 뒤에 :443 과 같이 입력하세요.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://www.domain.com
*/
define('KS_NAME','(주)제주럭키투어');
define('KS_DOMAIN', 'http://www.jejuluckytour.co.kr');
define('KS_HTTPS_DOMAIN', '');
define('KS_COOKIE_DOMAIN',  '');


define('KS_DBCONFIG_FILE',  'dbconfig.php');
define('KS_SUB_DIR',  '../');
define('KS_MO_SUB_DIR',  '../../');
define('KS_ADMIN_DIR',      'adm');
define('KS_CSS_DIR',        'css');
define('KS_DATA_DIR',       'data');
define('KS_EXTEND_DIR',     'extend');
define('KS_IMG_DIR',        'img');
define('KS_JS_DIR',         'js');
define('KS_LIB_DIR',        'lib');
define('KS_AIR_DIR',        'air');
define('KS_RENT_DIR',  "rentcar_images");
define('KS_LOD_DIR',  "lodging_images");
define('KS_ROOM_DIR',  "lodging_room_images");
define('KS_BUS_DIR',  "bus_images");
define('KS_BUSTOUR_DIR',  "bustour_images");
define('KS_GOLF_DIR',  "golf_images");
define('KS_BEST_DIR',  "best_image");


if (KS_DOMAIN) {
    define('KS_URL', KS_DOMAIN);
} else {
    //echo ($path['url']);
    if (isset($path['url']))
        define('KS_URL', $path['url']);
    else
        define('KS_URL', '');
}

if (isset($path['path'])) {
    define('KS_PATH', $path['path']);
} else {
    define('KS_PATH', '');
}
define('ESCAPE_FUNCTION', 'sql_escape_string');

//문자세팅 정보
define("CALL_PHONE","0647462727");
define("CALL_COMPANY","jejulucky");
?>