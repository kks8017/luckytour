  $(document).ready(function(){
        $(".quick_search li.act").css({"background-color":"#5683e8"}); 
        $(".quick_search li.menu").click(function(){
          $(".quick_search li.menu").css({"background-color":"transparent"});     
          $(this).css({"background-color":"#5683e8"}); 
        });
        
        $(".quick_form p.close img").click(function(){
            $(".quick_form").hide();
        });
        
        $(".quick_search li.menu:nth-child(1)").click(function(){
             $(".quick_form").show();
             $(".quick_form li:nth-child(1)").show();
             $(".quick_form li:nth-child(2)").hide();
             $(".quick_form li:nth-child(3)").hide();
             $(".quick_form li:nth-child(4)").hide();
             $(".quick_form li:nth-child(5)").hide();
             $(".quick_form li:nth-child(6)").hide();

        });
         $(".quick_search li.menu:nth-child(2)").click(function(){
              $(".quick_form").show();
             $(".quick_form li:nth-child(1)").hide();
             $(".quick_form li:nth-child(2)").show();
             $(".quick_form li:nth-child(3)").hide();
             $(".quick_form li:nth-child(4)").hide();
             $(".quick_form li:nth-child(5)").hide();
             $(".quick_form li:nth-child(6)").hide();

        });
         $(".quick_search li.menu:nth-child(3)").click(function(){
              $(".quick_form").show();
             $(".quick_form li:nth-child(1)").hide();
             $(".quick_form li:nth-child(2)").hide();
             $(".quick_form li:nth-child(3)").show();
             $(".quick_form li:nth-child(4)").hide();
             $(".quick_form li:nth-child(5)").hide();
             $(".quick_form li:nth-child(6)").hide();

        });
         $(".quick_search li.menu:nth-child(4)").click(function(){
              $(".quick_form").show();
             $(".quick_form li:nth-child(1)").hide();
             $(".quick_form li:nth-child(2)").hide();
             $(".quick_form li:nth-child(3)").hide();
             $(".quick_form li:nth-child(4)").show();
             $(".quick_form li:nth-child(5)").hide();
             $(".quick_form li:nth-child(6)").hide();

        });
          $(".quick_search li.menu:nth-child(5)").click(function(){
             $(".quick_form").show();
             $(".quick_form li:nth-child(1)").hide();
             $(".quick_form li:nth-child(2)").hide();
             $(".quick_form li:nth-child(3)").hide();
             $(".quick_form li:nth-child(4)").hide();
             $(".quick_form li:nth-child(5)").show();
             $(".quick_form li:nth-child(6)").hide();

        });
        $(".quick_search li.menu:nth-child(6)").click(function(){
             $(".quick_form").show();
             $(".quick_form li:nth-child(1)").hide();
             $(".quick_form li:nth-child(2)").hide();
             $(".quick_form li:nth-child(3)").hide();
             $(".quick_form li:nth-child(4)").hide();
             $(".quick_form li:nth-child(5)").hide();
             $(".quick_form li:nth-child(6)").show();

        });
    });