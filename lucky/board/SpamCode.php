<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가

header("Content-type: image/x-png");
$board_set = new board();
$scode = $board_set->generateRandomString(4);

$im = @imagecreate(100, 30) or die("Cannot Initialize new GD image stream");

$bgcolor = imagecolorallocate($im, 218, 232, 254);
$bgcolor2 = imagecolorallocate($im, 0, 0, 0);
$text_color = imagecolorallocate($im, 1, 103, 150);
$font = "font/HYGTRE.ttf";
ImageFilledRectangle($im,0,0,100,30,$bgcolor2);
ImageFilledRectangle($im,1,1,98,28,$bgcolor);
//imagestring($im, 5, 35, 6,  $scode, $text_color);
imagettftext($im,15,0,25,22,$text_color,$font,$scode);

imagepng($im);
imagedestroy($im);
$_SESSION['scode'] = $scode;
?>
