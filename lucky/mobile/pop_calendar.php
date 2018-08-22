<?php include "css/pop_cal.css" ?>
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<!--레이어 팝업 시작 -->
 <div id="pop_cal" style="display:none;">
    <div style="height:auto;">    	
    <div>
	    <div id="pop_close">
	      	<span class="pop-cal-name"> 출발일 선택</span>
	      	<span class="pop-cal-close"></span>
	    </div>
	</div>
    <br>
	<div id="c">
		<!-- 절대 지우지 마시오-->
		<div id="calHelp">
			<div class="first active"><i>S</i> <b id="sel1text">출발일</b></div><div class="disabled"><i>R</i> <b id="sel2text">도착일</b></div>
		</div>
		<!-- 절대 지우지 마시오-->
		<div id="disp"><div id="prev" class="nav">&larr;</div><div id="month"></div><div id="next" class="nav">&rarr;</div></div>
		<div id="cal"></div>
	</div><!-- /#c -->

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

	<script src="../js/index.js"></script>
	<div class="button-summit-area" style="margin-top : 20px;">
		<button class="button-summit" type="summit" id="date_ok">확인</button>
	</div>
  </div>
<!--레이어 팝업 끝 -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<!--레이어 팝업 제이쿼리 -->
 <script type="text/javascript">
   $(document).ready(function() {
    $('#start_date').click(function() {
     $('#pop_cal').show();
    });
       $('#end_date').click(function() {
           $('#pop_cal').show();
       });
       $('#tel_start_date').click(function() {
           $('#pop_cal').show();
       });
       $('#rent_start_date').click(function() {
           $('#pop_cal').show();
       });
       $('#end_start_date').click(function() {
           $('#pop_cal').show();
       });

    $('#pop_close').click(function() {
     $('#pop_cal').hide();
    });
       $('#date_ok').click(function() {
           $('#pop_cal').hide();
       });
   });
 </script>