<?php
include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/reset.css" />
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/normalize.css" rel="stylesheet">
    <style>
        body{background:#f2f3f4;}
        #wrap{width:100%;}
        #login{width:508px;height:338px;background-color:#fff;margin:10% auto;}
        #login .logtit{width:508px;height:87px;line-height:87px;background-color:#4671c6;text-align: center;}
        #login .logtit h1{color:#fff;font-size:20px}
        #login .logpara {text-align: center;position: absolute;width:506px;height:250px;border:1px solid #d7d7d7;border-top:none}
        #login .logpara img{position: relative;top:20px;left:0px}
        #login .logpara .frm{margin-top:40px;position:relative}
        #login .logpara .frm input.id{width:270px;height:38px;position:absolute;left:72px;top:0px;background-color:#eff2f8;border:1px solid #bdc4d1;border-bottom:none}
        #login .logpara .frm input.pw{width:270px;height:38px;position:absolute;left:72px;top:41px;background-color:#eff2f8;border:1px solid #bdc4d1}
        #login .logpara .frm input.btn{width:82px;height:82px;background-color:#4671c6;position:absolute;left:352px;top:0px;border:none;color:#fff;cursor:pointer}
    </style>

    <title> 제주럭키투어 | 관리자 </title>
</head>
<body>
<div id="wrap">
    <div id="login">
        <div class="logtit">
            <h1>관리자 로그인</h1>
        </div>
        <div class="logpara">
            <img src="./image/title.jpg" />
            <form method="post"  id="login_frm" class="frm">
                <input type="text" name="member_id" id="member_id" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;아이디" class="id"/><br />
                <input type="password" name="member_passwd" id="member_passwd" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;비밀번호" class="pw"/>
                <input type="button" value="로그인" onclick="login_frm();" class="btn"/>
            </form>
        </div>
    </div>
</div>
</body>
</html>

  <script>
      function login_frm() {
          if($("#member_id").val() == ""){
              alert("아이디를 입력해주세요");
              return false;
          }else if($("#member_passwd").val()==""){
              alert("비밀번호를 입력해주세요");
              return false;
          }else{

             $("#login_frm").attr('action','login_check.php').attr('method','post').attr('onsubmit','true').submit();
             return true;
          }
      }

  </script>


</body>
</html>
