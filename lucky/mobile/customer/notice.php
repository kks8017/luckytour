<?php include "../inc/header.sub.php"; ?>

<div class="notice">
	<table>
		<tr>
			<td style="width: 40%; border-bottom: 2px solid #4a78cd;"></td>
			<td rowspan="2" style="width: 20%; vertical-align: middle; font-size: 40px; font-weight: bold; text-align: center">공지사항</td>
			<td style="width: 40%; border-bottom: 2px solid #4a78cd;"></td>
		</tr>
		<tr>
			<td></td>
			<td></td>			
		</tr>
	</table>	
</div>

<div class="notice">
	<table class="sub-menu">
		<tr>
			<td  class="icon-pre">
				[공지]
			</td>
			<td class="icon-text">
				<a href="#" id="pop-notice_bt">현금영수증 신청은 반드시 해당...</a>
			</td>
			<td class="icon-back">
				<span class="icon_select"></span>
			</td>
		</tr>
		<tr>
			<td  class="icon-pre">
				[공지]
			</td>
			<td class="icon-text">
				<a href="#"  id="pop-notice_bt">현금영수증 신청은 반드시 해당...</a>
			</td>
			<td class="icon-back">
				<span class="icon_select"></span>
			</td>
		</tr>
		<tr>
			<td class="icon-pre">
				[공지]
			</td>
			<td class="icon-text">
				<a href="#"  id="pop-notice_bt">현금영수증 신청은 반드시 해당...</a>
			</td>
			<td class="icon-back">
				<span class="icon_select"></span>
			</td>
		</tr>
		<tr>
			<td  class="icon-pre">
				[공지]
			</td>
			<td class="icon-text">
				<a href="#"  id="pop-notice_bt">현금영수증 신청은 반드시 해당...</a>
			</td>
			<td class="icon-back">
				<span class="icon_select"></span>
			</td>
		</tr>
		<tr>
			<td  class="icon-pre">
				[공지]
			</td>
			<td class="icon-text">
				<a href="#"  id="pop-notice_bt">현금영수증 신청은 반드시 해당...</a>
			</td>
			<td class="icon-back">
				<span class="icon_select"></span>
			</td>
		</tr>
	</table>
</div>
<br>
<br>
<br>



<style type="text/css" media="screen">	
/*레이어 팝업*/
   #pop-notice{
    width:100%; 
    height:1000px; 
    background:#FFF; 
    color:#3d3d3d; 
    position:absolute; 
    top:700px; 
    left:0; 
    z-index: 100;
   }
 
   #pop-notice-close{
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
   .pop-notice-name {
   	padding-left: 20px;
   }
   
    .pop-notice-close {
   	display: inline-block;
   	vertical-align: middle;
  	margin-left: 15%;
   	width: 50px;
   	height: 50px;
   	background : url('../images/pop_close.png');
   }
	.pop-notice-text {
	width: 100%;
	height: auto;
	margin:50px auto; 
	text-align: left;
	font-size: 35px;
	line-height : 60px;
	color :  #666666;
	word-break: keep-all;
	}

</style>

<!--레이어 팝업 시작 -->
 <div id="pop-notice" style="display:none;">
    <div style="height:auto;">    	
    <div>
	    <div id="pop-notice-close">
	      	<span class="pop-notice-name"> >> 현금영수증 신청은 반드시 해당 게시판</span>
	      	<span class="pop-notice-close"></span>
	    </div>
	</div>

    <div class="pop-notice-text">
    	현금영수증신청은 여행일정이 끝나시기전 신청시 여러번 
		취소 신청이 반복되므로  업무지장이 초래됩니다.
		현금영수증요청 원하시는 고객님들께서는 일정이 끝나신후 
		신청 부탁드리며 현금영수증 신청 가능기간은 일정이 끝나신
		후 부터 한달까지 처리 가능하시니  이점도 참고 부탁드립니다
		이용해주셔서 감사합니다.
    </div>
 
    </div>
  </div>
<!--레이어 팝업 끝 -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<!--레이어 팝업 제이쿼리 -->
 <script type="text/javascript">
   $(document).ready(function() {
    $('#pop-notice_bt').click(function() {
     $('#pop-notice').show();
    });

    $('#pop-notice-close').click(function() {
     $('#pop-notice').hide();
    });
   });
 </script>

<?php include "../inc/footer.php"; ?>