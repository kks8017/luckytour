<?php
include_once('./_common.php');

if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/admin.css" rel="stylesheet">

</head>

<body>

<div id="container">
    <div id="header">
        <div class="log">
            <table class="log_t" >
                <tr>
                    <td >
                        투어
                    </td>
                </tr>
                <tr>
                    <td>이름 | 로그아웃</td>
                </tr>
            </table>
        </div>
    </div>
    <div id="sidebar">
        <div class="menu"><?php include_once ("./top_menu.php");?></div>
    </div>
    <div id="content">aaaaa</div>
    <div id="clr"></div>
    <div id="footer"></div>
</div>
</body>
</html>
