  $(document).ready(function(){
        $(".air").click(function(){
            $(".air_area").show();
            $(".rent_area").hide();
            $(".lodge_area").hide();
            $(".package_tabmenu ul li .air").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
        });
        $(".rent").click(function(){
            $(".air_area").hide();
            $(".rent_area").show();
            $(".lodge_area").hide();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#4474cc",color:"#fff"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#fff",color:"#000"});
        });
        $(".lodge").click(function(){
            $(".air_area").hide();
            $(".rent_area").hide();
            $(".lodge_area").show();
            $(".package_tabmenu ul li .rent").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .air").css({backgroundColor:"#fff",color:"#000"});
            $(".package_tabmenu ul li .lodge").css({backgroundColor:"#4474cc",color:"#fff"});
        });
        
		 $("#header .nav ul li a").click(function(){
			 $("#header .nav ul li a").css({"border-bottom":"none"});    /// a 태그 전체 
			  $(this).css({"border-bottom":"3px solid #498517"}); 
		});

        
		

     
    // 저장된 쿠키 읽어오기 

    var vBanner = $.cookie("banner"); 
   // 저장된 쿠키가 있다면   
    if(vBanner != undefined) 
    { 
       //배너 숨김 
      $(".banner").hide(); 
    } 
    else 
    {    
       //배너 보임 
      $(".banner").show();  
       //닫기 버튼 클릭 시, 
       $(".close_btn").click(function(){ 
         $.cookie("banner",$("#cookie").val(),{expires:1});  
         $(".banner").hide();  
		 //$(".banner").animate({display:"none"},1000);
      }); 
    } 
      
      
        

    $("#sdate").datepicker({
        showOn : "both",
        buttonImage : "./image/calender2.png",
        buttonImageOnly : true
    });
        $("#edate").datepicker({
	showOn : "both",
	buttonImage : "./image/calender2.png",
	buttonImageOnly : true
    });


      $("#car_sdate").datepicker({
        showOn : "both",
        buttonImage : "./image/calender2.png",
        buttonImageOnly : true
      });
        $("#car_edate").datepicker({
			showOn : "both",
			buttonImage : "./image/calender2.png",
			buttonImageOnly : true
        });
      
      $("#md_package").datepicker({
        showOn : "both",
        buttonImage : "./image/calender3.png",
        buttonImageOnly : true
      });


		$("#sgolf_date").datepicker({
        showOn : "both",
        buttonImage : "./image/calender2.png",
        buttonImageOnly : true
      });

 });


   