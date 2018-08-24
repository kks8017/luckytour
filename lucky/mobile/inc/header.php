<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$main = new main();
$main_company = $main->tour_config();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>제주여행</title>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/common.css">
</head>
<body>
<div class="header">
	<div class="header-top">
		<ul>
			<li class="header-top-title" style="width: 10%;">
				<button id="pop-menu_bt">
					<img src="images/menu.png" height="40">
				</button>
			</li>
			<li class="header-top-title" style="width: 80%;">
				<a href="index.php">
					<img src="<?=KS_DOMAIN?>/main_img/logo.gif"  width="200">
				</a>
			</li>
			<li class="header-top-title"  style="width: 10%;">
                <?php

                    if($_SESSION['user_id']){
                ?>
				<a href="member/mypage.php">
					<img src="images/mypage.png" height="40">
				</a>
                <?}else{?>
                        <a href="member/login.php">
                            <img src="images/mypage.png" height="40">
                        </a>
                <?}?>
			</li>
		</ul>
	</div>
	<div  class="header-menu">
		<ul>
			<li class="header-menu-title" style="padding-left: 5px;">
				<a href="package/package_list.php">자유여행패키지</a></li>
			<li class="header-menu-title">
				<a href="air/air.php">항공</a></li>
			<li class="header-menu-title">
				<a href="tel/tel_list.php">숙박</a></li>
			<li class="header-menu-title">
				<a href="car/car_list.php">렌터카</a>
			</li>
			<li class="header-menu-title">
				<a href="bus/bus_list.php">버스/택시</a>
			</li>
		</ul>	
	</div>
</div>


<style type="text/css" media="screen">	
/*레이어 팝업*/
   #pop-menu{
    width:100%; 
    height:1750px; 
    background:#FFF; 
    color:#3d3d3d; 
    position:absolute; 
    top:0; 
    left:0; 
    z-index: 100;
   }
 
   #pop-menu-close{
    width:100%;
    height: 85px; 
    margin:auto;
    cursor:pointer; 
    font-weight:bold;
    background-color: #4a78cd;
    font-family: NanumGothic;
  	font-size:40px;
  	font-weight: bold;
  	font-style: normal;
  	font-stretch: normal;
  	line-height: 85px;
  	letter-spacing: normal;
  	text-align: left;
  	color: #ffffff;
   }
   .pop-menu-name {
   	padding-left: 20px;
   }
    
    .pop-menu-close {
   	display: inline-block;
   	vertical-align: middle;
  	margin-left: 68%;
   	width: 50px;
   	height: 50px;
   	background : url('images/pop_close.png');
   }

	.pop-menu-info {
	width: 100%;
	height: auto;
	margin-top: 20px;
	}
	.pop-menu-info table{
	width: 100%;
	height: auto;
	}
	.gap {
	width: 100%;
	height: 50px;
	background:#eeeeee ;

	}
	.pop-menu-info td{
	width : 400px;
	height: 400px;
	text-align: center;
	}

	.pop-menu-info td span.res{
	display: inline-block;
	background : url('images/reserve.png') no-repeat center;
	width : 300px;
	height: 300px; 
	background-size: 65%;
	margin: auto;
	}

	.pop-menu-info td span.con{
	display: inline-block;
	background : url('images/cscenter.png') no-repeat center;
	width : 300px;
	height: 300px; 
	background-size: 65%;
	margin: auto;
	}

	.pop-menu-info td span.mypage{
	display: inline-block;	
	background : url('images/mypage_menu.png') no-repeat center;
	width : 300px;
	height: 300px; 	
	background-size: 65%;
	margin: auto;
	}

	.pop-menu-info td span.join{
	display: inline-block;		
	background :  url('images/join.png') no-repeat center;
	width : 300px;
	height: 300px; 	
	background-size: 65%;
	margin: auto;
	}

	.pop-menu-info td span.menu-title {
		display: inline-block;
		margin: auto;
		width: 100%;
		margin: auto;
		font-size: 40px;
		font-weight: 600;
		color : #000000;		
	}


	.pop-sub-menu {
	width: 100%;
	height: auto;
	margin-top: 40px;
	}

	.pop-sub-menu table.sub-menu {
	width: 100%;
	height: auto;
	margin-bottom: 100px;
	}

	.pop-sub-menu table.sub-menu td {
	height: 120px;
	line-height :  120px;
	border-bottom: 1px solid #BDBDBD;
	vertical-align: middle;
	}


	.pop-sub-menu table.sub-menu td.icon-pre {
		width: 12%;
		padding-left :  20px;
		text-align: center;
		height: 120px;
		line-height :  120px;
	}


	.pop-sub-menu table.sub-menu td.icon-pre span.icon_air {
		display: inline-block;
		width: 50px;
		height: 50px;
		background :  url('images/icon_air.png') no-repeat center;
		background-size: cover;
		vertical-align: middle;
	}

	.pop-sub-menu table.sub-menu td.icon-pre span.icon_pakc {
		display: inline-block;
		width: 50px;
		height: 50px;
		background :  url('images/icon_pack.png')no-repeat center;
		background-size: cover;
		vertical-align: middle;
	}

	.pop-sub-menu table.sub-menu td.icon-pre span.icon_tel {
		display: inline-block;
		width: 50px;
		height: 50px;
		background :  url('images/icon_tel.png')no-repeat center;
		background-size: cover;
		vertical-align: middle;
	}

	.pop-sub-menu table.sub-menu td.icon-pre span.icon_car {
		display: inline-block;
		width: 50px;
		height: 50px;
		background :  url('images/icon_car.png')no-repeat center;
		background-size: cover;
		vertical-align: middle;
	}

	.pop-sub-menu table.sub-menu td.icon-pre span.icon_place {
		display: inline-block;
		width: 50px;
		height: 50px;
		background :  url('images/icon_tour.png')no-repeat center;
		background-size: cover;
		vertical-align: middle;
	}

	.pop-sub-menu table.sub-menu td.icon-text {
		width: 85%;
		padding-left :  20px;
	}
	.pop-sub-menu table.sub-menu td.icon-text a {
		display: block;
		width: 100%;
		height: 100%;
		font-size: 35px;
		font-weight: 600;
		text-align: left;
		color : #000000;
	}

	.pop-sub-menu table.sub-menu td.icon-back {
		padding-right :  20px;
		text-align: right;
	}

	.pop-sub-menu table.sub-menu td.icon-back span.icon_select {
		display: inline-block;
		width: 20px;
		height: 20px;
		background :  url('images/icon_menu.png')no-repeat center;
		background-size:100%;
	}
</style>

<!--레이어 팝업 시작 -->
 <div id="pop-menu" style="display:none;">
    <div style="height:auto;">    	
    <div>
	    <div id="pop-menu-close">
	      	<span class="pop-menu-name"> >> 바로가기</span>
	      	<span class="pop-menu-close"></span>
	    </div>
	</div>

    <div class="pop-menu-info">
    	<table>
    		<tr>
    			<td style="border-bottom: 2px solid #BDBDBD; border-right: 2px solid #BDBDBD;">
    				<a href="res/res_end.php">
    					<span class="res"></span>
    					<span class="menu-title">예약확인</span>
    				</a>
    			</td>
    			<td style="border-bottom: 2px solid #BDBDBD; ">
    				<a href="customer/notice.php">
    					<span class="con"></span>
    					<span class="menu-title">고객센터</span>
    				</a>
    			</td>	
    		</tr>
    		<tr>
    			<td style="border-right: 2px solid #BDBDBD; ">
    				<a href="member/mypage.php">
    					<span class="mypage"></span>
    					<span class="menu-title">마이페이지</span>	
    				</a>
    			</td>
    			<td>
    				<a href="member/member_join.php">
    					<span class="join"></span>
    					<span class="menu-title">회원가입</span>
    				</a>
    			</td>	
    		</tr>
    	</table>
    </div>
 	<div class="gap"></div>
    <div class="pop-sub-menu">
    	<table class="sub-menu">
    		<tr>
    			<td  class="icon-pre">
    				<span class="icon_pakc"></span>
    			</td>
    			<td class="icon-text">
    				<a href="package/package_list.php">자유여행패키지</a>
    			</td>
    			<td class="icon-back">
    				<span class="icon_select"></span>
    			</td>
    		</tr>
    		<tr>
    			<td  class="icon-pre">
    				<span class="icon_air"></span>
    			</td>
    			<td class="icon-text">
    				<a href="air/air_list.php">항공</a>
    			</td>
    			<td class="icon-back">
    				<span class="icon_select"></span>
    			</td>
    		</tr>
    		<tr>
    			<td class="icon-pre">
    				<span class="icon_tel"></span>
    			</td>
    			<td class="icon-text">
    				<a href="tel/tel_list.php">숙박</a>
    			</td>
    			<td class="icon-back">
    				<span class="icon_select"></span>
    			</td>
    		</tr>
    		<tr>
    			<td  class="icon-pre">
    				<span class="icon_car"></span>
    			</td>
    			<td class="icon-text">
    				<a href="car/car_list.php">렌터카</a>
    			</td>
    			<td class="icon-back">
    				<span class="icon_select"></span>
    			</td>
    		</tr>
    		<tr>
    			<td  class="icon-pre">
    				<span class="icon_place"></span>
    			</td>
    			<td class="icon-text">
    				<a href="#">관광지</a>
    			</td>
    			<td class="icon-back">
    				<span class="icon_select"></span>
    			</td>
    		</tr>
    	</table>
    </div>
    </div>
  </div>
<!--레이어 팝업 끝 -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<!--레이어 팝업 제이쿼리 -->
 <script type="text/javascript">
   $(document).ready(function() {
    $('#pop-menu_bt').click(function() {
     $('#pop-menu').show();
    });

    $('#pop-menu-close').click(function() {
     $('#pop-menu').hide();
    });
   });
 </script>
