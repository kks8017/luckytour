    $(document).ready(function(){
        $("#content div.pic ul li img").mouseover(function(){
            $(".show_img").attr("src",$(this).attr("src"));
        });
        
        
        $("#content div.foot .lcon img.thm1").mouseover(function(){
            $(".show_pic1").attr("src",$(this).attr("src"));
        });
        
        $("#content div.foot .lcon img.thm2").mouseover(function(){
            $(".show_pic2").attr("src",$(this).attr("src"));
        });
    });