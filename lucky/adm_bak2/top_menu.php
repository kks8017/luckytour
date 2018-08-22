
<style>

    ul#navi {
        width: 200px;
        text-indent: 10px;
    }
    ul#navi, ul#navi ul {
        margin:0;
        padding:0;
        list-style:none;
    }
    li.group {
        margin-bottom: 3px;
    }
    li.group div.title {
        height: 35px;
        line-height: 35px;
        background:#9ab92e;
        cursor:pointer;
    }
    ul.sub li {
        margin-bottom: 2px;
        height:35px;
        line-height:35px;
        background:#f4f4f4;
        cursor:pointer;
    }
    ul.sub li a {
        display: block;
        width: 100%;
        height:100%;
        text-decoration:none;
        color:#000;
    }
    ul.sub li:hover {
        background:#cf0;
    }
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script>
    $(document).ready(function(){

        //모든 서브 메뉴 감추기
        $(".sub").css({display:"none"});
        //$(".sub").hide(); //위코드와 동일

        $(".title").click(function(){
            //일단 서브메뉴 다 가립니다.
            //$(".sub").css({display:"none"});

            //열린 서브메뉴에 대해서만 가립니다.
            $(".sub").each(function(){

                if($(this).css("display")=="block") {
                    //$(".sub").css({display:"none"});
                    //$(this).hide();
                    $(this).slideUp("fast");
                }
            });

            //현재 요소의 다음 요소를 보이게 합니다.
            //$(this).next("ul").css({display:"block"});
            //$(this).next("ul").show();
            $(this).next("ul").slideDown("fast");



        })
    });
</script>


<ul id="navi">
    <li class="group">
        <div class="title">title 1</div>
        <ul class="sub">
            <li><a href="#">sub1</a></li>
            <li><a href="#">sub1</a></li>
            <li><a href="#">sub1</a></li>
        </ul>
    </li>
    <li class="group">
        <div class="title">title 2</div>
        <ul class="sub">
            <li><a href="#">sub2</a></li>
        </ul>
    </li>
    <li class="group">
        <div class="title">title 3</div>
        <ul class="sub">
            <li><a href="#">sub3</a></li>
            <li><a href="#">sub3</a></li>
        </ul>
    </li>
</ul>
