<?php include_once ("../header.sub.php");?>
    <div id="content">
        <div class="search">
            <div class="search_tit">
                <!--<img src="./image/bar2.png" />-->
                <span class="bar mar"></span>
                <h3>관광지입장권</h3>
                <span class="bar"></span>
                <!-- <img src="./image/bar2.png" />-->
            </div>
        </div>
        <div style="text-align: center;">
            <iframe id="cpframe" src="http://r.jejumobile.kr/r/R0048" width="100%" height="700" scrolling="no"></iframe>
        </div>
    </div><!-- content 끝 -->
    <script type="text/javascript" src="http://r.jejumobile.kr/r/js/iframeheight.js"></script>


    <script type="text/javascript">


        $(document).ready(function () {




            $('#cpframe').iframeHeight({ //아이프레임 아이디(contentFrame)-대소문자주의

                debugMode : true,

                minimumHeight : $(window).height(),

                defaultHeight : $(window).height()  //기본높이 지정하기

            });

        });

    </script>

<?php include_once ("../footer.php");?>