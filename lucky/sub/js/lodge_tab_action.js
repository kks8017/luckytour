
	$(document).ready(function(){
		$(".middle .tabmenu li a.first").click(function(){
			$(".middle .tabmenu li:nth-child(1)").css({"background-color":"#4474cc"});
			$(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
			$(".middle .tabmenu li a.first").css({"color":"#fff"});
			$(".middle .tabmenu li a.second").css({"color":"#000"});
			$(".middle .tabmenu li a.third").css({"color":"#000"});
			$(".middle .tabmenu li a.fourth").css({"color":"#000"});
			$(".middle .tab_contents .tab1").show();
			$(".middle .tab_contents .tab2").hide();
			$(".middle .tab_contents .tab3").hide();
			$(".middle .tab_contents .tab4").hide();

		});
		$(".middle .tabmenu li a.second").click(function(){
			$(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(2)").css({"background-color":"#4474cc"});
			$(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
			$(".middle .tabmenu li a.first").css({"color":"#000"});
			$(".middle .tabmenu li a.second").css({"color":"#fff"});
			$(".middle .tabmenu li a.third").css({"color":"#000"});
			$(".middle .tabmenu li a.fourth").css({"color":"#000"});
			$(".middle .tab_contents .tab1").hide();
			$(".middle .tab_contents .tab2").show();
			$(".middle .tab_contents .tab3").hide();
			$(".middle .tab_contents .tab4").hide();
		});
		$(".middle .tabmenu li a.third").click(function(){
			$(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(3)").css({"background-color":"#4474cc"});
			$(".middle .tabmenu li:nth-child(4)").css({"background-color":"#fff"});
			$(".middle .tabmenu li a.first").css({"color":"#000"});
			$(".middle .tabmenu li a.second").css({"color":"#000"});
			$(".middle .tabmenu li a.third").css({"color":"#fff"});
			$(".middle .tabmenu li a.fourth").css({"color":"#000"});
			$(".middle .tab_contents .tab1").hide();
			$(".middle .tab_contents .tab2").hide();
			$(".middle .tab_contents .tab3").show();
			$(".middle .tab_contents .tab4").hide();
		});
		$(".middle .tabmenu li a.fourth").click(function(){
			$(".middle .tabmenu li:nth-child(1)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(2)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(3)").css({"background-color":"#fff"});
			$(".middle .tabmenu li:nth-child(4)").css({"background-color":"#4474cc"});
			$(".middle .tabmenu li a.first").css({"color":"#000"});
			$(".middle .tabmenu li a.second").css({"color":"#000"});
			$(".middle .tabmenu li a.third").css({"color":"#000"});
			$(".middle .tabmenu li a.fourth").css({"color":"#fff"});
			$(".middle .tab_contents .tab1").hide();
			$(".middle .tab_contents .tab2").hide();
			$(".middle .tab_contents .tab3").hide();
			$(".middle .tab_contents .tab4").show();
		});
	});
