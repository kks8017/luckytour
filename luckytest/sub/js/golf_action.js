    $(document).ready(function(){
        $("#content div.pic ul li img").mouseover(function(){
            $(".show_img").attr("src",$(this).attr("src"));
        });
        
        
    });