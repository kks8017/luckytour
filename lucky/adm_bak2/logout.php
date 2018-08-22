<?php
include_once('./_common.php');

// 이호경님 제안 코드

session_unset(); // 모든 세션변수를 언레지스터 시켜줌
session_destroy(); // 세션해제함

goto_url("index.php");
?>